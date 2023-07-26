<?php

namespace App\models\FormCreator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Form
 *
 * @property int $id
 * @property string|null $description
 * @property string|null $notice
 * @property int $asset_id
 * @property int $step
 * @property string $name
 * @property-read \App\models\Asset $asset
 * @property-read \App\models\FormField[] $form_fields
 * @property-read int|null $form_fields_count
 * @method static Builder|Form newModelQuery()
 * @method static Builder|Form newQuery()
 * @method static Builder|Form query()
 * @method static Builder|Form whereAssetId($value)
 * @method static Builder|Form whereId($value)
 * @method static Builder|Form whereStep($value)
 * @mixin \Eloquent
 */
class Form extends Model
{

    protected $fillable = ['name', 'description', 'notice', 'step', 'asset_id'];
    public $timestamps = false;
    protected  $connection = 'formDB';

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function form_fields()
    {
        return $this->hasMany(FormField::class);
    }

}
