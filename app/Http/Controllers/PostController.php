<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('welcome', compact('posts'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $posts = new Post();
        $posts->name = $request->name;
        $posts->description = $request->description;
        $posts->slug = Str::slug($request->name);
        $posts->save();

        return response()->json($posts);
        // return redirect()->route('index');
    }
}
