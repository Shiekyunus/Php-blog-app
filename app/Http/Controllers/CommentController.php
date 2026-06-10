<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Notifications\InteractionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Apply authentication and permission middleware to the controller actions.
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:moderate comments')->only(['pending','approve','reject']);
    }
    // Store a newly created comment for the specified article in storage.

    public function store(Request $request, Article $article)
    {
        //
        $request->validate([
            'body' => 'required|string',
        ]);
        $isModerator = Auth::user()->hasAnyRole(['Admin','Editor']);
        $comment = Comment::create([
           'article_id' => $article->id,
           'user_id' => Auth::id(),
           'body' => $request->body,
           'parent_id' => null,
           'status' => $isModerator ? 'approved' : 'pending',
        ]);
        if ($isModerator && $article->user_id !== Auth::id()) {
            $article->author->notify(new InteractionNotification($comment));
        }
        return back()->with('success', $isModerator ? 'Comment posted successfully' : 'Comment submitted for approval.');
    }
    // Display a listing of the pending comments for moderation.
    public function pending()
    {
        $comments = Comment::with(['user','article','parent'])
                  ->where('status', 'pending')
                  ->latest()
                  ->paginate(10);
        return view('comments.pending', compact('comments'));
    }
    // Approve the specified comment and notify the comment author if they are not the one approving.
    public function approve(Comment $comment)
    {
        $comment->update([
           'status' => 'approved'
        ]);
        $comment->articles->author->notify(new InteractionNotification($comment));
        return back()->with('success', 'Comment approved.');
    }
    // Reject the specified comment and notify the comment author if they are not the one rejecting.

    public function reject(Comment $comment)
    {
        $comment->update([
            'status' => 'rejected'
        ]);
        return back()->with('success', 'Comment rejected.');
    }
    // Reply to the specified comment and notify the original comment author if they are not the one replying.
    public function reply(Request $request, Comment $comment)
    {
        //
        $request->validate([
           'body' => 'required|string',
        ]);
        $isModerator = Auth::user()->hasAnyRole(['Admin','Editor']);
        $reply = Comment::create([
            'article_id' => $comment->article_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
            'parent_id' => $comment->id,
            'status' => $isModerator ? 'approved' : 'pending',
         ]);
        if ($isModerator && $comment->user_id !== Auth::id()) {
            $comment->user->notify(new InteractionNotification($reply));
        }
        return back()->with('success', $isModerator ? 'Reply posted successfully' : 'Reply submitted for approval.');
    }

    /**
     * Show the form for editing the specified resource.
     */

}
