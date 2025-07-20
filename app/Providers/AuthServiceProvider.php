<?php

namespace App\Providers;

use App\Models\User; // Import User model
use App\Policies\UserPolicy; // Import UserPolicy (if it exists)
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class, // Link User model to UserPolicy
         Category::class => CategoryPolicy::class,
    ];

    


    public function boot(): void
    {
        $this->registerPolicies();

        // Define Gates (Permissions)
        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin(); // Example: Only admins can view users
        });

        // Gate::define('create-users', function (User $user) {
        //     return $user->isAdmin(); // Example: Only admins can create users
        // });

          Gate::define('create-categories', function (User $user) {
            return $user->isAdmin(); // Example: Only admins can create users
        });

             Gate::define('view-categories', function (User $user) {
            return $user->isAdmin(); // Example: Only admins can create users
        });


           // gate for product management
        Gate::define('manage-products', function ($user) {
        return in_array($user->role->name, ['admin', 'manager']);

    });


     // Define your gates here if needed
        Gate::define('manage-users', function ($user) {
            return $user->isAdmin(); // Adjust according to your user model
        });
    }
}