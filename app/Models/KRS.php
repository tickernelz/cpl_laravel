<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\KRS.
 *
 * @mixin Eloquent
 * @property int $id
 * @property int $mahasiswa_id
 * @property int $tahun_ajaran_id
 * @property int $mata_kuliah_id
 * @property string $semester
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mahasiswa $mahasiswa
 * @property-read \App\Models\MataKuliah $mata_kuliah
 * @property-read \App\Models\TahunAjaran $tahun_ajaran
 * @method static \Illuminate\Database\Eloquent\Builder|KRS newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KRS newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KRS query()
 * @method static \Illuminate\Database\Eloquent\Builder|KRS whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KRS whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KRS whereMahasiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KRS whereMataKuliahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KRS whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KRS whereTahunAjaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KRS whereUpdatedAt($value)
 */
class KRS extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function mata_kuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }
}
