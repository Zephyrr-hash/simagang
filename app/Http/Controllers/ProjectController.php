<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\Logbook;
use App\Models\Magang;
use App\Models\Mahasiswa;
use App\Models\ProjectMagang;
use App\Models\Role;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends BaseController
{
    // =========================================================================
    // HELPER — ambil project dengan otorisasi berdasarkan role
    // =========================================================================

    /**
     * Cari project berdasarkan ID dan pastikan user berhak mengaksesnya.
     * SPV = owner, Dosen = melalui dosen_id di magang, Mahasiswa = melalui mhs_id di magang.
     */
    private function findAuthorizedProject(int $id): ProjectMagang
    {
        $user   = Auth::user();
        $roleId = (int) $user->role_id;

        $query = ProjectMagang::with([
            'magang.mahasiswa.jurusan',
            'magang.lowongan.mitra',
            'magang.dosen',
            'magang.spv',
        ]);

        return match ($roleId) {
            Role::SUPERVISOR => (function () use ($query, $id, $user) {
                $spv = Supervisor::where('user_id', $user->id)->firstOrFail();
                return $query->whereHas('magang', fn($q) => $q->where('spv_id', $spv->id))
                             ->findOrFail($id);
            })(),

            Role::DOSPEM => (function () use ($query, $id, $user) {
                $dosen = Dosen::where('user_id', $user->id)->firstOrFail();
                return $query->whereHas('magang', fn($q) => $q->where('dosen_id', $dosen->id))
                             ->findOrFail($id);
            })(),

            Role::MAHASISWA => (function () use ($query, $id, $user) {
                $mhs = Mahasiswa::where('user_id', $user->id)->firstOrFail();
                return $query->whereHas('magang', fn($q) => $q->where('mhs_id', $mhs->id))
                             ->findOrFail($id);
            })(),

            default => abort(403, 'Akses tidak diizinkan.'),
        };
    }

    /**
     * Ambil semua project yang bisa diakses user sesuai role.
     */
    private function getProjectsForUser()
    {
        $user   = Auth::user();
        $roleId = (int) $user->role_id;

        $query = ProjectMagang::with(['magang.mahasiswa', 'magang.lowongan.mitra']);

        return match ($roleId) {
            Role::SUPERVISOR => (function () use ($query, $user) {
                $spv = Supervisor::where('user_id', $user->id)->firstOrFail();
                return $query->whereHas('magang', fn($q) => $q->where('spv_id', $spv->id))
                             ->orderBy('created_at', 'desc')->get();
            })(),

            Role::DOSPEM => (function () use ($query, $user) {
                $dosen = Dosen::where('user_id', $user->id)->firstOrFail();
                return $query->whereHas('magang', fn($q) => $q->where('dosen_id', $dosen->id))
                             ->orderBy('created_at', 'desc')->get();
            })(),

            Role::MAHASISWA => (function () use ($query, $user) {
                $mhs = Mahasiswa::where('user_id', $user->id)->firstOrFail();
                return $query->whereHas('magang', fn($q) => $q->where('mhs_id', $mhs->id))
                             ->orderBy('created_at', 'desc')->get();
            })(),

            default => collect(),
        };
    }

    // =========================================================================
    // PROJECT CRUD (hanya SPV bisa create/edit/delete)
    // =========================================================================

    /** Daftar semua project yang bisa diakses user */
    public function index()
    {
        $projects    = $this->getProjectsForUser();
        $authProfile = $this->getAuthProfile();
        $roleId      = (int) Auth::user()->role_id;

        return view('project.index', compact('projects', 'authProfile', 'roleId'));
    }

    /** Form buat project baru — hanya SPV */
    public function create(Request $request)
    {
        $this->authorizeSpv();

        $spv = Supervisor::where('user_id', Auth::id())->firstOrFail();
        $magangs = Magang::with(['mahasiswa', 'lowongan'])
            ->where('spv_id', $spv->id)
            ->where('approval', Magang::DITERIMA)
            ->get();

        $selectedMagangId = $request->query('magang_id');
        $authProfile      = $this->getAuthProfile();

        return view('project.create', compact('magangs', 'selectedMagangId', 'authProfile'));
    }

    /** Simpan project baru — hanya SPV */
    public function store(Request $request)
    {
        $this->authorizeSpv();

        $spv = Supervisor::where('user_id', Auth::id())->firstOrFail();

        $validator = Validator::make($request->all(), [
            'magang_id'    => 'required|integer|exists:magang,id',
            'nama_project' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tujuan'       => 'nullable|string',
            'teknologi'    => 'nullable|string|max:255',
            'status'       => 'required|in:aktif,selesai,pending',
            'tgl_mulai'    => 'nullable|date',
            'tgl_selesai'  => 'nullable|date|after_or_equal:tgl_mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $magang = Magang::where('id', $request->magang_id)
            ->where('spv_id', $spv->id)->firstOrFail();

        $project = ProjectMagang::create([
            'magang_id'    => $magang->id,
            'nama_project' => $request->nama_project,
            'deskripsi'    => $request->deskripsi,
            'tujuan'       => $request->tujuan,
            'teknologi'    => $request->teknologi,
            'status'       => $request->status,
            'tgl_mulai'    => $request->tgl_mulai,
            'tgl_selesai'  => $request->tgl_selesai,
        ]);

        return redirect()->route('project.show', $project->id)->with('success', 'Project berhasil dibuat!');
    }

    /** Detail project — tampilkan logbook + bimbingan sesuai role */
    public function show($id)
    {
        $project = $this->findAuthorizedProject($id);
        $roleId  = (int) Auth::user()->role_id;

        // Logbook: hanya SPV dan Mahasiswa yang bisa melihat
        $logbooks = in_array($roleId, [Role::SUPERVISOR, Role::MAHASISWA])
            ? $project->logbooks()->orderBy('tanggal', 'asc')->get()
            : collect();

        // Bimbingan: hanya Dosen dan Mahasiswa yang bisa melihat
        $bimbingans = in_array($roleId, [Role::DOSPEM, Role::MAHASISWA])
            ? $project->bimbingans()->orderBy('tgl_bimbingan', 'asc')->get()
            : collect();

        $authProfile = $this->getAuthProfile();

        return view('project.show', compact('project', 'logbooks', 'bimbingans', 'roleId', 'authProfile'));
    }

    /** Form edit project — hanya SPV */
    public function edit($id)
    {
        $this->authorizeSpv();

        $spv     = Supervisor::where('user_id', Auth::id())->firstOrFail();
        $project = ProjectMagang::with(['magang.mahasiswa', 'magang.lowongan'])
            ->whereHas('magang', fn($q) => $q->where('spv_id', $spv->id))
            ->findOrFail($id);

        $authProfile = $this->getAuthProfile();
        return view('project.edit', compact('project', 'authProfile'));
    }

    /** Update project — hanya SPV */
    public function update(Request $request, $id)
    {
        $this->authorizeSpv();

        $spv     = Supervisor::where('user_id', Auth::id())->firstOrFail();
        $project = ProjectMagang::whereHas('magang', fn($q) => $q->where('spv_id', $spv->id))
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_project' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tujuan'       => 'nullable|string',
            'teknologi'    => 'nullable|string|max:255',
            'status'       => 'required|in:aktif,selesai,pending',
            'tgl_mulai'    => 'nullable|date',
            'tgl_selesai'  => 'nullable|date|after_or_equal:tgl_mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $project->update($request->only([
            'nama_project', 'deskripsi', 'tujuan', 'teknologi',
            'status', 'tgl_mulai', 'tgl_selesai',
        ]));

        return redirect()->route('project.show', $project->id)->with('success', 'Project berhasil diperbarui!');
    }

    /** Hapus project — hanya SPV */
    public function destroy($id)
    {
        $this->authorizeSpv();

        $spv     = Supervisor::where('user_id', Auth::id())->firstOrFail();
        $project = ProjectMagang::whereHas('magang', fn($q) => $q->where('spv_id', $spv->id))
            ->findOrFail($id);

        $project->delete(); // cascade ke logbook + bimbingan

        return redirect()->route('project.index')->with('success', 'Project berhasil dihapus!');
    }

    // =========================================================================
    // LOGBOOK — hanya Mahasiswa yang bisa CRUD logbook
    // =========================================================================

    public function logbookCreate($projectId)
    {
        $project     = $this->findAuthorizedProject($projectId);
        $authProfile = $this->getAuthProfile();
        return view('project.logbook.create', compact('project', 'authProfile'));
    }

    public function logbookStore(Request $request, $projectId)
    {
        if ((int) Auth::user()->role_id !== Role::MAHASISWA) abort(403);

        $project = $this->findAuthorizedProject($projectId);

        $validator = Validator::make($request->all(), [
            'tanggal'       => 'required|date',
            'kegiatan'      => 'required|string|max:255',
            'deskripsi_log' => 'required|string',
            'saran'         => 'nullable|string',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $fileName = null;
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . Str::uuid() . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('file'), $fileName);
        }

        Logbook::create([
            'tanggal'       => $request->tanggal,
            'kegiatan'      => $request->kegiatan,
            'deskripsi_log' => $request->deskripsi_log,
            'saran'         => $request->saran,
            'file'          => $fileName,
            'magang_id'     => $project->magang_id,
            'project_id'    => $project->id,
        ]);

        return redirect()->route('project.show', $project->id)->with('success', 'Logbook berhasil ditambahkan!');
    }

    public function logbookEdit($projectId, $logId)
    {
        if ((int) Auth::user()->role_id !== Role::MAHASISWA) abort(403);
        $project     = $this->findAuthorizedProject($projectId);
        $log         = Logbook::where('project_id', $project->id)->findOrFail($logId);
        $authProfile = $this->getAuthProfile();
        return view('project.logbook.edit', compact('project', 'log', 'authProfile'));
    }

    public function logbookUpdate(Request $request, $projectId, $logId)
    {
        if ((int) Auth::user()->role_id !== Role::MAHASISWA) abort(403);
        $project = $this->findAuthorizedProject($projectId);
        $log     = Logbook::where('project_id', $project->id)->findOrFail($logId);

        $validator = Validator::make($request->all(), [
            'tanggal'       => 'required|date',
            'kegiatan'      => 'required|string|max:255',
            'deskripsi_log' => 'required|string',
            'saran'         => 'nullable|string',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $data = $request->only(['tanggal', 'kegiatan', 'deskripsi_log', 'saran']);

        if ($request->hasFile('file')) {
            if ($log->file && file_exists(public_path('file/' . $log->file))) {
                @unlink(public_path('file/' . $log->file));
            }
            $fileName = time() . '_' . Str::uuid() . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('file'), $fileName);
            $data['file'] = $fileName;
        }

        $log->update($data);
        return redirect()->route('project.show', $project->id)->with('success', 'Logbook berhasil diubah!');
    }

    public function logbookDestroy($projectId, $logId)
    {
        if ((int) Auth::user()->role_id !== Role::MAHASISWA) abort(403);
        $project = $this->findAuthorizedProject($projectId);
        $log     = Logbook::where('project_id', $project->id)->findOrFail($logId);

        // Hapus file attachment jika ada
        foreach (['file', 'file_spv'] as $field) {
            if ($log->$field && file_exists(public_path('file/' . $log->$field))) {
                @unlink(public_path('file/' . $log->$field));
            }
        }

        $log->delete();
        return redirect()->route('project.show', $project->id)->with('success', 'Logbook berhasil dihapus!');
    }

    /** SPV memberikan catatan dan opsional file pada logbook */
    public function logbookCatatan(Request $request, $projectId, $logId)
    {
        if ((int) Auth::user()->role_id !== Role::SUPERVISOR) abort(403);
        $project = $this->findAuthorizedProject($projectId);
        $log     = Logbook::where('project_id', $project->id)->findOrFail($logId);

        $validator = Validator::make($request->all(), [
            'catatan_spv' => 'nullable|string|max:1000',
            'file_spv'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages());
        }

        $data = [];

        if ($request->filled('catatan_spv')) {
            $data['catatan_spv'] = $request->catatan_spv;
        }

        if ($request->hasFile('file_spv')) {
            // Hapus file lama jika ada
            if ($log->file_spv && file_exists(public_path('file/' . $log->file_spv))) {
                @unlink(public_path('file/' . $log->file_spv));
            }
            $fileName = time() . '_spv_' . Str::uuid() . '.' . $request->file('file_spv')->extension();
            $request->file('file_spv')->move(public_path('file'), $fileName);
            $data['file_spv'] = $fileName;
        }

        if (empty($data)) {
            return redirect()->back()->with('errorForm', ['Harap isi catatan atau lampirkan file.']);
        }

        $log->update($data);
        return redirect()->back()->with('success', 'Catatan berhasil disimpan!');
    }

    // =========================================================================
    // BIMBINGAN — Mahasiswa submit, Dosen beri feedback
    // =========================================================================

    public function bimbinganCreate($projectId)
    {
        if ((int) Auth::user()->role_id !== Role::MAHASISWA) abort(403);
        $project     = $this->findAuthorizedProject($projectId);
        $authProfile = $this->getAuthProfile();
        return view('project.bimbingan.create', compact('project', 'authProfile'));
    }

    public function bimbinganStore(Request $request, $projectId)
    {
        if ((int) Auth::user()->role_id !== Role::MAHASISWA) abort(403);
        $project = $this->findAuthorizedProject($projectId);

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

        Bimbingan::create([
            'catatan'       => $request->catatan,
            'tgl_bimbingan' => $request->tgl_bimbingan,
            'file'          => $fileName,
            'magang_id'     => $project->magang_id,
            'project_id'    => $project->id,
        ]);

        return redirect()->route('project.show', $project->id)->with('success', 'Laporan bimbingan berhasil dikirim!');
    }

    public function bimbinganEdit($projectId, $bimId)
    {
        if ((int) Auth::user()->role_id !== Role::MAHASISWA) abort(403);
        $project     = $this->findAuthorizedProject($projectId);
        $bimbingan   = Bimbingan::where('project_id', $project->id)->findOrFail($bimId);
        $authProfile = $this->getAuthProfile();
        return view('project.bimbingan.edit', compact('project', 'bimbingan', 'authProfile'));
    }

    public function bimbinganUpdate(Request $request, $projectId, $bimId)
    {
        if ((int) Auth::user()->role_id !== Role::MAHASISWA) abort(403);
        $project   = $this->findAuthorizedProject($projectId);
        $bimbingan = Bimbingan::where('project_id', $project->id)->findOrFail($bimId);

        $validator = Validator::make($request->all(), [
            'catatan'       => 'required|string',
            'tgl_bimbingan' => 'required|date',
            'file'          => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages())->withInput();
        }

        $data = $request->only(['catatan', 'tgl_bimbingan']);

        if ($request->hasFile('file')) {
            if ($bimbingan->file && file_exists(public_path('file/' . $bimbingan->file))) {
                @unlink(public_path('file/' . $bimbingan->file));
            }
            $fileName = time() . '_' . Str::uuid() . '.' . $request->file->extension();
            $request->file->move(public_path('file'), $fileName);
            $data['file'] = $fileName;
        }

        $bimbingan->update($data);
        return redirect()->route('project.show', $project->id)->with('success', 'Bimbingan berhasil diubah!');
    }

    public function bimbinganDestroy($projectId, $bimId)
    {
        if ((int) Auth::user()->role_id !== Role::MAHASISWA) abort(403);
        $project   = $this->findAuthorizedProject($projectId);
        $bimbingan = Bimbingan::where('project_id', $project->id)->findOrFail($bimId);

        if ($bimbingan->file && file_exists(public_path('file/' . $bimbingan->file))) {
            @unlink(public_path('file/' . $bimbingan->file));
        }

        $bimbingan->delete();
        return redirect()->route('project.show', $project->id)->with('success', 'Bimbingan berhasil dihapus!');
    }

    /** Dosen memberikan feedback dan opsional file pada bimbingan */
    public function bimbinganFeedback(Request $request, $projectId, $bimId)
    {
        if ((int) Auth::user()->role_id !== Role::DOSPEM) abort(403);
        $project   = $this->findAuthorizedProject($projectId);
        $bimbingan = Bimbingan::where('project_id', $project->id)->findOrFail($bimId);

        $validator = Validator::make($request->all(), [
            'feedback'      => 'nullable|string|max:2000',
            'feedback_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errorForm', $validator->errors()->getMessages());
        }

        $data = [];

        if ($request->filled('feedback')) {
            $data['feedback'] = $request->feedback;
        }

        if ($request->hasFile('feedback_file')) {
            // Hapus file lama jika ada
            if ($bimbingan->feedback_file && file_exists(public_path('file/' . $bimbingan->feedback_file))) {
                @unlink(public_path('file/' . $bimbingan->feedback_file));
            }
            $fileName = time() . '_fb_' . Str::uuid() . '.' . $request->file('feedback_file')->extension();
            $request->file('feedback_file')->move(public_path('file'), $fileName);
            $data['feedback_file'] = $fileName;
        }

        if (empty($data)) {
            return redirect()->back()->with('errorForm', ['Harap isi feedback atau lampirkan file.']);
        }

        $bimbingan->update($data);
        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }

    // =========================================================================
    // PDF Export Logbook (tetap tersedia dari dalam project)
    // =========================================================================
    public function printLogbook($projectId)
    {
        $project  = $this->findAuthorizedProject($projectId);
        $logbooks = $project->logbooks()->orderBy('tanggal', 'asc')->get();
        $mhs      = $project->magang?->mahasiswa;
        $magang   = $project->magang;

        $pdf = \Barryvdh\DomPDF\Facade::loadView('project.logbook.print', compact('project', 'logbooks', 'mhs', 'magang'));
        return $pdf->download('Logbook_' . ($mhs->nama_mhs ?? 'Mahasiswa') . '_' . Str::slug($project->nama_project) . '.pdf');
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function authorizeSpv(): void
    {
        if ((int) Auth::user()->role_id !== Role::SUPERVISOR) {
            abort(403, 'Hanya Supervisor yang dapat melakukan aksi ini.');
        }
    }
}
