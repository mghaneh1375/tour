<?php

namespace App\models\FormCreator;
use Illuminate\Database\Eloquent\Model;

/**
 * App\models\Image
 *
 * @property int $id
 * @property string|null $name
 * @property string $path
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image wherePath($value)
 * @mixin \Eloquent
 */
class Image extends FormCreatorBaseModel
{
    protected  $connection = 'formDB';
    protected $fillable = ['name', 'description', 'path'];

}
