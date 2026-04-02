<?php

namespace Gust\Components;

use Gust\ComponentBase;

class Gallery extends ComponentBase
{
    protected static string $name = 'gallery';

    public static function make(
        array $classes = [],
        ...$others
    ): ?static {
        return static::createFromArgs(static::mergeArgs(get_defined_vars()));
    }

    protected static function transform(array $args): array
    {
        $args['classes'] = array_merge(['gallery'], $args['classes'] ?? []);

        return $args;
    }
}
