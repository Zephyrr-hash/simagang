<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bimbingan;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\SkillMhs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BimbinganController extends BaseController
{
    // =========================================================================
    // DOSEN PEMBIMBING
    // =========================================================================

    public function mhsBimbingan()
    {
        $data = Mahasiswa::with(['status'])
            ->join('magang', 'mahasiswa.id', '=', 'magang.mhs_id')
            ->join('dosen', 'magang.dosen_id', '=', 'dosen.id')
            ->where('dosen.user_id', Auth::id())
            ->where('magang.approval', '!=', Magang::DITOLAK)
            ->select('mahasiswa.*', 'magang.approval', 'mahasiswa.id as mhs_id')
            ->orderBy('magang.approval', 'asc')
            ->groupBy('mahasiswa.id', 'mahasiswa.user_id', 'mahasiswa.nama_mhs', 'mahasiswa.NIM',
                'mahasiswa.telepon_mhs', 'mahasiswa.pengalaman', 'mahasiswa.jurusan_id',
                'mahasiswa.status_id', 'mahasiswa.jenis_kelamin', 'mahasiswa.tgl_lahir',
                'mahasiswa.foto_mhs', 'mahasiswa.depart_id', 'mahasiswa.created_at',
                'mahasiswa.updated_at', 'magang.approval')
            ->get();

        // Cek feedback terakhir per mahasiswa
        $arrFeedback = [];
        foreach ($data as $d) {
            $lastBim = Bimbingan::join('magang', 'bimbingan.magang_id', '=', 'magang.id')
                ->where('magang.mhs_id', $d->mhs_id)
                ->orderBy('bimbingan.created_at', 'desc')
                ->select('bimbingan.feedback')
                ->first();
            $arrFeedback[$d->mhs_id] = $lastBim?->feedback ?? 'Belum ada bimbingan';
        }

        $authProfile = $this->getAuthProfile();
        return view('dosen.bimbingan.index', compact('data', 'arrFeedback', 'authProfile'));
    }

    public function bimbinganDetail($id)
    {
        $mhs   = Mahasiswa::with(['jurusan', 'status'])->findOrFail($id);
        $data  = Bimbingan::join('magang', 'bimbingan.magang_id', '=', 'magang.id')
            ->where('magang.mhs_id', $mhs->id)
            ->select('bimbingan.*', 'bimbingan.id as bim_id')
            ->orderBy('bimbingan.tgl_bimbingan', 'asc')
            ->get();
        $mag   = Magang::with(['lowongan.mitra'])->where('mhs_id', $id)->first();
        $skill = SkillMhs::with('skill')->where('mhs_id', $mhs->id)->get();
        $authProfile = $this->getAuthProfile();
        return view('dosen.bimbingan.edit', compact('data', 'mhs', 'mag', 'skill', 'authProfile'));
    }

    public function feedbackBimbingan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'feedback' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $bim = Bimbingan::findOrFail($id);
        try {
            $bim->update(['feedback' => $request->feedback]);
            return redirect()->route('dospem.bimbingan', $request->mhs_id)->with('success', 'Feedback berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Feedback gagal ditambahkan!');
        }
    }

    // =========================================================================
    // MAHASISWA
    // =========================================================================

    public function index()
    {
        $magang = Magang::with(['lowongan.mitra', 'dosen'])
            ->join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->where('mahasiswa.user_id', Auth::id())
            ->select('magang.*')
            ->first();

        $bimbingan = Bimbingan::join('magang', 'bimbingan.magang_id', '=', 'magang.id')
            ->join('mahasiswa', 'magang.mhs_id', '=', 'mahasiswa.id')
            ->where('mahasiswa.user_id', Auth::id())
            ->select('bimbingan.*')
            ->orderBy('bimbingan.tgl_bimbingan', 'asc')
            ->get();

        $authProfile = $this->getAuthProfile();
        return view('mhs.bimbingan.index', compact('bimbingan', 'magang', 'authProfile'));
    }

    public function create()
    {
        $authProfile = $this->getAuthProfile();
        return view('mhs.bimbingan.create', compact('authProfile'));
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
            'catatan'       => 'required|string',
            'tgl_bimbingan' => 'required|date',
            'file'          => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $fileName = time() . '_' . Str::uuid() . '.' . $request->file->extension();
        $request->file->move(public_path('file'), $fileName);

        try {
            Bimbingan::create([
                'catatan'       => $request->catatan,
                'tgl_bimbingan' => $request->tgl_bimbingan,
                'file'          => $fileName,
                'magang_id'     => $magang->mag_id,
            ]);
            return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Bimbingan gagal ditambahkan!');
        }
    }

    public function show($id)
    {
        $bimbingan   = Bimbingan::findOrFail($id);
        $authProfile = $this->getAuthProfile();
        return view('mhs.bimbingan.show', compact('bimbingan', 'authProfile'));
    }

    public function edit($id)
    {
        $bimbingan   = Bimbingan::findOrFail($id);
        $authProfile = $this->getAuthProfile();
        return view('mhs.bimbingan.edit', compact('bimbingan', 'authProfile'));
    }

    public function update(Request $request, $id)
    {
        // FIX BUG: validasi hanya field yang ada di form
        $validator = Validator::make($request->all(), [
            'catatan'       => 'required|string',
            'tgl_bimbingan' => 'required|date',
            'file'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $bimbingan = Bimbingan::findOrFail($id);
        $data = [
            'catatan'       => $request->catatan,
            'tgl_bimbingan' => $request->tgl_bimbingan,
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($bimbingan->file) {
                $oldPath = public_path('file/' . $bimbingan->file);
                if (file_exists($oldPath)) @unlink($oldPath);
            }
            $fileName = time() . '_' . Str::uuid() . '.' . $request->file->extension();
            $request->file->move(public_path('file'), $fileName);
            $data['file'] = $fileName;
        }

        $bimbingan->update($data);
        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil diubah!');
    }

    public function destroy($id)
    {
        $bimbingan = Bimbingan::findOrFail($id);
        if ($bimbingan->file) {
            $path = public_path('file/' . $bimbingan->file);
            if (file_exists($path)) @unlink($path);
        }
        $bimbingan->delete();
        // FIX BUG: redirect ke bimbingan.index bukan route lain
        return redirect()->route('bimbingan.index')->with('success', 'Bimbingan berhasil dihapus!');
    }
}
