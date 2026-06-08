<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\SkillMhs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Validator;

class LogBookController extends BaseController
{
    // =========================================================================
    // SUPERVISOR
    // =========================================================================

    public function mhsLogbook()
    {
        $data = Mahasiswa::with(['status'])
            ->join('magang', 'mahasiswa.id', '=', 'magang.mhs_id')
            ->join('supervisor', 'magang.spv_id', '=', 'supervisor.id')
            ->where('supervisor.user_id', Auth::id())
            ->where('magang.approval', '!=', Magang::DITOLAK)
            ->leftJoin('lowongan', 'magang.lowongan_id', '=', 'lowongan.id')
            ->select('mahasiswa.*', 'mahasiswa.id as mhs_id', 'magang.approval', 'magang.id as magang_id', 'lowongan.nama_low')
            ->orderBy('magang.approval', 'asc')
            ->get();
        $authProfile = $this->getAuthProfile();
        return view('spv.logbook.index', compact('data', 'authProfile'));
    }

    public function logbookDetail($id)
    {
        $mhs   = Mahasiswa::with(['jurusan', 'status'])->findOrFail($id);
        $data  = Logbook::join('magang', 'logbook.magang_id', '=', 'magang.id')
            ->where('magang.mhs_id', $mhs->id)
            ->select('logbook.*')
            ->orderBy('logbook.tanggal', 'asc')
            ->get();
        $mag   = Magang::with(['lowongan.mitra', 'dosen'])->where('mhs_id', $id)->first();
        $skill = SkillMhs::with('skill')->where('mhs_id', $mhs->id)->get();
        $authProfile = $this->getAuthProfile();
        return view('spv.logbook.show', compact('data', 'mhs', 'mag', 'skill', 'authProfile'));
    }

    /** Supervisor memberikan catatan pada entri logbook */
    public function updateCatatanSpv(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'catatan_spv' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $log = Logbook::findOrFail($id);
        try {
            $log->update(['catatan_spv' => $request->catatan_spv]);
            return redirect()->back()->with('success', 'Catatan berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Catatan gagal disimpan!');
        }
    }

    // =========================================================================
    // MAHASISWA
    // =========================================================================

    public function print()
    {
        $mhs  = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
        $magang = Magang::with(['lowongan.mitra', 'dosen', 'spv'])
            ->where('mhs_id', $mhs->id)
            ->where('approval', '!=', Magang::DITOLAK)
            ->first();

        $logs = Logbook::join('magang', 'logbook.magang_id', '=', 'magang.id')
            ->where('magang.mhs_id', $mhs->id)
            ->select('logbook.*')
            ->orderBy('logbook.tanggal', 'asc')
            ->get();

        $pdf = PDF::loadView('mhs.logbook.print', compact('logs', 'mhs', 'magang'));
        return $pdf->download('Logbook_' . $mhs->nama_mhs . '.pdf');
    }

    public function index()
    {
        $magang = Magang::with(['lowongan.mitra', 'dosen', 'spv'])
            ->join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->where('mahasiswa.user_id', Auth::id())
            ->select('magang.*')
            ->first();

        $logs = Logbook::with('project')
            ->join('magang', 'logbook.magang_id', '=', 'magang.id')
            ->join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->where('mahasiswa.user_id', Auth::id())
            ->select('logbook.*')
            ->orderBy('logbook.tanggal', 'desc')
            ->get();

        // Load project yang terkait magang mahasiswa ini
        $projects = $magang
            ? \App\Models\ProjectMagang::where('magang_id', $magang->id)
                ->orderBy('status')->orderBy('nama_project')->get()
            : collect();

        $authProfile = $this->getAuthProfile();
        return view('mhs.logbook.index', compact('logs', 'magang', 'projects', 'authProfile'));
    }

    public function create()
    {
        $magang = Magang::join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->where('mahasiswa.user_id', Auth::id())
            ->select('magang.*')
            ->first();

        $projects = $magang
            ? \App\Models\ProjectMagang::where('magang_id', $magang->id)
                ->where('status', '!=', 'selesai')
                ->orderBy('nama_project')->get()
            : collect();

        $authProfile = $this->getAuthProfile();
        return view('mhs.logbook.create', compact('projects', 'authProfile'));
    }

    public function store(Request $request)
    {
        $magang = Magang::join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->where('mahasiswa.user_id', Auth::id())
            ->select('magang.id as mag_id')
            ->first();

        if (!$magang) {
            return redirect()->back()->with('error', 'Data magang tidak ditemukan.');
        }

        $validator = Validator::make($request->all(), [
            'tanggal'     => 'required|date',
            'kegiatan'    => 'required|string|max:255',
            'deskripsi_log' => 'required|string',
            'saran'       => 'required|string',
            'project_id'  => 'nullable|integer|exists:project_magang,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        try {
            Logbook::create([
                'tanggal'     => $request->tanggal,
                'kegiatan'    => $request->kegiatan,
                'deskripsi_log' => $request->deskripsi_log,
                'saran'       => $request->saran,
                'magang_id'   => $magang->mag_id,
                'project_id'  => $request->project_id ?: null,
            ]);
            return redirect()->route('logbook.index')->with('success', 'Aktivitas berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Aktivitas gagal ditambahkan!');
        }
    }

    public function show($id)
    {
        $log         = Logbook::findOrFail($id);
        $authProfile = $this->getAuthProfile();
        return view('mhs.logbook.show', compact('log', 'authProfile'));
    }

    public function edit($id)
    {
        $log         = Logbook::findOrFail($id);
        $authProfile = $this->getAuthProfile();
        return view('mhs.logbook.edit', compact('log', 'authProfile'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal'     => 'required|date',
            'kegiatan'    => 'required|string|max:255',
            'deskripsi_log' => 'required|string',
            'saran'       => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $log = Logbook::findOrFail($id);
        $log->update($request->only(['tanggal', 'kegiatan', 'deskripsi_log', 'saran']));
        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil diubah!');
    }

    public function destroy($id)
    {
        $log = Logbook::findOrFail($id);
        $log->delete();
        // FIX BUG: redirect ke logbook.index bukan bimbingan.index
        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil dihapus!');
    }
}
