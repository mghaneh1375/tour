<?php

namespace App\models\FormCreator;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\FormField
 *
 * @property int $id
 * @property int $user_id
 * @property int $field_id
 * @property int $user_asset_id
 * @property string $data
 * @property boolean $is_sub_asset
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\models\FormField $form_field
 * @property-read \App\models\UserAsset $user_asset
 * @property-read \App\User $user
 * @method static Builder|UserFormsData newModelQuery()
 * @method static Builder|UserFormsData newQuery()
 * @method static Builder|UserFormsData query()
 * @method static Builder|UserFormsData whereFieldId($value)
 * @method static Builder|UserFormsData whereUserId($value)
 * @method static Builder|UserFormsData whereIsSubAsset($value)
 * @method static Builder|UserFormsData whereUserAssetId($value)
 * @method static Builder|UserFormsData whereId($value)
 * @method static Builder|UserFormsData whereCreatedAt($value)
 * @method static Builder|UserFormsData whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserFormsData extends Model
{
    protected $fillable = ['user_id', 'form_id', 'data', 'user_asset_id'];
    public $table = "user_forms_data";
    protected  $connection = 'formDB';

    public function form_field()
    {
        return $this->belongsTo(FormField::class, 'field_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user_asset()
    {
        return $this->belongsTo(UserAsset::class);
    }

}
