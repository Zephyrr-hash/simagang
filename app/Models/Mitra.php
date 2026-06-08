<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitra';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_mitra', 'user_id', 'alamat_mitra', 'telepon_mitra', 'fax_mitra',
        'foto_mitra', 'kab_id', 'provinsi_id', 'kecamatan_id', 'kode_pos',
    ];

    public function lowongan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Lowongan::class);
    }

    public function kabupaten(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kab_id');
    }

    public function provinsi(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kecamatan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function spv(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Supervisor::class);
    }
}
