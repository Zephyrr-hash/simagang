<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Departemen;
use App\Models\Dosen;
use App\Models\Lowongan;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\Mitra;
use App\Models\Role;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SuperadminController extends BaseController
{
    // =========================================================
    // DASHBOARD
    // =========================================================

    public function home()
    {
        $stats = [
            'total_user'       => User::where('role_id', '!=', Role::SUPERADMIN)->count(),
            'total_departemen' => User::where('role_id', Role::DEPARTEMEN)->count(),
            'total_mitra'      => User::where('role_id', Role::MITRA)->count(),
            'total_dosen'      => User::where('role_id', Role::DOSPEM)->count(),
            'total_spv'        => User::where('role_id', Role::SUPERVISOR)->count(),
            'total_mahasiswa'  => User::where('role_id', Role::MAHASISWA)->count(),
            'total_lowongan'   => Lowongan::count(),
            'total_magang'     => Magang::count(),
            'magang_aktif'     => Mahasiswa::where('status_id', 2)->count(),
            'belum_magang'     => Mahasiswa::where('status_id', 1)->count(),
            'pengajuan_pending' => Magang::whereNull('dosen_id')->count(),
        ];

        // Data user terbaru
        $recentUsers = User::with('role')
            ->where('role_id', '!=', Role::SUPERADMIN)
            ->latest()
            ->take(5)
            ->get();

        $authProfile = $this->getAuthProfile();
        return view('superadmin.home', compact('stats', 'recentUsers', 'authProfile'));
    }

    // =========================================================
    // KELOLA USER (semua user tanpa batasan)
    // =========================================================

    public function userIndex(Request $request)
    {
        $search  = $request->search;
        $roleFilter = $request->role_id;

        $users = User::with(['role', 'creator'])
            ->where('role_id', '!=', Role::SUPERADMIN)
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
            ->when($roleFilter, fn($q) => $q->where('role_id', $roleFilter))
            ->orderBy('role_id')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $roles       = Role::where('id', '!=', Role::SUPERADMIN)->get();
        $authProfile = $this->getAuthProfile();

        return view('superadmin.users.index', compact('users', 'roles', 'authProfile', 'search', 'roleFilter'));
    }

    public function userCreate()
    {
        $roles       = Role::where('id', '!=', Role::SUPERADMIN)->get();
        $departemen  = Departemen::orderBy('nama_depart')->get();
        $authProfile = $this->getAuthProfile();
        return view('superadmin.users.create', compact('roles', 'departemen', 'authProfile'));
    }

    public function userStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'role_id'  => 'required|integer|exists:role,id',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required'     => 'Nama wajib diisi.',
            'role_id.required'  => 'Role wajib dipilih.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('errorForm', $validator->errors()->getMessages())
                ->withInput();
        }

        // Superadmin tidak boleh dibuat via form ini
        if ((int) $request->role_id === Role::SUPERADMIN) {
            return redirect()->back()->with('error', 'Tidak dapat membuat akun Superadmin.')->withInput();
        }

        try {
            DB::transaction(function () use ($request, &$user) {
                $user = User::create([
                    'name'       => $request->name,
                    'email'      => $request->email,
                    'role_id'    => $request->role_id,
                    'password'   => Hash::make($request->password),
                    'created_by' => Auth::id(),
                ]);

                $departId = $request->depart_id
                    ? Departemen::find($request->depart_id)?->id
                    : null;

                match ((int) $request->role_id) {
                    Role::DEPARTEMEN => Departemen::create(['user_id' => $user->id, 'nama_depart' => $user->name]),
                    Role::MITRA      => Mitra::create(['user_id' => $user->id, 'nama_mitra' => $user->name]),
                    Role::DOSPEM     => Dosen::create(['user_id' => $user->id, 'nama_dosen' => $user->name, 'depart_id' => $departId]),
                    Role::SUPERVISOR => Supervisor::create(['user_id' => $user->id, 'nama_spv' => $user->name]),
                    Role::MAHASISWA  => Mahasiswa::create(['user_id' => $user->id, 'nama_mhs' => $user->name, 'depart_id' => $departId]),
                    default          => null,
                };
            });

            ActivityLogger::logCreate('user', $user->name, [
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'email'   => $user->email,
                'by'      => 'superadmin',
            ]);

            return redirect()->route('superadmin.users.index')
                ->with('success', 'Akun berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat akun: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function userEdit(User $user)
    {
        if ((int) $user->role_id === Role::SUPERADMIN) {
            return redirect()->route('superadmin.users.index')
                ->with('error', 'Tidak dapat mengedit akun Superadmin.');
        }

        $roles       = Role::where('id', '!=', Role::SUPERADMIN)->get();
        $departemen  = Departemen::orderBy('nama_depart')->get();
        $authProfile = $this->getAuthProfile();
        return view('superadmin.users.edit', compact('user', 'roles', 'departemen', 'authProfile'));
    }

    public function userUpdate(Request $request, User $user)
    {
        if ((int) $user->role_id === Role::SUPERADMIN) {
            return redirect()->route('superadmin.users.index')
                ->with('error', 'Tidak dapat mengubah akun Superadmin.');
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'role_id'  => 'required|integer|exists:role,id',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'role_id.required' => 'Role wajib dipilih.',
            'email.required'   => 'Email wajib diisi.',
            'email.unique'     => 'Email sudah digunakan.',
            'password.min'     => 'Password minimal 8 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('errorForm', $validator->errors()->getMessages())
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request, $user) {
                $data = [
                    'name'    => $request->name,
                    'email'   => $request->email,
                    'role_id' => $request->role_id,
                ];

                if ($request->filled('password')) {
                    $data['password'] = Hash::make($request->password);
                }

                $user->update($data);

                match ((int) $user->role_id) {
                    Role::DEPARTEMEN => Departemen::where('user_id', $user->id)->update(['nama_depart' => $request->name]),
                    Role::MITRA      => Mitra::where('user_id', $user->id)->update(['nama_mitra' => $request->name]),
                    Role::DOSPEM     => Dosen::where('user_id', $user->id)->update(['nama_dosen' => $request->name]),
                    Role::SUPERVISOR => Supervisor::where('user_id', $user->id)->update(['nama_spv' => $request->name]),
                    Role::MAHASISWA  => Mahasiswa::where('user_id', $user->id)->update(['nama_mhs' => $request->name]),
                    default          => null,
                };
            });

            ActivityLogger::logUpdate('user', $user->name, [
                'user_id' => $user->id,
                'changes' => $request->only(['name', 'email', 'role_id']),
                'by'      => 'superadmin',
            ]);

            return redirect()->route('superadmin.users.index')
                ->with('success', 'Akun berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah akun.')
                ->withInput();
        }
    }

    public function userDestroy(User $user)
    {
        if ((int) $user->role_id === Role::SUPERADMIN) {
            return redirect()->route('superadmin.users.index')
                ->with('error', 'Tidak dapat menghapus akun Superadmin.');
        }

        try {
            $userName = $user->name;

            DB::transaction(function () use ($user) {
                $user->delete();
            });

            ActivityLogger::logDelete('user', $userName, [
                'user_id' => $user->id,
                'by'      => 'superadmin',
            ]);

            return redirect()->back()->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user.');
        }
    }

    // Show detail user (JSON untuk modal)
    public function userShow(User $user)
    {
        return response()->json([
            'code'   => 200,
            'result' => $user->load('role'),
        ]);
    }
}
