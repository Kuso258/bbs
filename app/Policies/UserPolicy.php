<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser, User $user){
        //框架会自动加载当前登录用户 $currentUser
        if($currentUser->id === $user->id){
            return true;
        }
        return false;
    }
}
