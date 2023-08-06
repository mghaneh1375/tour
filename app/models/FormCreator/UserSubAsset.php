<?php

namespace App\models\FormCreator;

use App\models\User;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * App\UserAsset
 *
 * @property int $id
 * @property int $user_id
 * @property int $asset_id
 * @property int $user_asset_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\models\Asset $asset
 * @property-read \App\models\UserAsset $userAsset
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\models\UserFormsData[] $user_forms_data
 * @property-read int|null $user_forms_data_count
 * @method static Builder|UserSubAsset newModelQuery()
 * @method static Builder|UserSubAsset newQuery()
 * @method static Builder|UserSubAsset query()
 * @method static Builder|UserSubAsset whereId($value)
 * @method static Builder|UserSubAsset whereCreatedAt($value)
 * @method static Builder|UserSubAsset whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserSubAsset extends FormCreatorBaseModel
{
    protected $fillable = ['user_id', 'asset_id', 'status'];
    public $table = "user_sub_assets";
    protected  $connection = 'formDB';

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function userAsset()
    {
        return $this->belongsTo(UserAsset::class);
    }

    public function user()
    {
        return $this->setConnection('mysql')->belongsTo(User::class);
    }

    public function user_forms_data() {
        return $this->hasMany(UserFormsData::class);
    }
    public function is_in_form($form_field_id, $is_pic = false, $gallery = false) {

        $uId = Auth::user()->id;
        if($is_pic)
            return (DB::connection('formDB')->select("select count(*) as countNum from user_sub_assets u, forms f, form_fields ff where u.asset_id = f.asset_id " .
                    "and u.user_id = " . $uId . " and f.id = ff.form_id and ff.type = 'FILE' and ff.id = " . $form_field_id)[0]->countNum > 0);

        if($gallery)
            return (DB::connection('formDB')->select("select count(*) as countNum from user_sub_assets u, forms f, form_fields ff where u.asset_id = f.asset_id " .
                    "and u.user_id = " . $uId . " and f.id = ff.form_id and ff.type = 'GALLERY' and ff.id = " . $form_field_id)[0]->countNum > 0);

        return (DB::connection('formDB')->select("select count(*) as countNum from user_sub_assets u, forms f, form_fields ff where u.asset_id = f.asset_id " .
                "and u.user_id = " . $uId . " and f.id = ff.form_id and ff.id = " . $form_field_id)[0]->countNum > 0);
    }

}
