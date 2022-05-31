<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Roles;

class UsersRoles extends Model {
    protected $table = 'users_roles';
    protected $primaryKey = null;
    public $timestamps  = false;
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public function setUpdatedAt($value)
    {
      return NULL;
    }

    public function setCreatedAt($value)
    {
      return NULL;
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role() {
        return $this->belongsTo(Roles::class, 'role_id');
    }

}