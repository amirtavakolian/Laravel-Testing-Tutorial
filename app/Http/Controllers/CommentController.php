<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        Comment::query()->create([
            'content' => $request->input('content'),
            'post_id' => $request->input('post_id'),
            'user_id' => auth()->user()->id
        ]);

        return redirect()->back()->with('comment_saved', 'comment added successfully');
    }
}
