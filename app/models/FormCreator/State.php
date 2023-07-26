<?php

namespace App\models\FormCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\State
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\models\City[] $cities
 * @property-read int|null $cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State newQuery()
 * @method static \Illuminate\Database\Query\Builder|State onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|State query()
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|State withTrashed()
 * @method static \Illuminate\Database\Query\Builder|State withoutTrashed()
 * @mixin \Eloquent
 */
class State extends Model
{

    protected $fillable = ['name'];
    protected $table = "state";
    protected  $connection = 'formDB';

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
