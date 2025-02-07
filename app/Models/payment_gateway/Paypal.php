<?php

namespace App\Models\payment_gateway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



//for paypal
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Paypal extends Model
{
    use HasFactory;

    public static function payment_status($identifier, $transaction_keys = [])
    {
        $payment_gateway = DB::table('payment_gateways')->where('identifier', $identifier)->first();
        $keys = json_decode($payment_gateway->keys, true);

        if ($payment_gateway->test_mode == 1) {
            $secret_key = $keys['sandbox_secret_key'];
            $client_id = $keys['sandbox_client_id'];
            $mode = 'sandbox';
            $paypalURL       = 'https://api.sandbox.paypal.com/v1/';
        } else {
            $secret_key = $keys['production_secret_key'];
            $client_id = $keys['production_client_id'];
            $mode = 'production';
            $paypalURL       = 'https://api.paypal.com/v1/';
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paypalURL . 'oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $client_id . ":" . $secret_key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $response = curl_exec($ch);
        curl_close($ch);

        if (empty($response)) {
            return false;
        } else {
            $jsonData = json_decode($response);
            $curl = curl_init($paypalURL . 'checkout/orders/' . $transaction_keys['payment_id']);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $jsonData->access_token,
                'Accept: application/json',
                'Content-Type: application/xml'
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            // Transaction data
            $result = json_decode($response);

            // CHECK IF THE PAYMENT STATE IS APPROVED OR NOT
            if ($result->status == 'approved' || $result->status == 'COMPLETED') {
                return true;
            } else {
                return false;
            }
        }
    }
}
