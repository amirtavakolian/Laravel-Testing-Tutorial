<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SingleController extends Controller
{

    public function show(Post $post)
    {
        return view('posts.single', compact('post'));
    }
}
