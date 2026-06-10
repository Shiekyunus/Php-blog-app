<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\SavedArticle;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Ensure that only authenticated users can access the methods in this controller.
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Display the dashboard with various statistics and information for the authenticated user.
    public function index()
    {
        $user = Auth::user();
        $savedCount = SavedArticle::where('user_id', $user->id)->count();
        $likedCount = ArticleLike::where('user_id', $user->id)->count();
        $publishedCount = Article::where('is_published', true)->count();
        $data = [
            'user' => $user,
            'savedCount' => $savedCount,
            'likedCount' => $likedCount,
            'publishedCount' => $publishedCount,
        ];
        if ($user->hasRole('Author') || $user->hasRole('Editor') || $user->hasRole('Admin')) {
            $data['ownPublished'] = Article::where('user_id', $user->id)->where('is_published', true)->count();
            $data['draftCount'] = Article::where('user_id', $user->id)->where('is_published', false)->count();
        }
        if ($user->hasRole('Editor') || $user->hasRole('Admin')) {
            $data['pendingComments'] = Comment::where('status', 'pending')->count();
        }
        if ($user->hasRole('Admin')) {
            $data['totalUsers'] = User::count();
        }
        return view('dashboard', $data);
    }
}
