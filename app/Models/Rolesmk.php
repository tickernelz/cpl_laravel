<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rolesmk extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function mata_kuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function dosen_admin()
    {
        return $this->belongsTo(DosenAdmin::class);
    }
}
