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
 * @property int $id
 * @property int $mata_kuliah_id
 * @property string $kode_cpmk
 * @property string $nama_cpmk
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MataKuliah $mata_kuliah
 * @method static \Illuminate\Database\Eloquent\Builder|Cpmk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cpmk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cpmk whereKodeCpmk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cpmk whereMataKuliahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cpmk whereNamaCpmk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cpmk whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bobotcpl[] $bobotcpl
 * @property-read int|null $bobotcpl_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Btp[] $btp
 * @property-read int|null $btp_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\kcpmk[] $kcpmk
 * @property-read int|null $kcpmk_count
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
