<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\IpHelper;
use App\Models\JaringanKantor;
use Symfony\Component\HttpFoundation\Response;

class CekIpJaringanKantor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $ipClient = $request->ip();
        $allowedRange = '172.16.31.0/24';

        if (IpHelper::ipInRange($ipClient, $allowedRange)) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'akses ditolak, IP Anda tidak terdaftar dalam jaringan kantor.');
    }
}
