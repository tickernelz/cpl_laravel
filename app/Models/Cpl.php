<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpl extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function bobotcpl()
    {
        return $this->hasMany(Bobotcpl::class);
    }

    public function kcpl()
    {
        return $this->hasMany(Kcpl::class);
    }
}
