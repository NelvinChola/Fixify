<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
public function viewAny(User $user)
{
    return $user->role->name === 'admin';
}

public function create(User $user)
{
    return $user->role->name === 'admin';
}

public function update(User $user, Category $category)
{
    return $user->role->name === 'admin';
}

public function delete(User $user, Category $category)
{
    return $user->role->name === 'admin';
}
}
