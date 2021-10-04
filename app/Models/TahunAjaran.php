<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TahunAjaran.
 *
 * @mixin Eloquent
 * @property int $id
 * @property string $tahun
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\KRS $krs
 * @method static \Illuminate\Database\Eloquent\Builder|TahunAjaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TahunAjaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TahunAjaran query()
 * @method static \Illuminate\Database\Eloquent\Builder|TahunAjaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TahunAjaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TahunAjaran whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TahunAjaran whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bobotcpl[] $bobotcpl
 * @property-read int|null $bobotcpl_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Btp[] $btp
 * @property-read int|null $btp_count
 * @property-read int|null $krs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\kcpmk[] $kcpmk
 * @property-read int|null $kcpmk_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\kcpl[] $kcpl
 * @property-read int|null $kcpl_count
 */
class TahunAjaran extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function krs()
    {
        return $this->hasMany(KRS::class);
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

    public function kcpl()
    {
        return $this->hasMany(Kcpl::class);
    }
}
