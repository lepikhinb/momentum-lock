<?php

namespace Momentum\Lock\Tests\Stubs;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('true', function (User $user) {
            return true;
        });

        Gate::define('false', function (User $user) {
            return false;
        });

        Gate::define('conditionable-true', function (User $user) {
            return $user->username == 'test-user';
        });

        Gate::define('conditionable-false', function (User $user) {
            return $user->username == 'test-user--2-2-2';
        });

        Gate::define('with-argument-true', function (User $user, string $argument) {
            return true;
        });

        Gate::define('with-argument-false', function (User $user, string $argument) {
            return false;
        });
    }
}
