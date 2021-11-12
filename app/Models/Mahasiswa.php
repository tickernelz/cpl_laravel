<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function krs()
    {
        return $this->hasMany(KRS::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function kcpmk()
    {
        return $this->hasMany(Kcpmk::class);
    }

    public function kcpl()
    {
        return $this->hasMany(Kcpl::class);
    }
}
