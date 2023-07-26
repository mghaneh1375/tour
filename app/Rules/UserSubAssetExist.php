<?php

namespace App\Rules;

use App\models\FormCreator\UserSubAsset;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserSubAssetExist implements Rule
{

    private $assetId;
    private $allowFirst;

    /**
     * Create a new rule instance.
     * @param $assetId
     * @param $allowFirst
     */
    public function __construct($assetId, $allowFirst) {
        $this->assetId = $assetId;
        $this->allowFirst = $allowFirst;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {

        if($this->assetId == -1)
            return false;

        if($value == -1)
            return $this->allowFirst;

        $uId = Auth::user()->id;
        if(UserSubAsset::where('user_id', $uId)->whereId($value)->where('asset_id',$this->assetId)->count() > 0)
            return true;

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
