<?php

namespace App\Http\Middleware;

use App\Models\Profile;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Jika admin sedang login, izinkan akses penuh (Bypass)
        if (auth()->check()) {
            return $next($request);
        }

        // 2. Rute otentikasi & deploy rahasia selalu diizinkan
        if ($request->is('login*') || $request->is('admin*') || $request->is('update-rahasia-portofolio*')) {
            return $next($request);
        }

        // 3. Cek pengaturan profil & status landing page
        $profile = Profile::with('socialLinks')->first();

        if ($profile && isset($profile->enable_landing_page) && !$profile->enable_landing_page) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'maintenance',
                    'message' => $profile->maintenance_message ?: 'Website portofolio sedang dalam proses pemeliharaan & pembaruan.',
                ], 503);
            }

            return response()->view('errors.maintenance', [
                'profile' => $profile,
                'title' => $profile->maintenance_title ?: 'Sistem Sedang Dalam Pemeliharaan & Pembaruan',
                'message' => $profile->maintenance_message ?: 'Website portofolio kami sedang dalam proses perbaruan karya dan peningkatan fitur terbaru untuk menghadirkan pengalaman terbaik. Kami akan segera kembali online!',
                'status' => $profile->maintenance_status ?: 'maintenance',
                'isPreview' => false,
            ], 200);
        }

        return $next($request);
    }
}
