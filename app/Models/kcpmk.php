<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\kcpmk
 *
 * @property int $id
 * @property int $tahun_ajaran_id
 * @property int $mahasiswa_id
 * @property int $mata_kuliah_id
 * @property int $cpmk_id
 * @property string $semester
 * @property float $nilai_kcpmk
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cpmk $cpmk
 * @property-read \App\Models\MataKuliah $mata_kuliah
 * @property-read \App\Models\TahunAjaran $tahun_ajaran
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk query()
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereCpmkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereMahasiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereMataKuliahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereNilaiKcpmk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereTahunAjaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $btp_id
 * @property string $kode_cpmk
 * @property-read \App\Models\Btp $btp
 * @property-read \App\Models\Mahasiswa $mahasiswa
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereBtpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereKodeCpmk($value)
 * @property string $kelas
 * @method static \Illuminate\Database\Eloquent\Builder|kcpmk whereKelas($value)
 */
class kcpmk extends Model
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

    public function cpmk()
    {
        return $this->belongsTo(Cpmk::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function btp()
    {
        return $this->belongsTo(Btp::class);
    }
}
