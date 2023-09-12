<?php

namespace App\Http\Resources;

use App\models\FormCreator\Form;
use App\models\FormCreator\UserAsset;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AssetDigest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {

        $forms = Form::where('asset_id', $this->id)->orderBy("step", "asc")->select("id")->get();
        $formIds = [];
        $counter = 0;
        foreach ($forms as $form)
            $formIds[$counter++] = $form->id;

        return [
            'id' => $this->id,
            "name" => $this->name,
            "description"=>$this->description,
            "pic" => URL::asset("assets/" . $this->pic),
            "mode" => $this->mode,
            "view_index" => $this->view_index,
            "myAssets" => UserAsset::where('asset_id',$this->id)->where('user_id', Auth::user()->_id)->count(),
            "create_pic" => URL::asset("assets/" . $this->create_pic),
            "formIds" => $formIds,
            "pre_required" => $this->pre_required,
        ];
    }
}
