<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\DeviceIp;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request)
    {
        if($request->user_agent){
            $session_id = DeviceIp::where('user_agent', $request->user_agent)->first()->session_id;
            if($session_id){
                // Get the session file path (typically stored in storage/framework/sessions)
                $sessionFilePath = storage_path('framework/sessions/' . $session_id);
                // Check if the session file exists and delete it
                if (File::exists($sessionFilePath)) {
                    File::delete($sessionFilePath);
                    DeviceIp::where('user_agent', $request->user_agent)->delete();
                }
                Session::flash('success', get_phrase('You have successfully verified. You can login now.'));
            }
            return redirect(route('login'));
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();


        //Track device limitation
        if (Auth::check() && auth()->user()->role != 'admin') {
            $user            = Auth::user();
            $current_ip      = request()->getClientIp();
            $session_id = $request->session()->getId();
            $current_user_agent      = base64_encode($user->id.request()->header('user-agent'));
            $allowed_devices = get_settings('device_limitation') ?? 1; //minimum allowed 1 devices
            $logged_in_devices = DeviceIp::where('user_id', $user->id)->get();

            if ($logged_in_devices->where('user_agent', '!=', $current_user_agent)->count() < $allowed_devices) {
                if ($logged_in_devices->where('user_agent', $current_user_agent)->count() == 0) {
                    DeviceIp::insert([
                        'user_id'    => $user->id,
                        'ip_address' => $current_ip,
                        'session_id' => $session_id,
                        'user_agent' => $current_user_agent,
                    ]);
                } else {
                    DeviceIp::where('user_id', $user->id)->where('user_agent', $current_user_agent)->update([
                        'session_id' => $session_id,
                        'updated_at'    => date('Y-m-d H:i:s'),
                    ]);
                }
            } else {

                $logged_in_oldest_row = DeviceIp::where('user_id', $user->id)->orderBy('id', 'desc')->first();
                $data = [];
                $data['verification_link'] = route('login', ['user_agent' => $logged_in_oldest_row->user_agent]);

                try {
                    Mail::send('email.new_device_login_verification', $data, function ($message) use($user){
                        $message->to($user->email, $user->name)->subject('New login confirmation');
                    });
                    Auth::guard('web')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    Session::flash('success', get_phrase('A confirmation email has been sent. Please check your inbox to confirm access to this account from this device.'));
                    return redirect(route('login'));
                } catch (\Swift_TransportException $e) {
                    // Show a user-friendly message
                    Session::flash('error', 'We could not send the email. Please try again later.');
                } catch (Exception $e) {
                    Session::flash('error', 'Something went wrong. Please try again.');
                }
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect(route('login'));
            }
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        //Remove device 
        $current_user_agent = base64_encode(auth()->user()->id.request()->header('user-agent'));
        DeviceIp::where('user_id', auth()->user()->id)->where('user_agent', $current_user_agent)->delete();

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // if (rand(1, 5) == 2) {
        // // if (rand(1, 5)) {
        //     $this->dataReplace('logout');
        // }else{
        //     $this->dataReplace();
        // }

        return redirect(route('login'));
    }

    public function dataReplace($type = "")
    {
        //Need to add the schema on top of class, before using this function
        //use Illuminate\Support\Facades\Schema;
        //use DB;

        //Restore data only for demo
        if ($type == 'logout') {
            DB::unprepared(file_get_contents(base_path('public/assets/restore.sql')));
        }

        //Date update to show demo data every time
        $databaseName = \DB::connection()->getDatabaseName();
        $databaseNameObject = 'Tables_in_' . $databaseName;
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $key => $table) {
            if ($key % 2 == 0) {
                $current_timestamp = time() - rand(1, 86400);
            } else {
                $current_timestamp = time() - rand(1000, 40400);
            }

            if (Schema::hasColumn($table->$databaseNameObject, 'created_at')) {
                if (is_numeric(DB::table($table->$databaseNameObject)->value('created_at'))) {
                    DB::table($table->$databaseNameObject)->update(['created_at' => $current_timestamp]);
                } else {
                    DB::table($table->$databaseNameObject)->update(['created_at' => date('Y-m-d H:i:s', $current_timestamp)]);
                }
            }

            if (Schema::hasColumn($table->$databaseNameObject, 'updated_at')) {
                if (is_numeric(DB::table($table->$databaseNameObject)->value('updated_at'))) {
                    DB::table($table->$databaseNameObject)->update(['updated_at' => $current_timestamp]);
                } else {
                    DB::table($table->$databaseNameObject)->update(['updated_at' => date('Y-m-d H:i:s', $current_timestamp)]);
                }
            }

            if (Schema::hasColumn($table->$databaseNameObject, 'timestamp')) {
                DB::table($table->$databaseNameObject)->update(['timestamp' => $current_timestamp]);
            }
        }
    }
}
