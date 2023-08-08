<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $user = $this->user;

        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'assetId' => $this->asset_id,
            'assetName' => $this->asset->name,
            'status' => ($this->status == "INIT") ? "در حال ساخت" : (($this->status == "PENDING") ? "در حال بررسی برای تایید" : (($this->status == "REJECT") ? "رد شده" : "تایید شده")),
            "title" => $this->title,
            "phone" => $user != null ? $user->phone : '',
            "createdAt" => Controller::convertDate($this->created_at),
            "updatedAt" => Controller::convertDate($this->updated_at),
            "username" => $user == null ? '' : $user->username,
            'name' => $user == null ? '' : $user->first_name . ' ' . $user->last_name
        ];
    }
}
