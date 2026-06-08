<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $table = 'bimbingan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'catatan', 'tgl_bimbingan', 'file', 'feedback', 'feedback_file', 'magang_id', 'project_id'
    ];

    public function magang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Magang::class, 'magang_id');
    }

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProjectMagang::class, 'project_id');
    }
}
