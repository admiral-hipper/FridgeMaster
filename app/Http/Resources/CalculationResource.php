<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalculationResource extends JsonResource
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
            "enough_blocks" => true,
            "total_price"  => $this->resource['price'],
            "term"=>$this->resource['term'],
            "location"=>$this->resource['location']->location,
            "needed_blocks" => $this->resource['blocks_count'],
            "blocks"=>BlockResource::collection($this->resource['blocks']),
        ];
    }
    public static $wrap="calculated";
}
