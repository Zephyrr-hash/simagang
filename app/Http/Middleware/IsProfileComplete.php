<?php

namespace App\Http\Middleware;

use App\Models\Departemen;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Mitra;
use App\Models\Role;
use App\Models\Supervisor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsProfileComplete
{
    /**
     * Daftar route yang dikecualikan dari pengecekan kelengkapan profil.
     * Menggunakan nama route (route name).
     */
    protected array $except = [
        'profile.index',
        'profile.edit',
        'profile.update',
        'profile.store',
        'profile.create',
        'logout',
    ];

    /**
     * Handle an incoming request.
     * Redirect ke halaman profil jika profil belum dibuat atau belum lengkap.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Lewati jika bukan request GET (POST/PUT/DELETE tidak perlu dicek)
        // Kecuali untuk route yang memang dikecualikan
        $currentRoute = $request->route()?->getName();

        if (in_array($currentRoute, $this->except, true)) {
            return $next($request);
        }

        $user    = Auth::user();
        $roleId  = (int) $user->role_id;

        // Ambil profil berdasarkan role
        $profile = match ($roleId) {
            Role::DEPARTEMEN => Departemen::where('user_id', $user->id)->first(),
            Role::MITRA      => Mitra::where('user_id', $user->id)->first(),
            Role::DOSPEM     => Dosen::where('user_id', $user->id)->first(),
            Role::SUPERVISOR => Supervisor::where('user_id', $user->id)->first(),
            Role::MAHASISWA  => Mahasiswa::where('user_id', $user->id)->first(),
            default          => null,
        };

        // Profil belum dibuat sama sekali → redirect ke halaman profil
        if ($profile === null) {
            return redirect()->route('profile.index')
                ->with('profile_incomplete', 'Silakan lengkapi profil Anda terlebih dahulu sebelum menggunakan fitur lainnya.');
        }

        // Cek kolom-kolom wajib terisi
        $isComplete = match ($roleId) {
            Role::DEPARTEMEN => filled($profile->nama_depart)
                             && filled($profile->alamat_depart)
                             && filled($profile->telepon_depart)
                             && filled($profile->NIDN),

            Role::MITRA      => filled($profile->nama_mitra)
                             && filled($profile->alamat_mitra)
                             && filled($profile->telepon_mitra)
                             && filled($profile->kab_id),

            Role::DOSPEM     => filled($profile->nama_dosen)
                             && filled($profile->telepon_dosen)
                             && filled($profile->NIP)
                             && filled($profile->depart_id),

            Role::SUPERVISOR => filled($profile->nama_spv)
                             && filled($profile->telepon_spv)
                             && filled($profile->no_pegawai)
                             && filled($profile->mitra_id),

            Role::MAHASISWA  => filled($profile->nama_mhs)
                             && filled($profile->NIM)
                             && filled($profile->telepon_mhs)
                             && filled($profile->pengalaman)
                             && filled($profile->jurusan_id)
                             && filled($profile->jenis_kelamin)
                             && filled($profile->tgl_lahir)
                             && filled($profile->depart_id),

            default          => true,
        };

        if (!$isComplete) {
            return redirect()->route('profile.index')
                ->with('profile_incomplete', 'Profil Anda belum lengkap. Silakan isi semua data yang diperlukan sebelum menggunakan fitur lainnya.');
        }

        return $next($request);
    }
}
