<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Dosen;
use App\Models\Lowongan;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\Mitra;
use App\Models\SkillMhs;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApplyController extends BaseController
{
    // =========================================================================
    // SUPERVISOR — Penilaian
    // =========================================================================

    public function penilaian()
    {
        $data = Magang::with(['mahasiswa', 'lowongan'])
            ->join('supervisor', 'magang.spv_id', '=', 'supervisor.id')
            ->where('supervisor.user_id', Auth::id())
            ->where('approval', Magang::SELESAI)
            ->select('magang.*', 'magang.id as mag_id')
            ->get();
        $authProfile = $this->getAuthProfile();
        return view('spv.penilaian.index', compact('data', 'authProfile'));
    }

    public function score(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nilai'      => 'required|numeric|min:0|max:100',
            'keterangan' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $data = Magang::findOrFail($id);
        try {
            $data->update([
                'keterangan' => $request->keterangan,
                'nilai'      => $request->nilai,
            ]);
            return redirect()->route('spv.penilaian')->with('success', 'Nilai berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nilai gagal disimpan!');
        }
    }

    // =========================================================================
    // MAHASISWA — Pengajuan
    // =========================================================================

    public function diajukan()
    {
        $data = Magang::with(['lowongan.mitra'])
            ->join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->where('mahasiswa.user_id', Auth::id())
            ->select('magang.*')
            ->get();
        $authProfile = $this->getAuthProfile();
        return view('mhs.ajukan.index', compact('data', 'authProfile'));
    }

    public function apply($id)
    {
        $mhsId = Mahasiswa::with(['jurusan'])->where('user_id', Auth::id())->firstOrFail();
        $skill = SkillMhs::with('skill')->where('mhs_id', $mhsId->id)->get();
        $low   = Lowongan::with(['mitra', 'kategori'])->findOrFail($id);

        $button = 'enable';

        // Profil belum lengkap
        if (!$mhsId->NIM || !$mhsId->telepon_mhs || !$mhsId->pengalaman ||
            !$mhsId->jurusan_id || !$mhsId->jenis_kelamin ||
            !$mhsId->tgl_lahir || !$mhsId->foto_mhs) {
            $button = 'disabled';
        }

        // Sudah diterima di suatu lowongan atau sedang aktif magang
        $sudahDiterima = Magang::where('mhs_id', $mhsId->id)
            ->where('approval', Magang::DITERIMA)
            ->exists();
        if ($sudahDiterima) {
            $button = 'disabled';
        }

        // Sudah pernah apply ke lowongan ini (pending atau diterima)
        $sudahApply = Magang::where('mhs_id', $mhsId->id)
            ->where('lowongan_id', $id)
            ->whereIn('approval', [Magang::PENDING, Magang::DITERIMA])
            ->exists();
        if ($sudahApply) {
            $button = 'already_applied';
        }

        $authProfile = $this->getAuthProfile();
        return view('lowongan.apply', compact('authProfile', 'low', 'button', 'skill', 'mhsId'));
    }

    public function detail($id)
    {
        $low = Lowongan::join('mitra', 'lowongan.mitra_id', '=', 'mitra.id')
            ->leftJoin('kabupaten', 'mitra.kab_id', '=', 'kabupaten.id')
            ->leftJoin('kecamatan', 'mitra.kecamatan_id', '=', 'kecamatan.id')
            ->leftJoin('provinsi', 'mitra.provinsi_id', '=', 'provinsi.id')
            ->select(
                'lowongan.*',
                'mitra.*',
                'lowongan.id as id',
                'kabupaten.nama as nama_kabupaten',
                'kecamatan.nama as nama_kecamatan',
                'provinsi.nama as nama_provinsi'
            )
            ->find($id);

        $mhs = Mahasiswa::where('user_id', Auth::id())->first();
        return view('lowongan.detail', compact('low', 'mhs'));
    }

    public function store(Request $request)
    {
        $mhsId = Mahasiswa::where('user_id', Auth::id())->firstOrFail();

        // Blokir jika sudah punya pengajuan DITERIMA (sedang/sudah magang)
        $sudahDiterima = Magang::where('mhs_id', $mhsId->id)
            ->where('approval', Magang::DITERIMA)
            ->exists();

        if ($sudahDiterima) {
            return redirect()->back()->with('error', 'Anda sudah memiliki magang yang aktif.');
        }

        // Blokir jika sudah apply ke lowongan yang sama
        $sudahApply = Magang::where('mhs_id', $mhsId->id)
            ->where('lowongan_id', $request->lowongan_id)
            ->whereIn('approval', [Magang::PENDING, Magang::DITERIMA])
            ->exists();

        if ($sudahApply) {
            return redirect()->back()->with('error', 'Anda sudah pernah mengajukan lamaran ke lowongan ini.');
        }

        try {
            DB::transaction(function () use ($request, $mhsId) {
                Magang::create([
                    'mhs_id'      => $mhsId->id,
                    'lowongan_id' => $request->lowongan_id,
                    'approval'    => Magang::PENDING,
                ]);
                // Hanya update status jika sebelumnya Belum Magang (1)
                // agar tidak menimpa status lain
                if ($mhsId->status_id == 1) {
                    $mhsId->update(['status_id' => 4]); // Sedang Mengajukan
                }
            });
            return redirect()->route('mahasiswa.home')->with('success', 'Lamaran berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lamaran gagal dikirim!');
        }
    }

    // =========================================================================
    // DEPARTEMEN — Assign Dosen
    // =========================================================================

    public function listPengajuan()
    {
        $magang = Magang::with(['mahasiswa', 'lowongan.mitra'])
            ->join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->join('departemen', 'mahasiswa.depart_id', '=', 'departemen.id')
            ->where('departemen.user_id', Auth::id())
            ->whereNull('magang.dosen_id')
            ->select('magang.*')
            ->get();
        $authProfile = $this->getAuthProfile();
        return view('depart.pengajuan.index', compact('magang', 'authProfile'));
    }

    public function pengajuan($id)
    {
        $magang = Magang::with(['mahasiswa', 'lowongan.mitra'])->findOrFail($id);
        $mhs    = $magang->mahasiswa;
        $skill  = SkillMhs::with('skill')->where('mhs_id', $mhs->id)->get();

        $departId = Departemen::where('user_id', Auth::id())->firstOrFail();
        $dosen    = Dosen::where('depart_id', $departId->id)->get();

        $authProfile = $this->getAuthProfile();
        return view('depart.pengajuan.edit', compact('magang', 'dosen', 'authProfile', 'mhs', 'skill'));
    }

    public function updateDospem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'dosen_id' => 'required|integer|exists:dosen,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $magang = Magang::findOrFail($id);
        try {
            DB::transaction(function () use ($magang, $request) {
                // Hanya update dosen_id — TIDAK mengubah status mahasiswa
                $magang->update(['dosen_id' => $request->dosen_id]);
            });
            return redirect()->route('pengajuan.index')->with('success', 'Dosen pembimbing berhasil ditugaskan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menugaskan dosen pembimbing!');
        }
    }

    // =========================================================================
    // MITRA — Pendaftar & Magang
    // =========================================================================

    public function listPendaftar()
    {
        $data = Magang::with(['mahasiswa', 'lowongan'])
            ->join('lowongan', 'magang.lowongan_id', '=', 'lowongan.id')
            ->join('mitra', 'lowongan.mitra_id', '=', 'mitra.id')
            ->where('mitra.user_id', Auth::id())
            ->where('magang.approval', Magang::PENDING)
            ->select('magang.*')
            ->get();
        $authProfile = $this->getAuthProfile();
        return view('mitra.pendaftar.index', compact('data', 'authProfile'));
    }

    public function pendaftar($id)
    {
        $magang = Magang::with(['mahasiswa.jurusan', 'lowongan'])->findOrFail($id);
        $mhs    = $magang->mahasiswa;
        $skill  = SkillMhs::with('skill')->where('mhs_id', $mhs->id)->get();

        $mitraId = Mitra::where('user_id', Auth::id())->firstOrFail();
        $spv     = Supervisor::where('mitra_id', $mitraId->id)->get();

        $authProfile = $this->getAuthProfile();
        return view('mitra.pendaftar.edit', compact('magang', 'spv', 'authProfile', 'mhs', 'skill'));
    }

    public function approval(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'action'     => 'required|in:approve,reject',
            'tgl_mulai'  => 'required_if:action,approve|nullable|date',
            'tgl_selesai'=> 'required_if:action,approve|nullable|date|after_or_equal:tgl_mulai',
            'spv_id'     => 'required_if:action,approve|nullable|integer|exists:supervisor,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $magang = Magang::findOrFail($id);

        try {
            DB::transaction(function () use ($magang, $request) {
                if ($request->action === 'approve') {
                    $magang->update([
                        'tgl_mulai'  => $request->tgl_mulai,
                        'tgl_selesai'=> $request->tgl_selesai,
                        'spv_id'     => $request->spv_id,
                        'approval'   => Magang::DITERIMA,
                    ]);

                    $mhs = Mahasiswa::findOrFail($magang->mhs_id);
                    $mhs->update(['status_id' => 2]); // Sedang Magang

                    // Kurangi kuota lowongan
                    $low = Lowongan::findOrFail($magang->lowongan_id);
                    $low->decrement('jumlah_mhs');

                    // Tolak semua pengajuan lain mahasiswa ini
                    Magang::where('mhs_id', $mhs->id)
                        ->where('id', '!=', $magang->id)
                        ->update(['approval' => Magang::DITOLAK]);

                } else {
                    $magang->update(['approval' => Magang::DITOLAK]);
                    Mahasiswa::where('id', $magang->mhs_id)->update(['status_id' => 1]); // Belum Magang
                }
            });

            $msg = $request->action === 'approve' ? 'Mahasiswa berhasil diterima!' : 'Mahasiswa berhasil ditolak!';
            return redirect()->route('pendaftar.index')->with('success', $msg);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /** Approve langsung tanpa form (legacy route) */
    public function approve($id)
    {
        Magang::findOrFail($id)->update(['approval' => Magang::DITERIMA]);
        return redirect()->route('pendaftar.index');
    }

    /** Reject langsung tanpa form (legacy route) */
    public function reject($id)
    {
        Magang::findOrFail($id)->update(['approval' => Magang::DITOLAK]);
        return redirect()->route('pendaftar.index');
    }

    public function listMagang()
    {
        $data = Magang::with(['mahasiswa', 'lowongan', 'spv'])
            ->join('lowongan', 'magang.lowongan_id', '=', 'lowongan.id')
            ->join('mitra', 'lowongan.mitra_id', '=', 'mitra.id')
            ->where('mitra.user_id', Auth::id())
            ->where('magang.approval', '!=', Magang::DITOLAK)
            ->select('magang.*')
            ->orderBy('magang.approval', 'asc')
            ->get();
        $authProfile = $this->getAuthProfile();
        return view('mitra.magang.index', compact('data', 'authProfile'));
    }

    public function detailMagang($id)
    {
        $magang = Magang::with(['mahasiswa.jurusan', 'lowongan', 'spv'])->findOrFail($id);
        $mhs    = $magang->mahasiswa;
        $skill  = SkillMhs::with('skill')->where('mhs_id', $mhs->id)->get();
        $authProfile = $this->getAuthProfile();
        return view('mitra.magang.show', compact('magang', 'skill', 'mhs', 'authProfile'));
    }

    public function end($id)
    {
        $magang = Magang::findOrFail($id);
        try {
            DB::transaction(function () use ($magang) {
                $magang->update(['approval' => Magang::SELESAI]);
                Mahasiswa::where('id', $magang->mhs_id)->update(['status_id' => 3]); // Sudah Magang
            });
            return redirect()->route('magang.index')->with('success', 'Magang berhasil diakhiri!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Magang gagal diakhiri!');
        }
    }

    public function index()
    {
        $low = Lowongan::all();
        return view('welcome', compact('low'));
    }

    public function create()  { /* */ }
    public function show(Lowongan $lowongan) { return view('lowongan.detail', compact('lowongan')); }
    public function edit($id) { /* */ }
    public function update(Request $request, $id) { /* */ }
    public function destroy($id) { /* */ }
}
