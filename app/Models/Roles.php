<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UsersRoles;

class Roles extends Model {
    protected $table = 'roles';
    protected $fillable = [
        'roles',
        'is_active'
    ];

    public function users() {
        return $this->hasMany(UsersRoles::class, 'role_id', 'id');
    }

}