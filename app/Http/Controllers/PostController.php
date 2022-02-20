<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeletePostRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function allPosts()
    {
        $posts = Post::all();

        return response()->json([
            'status' => 'success',
            'posts' => $posts
        ]);
    }
    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
        ]);

        return response()->json([
            'status' => 'success',
            'post' => $post,
        ]);
    }
    public function delete(DeletePostRequest $request)
    {
        $post = Post::findOrFail($request->id);
        $post->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
