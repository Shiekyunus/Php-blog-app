<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    //
    protected $fillable = ['article_id','user_id','title','body','image','category_id','tags'];
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
       'tags' => 'array',
    ];
}
