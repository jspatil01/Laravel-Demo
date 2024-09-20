<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Exception;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        // $teacher = Teacher::all();
        // return $teacher;
        try{
            $search = $request->query("search");
            $teachers = Teacher::when($search, function ($query, $search) {
            $query->whereAny(['id','name'],"like","%". $search ."%");
        })->paginate(3);
            return response()->json([
                'teachers' => $teachers
            ], 200);
        }catch(Exception $e){
            report($e);
            return response()->json([
                "message"=> "Something went wrong!"
            ],500);
        }
    }
    // Many to many realationship
    public function teacherdepartment(){
        try{
            $teacher = Teacher::with('departments')->get(); 
            return response()->json(['teachers-department'=>$teacher], 200);     
        }catch(Exception $e){
            report($e);
            return response()->json(["message"=>"Something went wrong!"], 500);
        }
    }

    public function store(Request $request)
    {
       $request->validate([
            "name"=> "required|string|max:255",
            "email"=> "required|string|email|max:255",
            "gender"=> "required|in:male,female",
            "contact_no"=>"required|string"
        ]);

        try{
            Teacher::create([
                "name"=> $request->name,
                "email"=> $request->email,
                "gender"=> $request->gender,
                "contact_no"=> $request->contact_no
            ]);
            return response()->json([
                "message"=>"Added Successfully."
            ], 200);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                "message"=>"Somethin went wrong!"
            ], 500);
        }
    }

    public function show(Teacher $teacher)
    {
        try{
            return response()->json($teacher);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                "message"=>"Something went wrong!"
            ], 500);
        }
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validate = $request->validate([
            "name"=> "required|string|max:255",
            "email"=> "required|string|email|max:255",
            "gender"=> "required|in:male,female",
            "contact_no"=>"required|string"
        ]);

        try{
            $teacher->name = $validate['name'];
            $teacher->email = $validate['email'];
            $teacher->gender = $validate['gender'];
            $teacher->contact_no = $validate['contact_no'];
            $teacher->save();

            return response()->json([
                "message"=>"Updated Successfuly."
            ], 200);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                "message"=>"Something went wrong!"
            ], 500);
        }
    }

    public function delete(Teacher $teacher)
    {
        try{
            $teacher->delete();
            return response()->json([
                "message"=>"Deleted Successfully."
            ], 200);
        }catch(Exception $e){
            report($e);
            return response()->json([
                "message"=>"Something went wrong!"
            ], 500);    
        }
    }
}
