<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\Employee;
use Illuminate\Http\Request;
use Exception;

class ContactController extends Controller
{
    public function index(){
        $contact = Contact::with('employee')->get();
        return $contact;
    }
    public function store(Request $request, Employee $employee){
    
        $request->validate([
            'phone_no'=> 'required|string|max:15',
            'email'=>'required|email|string|max:255',
            'city'=>'required|string|max:255',
        ]);

        try{
            $employee->contact()->create([
                'phone_no'=>$request->phone_no,
                'email'=>$request->email,
                'city'=>$request->city,
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
    }}
