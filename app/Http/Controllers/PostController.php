<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Exception;

class PostController extends Controller
{
    public function index()
    {
        try {
            // $posts = Post::with('comments')->get();

            // $allComments = $posts->where(function ($post) {
            //     return $post->comments;
            // });

            // -- sQuery 
            // $posts = Post::doesntHave('comments')->get();
            // $posts = Post::has('comments', '>=', 2)->get();
            $posts = Post::select('id', 'title')
                ->withExists('comments')->get();
            return response()->json([
                "Comments" => $posts
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            Post::create([
                "title" => $request->title,
                "body" => $request->body,
            ]);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }

    public function show(Post $post)
    {
        try {
            Post::find($post);
            $comments = $post->comments()->get();
            return response()->json([
                "message" => $comments
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }

    public function update(Request $request, Post $post)
    {

        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255'
        ]);
        try {
            $post->title = $validate['title'];
            $post->body = $validate['body'];
            $post->save();
            return response()->json(["message" => "Updated Successfully."], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json(["message" => "Something went wrong!"], 500);
        }
    }

    public function delete(Post $post)
    {
        try {
            Post::delete();
            return response()->json([
                "Post Deleted"
            ], 200);
        } catch (Exception $e) {
            report($e);
            return response()->json([
                "message" => "Something went wrong!"
            ], 500);
        }
    }
}
