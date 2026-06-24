<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Kategori;
use App\Models\Mitra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LowonganController extends BaseController
{
    public function AllLowongan(Request $request)
    {
        $cari = $request->cari;
        $low  = Lowongan::with(['mitra.kabupaten', 'kategori'])
            ->where('jumlah_mhs', '>', 0)
            ->where('nama_low', 'like', '%' . $cari . '%')
            ->paginate(12);
        return view('welcome', compact('low'));
    }

    public function index()
    {
        $authProfile = $this->getAuthProfile();

        // Superadmin melihat semua lowongan dari semua mitra
        if ((int) Auth::user()->role_id === \App\Models\Role::SUPERADMIN) {
            $low = Lowongan::with('kategori', 'mitra')->get();
            return view('mitra.lowongan.index', compact('low', 'authProfile'));
        }

        $mitra = Mitra::where('user_id', Auth::id())->firstOrFail();
        $low   = Lowongan::with('kategori')->where('mitra_id', $mitra->id)->get();
        return view('mitra.lowongan.index', compact('low', 'authProfile'));
    }

    public function create()
    {
        $kategori    = Kategori::orderBy('kategori')->get();
        $mitra       = Mitra::where('user_id', Auth::id())->firstOrFail();
        $authProfile = $this->getAuthProfile();
        return view('mitra.lowongan.create', compact('mitra', 'kategori', 'authProfile'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_low'     => 'required|string|max:255',
            'deskripsi_low'=> 'required|string',
            'telepon_low'  => 'required|string|max:20',
            'jumlah_mhs'   => 'required|integer|min:1',
            'durasi'       => 'required|integer|min:1',
            'kategori_id'  => 'required|integer|exists:kategori,id',
            'lokasi'       => 'required|string|max:255',
            'foto_low'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $mitra    = Mitra::where('user_id', Auth::id())->firstOrFail();
        $fileName = time() . '_' . Str::uuid() . '.' . $request->foto_low->extension();
        $request->foto_low->move(public_path('images'), $fileName);

        try {
            Lowongan::create([
                'nama_low'     => $request->nama_low,
                'deskripsi_low'=> $request->deskripsi_low,
                'telepon_low'  => $request->telepon_low,
                'jumlah_mhs'   => $request->jumlah_mhs,
                'durasi'       => $request->durasi,
                'mitra_id'     => $mitra->id,
                'kategori_id'  => $request->kategori_id,
                'lokasi'       => $request->lokasi,
                'foto_low'     => $fileName,
            ]);
            return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lowongan gagal dibuat!');
        }
    }

    public function show(Lowongan $lowongan)
    {
        $authProfile = $this->getAuthProfile();
        return view('mitra.lowongan.show', compact('lowongan', 'authProfile'));
    }

    public function edit(Lowongan $lowongan)
    {
        $kategori    = Kategori::orderBy('kategori')->get();
        $mitra       = Mitra::where('user_id', Auth::id())->firstOrFail();
        $authProfile = $this->getAuthProfile();
        return view('mitra.lowongan.edit', compact('lowongan', 'kategori', 'mitra', 'authProfile'));
    }

    public function update(Request $request, Lowongan $lowongan)
    {
        $validator = Validator::make($request->all(), [
            'nama_low'     => 'required|string|max:255',
            'deskripsi_low'=> 'required|string',
            'telepon_low'  => 'required|string|max:20',
            'jumlah_mhs'   => 'required|integer|min:0',
            'durasi'       => 'required|integer|min:1',
            'kategori_id'  => 'required|integer|exists:kategori,id',
            'lokasi'       => 'required|string|max:255',
            'foto_low'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $data = $request->only(['nama_low', 'deskripsi_low', 'telepon_low', 'jumlah_mhs', 'durasi', 'kategori_id', 'lokasi']);

        if ($request->hasFile('foto_low')) {
            if ($lowongan->foto_low) {
                $oldPath = public_path('images/' . $lowongan->foto_low);
                if (file_exists($oldPath)) @unlink($oldPath);
            }
            $fileName       = time() . '_' . Str::uuid() . '.' . $request->foto_low->extension();
            $request->foto_low->move(public_path('images'), $fileName);
            $data['foto_low'] = $fileName;
        }

        try {
            $lowongan->update($data);
            return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lowongan gagal diubah!');
        }
    }

    public function destroy($id)
    {
        $low = Lowongan::find($id);
        if (!$low) {
            return redirect()->back()->with('error', 'Lowongan tidak ditemukan.');
        }
        if ($low->foto_low) {
            $path = public_path('images/' . $low->foto_low);
            if (file_exists($path)) @unlink($path);
        }
        $low->delete();
        return redirect()->back()->with('success', 'Lowongan berhasil dihapus!');
    }
}
