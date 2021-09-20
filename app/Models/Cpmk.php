<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cpmk.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Cpmk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cpmk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cpmk query()
 * @mixin Eloquent
 */
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
}
