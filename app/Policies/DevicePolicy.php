<?php

namespace App\Policies;

use App\Models\Device;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
{
    use HandlesAuthorization;


    // Determine whether the user can view any devices.
    public function viewAny(User $user)
    {
        return $this->isAdminOrHelpDesk($user);
    }


     // Determine whether the user can view the device.
    public function view(User $user, Device $device)
    {
        return $this->isAdminOrHelpDesk($user);
    }

    /**
     * Determine whether the user can create devices.
     */
    public function create(User $user)
    {
        return $this->isAdminOrHelpDesk($user);
    }

    /**
     * Determine whether the user can update the device.
     */
    public function update(User $user, Device $device)
    {
        return $this->isAdminOrHelpDesk($user);
    }

    /**
     * Determine whether the user can delete the device.
     */
    public function delete(User $user, Device $device)
    {
        return $this->isAdminOrHelpDesk($user);
    }

    /**
     * Determine whether the user can restore the device.
     */
    public function restore(User $user, Device $device)
    {
        return false; // Not implemented
    }

    /**
     * Determine whether the user can permanently delete the device.
     */
    public function forceDelete(User $user, Device $device)
    {
        return false; // Not implemented
    }


    //Helper function to check if the user is Admin or HelpDesk
    private function isAdminOrHelpDesk(User $user)
    {
        return $user->role && in_array($user->role->name, ['Admin', 'HelpDesk']);
    }
}
