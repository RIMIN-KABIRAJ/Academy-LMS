<?php

namespace App\Http\Controllers;

use DateInterval;
use Illuminate\Http\Request;

class CommonController extends Controller
{
	// Get video details new code
	function get_video_details(Request $request, $url = "")
	{
		if ($url == "") {
			$url = $request->url;
		}

		$host = explode('.', str_replace('www.', '', strtolower(parse_url($url, PHP_URL_HOST))));
		$host = isset($host[0]) ? $host[0] : $host;

		$vimeo_api_key = get_settings('vimeo_api_key');
		$youtube_api_key = get_settings('youtube_api_key');

		if ($host == 'vimeo') {
			$video_id = substr(parse_url($url, PHP_URL_PATH), 1);
			$options = array('http' => array(
				'method'  => 'GET',
				'header' => 'Authorization: Bearer ' . $vimeo_api_key
			));
			$context  = stream_context_create($options);

			try {
				$hash = json_decode(file_get_contents("https://api.vimeo.com/videos/{$video_id}", false, $context));
			} catch (\Throwable $th) {
				$hash = '';
			}

			if ($hash == '') return;


			return array(
				'provider'          => 'Vimeo',
				'video_id'			=> $video_id,
				'title'             => $hash->name,
				'thumbnail'         => $hash->pictures->sizes[0]->link,
				'video'             => $hash->link,
				'embed_video'       => "https://player.vimeo.com/video/" . $video_id,
				'duration'			=>	gmdate("H:i:s", $hash->duration)
			);
		} elseif ($host == 'youtube' || $host == 'youtu') {
			preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
			$video_id = $match[1];

			try {
				$hash = json_decode(file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=$video_id&key=$youtube_api_key"));
			} catch (\Throwable $th) {
				$hash = '';
			}

			if ($hash == '') return;

			$duration = new DateInterval($hash->items[0]->contentDetails->duration);
			return array(
				'provider'          => 'YouTube',
				'video_id'			=> $video_id,
				'title'             => $hash->items[0]->snippet->title,
				'thumbnail'         => 'https://i.ytimg.com/vi/' . $hash->items[0]->id . '/default.jpg',
				'video'             => "http://www.youtube.com/watch?v=" . $hash->items[0]->id,
				'embed_video'       => "http://www.youtube.com/embed/" . $hash->items[0]->id,
				'duration'       	=> $duration->format('%H:%I:%S'),
			);
		} elseif ($host == 'drive') {
		}
	}

	public function rendered_view($path = "", Request $request)
	{
		$page_data = array();
		foreach ($request->all() as $key => $value) :
			$page_data[$key] = $value;
		endforeach;

		return view($path, $page_data)->render();
	}
}
