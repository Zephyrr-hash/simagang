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
        'nama_mitra','user_id','alamat_mitra','telepon_mitra','fax_mitra','foto_mitra','kab_id'
    ];

    public function lowongan()
    {
        return $this->hasMany(Lowongan::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kab_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function spv(){
        return $this->hasMany(Supervisor::class);
    }
}
