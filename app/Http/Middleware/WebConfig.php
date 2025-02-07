<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        config(
            [
                'app.name' => get_settings('system_title'),
                'app.timezone' => get_settings('timezone'),

                // //SMTP configuration
                'mail.mailers.smtp.transport' => get_settings('protocol'),
                'mail.mailers.smtp.host' => get_settings('smtp_host'),
                'mail.mailers.smtp.port' => get_settings('smtp_port'),
                'mail.mailers.smtp.encryption' => get_settings('smtp_crypto'),
                'mail.mailers.smtp.username' => get_settings('smtp_user'),
                'mail.mailers.smtp.password' => get_settings('smtp_pass'),
                'mail.mailers.smtp.timeout' => null,
                'mail.mailers.smtp.local_domain' => $_SERVER['SERVER_NAME'],
                'mail.from.name' => get_settings('system_title'),
                'mail.from.address' => get_settings('smtp_from_email'),
            ]
        );
        return $next($request);
    }
}
