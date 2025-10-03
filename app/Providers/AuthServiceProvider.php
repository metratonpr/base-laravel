<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Group;
use App\Models\Municipality;
use App\Models\State;
use App\Policies\CompanyPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\GroupPolicy;
use App\Policies\MunicipalityPolicy;
use App\Policies\StatePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /** @var array<class-string, class-string> */
    protected $policies = [
        Group::class => GroupPolicy::class,
        State::class => StatePolicy::class,
        Municipality::class => MunicipalityPolicy::class,
        Company::class => CompanyPolicy::class,
        Customer::class => CustomerPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
