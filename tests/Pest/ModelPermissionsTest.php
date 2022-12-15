<?php

use Momentum\Lock\Lock;
use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertArrayNotHasKey;
use function PHPUnit\Framework\assertEquals;

test('get all permissions for a model from its policy', function () {
    $user = user();

    actingAs($user);

    $permissions = Lock::getPermissions($user);

    $abilities = ['viewAny', 'view', 'create', 'update', 'delete'];

    foreach ($abilities as $ability) {
        assertArrayHasKey($ability, $permissions);
    }
});

test('get some permissions for a model', function () {
    $user = user();

    actingAs($user);

    $abilities = ['view', 'create'];

    $permissions = Lock::getPermissions($user, $abilities);

    assertArrayNotHasKey('viewAny', $permissions);

    foreach ($abilities as $ability) {
        assertArrayHasKey($ability, $permissions);
    }
});

test('the helper returns actual authorizations', function () {
    $user = user();

    actingAs($user);

    $assertionMap = [
        'viewAny' => true,
        'view' => false,
        'create' => true,
        'update' => true,
        'delete' => false,
    ];

    $permissions = Lock::getPermissions($user);

    foreach ($assertionMap as $ability => $value) {
        assertEquals($value, $permissions[$ability]);
    }
});
