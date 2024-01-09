<?php

declare(strict_types=1);

namespace Momentum\Lock;

use Illuminate\Support\ServiceProvider;

class LockServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/lock.php',
            'lock'
        );
    }
    
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/lock.php' => config_path('lock.php'),
        ], 'lock-config');
    }
}
