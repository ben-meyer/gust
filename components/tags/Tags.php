<?php

namespace Gust\Components;

use Gust\ComponentBase;

class Tags extends ComponentBase
{
    protected static string $name = 'tags';

    public static function make(
        array $classes = [],
        ...$others
    ): ?static {
        return static::createFromArgs(static::mergeArgs(get_defined_vars()));
    }

    protected static function transform(array $args): array
    {
        $args['classes'] = array_merge(['tags'], $args['classes'] ?? []);

        return $args;
    }
}
