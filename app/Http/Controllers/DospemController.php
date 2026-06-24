<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DospemController extends BaseController
{
    public function dospemHome()
    {
        // Superadmin diarahkan ke dashboard-nya sendiri
        if ((int) Auth::user()->role_id === \App\Models\Role::SUPERADMIN) {
            return redirect()->route('superadmin.home');
        }

        $mhsBim  = $this->countMhsBim();
        $feedback = $this->countBim();
        $authProfile = $this->getAuthProfile();
        return view('dosen.home', compact('authProfile', 'mhsBim', 'feedback'));
    }

    public function countMhsBim(): int
    {
        return Mahasiswa::join('magang', 'mahasiswa.id', '=', 'magang.mhs_id')
            ->join('dosen', 'magang.dosen_id', '=', 'dosen.id')
            ->where('dosen.user_id', Auth::id())
            ->where('magang.approval', '!=', Magang::DITOLAK)
            ->count();
    }

    public function countBim(): int
    {
        return Bimbingan::leftJoin('magang', 'bimbingan.magang_id', '=', 'magang.id')
            ->join('dosen', 'magang.dosen_id', '=', 'dosen.id')
            ->where('dosen.user_id', Auth::id())
            ->whereNull('feedback')
            ->count();
    }

    public function index() { /* */ }
    public function create() { /* */ }
    public function store(Request $request) { /* */ }
    public function show($id) { /* */ }
    public function edit($id) { /* */ }
    public function update(Request $request, $id) { /* */ }
    public function destroy($id) { /* */ }
}
