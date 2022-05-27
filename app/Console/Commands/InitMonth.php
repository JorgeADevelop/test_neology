<?php

namespace App\Console\Commands;

use App\Models\CarModels\CarBinnacle;
use Illuminate\Console\Command;

class InitMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:month';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete the task to end the month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CarBinnacle::join('cars', function ($join_car) {
            $join_car->on('car_binnacles.car_id', 'cars.id')
                ->join('car_types', function($join_car_type) {
                    $join_car_type->on('cars.car_type_id', 'car_types.id')
                        ->where('car_types.id', 1);
                });
            })
            ->delete();
    }
}
