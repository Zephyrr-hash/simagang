<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Kabupaten;
use App\Models\Mahasiswa;
use App\Models\Mitra;
use App\Models\Role;
use App\Models\Skill;
use App\Models\SkillMhs;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends BaseController
{
    public function index()
    {
        $user        = Auth::user();
        $authProfile = $this->getAuthProfile();

        switch ((int) $user->role_id) {
            case Role::DEPARTEMEN:
                $profile = Departemen::where('user_id', $user->id)->first();
                return view('depart.profile.index', compact('profile', 'authProfile'));
            case Role::MITRA:
                $profile = Mitra::with('kabupaten')->where('user_id', $user->id)->first();
                return view('mitra.profile.index', compact('profile', 'authProfile'));
            case Role::DOSPEM:
                $profile = Dosen::with('depart')->where('user_id', $user->id)->first();
                return view('dosen.profile.index', compact('profile', 'authProfile'));
            case Role::SUPERVISOR:
                $profile = Supervisor::with('mitra')->where('user_id', $user->id)->first();
                return view('spv.profile.index', compact('profile', 'authProfile'));
            case Role::MAHASISWA:
                $profile = Mahasiswa::with(['jurusan', 'status', 'depart'])->where('user_id', $user->id)->first();
                $skills  = $profile ? SkillMhs::with('skill')->where('mhs_id', $profile->id)->get() : collect();
                return view('mhs.profile.index', compact('profile', 'skills', 'authProfile'));
        }

        return redirect()->route('login');
    }

    public function edit($id)
    {
        $user        = Auth::user();
        $authProfile = $this->getAuthProfile();

        switch ((int) $user->role_id) {
            case Role::DEPARTEMEN:
                $profile = Departemen::where('user_id', $user->id)->first();
                return view('depart.profile.edit', compact('profile', 'authProfile'));
            case Role::MITRA:
                $profile    = Mitra::where('user_id', $user->id)->first();
                $kabupatens = Kabupaten::orderBy('nama')->get();
                return view('mitra.profile.edit', compact('profile', 'kabupatens', 'authProfile'));
            case Role::DOSPEM:
                $profile    = Dosen::where('user_id', $user->id)->first();
                $departemens = Departemen::orderBy('nama_depart')->get();
                return view('dosen.profile.edit', compact('profile', 'departemens', 'authProfile'));
            case Role::SUPERVISOR:
                $profile = Supervisor::where('user_id', $user->id)->first();
                $mitras  = Mitra::orderBy('nama_mitra')->get();
                return view('spv.profile.edit', compact('profile', 'mitras', 'authProfile'));
            case Role::MAHASISWA:
                $profile   = Mahasiswa::where('user_id', $user->id)->first();
                $jurusans  = Jurusan::orderBy('jurusan')->get();
                $skills    = Skill::orderBy('skill')->get();
                $departemens = Departemen::orderBy('nama_depart')->get();
                $skillMhsIds = $profile
                    ? SkillMhs::where('mhs_id', $profile->id)->pluck('skill_id')->toArray()
                    : [];
                $genders = ['Laki-laki', 'Perempuan'];
                return view('mhs.profile.edit', compact('profile', 'jurusans', 'skills', 'departemens', 'skillMhsIds', 'genders', 'authProfile'));
        }

        return redirect()->route('login');
    }

    public function update(Request $request, $id)
    {
        $user   = Auth::user();
        $userId = $user->id;

        switch ((int) $user->role_id) {

            case Role::DEPARTEMEN:
                $profile   = Departemen::where('user_id', $userId)->firstOrFail();
                $validator = Validator::make($request->all(), [
                    'nama_depart'    => 'required|string|max:255',
                    'alamat_depart'  => 'required|string',
                    'telepon_depart' => 'required|string|max:20',
                    'NIDN'           => 'required|string|max:20',
                    'foto_depart'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
                }
                $data = $request->only(['nama_depart', 'alamat_depart', 'telepon_depart', 'NIDN']);
                if ($request->hasFile('foto_depart')) {
                    $this->deleteOldPhoto($profile->foto_depart);
                    $data['foto_depart'] = $this->uploadPhoto($request->file('foto_depart'));
                }
                $profile->update($data);
                User::where('id', $userId)->update(['name' => $request->nama_depart]);
                return redirect()->route('profile.index')->with('success', 'Profil berhasil diubah!');

            case Role::MITRA:
                $profile   = Mitra::where('user_id', $userId)->firstOrFail();
                $validator = Validator::make($request->all(), [
                    'nama_mitra'    => 'required|string|max:255',
                    'alamat_mitra'  => 'required|string',
                    'telepon_mitra' => 'required|string|max:20',
                    'fax_mitra'     => 'nullable|string|max:20',
                    'kab_id'        => 'required|integer|exists:kabupaten,id',
                    'foto_mitra'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
                }
                $data = $request->only(['nama_mitra', 'alamat_mitra', 'telepon_mitra', 'fax_mitra', 'kab_id']);
                if ($request->hasFile('foto_mitra')) {
                    $this->deleteOldPhoto($profile->foto_mitra);
                    $data['foto_mitra'] = $this->uploadPhoto($request->file('foto_mitra'));
                }
                $profile->update($data);
                User::where('id', $userId)->update(['name' => $request->nama_mitra]);
                return redirect()->route('profile.index')->with('success', 'Profil berhasil diubah!');

            case Role::DOSPEM:
                $profile   = Dosen::where('user_id', $userId)->firstOrFail();
                $validator = Validator::make($request->all(), [
                    'nama_dosen'    => 'required|string|max:255',
                    'telepon_dosen' => 'required|string|max:20',
                    'NIP'           => 'required|string|max:20',
                    'depart_id'     => 'required|integer|exists:departemen,id',
                    'foto_dosen'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
                }
                $data = $request->only(['nama_dosen', 'telepon_dosen', 'NIP', 'depart_id']);
                if ($request->hasFile('foto_dosen')) {
                    $this->deleteOldPhoto($profile->foto_dosen);
                    $data['foto_dosen'] = $this->uploadPhoto($request->file('foto_dosen'));
                }
                $profile->update($data);
                User::where('id', $userId)->update(['name' => $request->nama_dosen]);
                return redirect()->route('profile.index')->with('success', 'Profil berhasil diubah!');

            case Role::SUPERVISOR:
                $profile   = Supervisor::where('user_id', $userId)->firstOrFail();
                $validator = Validator::make($request->all(), [
                    'nama_spv'    => 'required|string|max:255',
                    'telepon_spv' => 'required|string|max:20',
                    'no_pegawai'  => 'required|string|max:20',
                    'mitra_id'    => 'required|integer|exists:mitra,id',
                    'foto_spv'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
                }
                $data = $request->only(['nama_spv', 'telepon_spv', 'no_pegawai', 'mitra_id']);
                if ($request->hasFile('foto_spv')) {
                    $this->deleteOldPhoto($profile->foto_spv);
                    $data['foto_spv'] = $this->uploadPhoto($request->file('foto_spv'));
                }
                $profile->update($data);
                User::where('id', $userId)->update(['name' => $request->nama_spv]);
                return redirect()->route('profile.index')->with('success', 'Profil berhasil diubah!');

            case Role::MAHASISWA:
                $profile   = Mahasiswa::where('user_id', $userId)->firstOrFail();
                $validator = Validator::make($request->all(), [
                    'nama_mhs'     => 'required|string|max:255',
                    'NIM'          => 'required|string|max:20',
                    'telepon_mhs'  => 'required|string|max:20',
                    'pengalaman'   => 'required|string',
                    'jurusan_id'   => 'required|integer|exists:jurusan,id',
                    'jenis_kelamin'=> 'required|in:Laki-laki,Perempuan',
                    'tgl_lahir'    => 'required|date',
                    'depart_id'    => 'required|integer|exists:departemen,id',
                    'foto_mhs'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                    'skill_id'     => 'nullable|array',
                    'skill_id.*'   => 'integer|exists:skill,id',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
                }

                // Sync skill — delete lama, insert baru
                SkillMhs::where('mhs_id', $profile->id)->delete();
                if ($request->has('skill_id') && is_array($request->skill_id)) {
                    foreach ($request->skill_id as $skillId) {
                        SkillMhs::create(['skill_id' => $skillId, 'mhs_id' => $profile->id]);
                    }
                }

                $data = $request->only(['nama_mhs', 'NIM', 'telepon_mhs', 'pengalaman', 'jurusan_id', 'jenis_kelamin', 'tgl_lahir', 'depart_id']);
                if ($request->hasFile('foto_mhs')) {
                    $this->deleteOldPhoto($profile->foto_mhs);
                    $data['foto_mhs'] = $this->uploadPhoto($request->file('foto_mhs'));
                }
                $profile->update($data);
                User::where('id', $userId)->update(['name' => $request->nama_mhs]);
                return redirect()->route('profile.index')->with('success', 'Profil berhasil diubah!');
        }

        return redirect()->route('profile.index')->with('error', 'Role tidak dikenali.');
    }

    /** Upload foto ke public/images dengan nama unik */
    private function uploadPhoto($file): string
    {
        $fileName = time() . '_' . Str::uuid() . '.' . $file->extension();
        $file->move(public_path('images'), $fileName);
        return $fileName;
    }

    /** Hapus foto lama dari public/images jika ada */
    private function deleteOldPhoto(?string $fileName): void
    {
        if ($fileName && $fileName !== 'default.png') {
            $path = public_path('images/' . $fileName);
            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }

    public function create()  { /* */ }
    public function store(Request $request) { /* */ }
    public function show($id) { /* */ }
    public function destroy($id) { /* */ }
}
