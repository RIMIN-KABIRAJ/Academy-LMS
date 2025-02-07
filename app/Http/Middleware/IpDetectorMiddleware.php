<?php

namespace App\Http\Middleware;

use App\Models\DeviceIp;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class IpDetectorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && auth()->user()->role != 'admin') {
            $user            = Auth::user();
            $current_ip      = request()->getClientIp();
            $current_user_agent      = base64_encode(request()->header('user-agent'));
            $allowed_devices = get_settings('device_limitation') ?? 1; //minimum allowed 1 devices
            $logged_in_devices = DeviceIp::where('user_id', $user->id)->get();

            if($logged_in_devices->count() < $allowed_devices){
                if($logged_in_devices->where('user_agent', $current_user_agent)->count() == 0){
                    DeviceIp::insert([
                        'user_id'    => $user->id,
                        'ip_address' => $current_ip,
                        'user_agent' => $current_user_agent,
                    ]);
                }
            }else{
                Session::flash('error', 'Max device limit reached.');
                return redirect()->route('home');
            }
        }
        return $next($request);
    }
}