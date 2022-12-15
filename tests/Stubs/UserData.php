<?php

namespace Momentum\Lock\Tests\Stubs;

use Momentum\Lock\Data\DataResource;

class UserData extends DataResource
{
    public function __construct(
        public int $id,
        public string $username
    ) {
    }
}
