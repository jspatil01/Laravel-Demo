<?php

namespace App\Repositories;
use App\Models\User;
use App\interface\UserInterface;
use Exception;
use Illuminate\Http\Request;

class userRepository implements UserInterface
{
    public function show($user)
    {
        $currentUser = auth()->user();

        if ($currentUser->role == 'administrator') {
            if ($user) {
                return $user;
            }
            return User::all();
        }

        return $currentUser;
    }

    // public function update(Request $request, $user)
    // {

    //     $currentUser = auth()->user();
    //     $isAdmin = $currentUser->role === 'administrator';

    //     try {
    //         $user->name = $request->input('name');
    //         $user->gender = $request->input('gender');
    //         $user->mobile_no = $request->input('mobile_no');
    //         $user->address = $request->input('address');
    //         $user->status = $request->input('status');
    //         if ($isAdmin && $request->has('email')) {
    //             $user->email = $request->input('email');
    //         }
    //         if ($user->save()) {
    //             return [
    //                 'message' => 'User record updated successfully.',
    //                 'User' => $user
    //             ];
    //         }


    //         //Check For User
    //         if ($currentUser->id == $user->id) {

    //             if ($request->has('email')) {
    //                 return response()->json(["message" => "You are not allowed to update your email address."], 403);
    //             }
    //             $currentUser->name = $request['name'];
    //             $currentUser->gender = $request['gender'];
    //             $currentUser->mobile_no = $request['mobile_no'];
    //             $currentUser->address = $request['address'];
    //             $currentUser->status = $request['status'];

    //             if ($currentUser->save()) {
    //                 return response()->json([
    //                     "message" => "User record updated successfully."
    //                 ], 200);
    //             } else {
    //                 return response()->json([
    //                     "message" => "Failed to update your record."
    //                 ], 500);
    //             }
    //         }

    //         return response()->json([
    //             "message" => "Unauthorized to update this record."
    //         ], 403);

    //     } catch (Exception $e) {
    //         report($e);
    //         return response()->json(["message" => "Something went wrong"], 500);
    //     }
    // }

    public function update(Request $request, $user)
    {
        $user->name = $request->input('name');
        $user->gender = $request->input('gender');
        $user->mobile_no = $request->input('mobile_no');
        $user->address = $request->input('address');
        $user->status = $request->input('status');
        
        if(auth()->user()->role == 'administrator'){
            if ($request->has('email')) {
                $user->email = $request->input('email');
            }
        }else{
            return response()->json(['message' => 'You are not allowed to update your email address.'], 403);
        }

        return $user->save();
    }
}
?>