<?php

declare(strict_types=1);

namespace Momentum\Lock\Tests\Stubs;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $username
 */
class User extends Authenticatable
{
    protected $guarded = [];
}
