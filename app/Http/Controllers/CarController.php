<?php

namespace App\Http\Controllers;

use App\Events\CarUpdate;
use Exception;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Car;
use App\Models\User;
use Nette\Utils\Random;
use Illuminate\Support\Str;
use PharIo\Manifest\Extension;
use Storage;
class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        // $cars = DB::table('cars')->get();
        // return $cars;

        //-- Using selectRaw
        // $cars = DB::table('cars')
        //         ->selectRaw('price * ? as price_with_tax', [1.0825])
        //         ->get();
        // return $cars;

        //--Using havingRaw and groupBy
        // $cars = DB::table('cars')
        //     ->select('car_name', DB::raw('SUM(price) as Total_Price'))
        //     ->groupBy('car_name')
        //     ->havingRaw('SUM(price)')
        //     ->get();
        // return $cars;

        // $cars = DB::table('cars')
        //       ->where('price','>',70)
        //       ->select('car_name', 'price')
        //       ->get();
        // return $cars;

        //OrderBy-Sorting
        // $cars = DB::table('cars')
        //     ->orderBy('car_name','desc')
        //     ->select('id','car_name','model')
        //     ->get();
        // return $cars;

        //--Limit and Offset OR take and skip
        // $cars = DB::table('cars')->skip(6)->take(2)->get();
        // $cars = DB::table('cars')->offset(4)->limit(5)->get();
        return $cars;
    }

    public function store(Request $request, User $user)
    {
        $request->validate(
            [
                'car_name' => 'required|string',
                'model' => 'required',
                'price' => 'required|numeric',
                'registration_date' => 'required|date_format:Y-m-d',
                'attachment' => 'required|image|mimes:jpg,jpeg,png,webp',
            ]
        );
        try {
            $carData =[
                'car_name' => $request->car_name,
                'model' => $request->model,
                'price' => $request->price,
                'registration_date' => $request->registration_date,
            ];

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = $file->hashName();      //Str::uuid() and rand() - also used
                $file->storeAs('public/images/attachment', $filename);
                $carData['attachment'] = $filename;
            }

            $user->cars()->create($carData);

            return response()->json([
                "message" => "Car Record Stored Successfully."
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong"
            ], 500);
        }
    }

    public function show(Car $car)
    {
        try {
            echo !$car->attachment ? "Image Not Found" : $car->attachment;
            $car->attachment = asset('storage/images/' . $car->attachment);
            return response()->json([
                "car" => $car,
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something wwnt wrong!"
            ], 500);
        }
    }

    public function getImageUrl(Car $car)
    {
        try {
            if (!$car->attachment) {
                return response()->json([
                    "message" => "Image Not Found!"
                ], 404);
            }
            $path = 'images/' . $car->attachment;

            $url = asset('storage/' . $path);
            return response()->json([
                "message" => "URL Generated SUccessfully.",
                "URl" => $url
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }

    public function update(Request $request, Car $car)
    {

        $validate = $request->validate(
            [
                'car_name' => 'required|string',
                'model' => 'required',
                'price' => 'required|numeric',
                'registration_date' => 'required|date_format:Y-m-d',
            ]
        );

        try {
            $car->car_name = $validate['car_name'];
            $car->model = $validate['model'];
            $car->price = $validate['price'];
            $car->registration_date = $validate['registration_date'];
            $car->save();

            CarUpdate::dispatch($car);
            \Log::info('Dispatch Car Update to user: ' . $car->user_id);

            return response()->json([
                "message" => "Car record updated."
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }
}