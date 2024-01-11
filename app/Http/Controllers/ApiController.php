<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getLike(Article $article)
    {
        return response()->json(['like' => $article->aime]);
    }

    function AjoutLike(Article $article)
    {
        $article->aime = $article->aime + 1;
        $article->save();

//        return redirect()->route('article', ['article' => $article]);
        return response()->json(['like' => $article->aime]);
    }
}
