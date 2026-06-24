<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Magang;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraController extends BaseController
{
    public function countPendaftar(): int
    {
        $mitra = Mitra::where('user_id', Auth::id())->first();
        if (!$mitra) return 0;

        return Magang::whereHas('lowongan', function ($q) use ($mitra) {
            $q->where('mitra_id', $mitra->id);
        })->where('approval', Magang::PENDING)->count();
    }

    public function mitraHome()
    {
        // Superadmin diarahkan ke dashboard-nya sendiri
        if ((int) Auth::user()->role_id === \App\Models\Role::SUPERADMIN) {
            return redirect()->route('superadmin.home');
        }

        $count = $this->countPendaftar();
        $low   = $this->countLowongan();
        $mag   = $this->countMag();
        $full  = $this->countLowFull();
        $authProfile = $this->getAuthProfile();
        return view('mitra.home', compact('authProfile', 'count', 'low', 'mag', 'full'));
    }

    public function countLowongan(): int
    {
        $mitra = Mitra::where('user_id', Auth::id())->first();
        return $mitra ? Lowongan::where('mitra_id', $mitra->id)->count() : 0;
    }

    public function countMag(): int
    {
        return Magang::join('lowongan', 'magang.lowongan_id', '=', 'lowongan.id')
            ->join('mitra', 'lowongan.mitra_id', '=', 'mitra.id')
            ->where('mitra.user_id', Auth::id())
            ->whereNotIn('approval', [Magang::DITOLAK, Magang::PENDING])
            ->count();
    }

    public function countLowFull(): int
    {
        $mitra = Mitra::where('user_id', Auth::id())->first();
        return $mitra ? Lowongan::where('mitra_id', $mitra->id)->where('jumlah_mhs', 0)->count() : 0;
    }

    public function index() { /* */ }
    public function create() { /* */ }
    public function store(Request $request) { /* */ }
    public function show($id) { /* */ }
    public function edit($id) { /* */ }
    public function update(Request $request, $id) { /* */ }
    public function destroy($id) { /* */ }
}
