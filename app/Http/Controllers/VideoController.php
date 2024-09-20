<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Exception;

class VideoController extends Controller
{
    public function store(Request $request){
        try{
            Video::create([
                "title"=> $request->title,
                "url"=> $request->url,
            ]);
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
}
