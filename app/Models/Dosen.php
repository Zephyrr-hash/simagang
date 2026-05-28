<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'nama_dosen', 'telepon_dosen', 'NIP', 'foto_dosen', 'depart_id'
    ];

    public function depart(){
        return $this->belongsTo(Departemen::class, 'depart_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function magang(){
        return $this->hasMany(Magang::class, 'dosen_id');
    }
}
