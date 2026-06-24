<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const DEPARTEMEN = 1;
    const MITRA      = 2;
    const DOSPEM     = 3;
    const SUPERVISOR = 4;
    const MAHASISWA  = 5;
    const SUPERADMIN = 6;

    protected $table = 'role';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
