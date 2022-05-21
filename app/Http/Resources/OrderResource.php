<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'order_id' => $this->id,
            'status' => $this->status,
            'start_rent' => $this->start,
            'end_rent' => $this->end,
            'left_days' => date_diff($this->end_rent, now())->format("%a"),
            'bill' => $this->bill,
            'access_token' => $this->access_token,
            'need_to_take' => date_diff($this->end_rent, now())->format("%a") ? false : true,
            'blocks' => BlockResource::collection($this->blocks),
        ];
    }
    public static $wrap = "order";
}
