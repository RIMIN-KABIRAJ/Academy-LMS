<?php

namespace App\Http\Controllers;

use FFMpeg\Coordinate\Point;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class WatermarkController extends Controller
{
    public static function encode($video, $file_name, $path)
    {
        $full_output_path = "{$path}/watermark/{$file_name}";
        $output           = str_replace(public_path(''), '', $full_output_path);
        $watermark_data   = self::getWatermarkData();

        FFMpeg::fromDisk('public')
            ->open($video)
            ->addWatermark(function (WatermarkFactory $watermark) use ($watermark_data) {
                $watermark->fromDisk('public')
                    ->open($watermark_data['logo'])
                    ->top($watermark_data['top'])
                    ->left($watermark_data['left']);
            })
            ->export()
            ->inFormat(new X264())
            ->toDisk('public')
            ->save($output);

        self::deleteTempWatermark(public_path($watermark_data['logo']));
        return true;
    }

    public static function getWatermarkData()
    {
        $watermark = [
            'top'     => get_player_settings('watermark_top') ?? 0,
            'left'    => get_player_settings('watermark_left') ?? 0,
            'opacity' => get_player_settings('watermark_opacity'),
            'logo'    => self::makeTempWatermark(get_player_settings('watermark_logo')),
        ];
        return $watermark;
    }

    public static function makeTempWatermark($logo)
    {
        $temp_img_name = File::name($logo) . '.png';
        $path          = 'uploads/watermark/temp';
        $temp_path     = public_path($path);
        $watermark     = "{$path}/{$temp_img_name}";

        $width   = get_player_settings('watermark_width') ?? 200;
        $height  = get_player_settings('watermark_height') ?? 120;
        $opacity = get_player_settings('watermark_opacity') ?? 10;

        if (! File::exists($temp_path)) {
            File::makeDirectory($temp_path, 0755, true);
        }

        Image::make(public_path($logo))
            ->encode('png', 90)
            ->opacity($opacity)
            ->orientate()
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save(public_path($watermark));

        return $watermark;
    }

    public static function deleteTempWatermark($path)
    {
        if (is_file($path) && file_exists($path)) {
            remove_file($path);
        }
    }

    // randomly changes position (not finished)
    public static function randomPositionWatermark($file, $file_name, $path)
    {
        $full_output_path = "{$path}/{$file_name}";
        $output           = str_replace(public_path(''), '', $full_output_path);
        $watermark_data   = self::getWatermarkData();

        $inputPath          = $file;
        $outputPath         = $output;
        $watermarkImagePath = public_path($watermark_data['logo']);
        $watermarkImagePath = $watermark_data['logo'];

        $ffmpeg = FFMpeg::fromDisk('public')
            ->open($inputPath);

        $duration        = $ffmpeg->getDurationInSeconds();
        $videoDimensions = $ffmpeg->getVideoStream()->getDimensions();

        $width  = $videoDimensions->getWidth();
        $height = $videoDimensions->getHeight();

        $ffmpeg->addFilter(function ($filters) use ($width, $height, $watermarkImagePath, $duration) {
            for ($time = 0; $time < $duration; $time++) {
                $x = rand(0, $width - 100);
                $y = rand(0, $height - 100);

                $filters->watermark($watermarkImagePath, [
                    'position'   => new Point($x, $y),
                    'start_time' => TimeCode::fromSeconds($time),
                    'duration'   => 3,
                ]);
            }
        });

        $ffmpeg->export()
            ->toDisk('public')
            ->inFormat(new X264)
            ->save($outputPath);

        self::deleteTempWatermark(public_path($watermark_data['logo']));
        return true;
    }

}
