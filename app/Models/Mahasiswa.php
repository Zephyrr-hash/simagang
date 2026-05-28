<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'nama_mhs', 'NIM', 'telepon_mhs', 'pengalaman', 'jurusan_id', 'status_id', 'jenis_kelamin', 'tgl_lahir', 'foto_mhs', 'depart_id'
    ];

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function jurusan(){
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function depart(){
        return $this->belongsTo(Departemen::class);
    }

    public function magang(){
        return $this->hasMany(Magang::class, 'mhs_id');
    }

    public function skillMhs(){
        return $this->hasMany(SkillMhs::class, 'mhs_id');
    }
}
