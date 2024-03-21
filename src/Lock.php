<?php

declare(strict_types=1);

namespace Momentum\Lock;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Laravel\SerializableClosure\Support\ReflectionClosure;
use ReflectionClass;
use ReflectionMethod;

class Lock
{
    public static function getPermissions(mixed $model, ?array $abilities = null): array
    {
        $abilities ??= static::getAbilitiesFromPolicy($model);

        return collect($abilities)
            ->mapWithKeys(fn ($ability) => [$ability => Gate::allows($ability, $model)])
            ->toArray();
    }

    public static function getGlobalPermissions(?array $abilities = null): array
    {
        return collect(Gate::abilities())
            ->filter(function (Closure $closure, $ability) use ($abilities) {
                if ($abilities && ! in_array($ability, $abilities)) {
                    return false;
                }

                $reflection = new ReflectionClosure($closure);

                return $reflection->getNumberOfParameters() === 1;
            })
            ->mapWithKeys(fn (Closure $closure, $ability) => [$ability => Gate::check($ability)])
            ->toArray();
    }

    public static function getAbilitiesFromPolicy(Model $model): array
    {
        $policy = Gate::getPolicyFor($model);

        $reflection = new ReflectionClass($policy);

        return collect($reflection->getMethods(ReflectionMethod::IS_PUBLIC))
            ->filter(fn (ReflectionMethod $method) => !in_array($method->getName(), config('lock.ignore_abilities', [])))
            ->map(fn (ReflectionMethod $method) => $method->getName())
            ->toArray();
    }
}
