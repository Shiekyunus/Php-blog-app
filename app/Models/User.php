<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $fillable = ['name','email','password','image'];
    protected $hidden = ['password','remember_token'];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }
    public function receivedMessages()
    {
        return $this->hasMany(Feedback::class, 'target_user_id');
    }
    public function likes()
    {
        return $this->hasMany(ArticleLike::class);
    }
    public function savedArticles()
    {
        return $this->hasMany(SavedArticle::class);
    }
}
