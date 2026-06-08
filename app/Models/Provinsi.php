<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table    = 'provinsi';
    protected $fillable = ['nama', 'kode_bps'];

    public function kabupaten(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Kabupaten::class, 'provinsi_id');
    }
}
