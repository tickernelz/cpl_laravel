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
 */
class MataKuliah extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function krs()
    {
        return $this->belongsTo(KRS::class);
    }
}
