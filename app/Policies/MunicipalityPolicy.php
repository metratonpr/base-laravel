<?php

namespace App\Policies;

use App\Models\Municipality;
use App\Models\User;

class MunicipalityPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('municipality.view');
    }

    public function view(User $user, Municipality $municipality): bool
    {
        return $user->can('municipality.view');
    }

    public function create(User $user): bool
    {
        return $user->can('municipality.create');
    }

    public function update(User $user, Municipality $municipality): bool
    {
        return $user->can('municipality.update');
    }

    public function delete(User $user, Municipality $municipality): bool
    {
        return $user->can('municipality.delete');
    }

    public function restore(User $user, Municipality $municipality): bool
    {
        return $user->can('municipality.delete');
    }

    public function forceDelete(User $user, Municipality $municipality): bool
    {
        return $user->can('municipality.delete');
    }
}
