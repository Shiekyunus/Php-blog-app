<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    //
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'body',
        'is_published',
        'image'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }
    public function likes()
    {
        return $this->hasMany(ArticleLike::class);
    }
    public function savedArticles()
    {
        return $this->hasMany(SavedArticle::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
