<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
public function viewAny(User $user)
{
    return $user->role->name === 'Admin';
}

public function create(User $user)
{
    return $user->role->name === 'Admin';
}

public function update(User $user, Category $category)
{
    return $user->role->name === 'Admin';
}

public function delete(User $user, Category $category)
{
    return $user->role->name === 'Admin';
}
}
