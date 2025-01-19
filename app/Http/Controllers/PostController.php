<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $postData = $request->only(['title', 'content']);

        $postData['user_id'] = 1;

        Post::query()->create($postData);

        return redirect()->route('home')->with('post-created', 'post created successfully');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->all());

        return redirect()->route('home')->with('post-updated', 'post updated successfully');
    }

}
