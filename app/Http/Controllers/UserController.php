<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Mail\UserCreated;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Repositories\userRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UserController extends Controller
{
    public $userRepository;

    public function __construct(userRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        try {
            $users = User::all();
            return response()->json($users);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        // try{
        //     $search = $request->query('search');
        //     $users = User::when($search, function ($query) use ($search) {
        //         $query->where('name', 'like', '%'.$search.'%')
        //               ->orWhere('email', 'like', '%'.$search.'%');
        //     })->paginate(6);
        //     return response()->json([
        //         'users' => $users
        //     ], 200);  
        // }catch(Exception $e) {
        //     report($e);
        //     return response()->json([
        //         'message' => 'Something went wrong!'
        //     ], 500);
        // }

        // $users = DB::table ('users')->count();
        // return $users;

        // $users = DB::table ('users')->where('gender', 'male')->get();
        // return $users;

        // !--Show particular Data for all users--!
        // foreach ($users as $user) {
        //     echo $user->id." ".$user->email."\n";
        // }

        // $users = User::all();
        // return $users;

        // $users = DB::table('users')
        //             ->select('name as user_name', 'email', 'address as city','status')
        //             ->get();
        // return $users;

        // $users = DB::table('users')
        //         ->select(DB::raw('count(*) as user_count, status'))
        //         ->where('status',1)
        //         ->groupBy('status')
        //         ->get();
        // return $users;

        //-- Inner Join
        // $user = DB::table('users')
        //       ->join('cars','users.id','=','cars.user_id')
        //       ->select('users.*', 'cars.car_name')
        //       ->get();
        // return $user;

        //--Left Join
        // $users = DB::table('users')
        //       ->leftJoin('cars',"users.id","=","cars.user_id")
        //       ->select('users.name', 'cars.car_name', 'cars.price')
        //       ->get();
        // return $users;

        //--Right Join
        // $users = DB::table('users')
        //        ->rightJoin('cars',"users.id","=","cars.user_id")
        //        ->select('users.name', 'cars.car_name', 'cars.price')
        //        ->get();
        // return $users;

        //--Cross Join
        // $users = DB::table('users')
        //        ->crossJoin('cars')
        //        ->select('users.name', 'cars.car_name')
        //        ->get();
        // return $users;

        //--Where
        // $users = DB::table('users')
        //        ->where('gender', '!=','male')
        //        ->get();
        // return $users;

        // $user = DB::table('users')
        //       ->join('cars','users.id','=','cars.user_id')
        //       ->where([
        //             ['gender','female'],
        //             ['car_name','Kia']])
        //       ->select('users.*', 'cars.car_name')
        //       ->get();
        // return $user;

        // $users = DB::table('users')
        //        ->whereNot(function ($query) {
        //             $query->where('status', 1)
        //                   ->orWhere('address','Surat');
        //        })->get();
        // return $users;

        // $users = DB::table('users')
        //        ->whereNotIn('id', [1,2,4,6,8])
        //        ->get();
        // return $users;

        // $activeUsers = DB::table('users')->select('id')->where('status',1);
        // $users = DB::table('cars')->whereIn('user_id', $activeUsers)->get();
        // return $users;

        //--Sorting
        // $users = DB::table('users')
        //       ->orderBy('name')
        //       ->get();
        // return $users;

        // $users = DB::table('users')
        //       ->oldest()  latest()
        //       ->first();
        // return $users;
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:male,female',
            'mobile_no' => 'required|string',
            'password' => 'required|min:8|max:15|string',
            'address' => 'nullable|max:255|',
            'status' => 'required|in:0,1'
        ]);

        try {
            $user = User::create([
                "name" => $request->name,
                'email' => $request->email,
                'gender' => $request->gender,
                'mobile_no' => $request->mobile_no,
                'password' => bcrypt($request->password),
                'address' => $request->address,
                'status' => $request->status
            ]);

            // Mail::to($user->email)->queue(new UserCreated($user));

            SendEmail::dispatch($user)->onQueue('email');
            return response()->json([
                'message' => 'User Created and Mail Sent Successfully.',
                'User Data' => $user,
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
    }
    public function show(User $user)
    {
        try {
            $user = $this->userRepository->show($user);
            return response()->json([
                // auth()->user()
                "user" => $user,
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Something went wrong!'
            ], 500);
        }

        //--Fetch Single value--
        // $email= DB::table('users')->where('name','INto6')->value('email');
        // return $email; 

        //OR Fetch Specific row 
        // $email= DB::table('users')->where('name','INto6')->first();
        // return $user->status;

        //OR one row ID Wise
        // $users = DB::table('users')->find(1);
        // return $users;

    }

    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();
        $isAdmin = $currentUser->role === 'administrator';

        $rules = [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'mobile_no' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:0,1'
        ];

        if ($isAdmin && $request->has('email')) {
            $rules['email'] = 'required|email|unique:users,email,' . $user->id;
        } elseif (!$isAdmin && $request->has('email')) {
            return response()->json(['message' => 'You are not allowed to update your email address.'], 403);
        }

        try {
            $validatedData = $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed: ' . $e->getMessage()], 422);
        }

        try {
            $updated = $this->userRepository->update($request, $user);

            if ($updated) {
                return response()->json([
                    'message' => 'User record updated successfully.',
                    'User' => $user
                ], 200);
            } else {
                return response()->json(['message' => 'Failed to update user record.'], 500);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }


        // $updatedData = DB::table('users')
        //             ->where('id', 3)
        //             ->set('name' , 'Raj);
        // return $updatedData;

        // $user->update($request->all());
        // return $user;

        // $validate = $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|email',
        //     'gender' => 'required|in:male,female',
        //     'mobile_no' => 'required|string',
        //     'password' => 'required|min:8|max:15|string',
        //     'address' => 'nullable|max:255|',
        //     'status' => 'required|in:0,1'
        // ]);

        // try {
        //     $user->name = $validate['name'];
        //     $user->email = $validate['email'];
        //     $user->gender = $validate['gender'];
        //     $user->mobile_no = $validate['mobile_no'];
        //     $user->password = bcrypt($validate['password']);
        //     $user->address = $validate['address'];
        //     $user->status = $validate['status'];
        //     $user->save();

        //     return response()->json([
        //         'message' => 'Update Successfully.'
        //     ], 200);
        // } catch (Exception $e) {
        //     report($e);
        //     return response()->json([
        //         'message' => 'Something went Wrong!'
        //     ], 500);
        // }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $user = auth()->user();
                    if (!Hash::check($value, $user->password)) {
                        $fail('The provided password is incorrect.');
                    }
                }
            ]
        ]);
        try {
            $user = auth()->user();
            $user->tokens()->delete();
            $user->delete();

            return response()->json([
                'message' => 'Deleted Successfully.'
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                'message' => 'Something went wrong!'
            ], 500);
        }
    }


    public function login(Request $request, User $user)
    {
        // $request -> validate ([             
        //     'email' => 'required|email:users' , 
        //     'password' => 'required|min:8|max:12'
        //  ]); 

        // $user = User ::where ( 'email' , '=' ,$request ->email)-> first (); 
        // if ( $user ){ 
        //     if ( Hash :: check ( $request ->password, $user ->password)){ 
        //         $token = Str::random(32);
        //         $user->api_token =$token;
        //         $user->save ();
        //         return  "Success"; 
        //     } else { 
        //         return  "Fail"; 
        //     } 
        // } else { 
        //     return  "something wrong"; 
        // }     
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::User();
                $token = $user->createToken('personal_access_tokens')->plainTextToken;
                // $token = Str::random(32);
                // $user->api_token = $token;
                $user->save();
                return response()->json([
                    "message" => "Successful Login.",
                    "user" => $user,
                    "api_token" => $token
                ], 200);
            } else {
                return response()->json([
                    "message" => "Unauthorized"
                ], 401);
            }
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                "message" => "User Logout Successfully."
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }

    public function updateStatus(User $user, $action)
    {
        $validStatuses = [0, 1];

        try {
            $actionInt = (int) $action;

            if (!in_array($actionInt, $validStatuses, true) || $action !== strval($actionInt)) {
                return response()->json([
                    "message" => "Invalid Status Value!"
                ], 500);
            }

            $user->status = $actionInt;
            $user->save();

            return response()->json([
                "message" => "User status updated successfully."
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }

    // public function serachUser(Request $request){
    //     try{
    //         $keyword = $request->input('keyword');
    //         $users = User::where('name', 'like', "%keyword%")
    //               -> orWhere('email','like', "%keyword%")
    //               ->get();
    //         return response()->json([
    //             "users"=>$users
    //         ], 200);
    //     }catch(Exception $e){
    //         return response()->json([
    //             "message"=>"Something went wrong!"
    //         ], 500);
    //     }
    // }
}
