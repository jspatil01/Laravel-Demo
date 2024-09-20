<?php

namespace App\Http\Controllers;
use App\Helpers\Helper;
use App\Models\Employee;
use App\Models\Manager;
use App\Rules\BirthYearRule;
use Exception;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        // $employee = Employee::with('contact')->get();
        // return $employee;
        // $employees = Employee::with('manyContacts:id,emp_id,email,city')->get();
        $employees = Employee::with(['manyContacts'=>function($query){
            $query->where('city', 'like', '%ra');
        }])->get();
        return response()->json([
            "Employee"=>$employees
        ] ,200);
        // $employee = Employee::with('currentContacts')
        //          -> where('department', 'CSE')  
        //          ->orWhere('manager_id', 1)      
        //          -> get();
        // return $employee;
    }

    public function store(Request $request, Manager $manager){

        $request->validate([
            'name'=> ['required', 'string', 'max:255', function($attribute, $value, $fail){
                if(ucfirst($value) != $value){
                    $fail('The :attribute must be Sentence case!');
                }
            }],
            'DOB'=> ['required', 'Date', new BirthYearRule],
            'gender'=>'required|in:male,female',
            'department'=>'required|string|max:255'
        ]);

        try{
            $manager->employee()->create([
                'name'=>$request->name,
                'DOB'=>$request->DOB,
                'gender'=>$request->gender,
                'department'=>$request->department
            ]);
            return response()->json([
                "message"=>"Data Stored Successfully"
            ],200);
        }catch(Exception $e){
            report($e);
            return response()->json([
                "message"=>"Something went wrong!"
            ], 500);
        }
    }

    public function show(Employee $employee){
        $employee = Helper::getEmployeeDetails($employee);
        return json_decode($employee);
    }
}