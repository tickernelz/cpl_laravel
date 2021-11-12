<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kcpl extends Model
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

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function bobotcpl()
    {
        return $this->belongsTo(Bobotcpl::class);
    }

    public function cpl()
    {
        return $this->belongsTo(Cpl::class);
    }
}
