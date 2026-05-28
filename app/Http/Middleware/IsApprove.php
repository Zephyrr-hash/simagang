<?php

namespace App\Http\Middleware;

use App\Models\Mahasiswa;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsApprove
{
    /**
     * Handle an incoming request.
     *
     * Middleware ini memastikan mahasiswa sudah memiliki magang yang aktif
     * sebelum mengakses halaman tertentu (logbook, bimbingan, dll).
     *
     * status_id pada tabel mahasiswa:
     *   2 = Sedang Magang (aktif)
     *   3 = Sudah Magang (selesai)
     * Catatan: nilai ini berbeda dari konstanta Magang::DITERIMA/SELESAI
     * yang merujuk ke kolom `approval` pada tabel magang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $mhs = Mahasiswa::where('user_id', Auth::id())->first();

        // Pastikan profil mahasiswa sudah ada
        if ($mhs === null) {
            return redirect()->route('redirect')
                ->with('error', 'Profil mahasiswa tidak ditemukan.');
        }

        // status_id 2 = Sedang Magang, status_id 3 = Sudah Magang
        if ($mhs->status_id == 2 || $mhs->status_id == 3) {
            return $next($request);
        }

        return redirect()->route('redirect')
            ->with('error', 'Anda belum memiliki magang yang aktif.');
    }
}
