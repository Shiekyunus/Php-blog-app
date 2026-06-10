<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class InteractionNotification extends Notification
{
    use Queueable;
    public $comment;
    /**
     * Create a new notification instance.
     */
    public function __construct($comment)
    {
        //
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database'];
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            //
            'article_id' => $this->comment->article_id,
            'comment_id' => $this->comment->id,
            'message' => $this->comment->parent_id ? Auth::user()->name .' replied to your comment' : Auth::user()->name.' commented on your article',
        ];
    }
}
