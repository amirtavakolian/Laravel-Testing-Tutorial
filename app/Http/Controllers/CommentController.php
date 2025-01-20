<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id
        ]);

        return redirect()->back()->with('comment_saved', 'comment added successfully');
    }

}
