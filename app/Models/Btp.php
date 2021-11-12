<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Btp extends Model
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

    public function dosen_admin()
    {
        return $this->belongsTo(DosenAdmin::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function bobotcpl()
    {
        return $this->hasMany(Bobotcpl::class);
    }

    public function kcpmk()
    {
        return $this->hasMany(Kcpmk::class);
    }
}
