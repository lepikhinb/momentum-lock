<?php

declare(strict_types=1);

namespace Momentum\Lock\Tests\Stubs;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, User $model)
    {
        return false;
    }

    public function create(User $user)
    {
        return $user->username == 'test-user';
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model)
    {
        return $user->id !== $model->id;
    }
}
