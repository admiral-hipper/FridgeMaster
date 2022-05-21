<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Locations;

class BlocksController extends Controller
{
    public function index()
    {
        return LocationResource::collection(Locations::all());
    }
}
