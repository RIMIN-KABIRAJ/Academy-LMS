<?php

namespace App\Http\Controllers\instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\FileUploader;
use App\Models\Setting;

class OpenAiController extends Controller
{
    
    function generate(Request $request)
    {
        if ($request->service_type == 'Course thumbnail') {
            $prompt = "We have run a online LMS system. Please generate course thumbnails for me. \n Course topic: " . $request->ai_keywords;
            return $this->curl_call_to_generate_image_openai($prompt);
        } else {
            $prompt = "Write me a ";
            $prompt .= $request->service_type;
            $prompt .= " on ";
            $prompt .= $request->ai_keywords;
            $prompt .= " in ";
            $prompt .= $request->language;
            $prompt .= " language";

            $instructions = "You are a " . $request->service_type . " writer.";
            return $this->curl_call_to_generate_text_by_openai($prompt, $instructions);
        }
    }

    function curl_call_to_generate_image_openai($prompt)
    {
        $open_ai_secret_key = get_settings('open_ai_secret_key');

        $curlopt_post = ['prompt' => $prompt, 'model' => 'dall-e-3', 'size' => '1024x1024', 'n' => 1];
        $curlopt_post_url = 'https://api.openai.com/v1/images/generations';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curlopt_post_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $open_ai_secret_key,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlopt_post));

        $response = curl_exec($ch);

        curl_close($ch);

        $response_arr = json_decode($response, true);
        if (array_key_exists('error', $response_arr)) {
            return 'Error: ' . $response_arr['error']['message'];
        } else {
            return json_encode($response_arr['data']);
        }
    }

    function curl_call_to_generate_text_by_openai($instructions, $prompt)
    {
        $open_ai_secret_key = get_settings('open_ai_secret_key');
        $open_ai_model = get_settings('open_ai_model');
        $endpoint = "https://api.openai.com/v1/chat/completions";

        $data = array(
            "model" => $open_ai_model,
            "messages" => array(
                array(
                    "role" => "system",
                    "content" => $instructions
                ),
                array(
                    "role" => "user",
                    "content" => "$prompt"
                )
            )
        );

        $ch = curl_init($endpoint);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $open_ai_secret_key
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $response = json_decode($response, true);
            if (is_array($response)) {
                return $response['choices'][0]['message']['content'] ?? '';
            }
        }
    }
}
