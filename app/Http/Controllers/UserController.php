<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => '400',
                    'errors' => $validator->errors(),
                ],
                400,
                ['Content-Type' => 'application/json']
            );
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(
            compact('user', 'token'),
            201,
            ['Content-Type' => 'application/json']
        );
    }



    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => '400',
                    'errors' => $validator->errors(),
                ],
                400,
                ['Content-Type' => 'application/json']
            );
        }


        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(
                    ['error' => 'invalid_credentials'],
                    400,
                    ['Content-Type' => 'application/json']
                );
            }
        } catch (JWTException $e) {
            return response()->json(
                ['error' => 'could_not_create_token'],
                500,
                ['Content-Type' => 'application/json']
            );
        }
        return response()->json(compact('token'));
    }
}
