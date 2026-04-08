<?php

namespace Gust\Components;

use Gust\ComponentBase;

class CallToAction extends ComponentBase
{
    protected static string $name = 'call-to-action';

    public static function make(
        array $classes = [],
        ...$others
    ): ?static {
        return static::createFromArgs(static::mergeArgs(get_defined_vars()));
    }

    protected static function transform(array $args): array
    {
        $args['classes'] = array_merge(['call-to-action'], $args['classes'] ?? []);

        return $args;
    }
}
