<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log aktivitas
     * 
     * @param string $action - Tipe aksi (login, create, update, delete, approve, reject)
     * @param string $module - Module/fitur (lowongan, user, magang, dll)
     * @param string $description - Deskripsi aktivitas
     * @param array $details - Detail tambahan (opsional)
     * @return ActivityLog|null
     */
    public static function log(
        string $action,
        string $module,
        string $description,
        array $details = []
    ): ?ActivityLog {
        try {
            $user = Auth::user();
            
            // Get role name
            $roleName = $user ? self::getRoleName($user->role_id) : null;
            
            return ActivityLog::create([
                'user_id' => $user?->id,
                'role' => $roleName,
                'action' => $action,
                'module' => $module,
                'description' => $description,
                'details' => !empty($details) ? $details : null,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            // Log error tapi jangan break aplikasi
            \Log::error('ActivityLogger Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Log login
     */
    public static function logLogin(): void
    {
        self::log(
            'login',
            'auth',
            'User melakukan login ke sistem'
        );
    }

    /**
     * Log logout
     */
    public static function logLogout(): void
    {
        self::log(
            'logout',
            'auth',
            'User melakukan logout dari sistem'
        );
    }

    /**
     * Log create
     */
    public static function logCreate(string $module, string $itemName, array $details = []): void
    {
        self::log(
            'create',
            $module,
            "Membuat {$module} baru: {$itemName}",
            $details
        );
    }

    /**
     * Log update
     */
    public static function logUpdate(string $module, string $itemName, array $details = []): void
    {
        self::log(
            'update',
            $module,
            "Mengubah {$module}: {$itemName}",
            $details
        );
    }

    /**
     * Log delete
     */
    public static function logDelete(string $module, string $itemName, array $details = []): void
    {
        self::log(
            'delete',
            $module,
            "Menghapus {$module}: {$itemName}",
            $details
        );
    }

    /**
     * Log approve
     */
    public static function logApprove(string $module, string $itemName, array $details = []): void
    {
        self::log(
            'approve',
            $module,
            "Menyetujui {$module}: {$itemName}",
            $details
        );
    }

    /**
     * Log reject
     */
    public static function logReject(string $module, string $itemName, array $details = []): void
    {
        self::log(
            'reject',
            $module,
            "Menolak {$module}: {$itemName}",
            $details
        );
    }

    /**
     * Log view
     */
    public static function logView(string $module, string $itemName, array $details = []): void
    {
        self::log(
            'view',
            $module,
            "Melihat detail {$module}: {$itemName}",
            $details
        );
    }

    /**
     * Get role name dari role_id
     */
    private static function getRoleName(int $roleId): string
    {
        return match($roleId) {
            1 => 'Departemen',
            2 => 'Mitra',
            3 => 'Dosen Pembimbing',
            4 => 'Supervisor',
            5 => 'Mahasiswa',
            default => 'Unknown',
        };
    }
}
