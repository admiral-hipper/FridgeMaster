<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Controller method for signUp new customers account
     * @return JsonResponse
     */
    public function signUp(SignUpRequest $request): JsonResponse
    {
        $customer = Customers::create($request->all()); // Create new customer
        Auth::guard('apiAccess')->attempt([ //Automaticly allow access
            "login" => $request->login,
            "password" => $request->password
        ]);
        return  response()->json(array(
            "success" => true,
            "message" => "You were successfully signed up!"
        ), 200);
    }
    /**
     * Controller method for logging existing customers by login and password
     * @return JsonResponse
     */
    public function signIn(SignInRequest $request): JsonResponse
    {
        if (Auth::guard('apiAccess')->attempt([ //Check if password and login is correct
            'login' => $request,
            'password' => $request->password
        ]))
            return response()->json(array(
                "success" => true,
                "message" => "You are logged in!"
            ), 200);
        return response()->json(array(
            "success" => false,
            "message" => "Password or login is wrong!"
        ), 401);
    }

    /**
     * Controller method for signOut logged customers
     * @return JsonResponse
     */
    public function signOut(): JsonResponse
    {
        Auth::guard('apiAccess')->logout();
        return response()->json(array(
            "success" => true,
            "message" => "You are logged out!"
        ), 200);
    }
}
