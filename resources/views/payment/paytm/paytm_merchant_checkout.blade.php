@php

    //start common code of all payment gateway
    $identifier = 'paytm';
    $payment_details = session('payment_details');
    $model = $payment_details['success_method']['model_name'];
    $payment_gateway = DB::table('payment_gateways')->where('identifier', $identifier)->first();
    $user = auth()->user();

    $paytm_merchant_key = $paytm_merchant_mid = $paytm_merchant_website = $industry_type_id = $channel_id = '';
    if ($model == 'InstructorPayment') {
        $instructor_payment_keys = DB::table('users')
            ->where('id', $payment_details['items'][0]['id'])
            ->value('paymentkeys');
        $keys = isset($instructor_payment_keys) ? json_decode($instructor_payment_keys) : null;
        if ($keys) {
            $paytm_merchant_key = $keys->paytm->paytm_merchant_key;
            $paytm_merchant_mid = $keys->paytm->paytm_merchant_mid;
            $paytm_merchant_website = $keys->paytm->paytm_merchant_website;
            $industry_type_id = $keys->paytm->industry_type_id;
            $channel_id = $keys->paytm->channel_id;
        }
    } else {
        $keys = json_decode($payment_gateway->keys);
        $paytm_merchant_key = $keys->paytm_merchant_key;
        $paytm_merchant_mid = $keys->paytm_merchant_mid;
        $paytm_merchant_website = $keys->paytm_merchant_website;
        $industry_type_id = $keys->industry_type_id;
        $channel_id = $keys->channel_id;
    }

    if ($payment_gateway->test_mode == 1) {
        // define('PAYTM_ENVIRONMENT', 'TEST'); // PROD or TEST
        $PAYTM_STATUS_QUERY_NEW_URL = 'https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
        $PAYTM_TXN_URL = 'https://securegw-stage.paytm.in/theia/processTransaction';
    } else {
        define('PAYTM_ENVIRONMENT', 'PROD'); // PROD or TEST
        $PAYTM_STATUS_QUERY_NEW_URL = 'https://securegw.paytm.in/merchant-status/getTxnStatus';
        $PAYTM_TXN_URL = 'https://securegw.paytm.in/theia/processTransaction';
    }

    define('PAYTM_MERCHANT_KEY', $paytm_merchant_key);
    define('PAYTM_MERCHANT_MID', $paytm_merchant_mid);
    define('PAYTM_MERCHANT_WEBSITE', $paytm_merchant_website);
    define('PAYTM_REFUND_URL', '');
    define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
    define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
    define('PAYTM_TXN_URL', $PAYTM_TXN_URL);

    //ended common code of all payment gateway

    if (!function_exists('encrypt_e_new_sads')) {
        function encrypt_e_new_sads($input, $ky)
        {
            $key = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_encrypt($input, 'AES-128-CBC', $key, 0, $iv);
            return $data;
        }
    }

    if (!function_exists('decrypt_e')) {
        function decrypt_e($crypt, $ky)
        {
            $key = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_decrypt($crypt, 'AES-128-CBC', $key, 0, $iv);
            return $data;
        }
    }

    if (!function_exists('generateSalt_e')) {
        function generateSalt_e($length)
        {
            $random = '';
            srand((float) microtime() * 1000000);

            $data = 'AbcDE123IJKLMN67QRSTUVWXYZ';
            $data .= 'aBCdefghijklmn123opq45rs67tuv89wxyz';
            $data .= '0FGH45OP89';

            for ($i = 0; $i < $length; $i++) {
                $random .= substr($data, rand() % strlen($data), 1);
            }

            return $random;
        }
    }

    if (!function_exists('checkString_e')) {
        function checkString_e($value)
        {
            if ($value == 'null') {
                $value = '';
            }
            return $value;
        }
    }

    if (!function_exists('getChecksumFromArray')) {
        function getChecksumFromArray($arrayList, $key, $sort = 1)
        {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . '|' . $salt;
            $hash = hash('sha256', $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e_new_sads($hashString, $key);
            return $checksum;
        }
    }
    if (!function_exists('getChecksumFromString')) {
        function getChecksumFromString($str, $key)
        {
            $salt = generateSalt_e(4);
            $finalString = $str . '|' . $salt;
            $hash = hash('sha256', $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e_new_sads($hashString, $key);
            return $checksum;
        }
    }

    if (!function_exists('verifychecksum_e')) {
        function verifychecksum_e($arrayList, $key, $checksumvalue)
        {
            $arrayList = removeCheckSumParam($arrayList);
            ksort($arrayList);
            $str = getArray2StrForVerify($arrayList);
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);

            $finalString = $str . '|' . $salt;

            $website_hash = hash('sha256', $finalString);
            $website_hash .= $salt;

            $validFlag = 'FALSE';
            if ($website_hash == $paytm_hash) {
                $validFlag = 'TRUE';
            } else {
                $validFlag = 'FALSE';
            }
            return $validFlag;
        }
    }

    if (!function_exists('verifychecksum_eFromStr')) {
        function verifychecksum_eFromStr($str, $key, $checksumvalue)
        {
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);

            $finalString = $str . '|' . $salt;

            $website_hash = hash('sha256', $finalString);
            $website_hash .= $salt;

            $validFlag = 'FALSE';
            if ($website_hash == $paytm_hash) {
                $validFlag = 'TRUE';
            } else {
                $validFlag = 'FALSE';
            }
            return $validFlag;
        }
    }

    if (!function_exists('getArray2Str')) {
        function getArray2Str($arrayList)
        {
            $findme = 'REFUND';
            $findmepipe = '|';
            $paramStr = '';
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pos = strpos($value, $findme);
                $pospipe = strpos($value, $findmepipe);
                if ($pos !== false || $pospipe !== false) {
                    continue;
                }

                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= '|' . checkString_e($value);
                }
            }
            return $paramStr;
        }
    }

    if (!function_exists('getArray2StrForVerify')) {
        function getArray2StrForVerify($arrayList)
        {
            $paramStr = '';
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= '|' . checkString_e($value);
                }
            }
            return $paramStr;
        }
    }

    if (!function_exists('redirect2PG')) {
        function redirect2PG($paramList, $key)
        {
            $hashString = getchecksumFromArray($paramList);
            $checksum = encrypt_e_new_sads($hashString, $key);
        }
    }

    if (!function_exists('removeCheckSumParam')) {
        function removeCheckSumParam($arrayList)
        {
            if (isset($arrayList['CHECKSUMHASH'])) {
                unset($arrayList['CHECKSUMHASH']);
            }
            return $arrayList;
        }
    }

    if (!function_exists('getTxnStatus')) {
        function getTxnStatus($requestParamList)
        {
            return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
        }
    }

    if (!function_exists('getTxnStatusNew')) {
        function getTxnStatusNew($requestParamList)
        {
            return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
        }
    }

    if (!function_exists('initiateTxnRefund')) {
        function initiateTxnRefund($requestParamList)
        {
            $CHECKSUM = getRefundChecksumFromArray($requestParamList, PAYTM_MERCHANT_KEY, 0);
            $requestParamList['CHECKSUM'] = $CHECKSUM;
            return callAPI(PAYTM_REFUND_URL, $requestParamList);
        }
    }

    if (!function_exists('callAPI')) {
        function callAPI($apiURL, $requestParamList)
        {
            $jsonResponse = '';
            $responseParamList = [];
            $JsonData = json_encode($requestParamList);
            $postData = 'JsonData=' . urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($postData)]);
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse, true);
            return $responseParamList;
        }
    }

    if (!function_exists('callNewAPI')) {
        function callNewAPI($apiURL, $requestParamList)
        {
            $jsonResponse = '';
            $responseParamList = [];
            $JsonData = json_encode($requestParamList);
            $postData = 'JsonData=' . urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($postData)]);
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse, true);
            return $responseParamList;
        }
    }
    if (!function_exists('getRefundChecksumFromArray')) {
        function getRefundChecksumFromArray($arrayList, $key, $sort = 1)
        {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getRefundArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . '|' . $salt;
            $hash = hash('sha256', $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e_new_sads($hashString, $key);
            return $checksum;
        }
    }
    if (!function_exists('getRefundArray2Str')) {
        function getRefundArray2Str($arrayList)
        {
            $findmepipe = '|';
            $paramStr = '';
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pospipe = strpos($value, $findmepipe);
                if ($pospipe !== false) {
                    continue;
                }

                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= '|' . checkString_e($value);
                }
            }
            return $paramStr;
        }
    }
    if (!function_exists('callRefundAPI')) {
        function callRefundAPI($refundApiURL, $requestParamList)
        {
            $jsonResponse = '';
            $responseParamList = [];
            $JsonData = json_encode($requestParamList);
            $postData = 'JsonData=' . urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $refundApiURL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = [];
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse, true);
            return $responseParamList;
        }
    }

    // Create an array having all required parameters for creating checksum.
    $paramList = [];
    $paramList['MID'] = $paytm_merchant_mid;
    $paramList['ORDER_ID'] = 'ORDS' . rand(10000, 99999999);
    $paramList['CUST_ID'] = 'CUST' . $user->id;
    $paramList['INDUSTRY_TYPE_ID'] = $industry_type_id;
    $paramList['CHANNEL_ID'] = $channel_id;
    $paramList['TXN_AMOUNT'] = $payment_details['payable_amount'];
    $paramList['WEBSITE'] = $paytm_merchant_website;
    $paramList['CALLBACK_URL'] = $payment_details['success_url'] . '/' . $identifier;

    //Here checksum string will return by getChecksumFromArray() function.
    $checkSum = getChecksumFromArray($paramList, $paytm_merchant_key);

@endphp




<html>

<head>
    <title>Merchant Check Out Page</title>
</head>

<body>
    <center>
        <h1>{{ get_phrase('Please do not refresh this page') }}...</h1>
    </center>
    <form method='post' action='{{ PAYTM_TXN_URL }}' name='f1'>
        <table border="f1">
            <tbody>
                @foreach ($paramList as $name => $value)
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                @endforeach
                <input type='hidden' name='CHECKSUMHASH' value='{{ $checkSum }}'>
            </tbody>
        </table>
        <script type='text/javascript'>
            document.f1.submit();
        </script>
    </form>
</body>

</html>
