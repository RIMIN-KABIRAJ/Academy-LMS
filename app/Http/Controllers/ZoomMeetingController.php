<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class ZoomMeetingController extends Controller
{
    public static function createToken()
    {
        $clientId     = get_settings('zoom_client_id');
        $clientSecret = get_settings('zoom_client_secret');
        $accountId    = get_settings('zoom_account_id');
        $oauthUrl     = 'https://zoom.us/oauth/token?grant_type=account_credentials&account_id=' . $accountId;

        try {
            // Create the Basic Authentication header
            $authHeader = 'Basic ' . base64_encode($clientId . ':' . $clientSecret);

            $ch = curl_init($oauthUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $authHeader));

            // Execute cURL session and get the response
            $response = curl_exec($ch);

            // Check if the request was successful (status code 200)
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpCode == 200) {
                $oauthResponse = json_decode($response, true);
                $accessToken   = $oauthResponse['access_token'];
                http_response_code(200);
                header('Content-Type: application/json');
                return $accessToken;
            } else {
                echo 'OAuth Request Failed with Status Code: ' . $httpCode . PHP_EOL;
                echo $response . PHP_EOL;
                return null;
            }
        } catch (Exception $e) {
            echo 'An error occurred: ' . $e->getMessage() . PHP_EOL;
            return null;
        }
    }

    public static function createMeeting($topic, $time)
    {
        $zoom_account_email = get_settings('zoom_account_email');
        $token              = self::createToken();

        // API Endpoint for creating a meeting
        $zoomEndpoint = 'https://api.zoom.us/v2/users/me/meetings';

        // Meeting data
        $meetingData = [
            'topic'        => $topic,
            'schedule_for' => $zoom_account_email,
            'type'         => 2,
            'start_time'   => date('Y-m-d\TH:i:s', strtotime($time)),
            'duration'     => 60,
            'timezone'     => 'UTC',
            'settings'     => [
                'approval_type'    => 2,
                'join_before_host' => true,
                'jbh_time'         => 0,
            ],
        ];
        // Prepare headers
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ];

        // Make POST request to create meeting
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $zoomEndpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($meetingData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        // JSON response
        return $response;
    }

    public static function updateMeeting($topic, $time, $meetingId)
    {
        $token = self::createToken();

        // API Endpoint for updating a meeting
        $zoomEndpoint = 'https://api.zoom.us/v2/meetings/' . $meetingId;

        // Meeting data with updated start time
        $meetingData = [
            'topic'      => $topic,
            'start_time' => date('Y-m-d\TH:i:s', strtotime($time)),
        ];

        // Prepare headers
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ];

        // Make PATCH request to update meeting
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $zoomEndpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($meetingData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        // JSON response
        return $response;
    }

    public static function deleteMeeting($meetingId)
    {
        $token = self::createToken();

        // API Endpoint for deleting a meeting
        $zoomEndpoint = 'https://api.zoom.us/v2/meetings/' . $meetingId;

        // Prepare headers
        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ];

        // Make DELETE request to delete meeting
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $zoomEndpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        // JSON response
        return $response;
    }

    public static function config()
    {
        $data['clientId']     = get_settings('zoom_client_id');
        $data['clientSecret'] = get_settings('zoom_client_secret');
        $data['accountId']    = get_settings('zoom_account_id');
        $data['email']        = get_settings('zoom_account_email');
        return $data;
    }
}
