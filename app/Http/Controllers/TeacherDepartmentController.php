<?php

namespace App\Http\Controllers;
use App\Models\Department;
use Exception;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherDepartmentController extends Controller
{
    public function store(Request $request, Teacher $teacher){

        $request->validate([
            'dept_id' => 'required|array|exists:departments,id',
        ]);

        try{
            $teacher->departments()->attach($request->dept_id);
            return response()->json([
                "message"=>"Stored Successfully."
            ], 200);
        }catch(Exception $e){
            report($e);
            return response()->json([
                "message"=>"Something went wrong!"
            ], 500);
        }
    }
    
    public function update(Request $request, Teacher $teacher){
        $request->validate([
            'dept_id'=>'required|array|exists:departments,id',
        ]);
        try{
            $teacher->departments()->sync($request->dept_id);
            return response()->json([
                "message"=>"Updated Successfully."
            ], 200);
        }catch(Exception $e){
            report($e);
            return response()->json([
                "message"=>"Something went wrong!"
            ], 500);
        }
    }
    public function delete(Teacher $teacher){
        try{
            if(!$teacher->exists){
                return response()->json([
                    "message"=>"Teacher not found!"
                ], 404);
            }
            $teacher->departments()->detach();
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
