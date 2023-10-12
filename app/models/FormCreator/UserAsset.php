<?php

namespace App\models\FormCreator;

use App\models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * \App\models\FormCreator\UserAsset
 *
 * @property int $id
 * @property int $user_id
 * @property int $ticket_id
 * @property int $asset_id
 * @property string $place_id
 * @property string $status
 * @property string $title
 * @property string $err_text
 * @property string $pic
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\models\Asset $asset
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\models\UserFormsData[] $user_forms_data
 * @property-read int|null $user_forms_data_count
 * @method static Builder|UserAsset newModelQuery()
 * @method static Builder|UserAsset newQuery()
 * @method static Builder|UserAsset query()
 * @method static Builder|UserAsset whereStatus($value)
 * @method static Builder|UserAsset whereId($value)
 * @method static Builder|UserAsset whereCreatedAt($value)
 * @method static Builder|UserAsset whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserAsset extends FormCreatorBaseModel
{
    protected $fillable = ['user_id', 'asset_id', 'status', 'ticket_id', 'place_id'];
    public $table = "user_assets";
    protected  $connection = 'formDB';

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->setConnection('mysql')->belongsTo(User::class);
    }

    public function user_forms_data() {
        return $this->hasMany(UserFormsData::class, 'user_asset_id', 'id');
    }

    public function get_presenter_data() {
        return DB::connection('formDB')->select('select fd.data, ff.key_, ff.name from user_forms_data fd, form_fields ff where fd.user_asset_id = ' . $this->id . 
            ' and ff.id = fd.field_id and ff.presenter = true'
        );
    }

    public function is_in_form($form_field_id, $is_pic = false, $gallery = false) {

        $uId = Auth::user()->_id;
        if($is_pic)
            return (DB::connection('formDB')->select("select count(*) as countNum from user_assets u, forms f, form_fields ff where u.asset_id = f.asset_id " .
                    "and u.user_id = '" . $uId . "' and f.id = ff.form_id and ff.type = 'FILE' and ff.id = " . $form_field_id)[0]->countNum > 0);

        if($gallery)
            return (DB::connection('formDB')->select("select count(*) as countNum from user_assets u, forms f, form_fields ff where u.asset_id = f.asset_id " .
                    "and u.user_id = '" . $uId . "' and f.id = ff.form_id and ff.type = 'GALLERY' and ff.id = " . $form_field_id)[0]->countNum > 0);

        return (DB::connection('formDB')->select("select count(*) as countNum from user_assets u, forms f, form_fields ff where u.asset_id = f.asset_id " .
            "and u.user_id = '" . $uId . "' and f.id = ff.form_id and ff.id = " . $form_field_id)[0]->countNum > 0);
    }

}
