<?php

declare(strict_types=1);

namespace Momentum\Lock\Data;

use Illuminate\Database\Eloquent\Model;
use Momentum\Lock\Lock;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Wrapping\WrapExecutionType;

class DataResource extends Data
{
    protected ?Model $model;

    /** @var array|null */
    protected $permissions = null;

    public static function from(mixed ...$payloads): static
    {
        /** @var static $data */
        $data = parent::from(...$payloads);

        if (count($payloads) === 1 && $payloads[0] instanceof Model) {
            $data->setModel($payloads[0]);
        }

        return $data;
    }

    protected function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    protected function appendPermissions(): void
    {
        if (isset($this->model)) {
            $this->additional([
                'permissions' => Lock::getPermissions($this->model, $this->permissions),
            ]);
        }
    }

    public function transform(
        bool $transformValues = true,
        WrapExecutionType $wrapExecutionType = WrapExecutionType::Disabled,
        bool $mapPropertyNames = true,
    ): array {
        $this->appendPermissions();

        return parent::transform($transformValues, $wrapExecutionType, $mapPropertyNames);
    }
}
