<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cpl.
 *
 * @mixin Eloquent
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Cpl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cpl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cpl query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cpl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cpl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cpl whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cpl whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cpl whereUpdatedAt($value)
 * @property string $kode_cpl
 * @property string $nama_cpl
 * @method static \Illuminate\Database\Eloquent\Builder|Cpl whereKodeCpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cpl whereNamaCpl($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bobotcpl[] $bobotcpl
 * @property-read int|null $bobotcpl_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\kcpl[] $kcpl
 * @property-read int|null $kcpl_count
 */
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
