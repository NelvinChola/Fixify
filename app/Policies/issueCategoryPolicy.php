<?php

namespace App\Policies;
use App\Models\issueCategory;
use App\Models\User;


class issueCategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
{
    return $user->role->name === 'Admin';
}

public function create(User $user)
{
    return $user->role->name === 'Admin';
}

public function update(User $user, issueCategory $issueCategory)
{
    return $user->role->name === 'Admin';
}

public function delete(User $user, issueCategory $issueCategory)
{
    return $user->role->name === 'Admin';
}
}
