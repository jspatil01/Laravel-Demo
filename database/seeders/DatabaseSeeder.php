<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Using Factory

        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test Data',
        //     'email' => 'test1@example.com',
        // ]);

        //2. Direct insert in DB

        // DB::table("users")->insert([
        //     "name"=> Str::random(5),
        //     "email"=> Str::random(5)."@example.com",
        //     "password"=> Hash::make("password"),
        // ]);

        //3. Using Additional Seeder call

        $this->call(UserSeeder::class);

        //For Car Model
        $this->call(CarSeeder::class);

        // $userId = User::inRandomOrder()->first()->id;
        // DB::table("cars")->insert(
        // [
        //     "user_id"=> $userId,
        //     "car_name"=> Str::random(10),
        //     "model"=> random_int(2000,2025),
        //     "price"=> random_int(1,100),
        // ]);

        // \App\Models\Car::factory()->create([
        //     'user_id'=>$userId,
        //     'car_name'=> "Test Car",
        //     'model'=>'2020',
        //     'price'=> '88888.99',
        // ]);

    }
}
