<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Display the home page with a list of published articles.
    public function index()
    {
        $articles = Article::with(['author','category','tags'])->where('is_published', true)->latest()->paginate(10);
        return view('home', compact('articles'));
    }
}
