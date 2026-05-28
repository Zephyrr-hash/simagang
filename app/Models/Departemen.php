<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemen';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'nama_depart', 'alamat_depart', 'telepon_depart', 'NIDN', 'foto_depart'
    ];

    public function dosen(){
        return $this->hasMany(Dosen::class);
    }

    public function mahasiswa(){
        return $this->hasMany(Mahasiswa::class, 'depart_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
