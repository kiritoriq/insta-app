<?php

namespace App\Models;

use App\Models\Post;
use App\Models\UsersConnection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Keygen\Keygen;
use App\Models\UsersRoles;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at', 'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setEmailAttribute($email)
    {
        // Ensure valid email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Invalid email address.");
        }

        // Ensure email does not exist
        elseif (static::whereEmail($email)->count() > 0) {
            throw new \Exception("Email already exists.");
        }

        $this->attributes['email'] = $email;
    }

    protected function serialExists($serial)
    {
        return User::whereId($serial)->exists();
    }

    public function generateSerial()
    {
        $serial = Keygen::alphanum(6)->generate('strtoupper');
        if ($this->serialExists($serial)) {
            return $this->generateSerial();
        }
        return $serial;
    }

    public function genId()
    {
        $id = time() . '' . mt_rand();
        return (integer) $id;
    }

    public function role() {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function connections()
    {
        return $this->hasMany(UsersConnection::class, 'user_id', 'id');
    }

}
