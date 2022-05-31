<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersConnection extends Model
{
    use HasFactory;
    
    protected $table = 'users_connection';
    protected $guarded = [
        'id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function relations()
    {
        return $this->belongsTo(User::class, 'relation_id');
    }
}
