<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/table/{number?}', function ($number = 2) {
   for($i =1; $i <= 10 ; $i++){
       echo "$i * $number = ". $i* $number ."<br>";
   }   
});

// Route::get('user/{name?}', function ($name = 'TutorialsPoint') 
// {
//      return $name;
// });

// Route:: post('user/dashboard', function () {
//     return 'Welcome to dashboard';
//  });

//  Route::post('/reverse-me', function (Request $request) {
//     $reversed = strrev($request->input('reverse_this'));
//     return $reversed;
//   });

