<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class UserAssetDigest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        
        return [
            'id' => $this->id,
            'status' => ($this->status == "INIT") ? "در حال ساخت" : (($this->status == "PENDING") ? "در حال بررسی برای تایید" : (($this->status == "REJECT") ? "رد شده" : "تایید شده")),
            "title" => $this->title,
            "createdAt" => Controller::convertDate($this->created_at)
            // "pic" => (file_exists(__DIR__ . '/../../../storage/app/public/' . $this->pic)) ? URL::asset("storage/" . $this->pic) : URL::asset("images/default.png")
        ];
    }
}
