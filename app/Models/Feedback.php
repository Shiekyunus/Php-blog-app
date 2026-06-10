<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'user_id',
        'target_user_id',
        'type',
        'subject',
        'message',
        'status'
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
}
