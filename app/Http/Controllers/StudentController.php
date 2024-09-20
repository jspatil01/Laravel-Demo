<?php

namespace App\Http\Controllers;

use App\Rules\Uppercase;
use Illuminate\Http\Request;
use App\Models\Student;
use Exception;
use App\Jobs\DemoJob;
class StudentController extends Controller
{
    public function index()
    {
        try {
            $students = Student::get();
            return response()->json([
                "Students" => $students
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', new Uppercase],
            'email' => 'required|string|email|max:255',
            'gender' => 'required|in:male,female',
            'contactNo' => 'required|string|min:10|max:15'
        ]);

        try {
            Student::create([
                'name' => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'contactNo' => $request->contactNo
            ]);
            return response()->json([
                "message" => "Stored Successfully"
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }
}
