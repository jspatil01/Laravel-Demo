<?php

namespace App\Http\Controllers;

use App\Events\SentMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class BroadcastController extends Controller
{
    public function sendNotification(Request $request){

        $message = $request->input('message');
        $user = Auth::user();
        \Log::info("Message:", ['message' => $message]);
        // SentMessage::dispatch($message, $user);
        broadcast(new SentMessage($message, $user));
        \Log::info("Message Send");   
    }
}