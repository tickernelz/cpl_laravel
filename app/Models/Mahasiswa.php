<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Mahasiswa.
 *
 * @mixin Eloquent
 * @property int $id
 * @property string $nim
 * @property string $nama
 * @property string $angkatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\KRS|null $krs
 * @method static \Database\Factories\MahasiswaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa whereAngkatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa whereNim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mahasiswa whereUpdatedAt($value)
 * @property-read int|null $krs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nilai[] $nilai
 * @property-read int|null $nilai_count
 */
class Mahasiswa extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function krs()
    {
        return $this->hasMany(KRS::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function kcpmk()
    {
        return $this->hasMany(Kcpmk::class);
    }
}
