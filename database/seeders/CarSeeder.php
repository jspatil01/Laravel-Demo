<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use App\Models\Car;
use App\Models\User;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::inRandomOrder()->first()->id;
        $cars = ([
            "user_id"=> $userId,
            "car_name"=> Str::random(10),
            "model"=> random_int(2000,2025),
            "price"=> random_int(1,100),
            "registration_date"=> date("Y-m-d H:i:s"),
        ]);

        Car::create($cars);
    }
}
