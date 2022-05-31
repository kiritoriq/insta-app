<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';
    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function postImages()
    {
        return $this->hasMany(PostImages::class, 'post_id', 'id');
    }

    public function postLikes()
    {
        return $this->hasMany(PostLikes::class, 'post_id', 'id');
    }

    public function postComments()
    {
        return $this->hasMany(PostComments::class, 'post_id', 'id');
    }
}
