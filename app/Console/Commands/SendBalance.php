<?php

namespace App\Console\Commands;

use App\Http\Controllers\CarControllers\CarBinnacleController;
use App\Mail\BalanceNotification;
use App\Models\CarModels\CarBinnacle;
use App\Models\UserModels\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send balance to user admins';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start_date = Carbon::now()->startOfMonth();

        $end_date = Carbon::now()->endOfDay();

        $car_binnacles = CarBinnacle::select('car_id')
            ->where([
                ['delivery_time', '>=', $start_date],
                ['delivery_time', '<=', $end_date]
            ])
            ->get();

        $car_binnacles_id = $car_binnacles->map(function($car_binnacle) {
            return $car_binnacle->car_id;
        })->toArray();

        $car_binnacles_collector = collect($car_binnacles_id);

        $car_binnacle_controller = new CarBinnacleController();

        $balance_data = $car_binnacle_controller->generateBalance(
            $car_binnacles_collector->unique(),
            $start_date,
            $end_date
        );

        $users_email_array = User::select('users.email')
            ->join('user_types', function ($join) {
            $join->on('users.user_type_id', 'user_types.id')
                ->where('user_types.abilities', 'admin');
            })
            ->get()
            ->toArray();

        Mail::to($users_email_array)->send(new BalanceNotification($balance_data));
    }
}
