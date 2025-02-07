<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use App\Models\FrontendSetting;
use App\Models\Language;
use App\Models\Builder_page;
use App\Models\HomePageSetting;
use App\Models\User;
use App\Models\UserReview;
use App\Models\Language_phrase;
use App\Models\PlayerSettings;
use App\Models\NotificationSetting;
use App\Models\Payment_gateway;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function system_settings()
    {
        return view("admin.setting.system_setting");
    }

    public function system_settings_update(Request $request)
    {
        $data = $request->all();

        array_shift($data);

        foreach ($data as $key => $item) {
            Setting::where('type', $key)->update(['description' => $item]);
        }
        Session::flash('success', get_phrase('System settings update successfully'));
        return redirect()->back();
    }

    public function website_settings()
    {

        return view("admin.setting.website_setting");
    }
    public function website_settings_update(Request $request)
    {
        $data = $request->all();
        array_shift($data);
        if ($request->type == 'frontend_settings') {

            foreach ($data as $key => $item) {
                FrontendSetting::where('key', $key)->update(['value' => $item]);
            }
            Session::flash('success', get_phrase('Frontend settings update successfully'));
        }
        if ($request->type == 'motivational_speech') {
            array_shift($data);

            $motivations = array();
            $images      = array();
            foreach (array_filter($data['titles']) as $key => $title) {
                $motivations[$key]['title']       = $title;
                $motivations[$key]['designation'] = $data['designation'][$key];
                $motivations[$key]['description'] = $data['descriptions'][$key];

                if ($_FILES['images']['name'][$key] != "") {
                    $motivations[$key]['image'] = FileUploader::upload($request->images[$key], "uploads/motivational_speech", 500);
                } else {
                    $motivations[$key]['image'] = $data['previous_images'][$key];
                }
                $images[$key] = $motivations[$key]['image'];
            }
            $files = glob('uploads/motivational_speech/' . '*');
            foreach ($files as $file) {
                $file_name_arr = explode('/', $file);
                $file_name     = end($file_name_arr);
                if (!in_array($file_name, $images)) {
                    remove_file($file);
                }
            }
            $data['value'] = json_encode($motivations);
            FrontendSetting::where('key', 'motivational_speech')->update(['value' => $data['value']]);
            Session::flash('success', get_phrase('Motivational speech update successfully'));
        }
        if ($request->type == 'websitefaqs') {
            array_shift($data);

            $faqs = array();
            foreach (array_filter($data['questions']) as $key => $question) {
                $faqs[$key]['question'] = $question;
                $faqs[$key]['answer']   = $data['answers'][$key];
            }

            $data['value'] = json_encode($faqs);
            $faq           = $data['value'];
            FrontendSetting::where('key', 'website_faqs')->update(['value' => $faq]);
            Session::flash('success', get_phrase('Website Faqs update successfully'));
        }
        if ($request->type == 'contact_info') {

            array_shift($data);
            $contact_information = json_encode($data);
            $row                 = FrontendSetting::where('key', 'contact_info')->get();
            if ($row->count() > 0) {
                FrontendSetting::where('key', 'contact_info')->update(['value' => $contact_information]);
            } else {
                FrontendSetting::where('key', 'contact_info')->update(['value' => $contact_information]);
            }
            Session::flash('success', get_phrase('Contact information update successfully'));
        }

        if ($request->type == 'recaptcha_settings') {
            array_shift($data);

            FrontendSetting::where('key', 'recaptcha_status')->update(['value' => $data['recaptcha_status']]);
            FrontendSetting::where('key', 'recaptcha_sitekey')->update(['value' => $data['recaptcha_sitekey']]);
            FrontendSetting::where('key', 'recaptcha_secretkey')->update(['value' => $data['recaptcha_secretkey']]);

            Session::flash('success', get_phrase('Recaptcha setting update successfully'));
        }

        if ($request->type == 'banner_image') {
            array_shift($data);

            if (isset($request->banner_image) && $request->banner_image != '') {

                $banner = $request->banner_image->extension();

                $data = "uploads/banner_image/" . nice_file_name('banner_image', $banner);
                FileUploader::upload($request->banner_image, $data);

                if (get_frontend_settings('home_page')) {
                    $active_banner = array(
                        get_frontend_settings('home_page') => $data
                    );
                    FrontendSetting::where('key', $request->type)->update(['value' => json_encode($active_banner)]);
                } else {
                    FrontendSetting::where('key', $request->type)->update(['value' => $data]);
                }

                Session::flash('success', get_phrase('Banner image update successfully'));
            }
        }
        if ($request->type == 'light_logo') {
            array_shift($data);

            if (isset($request->light_logo) && $request->light_logo != '') {

                $data = "uploads/light_logo/" . nice_file_name('light_logo', $request->light_logo->extension());
                FileUploader::upload($request->light_logo, $data, 400, null, 200, 200);

                FrontendSetting::where('key', $request->type)->update(['value' => $data]);
                Session::flash('success', get_phrase('Light logo update successfully'));
            }
        }
        if ($request->type == 'dark_logo') {
            array_shift($data);

            if (isset($request->dark_logo) && $request->dark_logo != '') {

                $data = "uploads/dark_logo/" . nice_file_name('dark_logo', $request->dark_logo->extension());
                FileUploader::upload($request->dark_logo, $data, 400, null, 200, 200);

                FrontendSetting::where('key', $request->type)->update(['value' => $data]);
                Session::flash('success', get_phrase('Dark logo update successfully'));
            }
        }
        if ($request->type == 'small_logo') {
            array_shift($data);

            if (isset($request->small_logo) && $request->small_logo != '') {

                $data = "uploads/small_logo/" . nice_file_name('small_logo', $request->small_logo->extension());
                FileUploader::upload($request->small_logo, $data, 400, null, 200, 200);

                FrontendSetting::where('key', $request->type)->update(['value' => $data]);
                Session::flash('success', get_phrase('Small logo update successfully'));
            }
        }
        if ($request->type == 'favicon') {
            array_shift($data);

            if (isset($request->favicon) && $request->favicon != '') {

                $data = "uploads/favicon/" . nice_file_name('favicon', $request->favicon->extension());
                FileUploader::upload($request->favicon, $data, 400, null, 200, 200);

                FrontendSetting::where('key', $request->type)->update(['value' => $data]);
                Session::flash('success', get_phrase('Favicon logo update successfully'));
            }
        }
        return redirect()->back();
    }

    public function drip_content_settings()
    {

        return view("admin.setting.drip_content_setting");
    }

    public function drip_content_settings_update(Request $request)
    {

        $alldata = $request->all();
        array_shift($alldata);
        $data['value'] = json_encode($alldata);
        Setting::where('type', 'drip_content_settings')->update(['description' => $data['value']]);
        Session::flash('success', get_phrase('Drip content settings update successfully'));
        return redirect()->back();
    }

    public function payment_settings()
    {

        return view("admin.setting.payment_setting");
    }
    public function payment_settings_update(Request $request)
    {
        $data = $request->all(); 
        array_shift($data);

        if ($request->top_part == 'top_part') {
            foreach ($data as $key => $item) {
                Setting::where('type', $key)->update(['description' => $item]);
            }
        } else {
            if ($request->identifier == 'paypal') {
                $paypal = [
                    'sandbox_client_id'     => $data['sandbox_client_id'],
                    'sandbox_secret_key'    => $data['sandbox_secret_key'],
                    'production_client_id'  => $data['production_client_id'],
                    'production_secret_key' => $data['production_secret_key'],
                ];
                $paypal       = json_encode($paypal);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $paypal;
            } elseif ($request->identifier == 'stripe') {
                $stripe = [
                    'public_key'      => $data['public_key'],
                    'secret_key'      => $data['secret_key'],
                    'public_live_key' => $data['public_live_key'],
                    'secret_live_key' => $data['secret_live_key'],
                ];
                $stripe       = json_encode($stripe);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $stripe;
            } elseif ($request->identifier == 'razorpay') {
                $razorpay = [
                    'public_key' => $data['public_key'],
                    'secret_key' => $data['secret_key'],

                ];
                $razorpay     = json_encode($razorpay);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $razorpay;
            } elseif ($request->identifier == 'flutterwave') {
                $flutterwave = [
                    'public_key' => $data['public_key'],
                    'secret_key' => $data['secret_key'],

                ];
                $flutterwave  = json_encode($flutterwave);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $flutterwave;
            } elseif ($request->identifier == 'paytm') {
                $paytm = [
                    'paytm_merchant_key' => $data['paytm_merchant_key'],
                    'paytm_merchant_mid' => $data['paytm_merchant_mid'],
                    'paytm_merchant_website' => $data['paytm_merchant_website'],
                    'industry_type_id' => $data['industry_type_id'],
                    'channel_id' => $data['channel_id'],
                ];
                $paytm        = json_encode($paytm);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $paytm;
            } elseif ($request->identifier == 'offline') {
                $offline = [
                    'bank_information' => $data['bank_information'],

                ];
                $offline        = json_encode($offline);
                $data         = array_splice($data, 0, 4);

                $data['keys'] = $offline;
                unset($data['bank_information']);
            } elseif ($request->identifier == 'paystack') {
                $paystack = [
                    'secret_test_key'      => $data['secret_test_key'],
                    'public_test_key'      => $data['public_test_key'],
                    'secret_live_key' => $data['secret_live_key'],
                    'public_live_key' => $data['public_live_key'],
                ];
                $paystack       = json_encode($paystack);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $paystack;
            } elseif ($request->identifier == 'ccavenue') {
                $ccavenue = [
                    'ccavenue_merchant_id'      => $data['ccavenue_merchant_id'],
                    'ccavenue_working_key'      => $data['ccavenue_working_key'],
                    'ccavenue_access_code' => $data['ccavenue_access_code'],
                ];
                $ccavenue       = json_encode($ccavenue);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $ccavenue;
            }elseif ($request->identifier == 'pagseguro') {
                $pagseguro = [
                    'api_key'      => $data['api_key'],
                    'secret_key'      => $data['secret_key'],
                    'other_parameter' => $data['other_parameter'],
                ];
                $pagseguro       = json_encode($pagseguro);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $pagseguro;
            }elseif ($request->identifier == 'iyzico') {
                $iyzico = [
                    'api_test_key'      => $data['api_test_key'],
                    'secret_test_key'      => $data['secret_test_key'],
                    'api_live_key'      => $data['api_live_key'],
                    'secret_live_key' => $data['secret_live_key'],
                ];
                $iyzico       = json_encode($iyzico);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $iyzico;
            }elseif ($request->identifier == 'xendit') {
                $xendit = [
                    'api_key'      => $data['api_key'],
                    'secret_key'      => $data['secret_key'],
                    'other_parameter' => $data['other_parameter'],
                ];
                $xendit       = json_encode($xendit);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $xendit;
            }elseif ($request->identifier == 'payu') {
                $payu = [
                    'pos_id'      => $data['pos_id'],
                    'second_key'      => $data['second_key'],
                    'client_id'      => $data['client_id'],
                    'client_secret' => $data['client_secret'],
                ];
                $payu       = json_encode($payu);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $payu;
            }elseif ($request->identifier == 'skrill') {
                $skrill = [
                    'skrill_merchant_email'      => $data['skrill_merchant_email'],
                    'secret_passphrase'      => $data['secret_passphrase']
                ];
                $skrill       = json_encode($skrill);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $skrill;
            }elseif ($request->identifier == 'doku') {
                $doku = [
                    'client_id'      => $data['client_id'],
                    'shared_key'      => $data['shared_key']
                ];
                $doku       = json_encode($doku);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $doku;
            }elseif ($request->identifier == 'maxicash') {
                $maxicash = [
                    'merchant_id'      => $data['merchant_id'],
                    'merchant_password'      => $data['merchant_password']
                ];
                $maxicash       = json_encode($maxicash);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $maxicash;
            }elseif ($request->identifier == 'cashfree') {
                $cashfree = [
                    'client_id'      => $data['client_id'],
                    'client_secret'      => $data['client_secret']
                ];
                $cashfree       = json_encode($cashfree);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $cashfree;
            }elseif ($request->identifier == 'aamarpay') {
                $aamarpay = [
                    'store_id'      => $data['store_id'],
                    'signature_key'      => $data['signature_key']
                ];
                $aamarpay       = json_encode($aamarpay);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $aamarpay;
            }elseif ($request->identifier == 'tazapay') {
                $tazapay = [
                    'public_key'      => $data['public_key'],
                    'api_key'      => $data['api_key'],
                    'api_secret'      => $data['api_secret']
                ];
                $tazapay       = json_encode($tazapay);
                $data         = array_splice($data, 0, 4);
                $data['keys'] = $tazapay;
            }
            Payment_gateway::where('identifier', $request->identifier)->update($data);
        }

        Session::flash('success', get_phrase('Payment settings update successfully'));
        return redirect(route('admin.payment.settings', ['tab' => $request->identifier]));
    }

    function language_import(Request $request)
    {
        // Get the file name without extension
        $fileName = pathinfo($request->file('language_file')->getClientOriginalName(), PATHINFO_FILENAME);

        // Read JSON content from the uploaded file
        $jsonContent = json_decode(file_get_contents($request->file('language_file')->getPathname()), true);

        $language_name = ucfirst($fileName);

        if (Language::where('name', 'like', $language_name)->count() > 0) {
            $language_id = Language::where('name', 'like', $language_name)->first()->id;
        } else {
            $language_data['name'] = $language_name;
            $language_data['direction'] = 'ltr';
            $language_data['created_at'] = date('Y-m-d H:i:s');
            $language_id = Language::insertGetId($language_data);
        }

        // Insert phrases into the database
        foreach ($jsonContent as $phrase => $translated) {

            if (Language_phrase::where('language_id', $language_id)->where('phrase', $phrase)->count() > 0) {
                Language_phrase::where('language_id', $language_id)->where('phrase', $phrase)->update([
                    'translated' => $translated, // Assuming you want to store the language name
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                Language_phrase::create([
                    'language_id' => $language_id,
                    'phrase' => $phrase,
                    'translated' => $translated, // Assuming you want to store the language name
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        Session::flash('success', get_phrase('Language has been imported'));
        return redirect()->back();
    }

    public function manage_language()
    {
        return view('admin.setting.language_setting');
    }

    function language_direction_update(Request $request)
    {
        Language::where('id', $request->language_id)->update(['direction' => $request->direction]);
        return true;
    }

    function edit_phrase($lan_id)
    {
        $page_data['phrases'] = Language_phrase::where('language_id', $lan_id)->get();
        $page_data['language'] = Language::where('id', $lan_id)->first();
        return view('admin.setting.edit_phrase', $page_data);
    }

    function update_phrase(Request $request, $phrase_id)
    {
        $translated = $request->translated_phrase;

        Language_phrase::where('id', $phrase_id)->update(['translated' => $translated, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    function phrase_import($lan_id)
    {
        $english_lan_id = Language::where('name', 'like', 'English')->first()->id;
        foreach (Language_phrase::where('language_id', $english_lan_id)->get() as $en_lan_phrase) {
            if (Language_phrase::where('language_id', $lan_id)->where('phrase', $en_lan_phrase->phrase)->count() == 0) {
                Language_phrase::insert(['language_id' => $lan_id, 'phrase' => $en_lan_phrase->phrase, 'translated' => $en_lan_phrase->translated, 'created_at' => date('Y-m-d H:i:s')]);
            }
        }
        return redirect(route('admin.language.phrase.edit', ['lan_id' => $lan_id]));
    }

    public function language_store(Request $request)
    {

        if (Language::where('name', 'like', $request->language)->count() == 0) {
            $new_lan_id = Language::insertGetId(['name' => $request->language, 'direction' => 'ltr']);

            $english_lan_id = Language::where('name', 'like', 'English')->first()->id;

            foreach (Language_phrase::where('language_id', $english_lan_id)->get() as $en_lan_phrase) {
                Language_phrase::insert(['language_id' => $new_lan_id, 'phrase' => $en_lan_phrase->phrase, 'translated' => $en_lan_phrase->translated, 'created_at' => date('Y-m-d H:i:s')]);
            }
            Session::flash('success', get_phrase('Language added successfully'));
        } else {
            Session::flash('error', get_phrase('Language already exists'));
        }

        return redirect()->back();
    }

    function language_delete($id)
    {
        Language::where('id', $id)->delete();
        Language_phrase::where('language_id', $id)->delete();
        Session::flash('success', get_phrase('Language deleted successfully'));
        return redirect()->back();
    }

    public function notification_settings()
    {
        return view('admin.setting.notification_setting');
    }

    public function notification_settings_store(Request $request, $param1 = '', $id = '')
    {
        $data = $request->all();

        if ($param1 == 'smtp_settings') {
            array_shift($data);

            foreach ($data as $key => $item) {
                Setting::where('type', $key)->update(['description' => $item]);
            }

            if (isset($_GET['tab'])) {
                $page_data['tab'] = $_GET['tab'];
            } else {
                $page_data['tab'] = 'smtp-settings';
            }
            Session::flash('success', get_phrase('SMTP setting update successfully'));
        }
        if ($param1 == 'edit_email_template') {
            array_shift($data);
            unset($data['files']);
            $data['subject']  = json_encode($request->subject);
            $data['template'] = json_encode($request->template);
            NotificationSetting::where('id', $id)->update($data);

            if (isset($_GET['tab'])) {
                $page_data['tab'] = $_GET['tab'];
            } else {
                $page_data['tab'] = 'edit_email_template';
            }
            Session::flash('success', get_phrase('Email template update successfully'));
        }

        if ($param1 == 'notification_enable_disable') {

            $id                       = $request->id;
            $user_type                = $request->user_types;
            $notification_type        = $request->notification_type;
            $input_val                = $request->input_val;
            $notification_setting_row = NotificationSetting::where('id', $id)->first();
            if ($notification_type == 'system') {
                $json_to_arr                 = json_decode($notification_setting_row->system_notification, true);
                $json_to_arr[$user_type]     = $input_val;
                $data['system_notification'] = json_encode($json_to_arr);
            }
            if ($notification_type == 'email') {
                $json_to_arr                = json_decode($notification_setting_row->email_notification, true);
                $json_to_arr[$user_type]    = $input_val;
                $data['email_notification'] = json_encode($json_to_arr);
            }
            if ($notification_setting_row->is_editable == 1) {
                unset($data['notification_type']);
                unset($data['input_val']);
                unset($data['user_types']);
                NotificationSetting::where('id', $id)->update($data);

                if ($input_val == 1) {
                    $msg = 'Successfully enabled';
                } else {
                    $msg = 'Successfully disabled';
                }
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'msg'    => $msg,
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function about()
    {

        $purchase_code    = get_settings('purchase_code');
        $returnable_array = array(
            'purchase_code_status' => get_phrase('Not found'),
            'support_expiry_date'  => get_phrase('Not found'),
            'customer_name'        => get_phrase('Not found'),
        );

        $personal_token = "gC0J1ZpY53kRpynNe4g2rWT5s4MW56Zg";
        $url            = "https://api.envato.com/v3/market/author/sale?code=" . $purchase_code;
        $curl           = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:' . $purchase_code . '.json';
        $ch_verify  = curl_init($verify_url . '?code=' . $purchase_code);

        curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        $response = json_decode($cinit_verify_data, true);

        if (is_array($response) && isset($response['verify-purchase']) && count($response['verify-purchase']) > 0) {

            $item_name     = $response['verify-purchase']['item_name'];
            $purchase_time = $response['verify-purchase']['created_at'];
            $customer      = $response['verify-purchase']['buyer'];
            $licence_type  = $response['verify-purchase']['licence'];
            $support_until = $response['verify-purchase']['supported_until'];
            $customer      = $response['verify-purchase']['buyer'];

            $purchase_date = date("d M, Y", strtotime($purchase_time));

            $todays_timestamp         = strtotime(date("d M, Y"));
            $support_expiry_timestamp = strtotime($support_until);

            $support_expiry_date = date("d M, Y", $support_expiry_timestamp);

            if ($todays_timestamp > $support_expiry_timestamp) {
                $support_status = 'expired';
            } else {
                $support_status = 'valid';
            }

            $returnable_array = array(
                'purchase_code_status' => $support_status,
                'support_expiry_date'  => $support_expiry_date,
                'customer_name'        => $customer,
                'product_license'      => 'valid',
                'license_type'         => $licence_type,
            );
        } else {
            $returnable_array = array(
                'purchase_code_status' => 'invalid',
                'support_expiry_date'  => 'invalid',
                'customer_name'        => 'invalid',
                'product_license'      => 'invalid',
                'license_type'         => 'invalid',
            );
        }

        $data['application_details'] = $returnable_array;
        return view('admin.setting.about', $data);
    }

    function curl_request($code = '')
    {
        $purchase_code = $code;

        $personal_token = "FkA9UyDiQT0YiKwYLK3ghyFNRVV9SeUn";
        $url            = "https://api.envato.com/v3/market/author/sale?code=" . $purchase_code;
        $curl           = curl_init($url);

        //setting the header for the rest of the api
        $bearer   = 'bearer ' . $personal_token;
        $header   = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: ' . $bearer;

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:' . $purchase_code . '.json';
        $ch_verify  = curl_init($verify_url . '?code=' . $purchase_code);

        curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        $response = json_decode($cinit_verify_data, true);

        if (is_array($response) && count($response['verify-purchase']) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function save_valid_purchase_code($action_type, Request $request)
    {
        if ($action_type == 'update') {
            $data['description'] = $request->purchase_code;

            $status = $this->curl_request($data['description']);
            if ($status) {
                Setting::where('type', 'purchase_code')->update($data);
                session()->flash('success', get_phrase('Purchase code has been updated'));
                echo 1;
            } else {
                echo 0;
            }
        } else {
            return view('admin.setting.save_purchase_code');
        }
    }

    function api_configurations()
    {
        return view('admin.api_configuration.index');
    }

    function api_configuration_update(Request $request, $type = "")
    {

        if (Setting::where('type', $type)->count()) {
            Setting::where('type', $type)->update(['description' => $request->$type]);
            Session::flash('success', get_phrase('API updated successfully'));
        } else {
            Setting::where('type', $type)->insert(['type' => $type, 'description' => $request->$type]);
            Session::flash('success', get_phrase('API added successfully'));
        }

        return redirect()->back();
    }

    function certificate()
    {
        return view('admin.certificate.index');
    }

    function certificate_update_template(Request $request)
    {
        $request->validate(['certificate_template' => 'required|image']);

        $row = Setting::where('type', 'certificate_template');

        if ($row->count() > 0) {
            remove_file(get_settings('certificate_template'));
            $path = FileUploader::upload($request->certificate_template, 'uploads/certificate-template', 1000);
            Setting::where('type', 'certificate_template')->update(['description' => $path]);
        } else {
            $path = FileUploader::upload($request->certificate_template, 'uploads/certificate-template', 1000);
            Setting::insert(['type' => 'certificate_template', 'description' => $path]);
        }

        $certificate_builder_content = get_settings('certificate_builder_content');
        if ($certificate_builder_content) {
            // Use regular expression to replace the image source
            $modifiedHtml = preg_replace('/(<img[^>]+src=")([^"]+)(")/', '$1' . get_image($path) . '$3', $certificate_builder_content);
            Setting::where('type', 'certificate_builder_content')->update(['description' => $modifiedHtml]);
        }

        return redirect(route('admin.certificate.settings'))->with('success', get_phrase('Certificate template has been updated'));
    }

    function certificate_builder()
    {
        return view('admin.certificate.builder');
    }

    function certificate_builder_update(Request $request)
    {
        $request->validate(['certificate_builder_content' => 'required']);

        $row = Setting::where('type', 'certificate_builder_content');

        if ($row->count() > 0) {
            Setting::where('type', 'certificate_builder_content')->update(['description' => $request->certificate_builder_content]);
        } else {
            Setting::insert(['type' => 'certificate_builder_content', 'description' => $request->certificate_builder_content]);
        }
        Session::flash('success', get_phrase('Certificate builder template has been updated'));
        return route('admin.certificate.settings');
    }

    //User Review Add 
    public function user_review_add()
    {
        $page_data['userList'] = User::where('role', 'student')->get();
        return view('admin.setting.user_review_create', $page_data);
    }
    public function user_review_stor(Request $request)
    {
        $data = $request->all();
        $reviewAdd = new UserReview;
        $reviewAdd['user_id'] = $data['user_id'];
        $reviewAdd['rating'] = $data['rating'];
        $reviewAdd['review'] = $data['review'];
        $reviewAdd->save();
        Session::flash('success', get_phrase('Review added successfull'));
        return redirect()->back();
    }

    public function review_edit($id)
    {
        $page_data["review_data"] = UserReview::find($id);
        $page_data['userList'] = User::where('role', 'student')->get();
        return view("admin.setting.user_review_edit", $page_data);
    }
    public function review_update(Request $request, $id)
    {
        $data = $request->all();
        unset($data['_token']);
        UserReview::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Review Update successfully'));
        return redirect()->route('admin.website.settings');
    }

    public function review_delete($id)
    {
        $query = UserReview::where("id", $id);
        $query->delete();
        Session::flash('success', get_phrase('Review delete successfully'));
        return redirect()->back();
    }

    public function update_home(Request $request, $id)
    {
        $home_page = $request->type;
        if ($home_page == 'cooking') {
            $title = $request->input('title');
            $description = $request->input('description');
            $video_url = $request->input('video_url');
            $speech = [
                'title' => $title,
                'description' => $description,
                'video_url' => $video_url,
                'image' => $request->input('previous_image'),
            ];

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = $image->getClientOriginalName();
                FileUploader::upload($request->image, 'uploads/home_page_image/cooking/' . $image_name);
                $speech['image'] = $image_name;

                // Unlink the previous image if it exists
                $previous_image = $request->input('previous_image');
                if (!empty($previous_image)) {
                    $previous_image_path = public_path('uploads/home_page_image/cooking/') . $previous_image;
                    if (file_exists($previous_image_path)) {
                        remove_file($previous_image_path);
                    }
                }
            }
        } elseif ($home_page == 'university') {
            $homePageSetting = HomePageSetting::where('home_page_id', $id)->first();
            $storImage = json_decode($homePageSetting->value, true);

            if ($request->hasFile('image')) {
                $image_name = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
                FileUploader::upload($request->image, 'uploads/home_page_image/university/' . $image_name);
                $previous_image = $request->input('previous_image');
                $speech['image'] = $image_name;
                if (!empty($previous_image)) {
                    $previous_image_path = public_path('uploads/home_page_image/university/') . $previous_image;
                    if (file_exists($previous_image_path)) {
                        remove_file($previous_image_path);
                    }
                }
            } elseif (!array_key_exists('image', $storImage)) {
                $speech['image'] = 0;
            } else {
                $speech['image'] = $storImage['image'];
            }

            if ($request->hasFile('faq_image')) {
                $image_names = uniqid() . '.' . $request->file('faq_image')->getClientOriginalExtension();
                FileUploader::upload($request->faq_image, 'uploads/home_page_image/university/' . $image_name);
                $speech['faq_image'] = $image_names;
                $previous_images = $request->input('previous_faq_image');
                if (!empty($previous_images)) {
                    $previous_image_path = public_path('uploads/home_page_image/university/') . $previous_images;
                    if (file_exists($previous_image_path)) {
                        remove_file($previous_image_path);
                    }
                }
            } elseif (!array_key_exists('faq_image', $storImage)) {
                $speech['faq_image'] = 0;
            } else {
                $speech['faq_image'] = $storImage['faq_image'];
            }

            $slider_items = array();
            if ($request->previous_slider_items && is_array($request->previous_slider_items) && count($request->previous_slider_items) > 0) {
                foreach ($request->previous_slider_items as $key => $previous_slider_item) {

                    if ($previous_slider_item == 'no') {
                        if ($request->hasFile('slider_items.' . $key)) {
                            $file_path = FileUploader::upload($request->slider_items[$key], 'uploads/home_page_image/university', 1500);
                            if ($file_path) $slider_items[] = $file_path;
                        } else {
                            if (array_key_exists($key, $request->slider_items)) {
                                if ($request->slider_items[$key]) $slider_items[] = $request->slider_items[$key];
                            }
                        }
                    } else {
                        if ($request->hasFile('slider_items.' . $key)) {
                            remove_file($previous_slider_item);
                            $file_path = FileUploader::upload($request->slider_items[$key], 'uploads/home_page_image/university', 1500);
                            if ($file_path) $slider_items[] = $file_path;
                        } else {
                            $slider_items[] = $previous_slider_item;
                        }
                    }
                }
            }
            $speech['slider_items'] = json_encode($slider_items);
        } elseif ($home_page == 'development') {
            $title = $request->input('title');
            $description = $request->input('description');
            $video_url = $request->input('video_url');
            $speech = [
                'title' => $title,
                'description' => $description,
                'video_url' => $video_url,
                'image' => $request->input('previous_image'),
            ];
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = uniqid() . '.' . $image->getClientOriginalName();
                FileUploader::upload($request->image, 'uploads/home_page_image/development/' . $image_name);
                $speech['image'] = $image_name;

                // Unlink the previous image if it exists
                $previous_image = $request->input('previous_image');
                if (!empty($previous_image)) {
                    $previous_image_path = public_path('uploads/home_page_image/development/') . $previous_image;
                    if (file_exists($previous_image_path)) {
                        remove_file($previous_image_path);
                    }
                }
            }
        } elseif ($home_page == 'kindergarden') {
            $title = $request->input('title');
            $description = $request->input('description');
            $speech = [
                'title' => $title,
                'description' => $description,
                'image' => $request->input('previous_image'),
            ];
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = uniqid() . '.' . $image->getClientOriginalName();
                FileUploader::upload($request->image, 'uploads/home_page_image/kindergarden/' . $image_name);
                $speech['image'] = $image_name;

                // Unlink the previous image if it exists
                $previous_image = $request->input('previous_image');
                if (!empty($previous_image)) {
                    $previous_image_path = public_path('uploads/home_page_image/kindergarden/') . $previous_image;
                    if (file_exists($previous_image_path)) {
                        remove_file($previous_image_path);
                    }
                }
            }
        } elseif ($home_page == 'marketplace') {
            $title = $request->input('title');
            $description = $request->input('description');
            $video_url = $request->input('video_url');
            $instructor = [
                'title' => $title,
                'description' => $description,
                'video_url' => $video_url,
                'image' => $request->input('previous_image'),
            ];
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = uniqid() . '.' . $image->getClientOriginalName();
                FileUploader::upload($request->image, 'uploads/home_page_image/marketplace/' . $image_name);
                $instructor['image'] = $image_name;

                // Unlink the previous image if it exists
                $previous_image = $request->input('previous_image');
                if (!empty($previous_image)) {
                    $previous_image_path = public_path('uploads/home_page_image/marketplace/') . $previous_image;
                    if (file_exists($previous_image_path)) {
                        remove_file($previous_image_path);
                    }
                }
            }
            $sliders = $request->slider;
            $marketplace_banner = array();
            foreach ($sliders as $slider) {
                $banner_title_field = 'banner_title' . $slider;
                $banner_description_field = 'banner_description' . $slider;
                $datas['banner_title'] = $request->$banner_title_field;
                $datas['banner_description'] = $request->$banner_description_field;
                array_push($marketplace_banner, $datas);
            }
            $speech['instructor'] = $instructor;
            $speech['slider'] = $marketplace_banner;
        } elseif ($home_page == 'meditation') {
            if ($request->hasFile('big_image')) {
                $image_name = uniqid() . '.' . $request->file('big_image')->getClientOriginalExtension();
                FileUploader::upload($request->big_image, 'uploads/home_page_image/meditation/' . $image_name);
                $previous_image = $request->input('big_previous_image');
                $speech['big_image'] = $image_name;
                if (!empty($previous_image)) {
                    $previous_image_path = public_path('uploads/home_page_image/meditation/') . $previous_image;
                    if (file_exists($previous_image_path)) {
                        remove_file($previous_image_path);
                    }
                }
            } elseif (isset($storImage) && !array_key_exists('big_image', $storImage)) {
                $speech['big_image'] = 0;
            } elseif (isset($storImage)) {
                $speech['big_image'] = $storImage['big_image'];
            } else {
                $speech['big_image'] = $request->input('big_previous_image');
            }


            $meditations = $request->meditation;
            $meditation_array = array();
            foreach ($meditations as $meditation) {
                $meditation_title_field = 'banner_title' . $meditation;
                $meditation_image_field = 'image' . $meditation;
                $meditation_old_image_field = 'old_image' . $meditation;

                $image_name = $request->input($meditation_old_image_field);

                if ($request->hasFile($meditation_image_field)) {
                    $image = $request->file($meditation_image_field);
                    $image_name = uniqid() . '.' . $image->getClientOriginalName();
                    FileUploader::upload($request->image, 'uploads/home_page_image/meditation/' . $image_name);
                    $old_image = $request->input('old_image');
                    $previous_path = public_path('uploads/home_page_image/meditation/') . $old_image;
                    if (file_exists('uploads/home_page_image/meditation/' . $old_image)) {
                        remove_file($previous_path);
                    }
                }
                $meditation_description_field = 'banner_description' . $meditation;
                $stor['banner_title'] = $request->$meditation_title_field;
                $stor['image'] = $image_name;
                $stor['banner_description'] = $request->$meditation_description_field;
                array_push($meditation_array, $stor);
            }
            $speech['meditation'] = $meditation_array;
        }


        $data['home_page_id'] =  $id;
        $data['key'] =  $home_page;
        $data['value'] = json_encode($speech);
        $homePageSetting = HomePageSetting::where('key', $home_page);
        if ($homePageSetting->first()) {
            $homePageSetting->update($data);
        } else {
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            $homePageSetting->insert($data);
        }
        Session::flash('success', get_phrase('Homepage updated successfully'));
        return redirect()->back();
    }

    public function player_settings()
    {
        return view('admin.setting.player_settings');
    }
    public function player_settings_update(Request $request)
    {
        if ($request->type == 'watermark') {
            $watermark['watermark_width']   = $request->watermark_width;
            $watermark['watermark_height']  = $request->watermark_height;
            $watermark['watermark_top']     = $request->watermark_top;
            $watermark['watermark_left']    = $request->watermark_left;
            $watermark['watermark_opacity'] = $request->watermark_opacity;
            $watermark['watermark_type']    = $request->watermark_type;
            $watermark['watermark_logo']    = $request->watermark_logo;
            $watermark['animation_speed']    = $request->animation_speed;
            

            $validator = Validator::make($watermark, [
                'watermark_width'   => 'required|numeric',
                'watermark_height'  => 'required|numeric',
                'watermark_top'     => 'required|numeric',
                'watermark_left'    => 'required|numeric',
                'watermark_opacity' => 'required|integer|min:0|max:100',
                'watermark_type'    => 'required|in:js,ffmpeg',
                'animation_speed'   => 'required|numeric',
            ]);

            $validator->sometimes('watermark_logo', 'file|mimes:png,jpg,gif', function ($input) {
                return isset($input->watermark_logo);
            });

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            unset($watermark['watermark_logo']);
            if (isset($request->watermark_logo) && $request->watermark_logo != '') {
                $watermark['watermark_logo'] = "uploads/watermark/" . nice_file_name('watermark', $request->watermark_logo->extension());
                FileUploader::upload($request->watermark_logo, $watermark['watermark_logo']);
            }

            foreach ($watermark as $key => $data) {
                if (! PlayerSettings::where('title', $key)->exists()) {
                    PlayerSettings::insert(['title' => $key, 'description' => $data]);
                    continue;
                }
                PlayerSettings::where('title', $key)->update(['description' => $data]);
            }
        }

        Session::flash('success', get_phrase('Your changes has been saved.'));
        return redirect()->route('admin.player.settings');
    }
}
