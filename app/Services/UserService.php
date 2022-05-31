<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function existPhone($phone)
    {
        return $this->model::where('phone', $phone)->count();
    }

}
