<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class RecordVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $table, $param1, $param2 = null): Response
    {
        if (! Schema::hasTable($table)) {
            return redirect()->route('admin.team.packages')->with('error', get_phrase('Data table not found.'));
        }

        $query = DB::table($table)->where($param1, request($param1));

        if ($param2) {
            $param_value = request($param2);
            if ($param2 == 'user_id' && ! isset($param_value)) {
                $param_value = auth()->user()->id;
            }
            $query = $query->where($param2, $param_value);
        }

        if (! $query->exists()) {
            return redirect()->route('admin.team.packages')->with('error', get_phrase('Data not found.'));
        }
        return $next($request);
    }
}
