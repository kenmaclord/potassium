<?php

namespace Potassium\App\Policies;

use Potassium\App\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage the model.
     *
     * @param  \Entities\User  $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->canManage('users');
    }
}