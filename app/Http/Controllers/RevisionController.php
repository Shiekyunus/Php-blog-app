<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Revision;
use Illuminate\Support\Facades\Auth;

class RevisionController extends Controller
{
    // Apply authentication and permission middleware to the controller actions.
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage revisions');
    }
    // Display a list of revisions for a specific article.
    public function index(Article $article)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['Admin','Editor']) && $article->user_id !== $user->id) {
            abort(403);
        }
        $revisions = $article->revisions()->with('user')->latest()->paginate();
        return view('revisions.index', compact('article', 'revisions'));
    }
    // Restore a specific revision of an article.
    public function restore(Article $article, Revision $revision)
    {
        $user = Auth::user();
        if (!$user->hasAnyRole(['Admin','Editor']) && $article->user_id !== $user->id) {
            abort(403);
        }
        if ($revision->article_id !== $article->id) {
            abort(404);
        }
        $article->revisions()->create([
                'user_id' => Auth::id(),
                'title' => $article->title,
                'body' => $article->body,
                'image' => $article->image,
                'category_id' => $article->category_id,
                'tags' => $article->tags->pluck('id')->toArray(),
        ]);
        $article->update([
            'title' => $revision->title,
            'body' => $revision->body,
            'category_id' => $revision->category_id,
            'image' => $revision->image,
        ]);
        if ($revision->tags) {
            $article->tags()->sync($revision->tags);
        }
        return redirect()->route('articles.index', $article)->with('success', 'Revision restore successfully.');
    }
}
