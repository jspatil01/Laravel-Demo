<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\PHPStan\Macro;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use SebastianBergmann\Diff\Chunk;

class CollectionController extends Controller
{
    public function test(Request $request){
        try{

            // $users = User::all();
       //Using  keyword:
            // $keyword = $request->input('keyword');
            // $users = User::where('name', 'like', "%$keyword%")
            //       -> orWhere('email', 'like', "%$keyword%")
            //       -> get();
        
        //using group by, sorting:
            // $users = $users->groupBy('address');
            // $users = $users->sortBy('name');

        // using pluck:
            // $users = $users->pluck('name');

        // using contains:
            // $users= $users->contains('name', 'Jayesh');

        //using diff($item), except:
            // $users = $users->diff($collection2);
            // $users = $users->except([5,6,7]);
            // $users = $users->fresh();
            // $users = $users->intersect(User::whereIn('id',[5,6,7])->get());
            // $users = $users->modelKeys();
            // $users = $users->makeVisible(['password']);  
            // $users = $users->makeHidden(['email_verified_at', 'api_token', 'created_at', 'updated_at']);  
            // $users = $users->only([1,2]);

        // toQuery():    
            // $address = $request->input('address');
            // $users = User::where('address', $address)->get();
            // $users->toQuery()->update([
            //     'address'=>'Vapi'
            // ]);

            // $users = $users->unique();
        
            $users = User::select('id','name', 'email', 'address', 'role', 'status')->get();
            // $users = $users->map(function ($user) {
            //         return strtoupper($user->name);
            // });

            // $users = $users->chunk(3);
            // $users = $users->collect();

            // $id = $users->pluck('id');
            // $names = $users->pluck('name');
            // $users = $id->combine($names);

            // $users = $users->concat(["Demo"]);

            // $users = $users->contains('name', 'Jayshree');

            // $users = $users->containsOneItem();

            // $users = $users->countBy(function(string $email){
            //     return substr(strrchr($email, '@'), 1);
            // });
            // $users->all();

            // $users = $users->doesntContain('name', 'axcwf');
            // $user = $users->ensure(User::class);

            // $users= $users->every(function($user){
            //     return $user->status;
            // });

            // $users = $users->filter(function($users){
            //     return $users->status; 
            // });

            // $users = $users->firstWhere('name'); //first, firstorFail

            // $users = $users->implode('name', '-');

            // $users = $users->isEmpty();

            // $users = $users->keyBy('role');

            // $users = $users->keys();

            // $users = $users->mapToGroups(function(array $item, int $key){
            //     return [$item['address']=> $item['name']];
            // });
            // $users->all();

            // $users = $users->nth(4);

            // $users = $users->pad(-12, 0);

            // $users = $users->pluck('name', 'id');

            // $users = $users->put('name', 'jhudh');

            // $users = $users->range(3,6);

            // $users = $users->reject(function($user){
            //     return $user->status;
            // });

            // $users = $users->replace([0 => 'hvxhv']);
            // $users->all();

            // $users = $users->reverse();
            
            // $users = $users->shift(3);

            // $users = $users->skipUntil(function($user){
            //     return $user->role == 'administrator';
            // });

            // $users = $users->slice(5, 3);

            // $users = $users->sliding(2, step:3);
            // $users->toArray();

            // $users = $users->sole('name', 'Jayesh');

            // $users = $users->sort();
            // $users->values()->all();

            // $users = $users->sortByDesc('name');

            // $users = $users->sortKeysDesc();

            // $users = $users->splice(4,3);

            // $users = $users->split(4);

            // $users = $users->take(-3);

            // $users = $users->value('name');

            // $users = $users->when(true, function($user){
            //     return $user->push('kjnsf');
            // });
            
            // $users = $users->whereNotBetween('address', ['Bardoli', 'Surat']);
            // $users->all();

            // $users = $users->whereInstanceOf(User::class);

            // $users = $users->whereNotNull('api_token');   //WhereNull
            // $users->all();

        
            return response()->json([
                "Users:"=>$users
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                "message"=>"Something went wrong!"
            ], 500);
        }
    }
}
