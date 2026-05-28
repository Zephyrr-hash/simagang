<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_low','deskripsi_low','telepon_low','jumlah_mhs','durasi','mitra_id','kategori_id','lokasi','foto_low'
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function mitra(){
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function magang(){
        return $this->hasMany(Magang::class, 'lowongan_id');
    }
}
