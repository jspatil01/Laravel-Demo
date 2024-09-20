<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Exception;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(){
        return Department::all();
    }
    public function store(Request $request){

        $request->validate([
            'dept_name'=> 'required|string|max:255'
        ]);

        try{
            Department::create([
                'dept_name' => $request->dept_name,
            ]);
            return response()->json([
                "message"=>"Stored Successfully"
            ], 200);
        }catch(Exception $e){
            report($e);
            return response()->json([
                "message"=>"Something went wrong!"
            ], 500);
        }
    }

    public function updateDepartment(Department $department, $action){
        try{
            $validateDept = ['IT', 'CE', 'Civil', 'Mechanical'];

            if(!in_array($action, $validateDept)){
                return response()->json([
                    "mesaage"=>"Invalid Department Value!"
                ], 500);
            }

            $department->dept_name = $action;
            $department->save();

            return response()->json([
                "message"=>"Department value updated successfully."
            ], 200);
        }catch(Exception $e){
            report($e);
            return response()->json([
                "message"=>"Something went wrong!"
            ], 500);
        }
    }
}
