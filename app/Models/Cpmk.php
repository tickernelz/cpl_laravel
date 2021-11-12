<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpmk extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function mata_kuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function btp()
    {
        return $this->hasMany(Btp::class);
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
