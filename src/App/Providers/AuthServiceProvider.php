<?php

namespace Potassium\App\Providers;

use Potassium\App\Entities\User;
use Potassium\App\Entities\Traduction;
use Potassium\App\Policies\UserPolicy;
use Potassium\App\Policies\TraductionPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Traduction::class => TraductionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
