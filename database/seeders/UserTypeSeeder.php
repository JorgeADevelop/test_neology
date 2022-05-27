<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_types = [
            [
                'type' => 'admin',
                'abilities' => "admin"
            ],
            [
                'type' => 'checker',
                'abilities' => "check"
            ]
        ];

        foreach ($user_types as $user_type) {
            DB::table('user_types')->insert($user_type);
        }
    }
}
