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

    /**
     * user edit info
     * @param  User   $currentUser [description]
     * @param  User   $user        [description]
     * @return [type]              [description]
     */
    public function update(User $currentUser, User $user){
        return $currentUser->id === $user->id;
    }

    /**
     * admin user destroy simple user
     * @var [type]
     */
    public function destroy(User $currentUser, User $user){
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
