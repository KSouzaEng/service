<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Authcontroller extends Controller
{
    public function login(LoginRequest $request)
    {
        $input = $request->validated();
        // dd($input);
        $credentials = [
            'email' => $input['email'],
            'password' => $input['password']
        ];

        try {
            if (($token = auth('api')->attempt($credentials))) {
                return response()->json(['token' => $token, 'status' => true, 'credentials' => $credentials]);
            } else {
                return response()->json(['error' => 'Credenciais inválidas', 'status' => false], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token', 'status' => false], 500);
        }
    }
    public function getUser(){
        return response()->json(['token' => $user], 200);
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }


        $set_access = Access::create([
            'user_id' => $user->id,
            // 'datetime' =>  Carbon::now()->format('Y-m-d H:i:s')

        ]);
        return response()->json(['user' => $user,'set_access' => $set_access]);
    }

}
