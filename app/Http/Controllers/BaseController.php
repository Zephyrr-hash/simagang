<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Mitra;
use App\Models\Role;
use App\Models\Supervisor;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    /**
     * Mendapatkan data profil user yang sedang login beserta foto dan nama
     * berdasarkan role yang dimiliki.
     *
     * @return array{profile: \Illuminate\Database\Eloquent\Model|null, foto: string, nama: string, role_id: int}
     */
    public function getAuthProfile(): array
    {
        $user = Auth::user();

        $profile = match ((int) $user->role_id) {
            Role::DEPARTEMEN => Departemen::where('user_id', $user->id)->first(),
            Role::MITRA      => Mitra::where('user_id', $user->id)->first(),
            Role::DOSPEM     => Dosen::where('user_id', $user->id)->first(),
            Role::SUPERVISOR => Supervisor::where('user_id', $user->id)->first(),
            Role::MAHASISWA  => Mahasiswa::where('user_id', $user->id)->first(),
            Role::SUPERADMIN => null,
            default          => null,
        };

        [$fotoField, $namaField] = match ((int) $user->role_id) {
            Role::DEPARTEMEN => ['foto_depart', 'nama_depart'],
            Role::MITRA      => ['foto_mitra',  'nama_mitra'],
            Role::DOSPEM     => ['foto_dosen',  'nama_dosen'],
            Role::SUPERVISOR => ['foto_spv',    'nama_spv'],
            Role::MAHASISWA  => ['foto_mhs',    'nama_mhs'],
            default          => [null, null],
        };
        $foto = ($fotoField !== null ? $profile?->$fotoField : null) ?? 'default.png';
        $nama = ($namaField !== null ? $profile?->$namaField : null) ?? $user->name;

        return [
            'profile' => $profile,
            'foto'    => $foto,
            'nama'    => $nama,
            'role_id' => (int) $user->role_id,
        ];
    }
}
