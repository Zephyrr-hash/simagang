<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Mitra;
use App\Models\Role;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ActivityLogger;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        $search = $request->search;
        
        // Filter: hanya tampilkan user yang dibuat oleh departemen yang sedang login
        $users = User::with(['role', 'creator'])
            ->where('created_by', Auth::id()) // FILTER BY CREATOR
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
            ->orderBy('role_id', 'asc')
            ->paginate(15)
            ->withQueryString();

        $authProfile = $this->getAuthProfile();
        return view('depart.user.index', compact('users', 'authProfile', 'search'));
    }

    public function create()
    {
        $role = Role::all();
        $authProfile = $this->getAuthProfile();
        return view('depart.user.create', compact('role', 'authProfile'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'role_id'  => 'required|integer|exists:role,id',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('errorForm', $validator->errors()->getMessages())
                ->withInput();
        }

        $depart = Departemen::where('user_id', Auth::id())->first();

        try {
            DB::transaction(function () use ($request, $depart, &$user) {
                $user = User::create([
                    'name'       => $request->name,
                    'email'      => $request->email,
                    'role_id'    => $request->role_id,
                    'password'   => Hash::make($request->password),
                    'created_by' => Auth::id(), // SET CREATOR
                ]);

                match ((int) $request->role_id) {
                    Role::DEPARTEMEN => Departemen::create(['user_id' => $user->id, 'nama_depart' => $user->name]),
                    Role::MITRA      => Mitra::create(['user_id' => $user->id, 'nama_mitra' => $user->name]),
                    Role::DOSPEM     => Dosen::create(['user_id' => $user->id, 'nama_dosen' => $user->name, 'depart_id' => $depart?->id]),
                    Role::SUPERVISOR => Supervisor::create(['user_id' => $user->id, 'nama_spv' => $user->name]),
                    Role::MAHASISWA  => Mahasiswa::create(['user_id' => $user->id, 'nama_mhs' => $user->name, 'depart_id' => $depart?->id]),
                    default          => null,
                };
            });

            // Log activity
            ActivityLogger::logCreate('user', $user->name, [
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'email' => $user->email,
            ]);

            return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat akun. Silakan coba lagi.')->withInput();
        }
    }

    public function show(User $user)
    {
        // Security: hanya bisa view user yang dibuat oleh departemen ini
        if ($user->created_by !== Auth::id()) {
            return response()->json(['code' => 403, 'result' => 'Forbidden']);
        }

        $result = User::find($user->id);
        return response()->json($result
            ? ['code' => 200, 'result' => $result]
            : ['code' => 500, 'result' => 'Error']
        );
    }

    public function edit(User $user)
    {
        // Security: hanya bisa edit user yang dibuat oleh departemen ini
        if ($user->created_by !== Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit user ini.');
        }

        $role = Role::all();
        $authProfile = $this->getAuthProfile();
        return view('depart.user.edit', compact('user', 'role', 'authProfile'));
    }

    public function update(Request $request, User $user)
    {
        // Security: hanya bisa update user yang dibuat oleh departemen ini
        if ($user->created_by !== Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah user ini.');
        }

        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'role_id' => 'required|integer|exists:role,id',
            'email'   => 'required|email|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('errorForm', $validator->errors()->getMessages())
                ->withInput();
        }

        try {
            DB::transaction(function () use ($request, $user) {
                $user->update([
                    'name'    => $request->name,
                    'email'   => $request->email,
                    'role_id' => $request->role_id,
                ]);

                match ((int) $user->role_id) {
                    Role::DEPARTEMEN => Departemen::where('user_id', $user->id)->update(['nama_depart' => $request->name]),
                    Role::MITRA      => Mitra::where('user_id', $user->id)->update(['nama_mitra' => $request->name]),
                    Role::DOSPEM     => Dosen::where('user_id', $user->id)->update(['nama_dosen' => $request->name]),
                    Role::SUPERVISOR => Supervisor::where('user_id', $user->id)->update(['nama_spv' => $request->name]),
                    Role::MAHASISWA  => Mahasiswa::where('user_id', $user->id)->update(['nama_mhs' => $request->name]),
                    default          => null,
                };
            });

            // Log activity
            ActivityLogger::logUpdate('user', $user->name, [
                'user_id' => $user->id,
                'changes' => $request->only(['name', 'email', 'role_id']),
            ]);

            return redirect()->route('users.index')->with('success', 'Akun berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah akun.')->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Security: hanya bisa delete user yang dibuat oleh departemen ini
        if ($user->created_by !== Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus user ini.');
        }

        try {
            $userName = $user->name;
            
            DB::transaction(function () use ($user) {
                $user->delete();
            });

            // Log activity
            ActivityLogger::logDelete('user', $userName, [
                'user_id' => $id,
            ]);

            return redirect()->back()->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user.');
        }
    }
}
