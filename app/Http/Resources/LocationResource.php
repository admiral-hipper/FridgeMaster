<?php

namespace App\Http\Resources;

use App\Models\Locations;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'location';

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = Locations::class;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $count = count($this->block()->spare()->get());
        return [
            'location_name' => $this->location,
            'location_slug' => $this->slug,
            'count_blocks' => $count,
            'spare_volume' => $count * 2
        ];
    }

    public function with($request)
    {
        return [
            "success" => true,
        ];
    }
}
