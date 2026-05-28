<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillMhs extends Model
{
    use HasFactory;

    protected $table = 'skill_mhs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'skill_id', 'mhs_id'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mhs_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }
}
