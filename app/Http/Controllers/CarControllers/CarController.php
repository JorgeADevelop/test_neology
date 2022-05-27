<?php

namespace App\Http\Controllers\CarControllers;

use App\Http\Controllers\Controller;
use App\Models\CarModels\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car = Car::simplePaginate(15);

        if(count($car) <= 0) {
            return response()->json([
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Cars found successfuly',
                'data'      => $car,
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
            'message'   => 'Cars found successfuly',
            'data'      => $car,
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
            'registration_number' => 'required|min:6|max:10|alpha_num',
            'car_type_id' => 'required|numeric'
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

        $car = Car::where('registration_number', $request->registration_number)
            ->first();

        if($car) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'Car already exists',
                'data'      => $car,
                'errors'    => [
                    'Registration number already exists'
                ]
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        $request_data = $request->merge([
            'created_by' => 1,
            'updated_by' => null
        ])->all();

        $car = Car::create($request_data);

        if(!$car) {
            return response()->json([
                'code'      => 500,
                'status'    => 'error',
                'message'   => 'Error creating car',
                'data'      => null,
                'errors'    => [
                    'Database error'
                    ]
            ], 500, [
                'Content-Type' => 'application/json'
            ]);
        }

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Car created successfuly',
            'data'      => $car,
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
        $car = Car::where('id', $id)
            ->first();

        if(!$car) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'Car not found',
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
            'message'   => 'Car found successfuly',
            'data'      => $car,
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
        $validation = Validator::make($request->all(), [
            'registration_number' => 'required|min:6|max:10|alpha',
            'car_type_id' => 'required|numeric'
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

        $car = Car::where('id', $id)
            ->first();

        if(!$car) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'Car not found',
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
        unset($request_data['registration_number']);

        tap($car)->update($request_data)
            ->first();

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Car update successfuly',
            'data'      => $car,
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
        $car = Car::where('id', $id)
            ->first();

        if(!$car) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'Car not found',
                'data'      => null,
                'errors'    => [
                    'Id not found'
                    ]
            ], 400, [
                'Content-Type' => 'application/json'
            ]);
        }

        $car->delete();

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Car deleted successfuly',
            'data'      => null,
            'errors'    => null
        ], 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
