<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Locations;
use Illuminate\Http\Resources\Json\JsonResource;

class BlocksController extends Controller
{
    /**
     * Show all locations with spare blocks
     * @return JsonResource
     */
    public function index():JsonResource
    {
        return LocationResource::collection(Locations::all());
    }
}
