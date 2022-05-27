<?php

namespace App\Http\Controllers;

use App\Models\UserModels\User;
use App\Models\UserModels\UserBinnacle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Starts a session token.
     *
     * @return \Illuminate\Http\Response
     */
    public function Login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'username' => 'required|alpha_num',
            'password' => 'required'
        ]);

        if($validation->fails()) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'Validation fails',
                'data'      => null,
                'errors'    => $validation->errors()
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        $user = User::where('username', $request->username)
            ->first();

        if(!$user) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'User not found',
                'data'      => null,
                'errors'    => [
                    'Username not found'
                    ]
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        if(!Hash::check('password', $user->password)) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'Incorrect password',
                'data'      => null,
                'errors'    => [
                    'Incorrect password'
                    ]
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        UserBinnacle::create([
            'user_id' => $user->id
        ]);

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'User logged successfuly',
            'data'      => [
                'token' => $user->createToken('token', [$user->UserType->abilities])->plainTextToken
            ],
            'errors'    => null
        ], 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
