<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $posts = Post::with('category', 'user')->where('user_id', $user_id)->latest('id')->paginate(10);
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePost $request)
    {
        $input = $request->validated();
        $input['user_id'] = $request->user()->id;
        Post::query()->create($input);
        return to_route('posts.index')->with('success', 'Post store successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePost $request, Post $post)
    {
        $input = $request->validated();
        $input['user_id'] = $request->user()->id;
        $post->update($input);
        return to_route('posts.index')->with('success', 'Post update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('posts.index')->with('success', 'Post delete successfully!');
    }
}
