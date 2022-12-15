<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Gate;
use Momentum\Lock\Lock;
use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

test('global gates can be handled', function () {
    $user = user();

    actingAs($user);

    $assertionMap = [
        'true' => assertTrue(...),
        'false' => assertFalse(...),
        'conditionable-true' => assertTrue(...),
        'conditionable-false' => assertFalse(...),
        'with-argument-true' => assertTrue(...),
        'with-argument-false' => assertFalse(...),
    ];

    $permissions = Lock::getGlobalPermissions();

    foreach ($permissions as $permission => $value) {
        return $assertionMap[$permission]($value);
    }

    foreach ($assertionMap as $permission => $assert) {
        $assert(Gate::check($permission));
    }

    foreach (array_keys($permissions) as $permission) {
        $assert = $assertionMap[$permission];

        $assert(Gate::check($permission));
    }
});
