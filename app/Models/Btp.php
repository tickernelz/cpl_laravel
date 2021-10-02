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
 * @property int $tahun_ajaran_id
 * @property int $mata_kuliah_id
 * @property int $cpmk_id
 * @property int $dosen_admin_id
 * @property string $nama
 * @property string $semester
 * @property string $kategori
 * @property int $bobot
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cpmk $cpmk
 * @property-read \App\Models\DosenAdmin $dosen_admin
 * @property-read \App\Models\MataKuliah $mata_kuliah
 * @property-read \App\Models\TahunAjaran $tahun_ajaran
 * @method static \Illuminate\Database\Eloquent\Builder|Btp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Btp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Btp query()
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereBobot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereCpmkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereDosenAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereMataKuliahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereTahunAjaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bobotcpl[] $bobotcpl
 * @property-read int|null $bobotcpl_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nilai[] $nilai
 * @property-read int|null $nilai_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\kcpmk[] $kcpmk
 * @property-read int|null $kcpmk_count
 * @property string $kelas
 * @method static \Illuminate\Database\Eloquent\Builder|Btp whereKelas($value)
 */
class Btp extends Model
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

    public function dosen_admin()
    {
        return $this->belongsTo(DosenAdmin::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
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
