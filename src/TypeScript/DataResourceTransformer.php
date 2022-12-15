<?php

declare(strict_types=1);

namespace Momentum\Lock\TypeScript;

use ReflectionClass;
use Spatie\LaravelData\Support\TypeScriptTransformer\DataTypeScriptTransformer;
use Spatie\TypeScriptTransformer\Structures\MissingSymbolsCollection;

class DataResourceTransformer extends DataTypeScriptTransformer
{
    protected function transformExtra(
        ReflectionClass $class,
        MissingSymbolsCollection $missingSymbols,
    ): string {
        $permissions = collect($class->getProperty('permissions')->getDefaultValue())
            ->map(fn ($permission) => "{$permission}: boolean")
            ->join(';');

        return 'permissions: { ' . $permissions . ' } ';
    }
}
