<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Video;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CommentController extends Controller
{
    public function index(){
        try{
            $comments = Comment::whereHasMorph( // whereDoesntHaveMorph also used
                'commentable',
                [Post::class, Video::class],
                function(Builder $query){
                    $query->where('content', 'like', 'iodhjkdubjkd%');
                }
            )->get();
            return response()->json([
                "message"=>$comments
            ], 200);
        }catch(Exception $e){
            return response()->json([
                "message"=>"Something went wrong!"
            ], 500);
        }
    }
    public function store(Request $request, Post $post, Video $video)
    {
        // try {
        //     $post->comments()->create([
        //         'content' => $request->content,
        //     ]);
        //     return response()->json([
        //         "message" => "Stored Comments Successfully."
        //     ], 200);
        // } catch (Exception $e) {
        //     report($e);
        //     return response()->json([
        //         "message" => "Something went wrong!"
        //     ], 500);
        // }

        $modelClasses = [
            'Post' => Post::class,
            'Video' => Video::class,
        ];

        try {
            $modelClass = $modelClasses[$request->commentable_type];
            $model = $modelClass::find($request->commentable_id);

            $model->comments()->create([
                'content' => $request->content,
            ]);
            return response()->json([
                "message" => "Stored Comment Successfully."
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request){
        $modelClasses = [
            'Post' => Post::class,
            'Video' => Video::class,
        ];
        try{
            $modelClass = $modelClasses[$request->commentable_type];
            $model = $modelClass::find($request->commentable_id);
            $model->comments()->update([
                'content' => $request->content,
            ]);
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
}
