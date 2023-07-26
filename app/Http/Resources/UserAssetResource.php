<?php

namespace App\Http\Resources;

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


        return [
            'id' => $this->id,
            'status' => ($this->status == "INIT") ? "در حال ساخت" : (($this->status == "PENDING") ? "در حال بررسی برای تایید" : (($this->status == "REJECT") ? "رد شده" : "تایید شده")),
            "title" => $this->title,
            "createdAt" => $this->created_at,

        ];
    }
}
