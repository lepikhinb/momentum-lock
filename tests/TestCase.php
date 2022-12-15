<?php

declare(strict_types=1);

namespace Momentum\Lock\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Momentum\Lock\LockServiceProvider;
use Momentum\Lock\Tests\Stubs\AuthServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends TestbenchTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function defineDatabaseMigrations()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->timestamps();
        });

        Schema::create('tweets', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->string('body');
            $table->timestamps();
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            AuthServiceProvider::class,
            LockServiceProvider::class,
            LaravelDataServiceProvider::class,
        ];
    }
}
