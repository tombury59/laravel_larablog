<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {

        if (Auth::check()) {

            Comment::create([
                'content' => $request->input("content"),
                'article_id' => $request->input("article"),
                'user_id' => Auth::user()->id
            ]);
            return redirect()->back();
        }
        else
        {
            return redirect()->route('login');
        }
    }
}
