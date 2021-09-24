<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Nilai
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai query()
 * @mixin \Eloquent
 */
class Nilai extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function btp()
    {
        return $this->belongsTo(Btp::class);
    }
}
