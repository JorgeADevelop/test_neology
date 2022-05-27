<?php

namespace App\Http\Controllers\CarControllers;

use App\Http\Controllers\Controller;
use App\Models\CarModels\CarType;
use App\Models\UserModels\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car_types = CarType::get();

        if(count($car_types) <= 0) {
            return response()->json([
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Car types found successfuly',
                'data'      => $car_types,
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
            'message'   => 'Car types found successfuly',
            'data'      => $car_types,
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
        $validation = Validator::make($request->all(), [
            'type' => 'required|min:2',
            'cost_minute' => 'required|numeric'
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

        $request_data = $request->merge([
            'created_by' => 1,
            'updated_by' => null
        ])->all();

        $car_type = CarType::create($request_data);

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Car type created successfuly',
            'data'      => $car_type,
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
        $validation = Validator::make($request->all(), [
            'type' => 'required|min:2',
            'cost_minute' => 'required|numeric'
        ]);

        if($validation->fails()) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'Validation fails',
                'data'      => null,
                'errors'    => $validation->errors()
            ], 500, [
                'Content-Type' => 'application/json'
            ]);
        }

        $car_type = CarType::where('id', $id)
            ->first();

        if(!$car_type) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'Car type not found',
                'data'      => null,
                'errors'    => [
                    'Id not found'
                    ]
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        $request_data = $request->merge([
            'updated_by' => 1
        ])->all();

        unset($request_data['id']);
        unset($request_data['created_by']);

        tap($car_type)->update($request_data)
            ->first();

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Car type update successfuly',
            'data'      => $car_type,
            'errors'    => null
        ], 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car_type = CarType::where('id', $id)
            ->first();

        if(!$car_type) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'Car type not found',
                'data'      => null,
                'errors'    => [
                    'Id not found'
                    ]
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        $car_type->delete();

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Car type deleted successfuly',
            'data'      => null,
            'errors'    => null
        ], 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
