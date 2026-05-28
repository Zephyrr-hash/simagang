<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Logbook;
use App\Models\Mahasiswa;
use App\Models\Magang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MhsController extends BaseController
{
    public function mahasiswaHome()
    {
        $mhsId  = Mahasiswa::with(['status', 'jurusan'])->where('user_id', Auth::id())->first();
        $ajukan = $this->countAjukan();
        $log    = $this->countLogbook();
        $bim    = $this->countBimbingan();
        $authProfile = $this->getAuthProfile();
        return view('mhs.home', compact('authProfile', 'ajukan', 'log', 'bim', 'mhsId'));
    }

    public function countAjukan(): int
    {
        return Magang::join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->where('mahasiswa.user_id', Auth::id())
            ->count();
    }

    public function countLogbook(): int
    {
        return Logbook::join('magang', 'logbook.magang_id', '=', 'magang.id')
            ->join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->where('mahasiswa.user_id', Auth::id())
            ->count();
    }

    public function countBimbingan(): int
    {
        return Bimbingan::join('magang', 'bimbingan.magang_id', '=', 'magang.id')
            ->join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->where('mahasiswa.user_id', Auth::id())
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
