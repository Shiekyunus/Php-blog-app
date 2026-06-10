<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class AdminLayoutComposer
{
    // Compose the view with data related to unread notifications and pending comments for the authenticated user.
    public function compose(View $view)
    {
        $unreadNotifications = 0;
        $pendingComments = 0;
        if (Auth::check()) {
            $unreadNotifications = Auth::user()->unreadNotifications()->count();
            if (Auth::user()->can('moderate comments')) {
                $pendingComments = Comment::where('status', 'pending')->count();
            }
        }
        $view->with([
           'unreadNotifications' => $unreadNotifications,
           'pendingComments' => $pendingComments,
        ]);
    }
}
