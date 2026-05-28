<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;
use App\Models\Mahasiswa;
use App\Models\Magang;
use App\Models\Role;
use App\Models\SkillMhs;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DepartController extends BaseController
{
    public function countPengajuan(): int
    {
        return Magang::whereNull('dosen_id')->count();
    }

    public function detailMhs($id)
    {
        $mhs = Mahasiswa::with(['status', 'jurusan'])->findOrFail($id);
        $skill = SkillMhs::join('skill', 'skill_mhs.skill_id', '=', 'skill.id')
                ->where('skill_mhs.mhs_id', $mhs->id)
                ->select('skill')->get();
        $data = Magang::leftJoin('lowongan', 'magang.lowongan_id', '=', 'lowongan.id')
        ->leftJoin('mitra', 'lowongan.mitra_id', '=', 'mitra.id')
        ->where('mhs_id', $mhs->id)
        ->first();
        $authProfile = $this->getAuthProfile();
        return view('depart.mhs.show', compact('mhs', 'data', 'authProfile', 'skill'));
    }

    public function listMhs()
    {
        $depart = Departemen::where('user_id', Auth::id())->first();
        $mhs = Mahasiswa::with('status')
            ->where('depart_id', $depart->id)
            ->orderBy('status_id', 'asc')
            ->get();
        $authProfile = $this->getAuthProfile();
        return view('depart.mhs.index', compact('mhs', 'authProfile'));
    }

    public function departHome()
    {
        $count   = $this->countPengajuan();
        $user    = $this->countUser();
        $mitra   = $this->countMitra();
        $spv     = $this->countSpv();
        $dosen   = $this->countDosen();
        $mhs     = $this->countMhs();
        $mhsMag  = $this->countMhsMagang();
        $blmMag  = $this->countBelumMagang();
        $authProfile = $this->getAuthProfile();
        return view('depart.home', compact('authProfile', 'count', 'user', 'mitra', 'spv', 'dosen', 'mhs', 'mhsMag', 'blmMag'));
    }

    public function countUser(): int
    {
        return User::count();
    }

    public function countMitra(): int
    {
        return User::where('role_id', Role::MITRA)->count();
    }

    public function countSpv(): int
    {
        return User::where('role_id', Role::SUPERVISOR)->count();
    }

    public function countDosen(): int
    {
        return User::where('role_id', Role::DOSPEM)->count();
    }

    public function countMhs(): int
    {
        return User::where('role_id', Role::MAHASISWA)->count();
    }

    public function countMhsMagang(): int
    {
        return Mahasiswa::where('status_id', 2)->count();
    }

    public function countBelumMagang(): int
    {
        return Mahasiswa::where('status_id', 1)->count();
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mhs)
    {
        $data = Mahasiswa::find($mhs->id);
        return view('depart.mhs.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
