<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Models\UserModels\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
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

        $user_types = UserType::get();

        if(count($user_types) <= 0) {
            return response()->json([
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'User types found successfuly',
                'data'      => $user_types,
                'errors'    => [
                    'Empty Car types'
                    ]
            ], 200, [
                'Content-Type' => 'application/json'
            ]);
        }

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'User types found successfuly',
            'data'      => $user_types,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
