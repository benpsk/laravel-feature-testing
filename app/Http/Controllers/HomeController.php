<?php

namespace App\Http\Controllers;

use App\Models\Post;


class HomeController extends Controller
{
    public function __invoke()
    {
        $posts = Post::with('category', 'user')->latest('id')->paginate(10);
        return view('home', compact('posts'));
    }
}
