<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('company.view');
    }

    public function view(User $user, Company $company): bool
    {
        return $user->can('company.view');
    }

    public function create(User $user): bool
    {
        return $user->can('company.create');
    }

    public function update(User $user, Company $company): bool
    {
        return $user->can('company.update');
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->can('company.delete');
    }

    public function restore(User $user, Company $company): bool
    {
        return $user->can('company.delete');
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return $user->can('company.delete');
    }
}
