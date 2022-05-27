<?php

namespace App\Http\Controllers\CarControllers;

use App\Http\Controllers\Controller;
use App\Models\CarModels\Car;
use App\Models\CarModels\CarBinnacle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarBinnacleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $car_binnacle = CarBinnacle::orderBy('delivery_time', 'desc')
            ->simplePaginate(15);

        if(count($car_binnacle) <= 0) {
            return response()->json([
                'code'      => 200,
                'status'    => 'success',
                'message'   => 'Car binnacle found successfuly',
                'data'      => $car_binnacle,
                'errors'    => [
                    'Empty Car binnacle'
                    ]
            ], 200, [
                'Content-Type' => 'application/json'
            ]);
        }

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Car binnacle found successfuly',
            'data'      => $car_binnacle,
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
            'delivery_time' => "boolean",
            'departure_time' => "boolean"
        ]);

        if($request->delivery_time && $request->departure_time) {
            $validation->after(function($validator) {
                $validator->getMessageBag()->add('time_register', 'Can only use delivery_time or departure_time');
            });
        } else if(!$request->delivery_time && !$request->departure_time) {
            $validation->after(function($validator) {
                $validator->getMessageBag()->add('time_register', 'Required delivery_time or departure_time');
            });
        }

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

        if(!$car) {
            $car = Car::create([
                'registration_number' => $request->registration_number,
                'car_type_id' => 3,
                'created_by' => 1,
                'updated_by' => null,
            ]);
        }

        if($request->delivery_time) {
            $car_binnacle_exist = CarBinnacle::join('cars', function ($join) use($request) {
                $join->on('car_binnacles.car_id', 'cars.id')
                    ->where('cars.registration_number', $request->registration_number);
                })
                ->whereNull('car_binnacles.departure_time')
                ->first();

            if($car_binnacle_exist) {
                return response()->json([
                    'code'      => 400,
                    'status'    => 'bad request',
                    'message'   => 'Car delivery already exists',
                    'data'      => $car_binnacle_exist,
                    'errors'    => [
                        'Delivery with registration number ' . $request->registration_number . ' already exists'
                    ]
                ], 400, [
                    'Content-Type' => 'application/json'
                ]);
            }

            $request_data = [
                'car_id' => $car->id,
                'delivery_time' => now(),
                'deliver_by_user_id' => 1,
                'departure_time' => null,
                'departure_by_user_id' => null,
                'deliver_by_user_id' => 1,
                'departure_by_user_id' => null
            ];
    
            $car_binnacle = CarBinnacle::create($request_data);
        } else {
            $car_binnacle_exist = CarBinnacle::select('car_binnacles.*')
                ->join('cars', function ($join) use($request) {
                $join->on('car_binnacles.car_id', 'cars.id')
                    ->where('cars.registration_number', $request->registration_number);
                })
                ->whereNull('car_binnacles.departure_time')
                ->first();

            if(!$car_binnacle_exist) {
                return response()->json([
                    'code'      => 400,
                    'status'    => 'bad request',
                    'message'   => 'Car delivery not exists',
                    'data'      => null,
                    'errors'    => [
                        'Delivery with registration number ' . $request->registration_number . ' not exists'
                    ]
                ], 400, [
                    'Content-Type' => 'application/json'
                ]);
            }

            $request_data = [
                'car_binnacles.departure_time' => now(),
                'car_binnacles.departure_by_user_id' => 1
            ];

            $car_binnacle = tap(CarBinnacle::where('id', $car_binnacle_exist->id))
                ->update($request_data)
                ->first();
        }

        return response()->json([
            'code'      => 200,
            'status'    => 'success',
            'message'   => 'Car binnacle created successfuly',
            'data'      => $car_binnacle,
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
        $car_binnacle = CarBinnacle::where('id', $id)
            ->first();

        if(!$car_binnacle) {
            return response()->json([
                'code'      => 400,
                'status'    => 'bad request',
                'message'   => 'Car binnacle not found',
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
            'message'   => 'Car binnacle found successfuly',
            'data'      => $car_binnacle,
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
    public function destroy($id)
    {
        //
    }
}
