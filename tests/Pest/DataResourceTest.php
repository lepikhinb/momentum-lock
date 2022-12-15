<?php

use Momentum\Lock\Tests\Stubs\UserData;
use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertArrayHasKey;
use function PHPUnit\Framework\assertEquals;

test('data resource can append permissions', function () {
    $user = user();

    actingAs($user);

    $data = UserData::from($user);

    $assertionMap = [
        'viewAny' => true,
        'view' => false,
        'create' => true,
        'update' => true,
        'delete' => false,
    ];

    assertArrayHasKey('permissions', $data->toArray());

    foreach ($assertionMap as $ability => $value) {
        assertEquals($value, $data->toArray()['permissions'][$ability]);
    }
});
