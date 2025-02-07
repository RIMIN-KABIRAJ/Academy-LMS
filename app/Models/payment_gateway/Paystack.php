<?php

namespace App\Models\payment_gateway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class Paystack extends Model
{
	use HasFactory;


  public static function create_xendit_payment($identifier = "") {
	
	  $payment_details = session('payment_details');
	  $payment_gateway = DB::table('payment_gateways')->where('identifier', $identifier)->first();
	  $keys = json_decode($payment_gateway->keys, true);
	  $test_mode = $payment_gateway->test_mode == 1 ? 1 : 0;
	  if($test_mode == 1){
		  $secret_key = $keys['secret_test_key'];  
	  } else {
		  $secret_key = $keys['secret_live_key'];
	  }
	  $reference = isset($_GET['reference']) ? $_GET['reference'] : '';

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http")."://api.paystack.co/transaction/verify/".$_GET['reference'],
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"Authorization: Bearer ".$secret_key,
		"Cache-Control: no-cache",
	  ),
	));
	
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if ($err) {
	  return false;
	} else {
	  return true;
	}
  }





}
