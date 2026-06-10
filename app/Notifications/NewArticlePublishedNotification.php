<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewArticlePublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $article;
    /**
     * Create a new notification instance.
     */
    public function __construct($article)
    {
        //
        $this->article = $article;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('New Article Published: '.$this->article->title)
            ->greeting('Hello '.$notifiable->name)
            ->line('A new article has been published on our blog.')
            ->line('Title: '.$this->article->title)
            ->action('Read Article', url('/articles/'.$this->article->slug))
            ->line('Thank you for subscribing to our blog!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
