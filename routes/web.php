<?php

use App\Http\Resources\CustomerResource;
use App\Http\Resources\LocationResource;
use App\Models\Blocks;
use App\Models\Customers;
use App\Models\Locations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    dd(Blocks::whereDoesntHave('orders',function($q){
        $q->where('id','=',9);
    })->get());
    //dd(response()->json([Customers::all()->find(100)->orders[0]->blocks]));
    return response()->json([Customers::all()->find(100)->orders[0]]);
    return view('welcome');
});
Route::get('/test',function(){
    return (LocationResource::collection(Blocks::doesntHave('orders')->get()));
});

