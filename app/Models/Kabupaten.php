<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table    = 'kabupaten';
    protected $fillable = ['nama', 'kode_bps', 'provinsi_id'];

    public function provinsi(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kecamatan(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Kecamatan::class, 'kabupaten_id');
    }

    public function mitra(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Mitra::class, 'kab_id');
    }
}
