<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MataKuliah.
 *
 * @mixin Eloquent
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read MataKuliah|null $krs
 * @method static \Illuminate\Database\Eloquent\Builder|MataKuliah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MataKuliah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MataKuliah query()
 * @method static \Illuminate\Database\Eloquent\Builder|MataKuliah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MataKuliah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MataKuliah whereKode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MataKuliah whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MataKuliah whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bobotcpl[] $bobotcpl
 * @property-read int|null $bobotcpl_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Btp[] $btp
 * @property-read int|null $btp_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cpmk[] $cpmk
 * @property-read int|null $cpmk_count
 * @property-read int|null $krs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\kcpmk[] $kcpmk
 * @property-read int|null $kcpmk_count
 * @property int $sks
 * @method static \Illuminate\Database\Eloquent\Builder|MataKuliah whereSks($value)
 * @property int $semester
 * @method static \Illuminate\Database\Eloquent\Builder|MataKuliah whereSemester($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\kcpl[] $kcpl
 * @property-read int|null $kcpl_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rolesmk[] $rolesmk
 * @property-read int|null $rolesmk_count
 */
class MataKuliah extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function krs()
    {
        return $this->hasMany(KRS::class);
    }

    public function cpmk()
    {
        return $this->hasMany(Cpmk::class);
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

    public function rolesmk()
    {
        return $this->hasMany(Rolesmk::class);
    }
}
