<?php

namespace App\Http\Controllers;
use App\Models\Manager;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class ManagerController extends Controller
{
    public function index(){
        $managers = Manager::with('employeeDetail')->get();
        return $managers;
    }

    public function store(Request $request){

        $request->validate([
            'name'=> 'required|string|max:255'
        ]);

        try{
            Manager::create([
                'name'=>Helper::upperName($request->name),
            ]);
            return response()->json([
                "message"=>"Stored Successfully.
            "], 200);
        }catch(Exception $e){
            report($e);
            return response()->json([
                "message"=>"Something went wrong"
            ], 500);
        }
    }
}
