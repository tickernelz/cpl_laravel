<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Nilai
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $mahasiswa_id
 * @property int $btp_id
 * @property float $nilai
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Btp $btp
 * @property-read \App\Models\Mahasiswa $mahasiswa
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai whereBtpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai whereMahasiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nilai whereUpdatedAt($value)
 */
class Nilai extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function btp()
    {
        return $this->belongsTo(Btp::class);
    }
}
