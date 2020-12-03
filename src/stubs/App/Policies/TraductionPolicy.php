<?php

namespace App\Policies;

use Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TraductionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Entities\User  $user
     *
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->canManage('traductions');
    }
}
