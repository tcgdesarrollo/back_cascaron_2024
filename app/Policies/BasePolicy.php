<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Model;
use App\Models\User;

class BasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(($this->get_permission(__FUNCTION__)), 'api');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Model $model): bool
    {
        return $user->hasPermissionTo($this->get_permission(__FUNCTION__), 'api');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo($this->get_permission(__FUNCTION__), 'api');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Model $model): bool
    {
        return $user->hasPermissionTo($this->get_permission(__FUNCTION__), 'api');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Model $model): bool
    {
        return $user->hasPermissionTo($this->get_permission(__FUNCTION__), 'api');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Model $model): bool
    {
        return $user->hasPermissionTo($this->get_permission(__FUNCTION__), 'api');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Model $model): bool
    {
        return $user->hasPermissionTo($this->get_permission(__FUNCTION__), 'api');
    }

    /**
     * Return the standard name permission for the current class and gate.
     * @param string $functionName name of the caller function
     * @return string The resulting standard permission name
     */
    protected function get_permission(string $functionName): string
    {
        return str_replace(
            'Policy',
            '',
            ((new \ReflectionClass($this))->getShortName())
        ) . ': ' . $functionName;
    }
}
