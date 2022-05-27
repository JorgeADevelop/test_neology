<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Models\UserModels\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->user()->currentAccessToken()->can('admin')){
            return response()->json([
                'code'      => 401,
                'status'    => 'unauthorized',
                'message'   => 'Without permission',
                'data'      => null,
                'errors'    => [
                    'Token does not have permission in this resource'
                    ]
            ], 401, [
                'Content-Type' => 'application/json'
            ]);
        }

        $user = User::simplePaginate(15);

        if(count($user) <= 0) {
            return response()->json([
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'User found successfuly',
                'data'      => $user,
                'errors'    => [
                    'Empty Cars'
                    ]
            ], 200, [
                'Content-Type' => 'application/json'
            ]);
        }

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'User found successfuly',
            'data'      => $user,
            'errors'    => null
        ], 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->user()->currentAccessToken()->can('admin')){
            return response()->json([
                'code'      => 401,
                'status'    => 'unauthorized',
                'message'   => 'Without permission',
                'data'      => null,
                'errors'    => [
                    'Token does not have permission in this resource'
                    ]
            ], 401, [
                'Content-Type' => 'application/json'
            ]);
        }

        $validation = Validator::make($request->all(), [
            'name' => 'required|min:2|max:30',
            'lastname' => 'required|min:2|max:30',
            'username' => 'required|alpha_num',
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
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

        if($user) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'User already exists',
                'data'      => $user,
                'errors'    => [
                    'Registration number already exists'
                ]
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        $request_data = $request->merge([
            'user_type_id' => 2
        ])->all();

        $request_data['password'] = Hash::make($request->password);
        $user = User::create($request_data);

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'User created successfuly',
            'data'      => $user,
            'errors'    => null
        ], 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if(!$request->user()->currentAccessToken()->can('admin')){
            return response()->json([
                'code'      => 401,
                'status'    => 'unauthorized',
                'message'   => 'Without permission',
                'data'      => null,
                'errors'    => [
                    'Token does not have permission in this resource'
                    ]
            ], 401, [
                'Content-Type' => 'application/json'
            ]);
        }

        $user = User::where('id', $id)
            ->first();

        if(!$user) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'User not found',
                'data'      => null,
                'errors'    => [
                    'Id not found'
                    ]
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'User found successfuly',
            'data'      => $user,
            'errors'    => null
        ], 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if(!$request->user()->currentAccessToken()->can('admin')){
            return response()->json([
                'code'      => 401,
                'status'    => 'unauthorized',
                'message'   => 'Without permission',
                'data'      => null,
                'errors'    => [
                    'Token does not have permission in this resource'
                    ]
            ], 401, [
                'Content-Type' => 'application/json'
            ]);
        }
        
        $user = User::where('id', $id)
            ->first();

        if(!$user) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'User not found',
                'data'      => null,
                'errors'    => [
                    'Id not found'
                    ]
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        if($user->UserType->abilities == 'admin') {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'User does not be deleted',
                'data'      => null,
                'errors'    => [
                    'User admin does not be deleted '
                    ]
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        $user->delete();

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'User deleted successfuly',
            'data'      => null,
            'errors'    => null
        ], 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
