<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Core\Number;
use Faker\Provider\da_DK\PhoneNumber;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
        [
            "name"=> Str::random(5),
            "email"=> Str::random(5)."@example.com",
            "password"=> Hash::make("password"),
            "mobile_no"=> random_int(1000000000, 9999999999),
            "address"=>Str::random(50),
            "status"=> random_int(0,1),
        ]];

        foreach($users as $user){
            User::create($user);
        }
    }
}
