<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role',
        'action',
        'module',
        'description',
        'details',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'details' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk filter berdasarkan action
     */
    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope untuk filter berdasarkan module
     */
    public function scopeByModule($query, string $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Get action badge color
     */
    public function getActionBadgeAttribute(): string
    {
        return match($this->action) {
            'login' => 'info',
            'logout' => 'secondary',
            'create' => 'success',
            'update' => 'warning',
            'delete' => 'danger',
            'approve' => 'success',
            'reject' => 'danger',
            'view' => 'info',
            default => 'secondary',
        };
    }

    /**
     * Get action icon
     */
    public function getActionIconAttribute(): string
    {
        return match($this->action) {
            'login' => '🔐',
            'logout' => '🚪',
            'create' => '➕',
            'update' => '✏️',
            'delete' => '🗑️',
            'approve' => '✅',
            'reject' => '❌',
            'view' => '👁️',
            default => '📝',
        };
    }

    /**
     * Get formatted time
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->locale('id')->diffForHumans();
    }
}
