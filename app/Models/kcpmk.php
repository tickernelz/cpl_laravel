<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kcpmk extends Model
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

    public function cpmk()
    {
        return $this->belongsTo(Cpmk::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function btp()
    {
        return $this->belongsTo(Btp::class);
    }
}
