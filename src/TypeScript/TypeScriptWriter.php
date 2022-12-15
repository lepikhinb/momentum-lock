<?php

declare(strict_types=1);

namespace Momentum\Lock\TypeScript;

use Spatie\TypeScriptTransformer\Structures\TypesCollection;
use Spatie\TypeScriptTransformer\Writers\TypeDefinitionWriter;

class TypeScriptWriter extends TypeDefinitionWriter
{
    public function format(TypesCollection $collection): string
    {
        $output = parent::format($collection);

        return str($output)
            ->replace('App.', '')
            ->toString();
    }
}
