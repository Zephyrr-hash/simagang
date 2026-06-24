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
    public function detailMhs($id)
    {
        $mhs = Mahasiswa::with(['status', 'jurusan'])->findOrFail($id);
        $skill = SkillMhs::join('skill', 'skill_mhs.skill_id', '=', 'skill.id')
                ->where('skill_mhs.mhs_id', $mhs->id)
                ->select('skill')->get();
        $data = Magang::with(['dosen', 'spv'])
            ->leftJoin('lowongan', 'magang.lowongan_id', '=', 'lowongan.id')
            ->leftJoin('mitra', 'lowongan.mitra_id', '=', 'mitra.id')
            ->where('mhs_id', $mhs->id)
            ->select('magang.*', 'lowongan.nama_low', 'mitra.nama_mitra')
            ->first();
        $authProfile = $this->getAuthProfile();
        return view('depart.mhs.show', compact('mhs', 'data', 'authProfile', 'skill'));
    }

    public function listMhs()
    {
        $authProfile  = $this->getAuthProfile();
        $isSuperadmin = (int) Auth::user()->role_id === Role::SUPERADMIN;

        // Superadmin melihat semua mahasiswa, Departemen hanya miliknya
        if ($isSuperadmin) {
            $mhs = Mahasiswa::with(['status', 'jurusan', 'user.creator'])
                ->orderBy('status_id', 'asc')->get();
        } else {
            $depart = Departemen::where('user_id', Auth::id())->firstOrFail();
            $mhs = Mahasiswa::with(['status', 'jurusan', 'user.creator'])
                ->where('depart_id', $depart->id)
                ->orderBy('status_id', 'asc')
                ->get();
        }

        return view('depart.mhs.index', compact('mhs', 'authProfile'));
    }

    public function departHome()
    {
        // Superadmin diarahkan ke dashboard-nya sendiri
        if ((int) Auth::user()->role_id === Role::SUPERADMIN) {
            return redirect()->route('superadmin.home');
        }

        $count   = $this->countPengajuan();
        $user    = $this->countUser();
        $mitra   = $this->countMitra();
        $spv     = $this->countSpv();
        $dosen   = $this->countDosen();
        $mhs     = $this->countMhs();
        $mhsMag  = $this->countMhsMagang();
        $blmMag  = $this->countBelumMagang();
        
        // Get current departemen
        $depart = Departemen::where('user_id', Auth::id())->first();
        
        $authProfile = $this->getAuthProfile();
        return view('depart.home', compact('authProfile', 'count', 'user', 'mitra', 'spv', 'dosen', 'mhs', 'mhsMag', 'blmMag', 'depart'));
    }

    public function countUser(): int
    {
        // Hanya user yang dibuat oleh departemen ini
        return User::where('created_by', Auth::id())->count();
    }

    public function countMitra(): int
    {
        // Hanya mitra yang dibuat oleh departemen ini
        return User::where('role_id', Role::MITRA)
            ->where('created_by', Auth::id())
            ->count();
    }

    public function countSpv(): int
    {
        // Hanya supervisor yang dibuat oleh departemen ini
        return User::where('role_id', Role::SUPERVISOR)
            ->where('created_by', Auth::id())
            ->count();
    }

    public function countDosen(): int
    {
        // Hanya dosen dari departemen ini
        $depart = Departemen::where('user_id', Auth::id())->first();
        if (!$depart) return 0;
        
        return User::where('role_id', Role::DOSPEM)
            ->whereHas('dospem', function($q) use ($depart) {
                $q->where('depart_id', $depart->id);
            })
            ->count();
    }

    public function countMhs(): int
    {
        // Hanya mahasiswa dari departemen ini
        $depart = Departemen::where('user_id', Auth::id())->first();
        if (!$depart) return 0;
        
        return Mahasiswa::where('depart_id', $depart->id)->count();
    }

    public function countMhsMagang(): int
    {
        // Hanya mahasiswa magang dari departemen ini
        $depart = Departemen::where('user_id', Auth::id())->first();
        if (!$depart) return 0;
        
        return Mahasiswa::where('depart_id', $depart->id)
            ->where('status_id', 2)
            ->count();
    }

    public function countBelumMagang(): int
    {
        // Hanya mahasiswa belum magang dari departemen ini
        $depart = Departemen::where('user_id', Auth::id())->first();
        if (!$depart) return 0;
        
        return Mahasiswa::where('depart_id', $depart->id)
            ->where('status_id', 1)
            ->count();
    }

    public function countPengajuan(): int
    {
        // Hanya pengajuan dari mahasiswa departemen ini
        $depart = Departemen::where('user_id', Auth::id())->first();
        if (!$depart) return 0;
        
        return Magang::whereNull('dosen_id')
            ->whereHas('mahasiswa', function($q) use ($depart) {
                $q->where('depart_id', $depart->id);
            })
            ->count();
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
