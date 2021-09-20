<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DosenAdmin.
 *
 * @mixin Eloquent
 * @property int $id
 * @property int $user_id
 * @property string $nip
 * @property string $nama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|DosenAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DosenAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DosenAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder|DosenAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DosenAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DosenAdmin whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DosenAdmin whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DosenAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DosenAdmin whereUserId($value)
 */
class DosenAdmin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}