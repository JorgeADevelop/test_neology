<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $car_types = [
            [
                "type" => "Oficial",
                "cost_minute" => 0,
                "created_by" => 1,
                "updated_by" => null,
            ],
            [
                "type" => "Recidente",
                "cost_minute" => 0.05,
                "created_by" => 1,
                "updated_by" => null,
            ],
            [
                "type" => "No recidente",
                "cost_minute" => 0.5,
                "created_by" => 1,
                "updated_by" => null,
            ]
        ];

        foreach ($car_types as $car_type) {
            DB::table('car_types')->insert($car_type);
        }
    }
}
