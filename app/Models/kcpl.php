<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\kcpl
 *
 * @property int $id
 * @property int $tahun_ajaran_id
 * @property int $mahasiswa_id
 * @property int $mata_kuliah_id
 * @property int $bobotcpl_id
 * @property int $cpl_id
 * @property string $kode_cpl
 * @property string $semester
 * @property string $kelas
 * @property float|null $nilai_cpl
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bobotcpl $bobotcpl
 * @property-read \App\Models\Cpl $cpl
 * @property-read \App\Models\Mahasiswa $mahasiswa
 * @property-read \App\Models\MataKuliah $mata_kuliah
 * @property-read \App\Models\TahunAjaran $tahun_ajaran
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl query()
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereBobotcplId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereCplId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereKodeCpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereMahasiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereMataKuliahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereNilaiCpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereTahunAjaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property float|null $bobot_cpl
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereBobotCpl($value)
 * @property int|null $urutan
 * @method static \Illuminate\Database\Eloquent\Builder|kcpl whereUrutan($value)
 */
class kcpl extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function mata_kuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function bobotcpl()
    {
        return $this->belongsTo(Bobotcpl::class);
    }

    public function cpl()
    {
        return $this->belongsTo(Cpl::class);
    }
}
