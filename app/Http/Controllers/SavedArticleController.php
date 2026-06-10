<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\SavedArticle;
use Illuminate\Support\Facades\Auth;

class SavedArticleController extends Controller
{
    //
    // Ensure that only authenticated users can access the methods in this controller.
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Toggle the saved status of an article for the authenticated user.
    public function toggle(Article $article)
    {
        $saved = SavedArticle::where('user_id', Auth::id())->where('article_id', $article->id)->first();
        if ($saved) {
            $saved->delete();
            return response()->json(['saved' => false]);
        }
        SavedArticle::create([
           'user_id' => Auth::id(),
           'article_id' => $article->id
        ]);
        return response()->json(['saved' => true]);
    }
    // Display the list of saved articles for the authenticated user.
    public function index()
    {
        $savedArticles = SavedArticle::with('article')->where('user_id', Auth::id())->latest()->paginate(5);
        return view('saved.index', compact('savedArticles'));
    }
}
