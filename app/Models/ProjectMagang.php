<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMagang extends Model
{
    use HasFactory;

    protected $table    = 'project_magang';
    protected $fillable = [
        'nama_project', 'deskripsi', 'tujuan', 'teknologi',
        'status', 'tgl_mulai', 'tgl_selesai', 'magang_id',
    ];

    protected $casts = [
        'tgl_mulai'   => 'date',
        'tgl_selesai' => 'date',
    ];

    /** Project milik satu record magang (mhs + spv) */
    public function magang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Magang::class, 'magang_id');
    }

    /** Logbook yang terkait project ini */
    public function logbooks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Logbook::class, 'project_id');
    }

    /** Bimbingan yang terkait project ini */
    public function bimbingans(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Bimbingan::class, 'project_id');
    }

    /** Shortcut: mahasiswa lewat magang */
    public function mahasiswa(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            Mahasiswa::class,
            Magang::class,
            'id',        // FK di magang
            'id',        // FK di mahasiswa
            'magang_id', // local key di project_magang
            'mhs_id'     // local key di magang
        );
    }

    /** Label warna status */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'aktif'   => '#4F46E5',
            'selesai' => '#059669',
            'pending' => '#D97706',
            default   => '#6B7280',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'aktif'   => 'Aktif',
            'selesai' => 'Selesai',
            'pending' => 'Pending',
            default   => $this->status,
        };
    }
}
