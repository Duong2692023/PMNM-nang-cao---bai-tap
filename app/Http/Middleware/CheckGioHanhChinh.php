<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGioHanhChinh
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $gioHanhChinhBatDau = 7; // 7 giờ sáng
        $gioHanhChinhKetThuc = 17; // 5 giờ chiều

        $gioHienTai = now()->hour;

        if ($gioHienTai < $gioHanhChinhBatDau || $gioHienTai >= $gioHanhChinhKetThuc) {
            return response()->json(['message' => 'Chỉ có thể truy cập ngoài giờ hành chính (7:00 - 17:00).'], 403);
        }

        return $next($request);
    }
}
