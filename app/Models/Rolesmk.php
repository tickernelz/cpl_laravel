<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rolesmk
 *
 * @property int $id
 * @property int $tahun_ajaran_id
 * @property int $mata_kuliah_id
 * @property int $dosen_admin_id
 * @property string $semester
 * @property string $kelas
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MataKuliah $mata_kuliah
 * @property-read \App\Models\TahunAjaran $tahun_ajaran
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk whereDosenAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk whereKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk whereMataKuliahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk whereTahunAjaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rolesmk whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\MataKuliah $dosenadmin
 * @property-read \App\Models\DosenAdmin $dosen_admin
 */
class Rolesmk extends Model
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

    public function dosen_admin()
    {
        return $this->belongsTo(DosenAdmin::class);
    }
}
