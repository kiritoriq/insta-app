<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImages extends Model
{
    use HasFactory;

    protected $table = 'post_images';
    protected $guarded = [
        'id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
