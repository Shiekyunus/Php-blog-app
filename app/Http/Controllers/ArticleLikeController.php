<?php

namespace App\Http\Controllers;

use App\Models\ArticleLike;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;


class ArticleLikeController extends Controller
{
    //
    // Ensure that only authenticated users can access the methods in this controller.
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Toggle the like status of an article for the authenticated user.
    public function toggle(Article $article)
    {
        $like = ArticleLike::where('user_id', Auth::id())->where('article_id', $article->id)->first();
        if ($like) {
            $like->delete();
            return response()->json(['liked' => false,'like_count' => $article->likes()->count()]);
        }
        ArticleLike::create([
            'user_id' => Auth::id(),
            'article_id' => $article->id,
        ]);
        return response()->json(['liked' => true,'like_count' => $article->likes()->count()]);
    }
    // Display a listing of the liked articles for the authenticated user.
    public function index()
    {
        $likes = ArticleLike::with('article')->where('user_id', Auth::id())->latest()->paginate(5);
        return view('likes.index', compact('likes'));
    }
}
