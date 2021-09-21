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
