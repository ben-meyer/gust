<?php

namespace Gust\Components;

use Gust\ComponentBase;

class CallToAction extends ComponentBase
{
    protected static string $name = 'call-to-action';

    protected static function getDefaults(): array
    {
        return [
            'heading' => 'Main Heading',
            'subheading' => 'Supporting Subheading',
            'cards' => [
                ['title' => 'Card 1'],
                ['title' => 'Card 2'],
                ['title' => 'Card 3'],
            ],
        ];
    }

    public static function make(
        string $heading = '',
        string $subheading = '',
        array $cards = [],
        array $classes = [],
        array $attributes = [],
        ...$others
    ): ?static {
        return static::createFromArgs(static::mergeArgs(get_defined_vars()));
    }

    protected static function transform(array $args): array
    {
        $args['classes'] = array_merge(['call-to-action'], $args['classes'] ?? []);
        $args['cards'] = array_slice($args['cards'] ?? [], 0, 3);

        while (count($args['cards']) < 3) {
            $args['cards'][] = ['title' => 'Card '.(count($args['cards']) + 1)];
        }

        return $args;
    }
}
