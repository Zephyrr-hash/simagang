<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table    = 'kecamatan';
    protected $fillable = ['nama', 'kode_bps', 'kabupaten_id'];

    public function kabupaten(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    public function mitra(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Mitra::class, 'kecamatan_id');
    }
}
