<?php

namespace App\Http\Controllers;

use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpvController extends BaseController
{
    public function supervisorHome()
    {
        $mhsLogbook = $this->countMhsLogbook();
        $nilai      = $this->countPenilaian();
        $authProfile = $this->getAuthProfile();
        return view('spv.home', compact('authProfile', 'mhsLogbook', 'nilai'));
    }

    public function countMhsLogbook(): int
    {
        return Mahasiswa::join('magang', 'mahasiswa.id', '=', 'magang.mhs_id')
            ->join('supervisor', 'magang.spv_id', '=', 'supervisor.id')
            ->where('supervisor.user_id', Auth::id())
            ->where('magang.approval', '!=', Magang::DITOLAK)
            ->count();
    }

    public function countPenilaian(): int
    {
        return Magang::join('supervisor', 'magang.spv_id', '=', 'supervisor.id')
            ->where('supervisor.user_id', Auth::id())
            ->where('approval', Magang::SELESAI)
            ->whereNull('nilai')
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
