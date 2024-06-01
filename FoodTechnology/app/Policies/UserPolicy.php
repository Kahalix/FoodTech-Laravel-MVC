<?php

namespace App\Policies;

use App\Models\employees;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user is an admin.
     */
    public function isAdmin(employees $user)
    {
        return $user->position === 'admin';
    }

    /**
     * Determine if the user is a secretary.
     */
    public function isSecretary(employees $user)
    {
        return $user->position === 'secretary';
    }

    /**
     * Determine if the user is a manager.
     */
    public function isManager(employees $user)
    {
        return $user->position === 'manager';
    }

    /**
     * Determine if the user is an employee.
     */
    public function isFoodTechnologist(employees $user)
    {
        return $user->position === 'food_technologist';
    }
}
