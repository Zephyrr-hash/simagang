<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $table = 'supervisor';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'nama_spv', 'telepon_spv', 'no_pegawai', 'foto_spv', 'mitra_id'
    ];

    public function mitra(){
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function magang(){
        return $this->hasMany(Magang::class, 'spv_id');
    }
}
