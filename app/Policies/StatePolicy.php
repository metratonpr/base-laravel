<?php

namespace App\Policies;

use App\Models\State;
use App\Models\User;

class StatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('state.view');
    }

    public function view(User $user, State $state): bool
    {
        return $user->can('state.view');
    }

    public function create(User $user): bool
    {
        return $user->can('state.create');
    }

    public function update(User $user, State $state): bool
    {
        return $user->can('state.update');
    }

    public function delete(User $user, State $state): bool
    {
        return $user->can('state.delete');
    }

    public function restore(User $user, State $state): bool
    {
        return $user->can('state.delete');
    }

    public function forceDelete(User $user, State $state): bool
    {
        return $user->can('state.delete');
    }
}
