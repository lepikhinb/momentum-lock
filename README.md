# Momentum Lock

Momentum Lock is a Laravel package that lets you handle Laravel authorizations on the frontend level.

The package is only intended to work with [Laravel Data](https://github.com/spatie/laravel-data) objects and [TypeScript Transformer](https://github.com/spatie/laravel-typescript-transformer).

- [**Installation**](#installation)
  - [**Laravel**](#laravel)
  - [**Frontend**](#frontend)
- [**Usage**](#usage)
- [**Advanced Inertia**](#advanced-inertia)
- [**Momentum**](#momentum)

## Installation

### Laravel

Install the package into your Laravel app.

```bash
composer require based/momentum-lock
```

### Frontend

The frontend package is framework-agnostic and will work great within any TypeScript-powered workflow.

Install the [frontend package](https://github.com/lepikhinb/momentum-lock-helper).

```bash
npm i momentum-lock
# or
yarn add momentum-lock
```

## Usage

Extend your data classes from `DataResource` instead of `Data` provided by [Laravel Data](https://github.com/spatie/laravel-data).

```php
use Momentum\Lock\Data\DataResource;

class UserData extends DataResource
{
    public function __construct(
        public int $id,
        public string $username
    ) {
    }
}
```

You can either specify the list of abilities manually, or let the package resolve them from the corresponding policy class.

```php
class UserData extends DataResource
{
    protected $permissions = ['update', 'delete'];
}
```

Register `DataResourceCollector` in the TypeScript Transformer configuration file — `typescript-transformer.php`. This class helps TypeScript Transformer handle `DataResource` classes and append permissions to generated TypeScript definitions.

```diff
return [
    'collectors' => [
+       Momentum\Lock\TypeScript\DataResourceCollector::class,
        Spatie\TypeScriptTransformer\Collectors\DefaultCollector::class,
        Spatie\LaravelData\Support\TypeScriptTransformer\DataTypeScriptCollector::class,
    ],
]
```

On the frontend, you can use the helper `can`. This function checks whether the required permission is set to true on the passed object, and can be used in both scripts or templates.

```vue
<script lang="ts" setup>
import { can } from "momentum-lock"

const props = defineProps<{
  users: UserData[]
}>()
</script>

<template>
  <div v-for="user in users" :key="user.id">
    <a v-if="can(user, 'edit')" :href="route('users.edit', user)"> Edit </a>
  </div>
</template>
```

## Advanced Inertia

[<img src="https://advanced-inertia.com/og5.png" width="420px" />](https://advanced-inertia.com)

Make Inertia-powered frontend a breeze to build and maintain with my upcoming book [Advanced Inertia](https://advanced-inertia.com/). Join the waitlist and get **20% off** when the book is out.

## Momentum

Momentum is a set of packages designed to bring back the feeling of working on a single codebase to Inertia-powered apps.

- [Modal](https://github.com/lepikhinb/momentum-modal) — Build dynamic modal dialogs for Inertia apps
- [Preflight](https://github.com/lepikhinb/momentum-preflight) — Realtime backend-driven validation for Inertia apps
- [Paginator](https://github.com/lepikhinb/momentum-paginator) — Headless wrapper around Laravel Pagination
- [Trail](https://github.com/lepikhinb/momentum-trail) — Frontend package to use Laravel routes with Inertia
- [Lock](https://github.com/lepikhinb/momentum-lock) — Frontend package to use Laravel permissions with Inertia _(coming soon)_
- [Vite Plugin Watch](https://github.com/lepikhinb/vite-plugin-watch) — Vite plugin to run shell commands on file changes

## Credits

- [Boris Lepikhin](https://twitter.com/lepikhinb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
