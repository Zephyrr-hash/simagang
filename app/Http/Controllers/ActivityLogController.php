<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs (Departemen only)
     */
    public function index(Request $request)
    {
        // Filter parameters
        $action = $request->input('action');
        $module = $request->input('module');
        $userId = $request->input('user_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        // Query builder
        $logs = ActivityLog::with('user')
            ->when($action, fn($q) => $q->where('action', $action))
            ->when($module, fn($q) => $q->where('module', $module))
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]))
            ->when($search, function($q) use ($search) {
                $q->where(function($query) use ($search) {
                    $query->where('description', 'like', "%{$search}%")
                          ->orWhere('action', 'like', "%{$search}%")
                          ->orWhere('module', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Get unique actions and modules for filter
        $actions = ActivityLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $modules = ActivityLog::select('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        // Get all users for filter
        $users = User::select('id', 'name', 'role_id')
            ->orderBy('name')
            ->get();

        // Statistics
        $stats = $this->getStatistics($startDate, $endDate);

        return view('depart.activity-logs.index', compact(
            'logs',
            'actions',
            'modules',
            'users',
            'stats'
        ));
    }

    /**
     * Get statistics
     */
    private function getStatistics($startDate = null, $endDate = null): array
    {
        $query = ActivityLog::query();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }

        return [
            'total' => $query->count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'this_week' => ActivityLog::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'this_month' => ActivityLog::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'by_action' => $query->clone()
                ->select('action', DB::raw('count(*) as total'))
                ->groupBy('action')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get(),
            'by_module' => $query->clone()
                ->select('module', DB::raw('count(*) as total'))
                ->groupBy('module')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->get(),
            'top_users' => $query->clone()
                ->select('user_id', DB::raw('count(*) as total'))
                ->whereNotNull('user_id')
                ->groupBy('user_id')
                ->orderBy('total', 'desc')
                ->limit(5)
                ->with('user')
                ->get(),
        ];
    }

    /**
     * Show activity log detail
     */
    public function show($id)
    {
        $log = ActivityLog::with('user')->findOrFail($id);
        
        return view('depart.activity-logs.show', compact('log'));
    }

    /**
     * Export logs to CSV
     */
    public function export(Request $request)
    {
        $action = $request->input('action');
        $module = $request->input('module');
        $userId = $request->input('user_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $logs = ActivityLog::with('user')
            ->when($action, fn($q) => $q->where('action', $action))
            ->when($module, fn($q) => $q->where('module', $module))
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]))
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'activity_logs_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM untuk Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header CSV
            fputcsv($file, [
                'No',
                'Tanggal/Waktu',
                'User',
                'Role',
                'Aksi',
                'Module',
                'Deskripsi',
                'IP Address',
            ]);

            // Data
            foreach ($logs as $index => $log) {
                fputcsv($file, [
                    $index + 1,
                    $log->created_at->format('d/m/Y H:i:s'),
                    $log->user?->name ?? 'System',
                    $log->role ?? '-',
                    $log->action,
                    $log->module,
                    $log->description,
                    $log->ip_address ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Clear old logs (older than X days)
     */
    public function clearOld(Request $request)
    {
        $days = $request->input('days', 90); // Default 90 hari
        
        $deleted = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();
        
        return redirect()->back()->with('success', "Berhasil menghapus {$deleted} log aktivitas yang lebih dari {$days} hari.");
    }

    /**
     * Display ALL activity logs (Superadmin - tanpa filter departemen)
     */
    public function indexAll(Request $request)
    {
        $action    = $request->input('action');
        $module    = $request->input('module');
        $userId    = $request->input('user_id');
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $search    = $request->input('search');

        $logs = ActivityLog::with('user')
            ->when($action, fn($q) => $q->where('action', $action))
            ->when($module, fn($q) => $q->where('module', $module))
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59',
            ]))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('description', 'like', "%{$search}%")
                          ->orWhere('action', 'like', "%{$search}%")
                          ->orWhere('module', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $actions = ActivityLog::select('action')->distinct()->orderBy('action')->pluck('action');
        $modules = ActivityLog::select('module')->distinct()->orderBy('module')->pluck('module');
        $users   = \App\Models\User::select('id', 'name', 'role_id')->orderBy('name')->get();
        $stats   = $this->getStatistics($startDate, $endDate);

        return view('superadmin.activity-logs.index', compact(
            'logs', 'actions', 'modules', 'users', 'stats'
        ));
    }

    /**
     * Export ALL logs to CSV (Superadmin)
     */
    public function exportAll(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->when($request->module, fn($q) => $q->where('module', $request->module))
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->start_date && $request->end_date, fn($q) => $q->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]))
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'all_activity_logs_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['No', 'Tanggal/Waktu', 'User', 'Role', 'Aksi', 'Module', 'Deskripsi', 'IP Address']);
            foreach ($logs as $i => $log) {
                fputcsv($file, [
                    $i + 1,
                    $log->created_at->format('d/m/Y H:i:s'),
                    $log->user?->name ?? 'System',
                    $log->role ?? '-',
                    $log->action,
                    $log->module,
                    $log->description,
                    $log->ip_address ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
