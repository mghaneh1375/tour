<?php

namespace App\models\FormCreator;

use Illuminate\Database\Eloquent\Model;

/**
 * App\models\Notification
 *
 * @property int $id
 * @property string|null $msg
 * @property int $user_asset_id
 * @property boolean $seen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\models\UserAsset $userAsset
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUserAssetId($value)
 * @mixin \Eloquent
 */
class Notification extends FormCreatorBaseModel
{

    protected $fillable = ['msg', 'user_asset_id', 'seen'];
    protected  $connection = 'formDB';

    public function userAsset() {
        return $this->belongsTo(UserAsset::class);
    }
}
