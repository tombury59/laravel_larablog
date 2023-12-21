<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('articles.create',["categories" => Category::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->only(['title', 'content', 'draft']);

        $data['user_id'] = Auth::user()->id;

        $data['draft'] = isset($data['draft']) ? 1 : 0;


        $article = Article::create($data);
        $article->categories()->sync($request->input('categories'));

        return redirect()->route('dashboard')->with('success', 'Article crée !');
    }


    public function index()
    {
        // On récupère l'utilisateur connecté.
        $user = Auth::user();


        $articles = Article::where('user_id', $user->id)->get();
        return view('dashboard', [
            'articles' => $articles
        ]);
    }



    public function edit(Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            return redirect()->route('dashboard')->with('error', "Euh, jcroit que té po le créateur de l'article :/");
        }

        // On retourne la vue avec l'article
        return view('articles.edit', [
            'article' => $article,"categories" => Category::all()]);
    }

    public function update(Request $request, Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            return redirect()->route('dashboard')->with('error', "Euh, jcroit que té po le créateur de l'article :/");
        }

        // On récupère les données du formulaire
        $data = $request->only(['title', 'content', 'draft']);

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On met à jour l'article
        $article->update($data);


        // On redirige l'utilisateur vers la liste des articles (avec un flash)
        return redirect()->route('dashboard')->with('success', 'Article mis à jour !');
    }

    public function delete(Article $article)
    {
        $article->delete();
        return redirect()->route('dashboard')->with('success', 'Article supprimé !');
    }




}
