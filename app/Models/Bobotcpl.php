<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bobotcpl.
 *
 * @property int $id
 * @property int $tahun_ajaran_id
 * @property int $mata_kuliah_id
 * @property int $cpl_id
 * @property int $cpmk_id
 * @property int $btp_id
 * @property string $semester
 * @property int $bobot_cpl
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl whereBobotCpl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl whereBtpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl whereCplId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl whereCpmkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl whereMataKuliahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl whereTahunAjaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bobotcpl whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Btp $btp
 * @property-read \App\Models\Cpl $cpl
 * @property-read \App\Models\Cpmk $cpmk
 * @property-read \App\Models\MataKuliah $mata_kuliah
 * @property-read \App\Models\TahunAjaran $tahun_ajaran
 */
class Bobotcpl extends Model
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

    public function cpl()
    {
        return $this->belongsTo(Cpl::class);
    }

    public function cpmk()
    {
        return $this->belongsTo(Cpmk::class);
    }

    public function btp()
    {
        return $this->belongsTo(Btp::class);
    }
}
