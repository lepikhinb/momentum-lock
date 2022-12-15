<?php

declare(strict_types=1);

namespace Momentum\Lock\TypeScript;

use Momentum\Lock\Lock;
use ReflectionClass;
use Spatie\LaravelData\Support\TypeScriptTransformer\DataTypeScriptTransformer;
use Spatie\TypeScriptTransformer\Structures\MissingSymbolsCollection;

class DataResourceTransformer extends DataTypeScriptTransformer
{
    protected function transformExtra(
        ReflectionClass $class,
        MissingSymbolsCollection $missingSymbols,
    ): string {
        $abilities = $class->getProperty('permissions')->getDefaultValue();

        if (! $abilities) {
            $modelClass = $class->getProperty('modelClass')->getDefaultValue();

            /** @var \Illuminate\Database\Eloquent\Model $model */
            $model = new $modelClass;

            $abilities = Lock::getAbilitiesFromPolicy($model);
        }

        $permissions = collect($abilities)
            ->map(fn ($permission) => "{$permission}: boolean")
            ->join(';');

        return 'permissions: { ' . $permissions . ' } ';
    }
}
