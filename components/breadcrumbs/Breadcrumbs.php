<?php

namespace Gust\Components;

use Gust\Component;
use Gust\ComponentBase;

/**
 * Breadcrumbs Component
 *
 * Usage:
 *   use Gust\Components\Breadcrumbs;
 *
 *   echo Breadcrumbs::make();
 */
class Breadcrumbs extends ComponentBase
{
    protected static string $name = 'breadcrumbs';

    /**
     * Create a new Breadcrumbs component.
     *
     * When `back_link` is provided (an array with `url` and `label`),
     * the back-link is rendered in place of the Yoast breadcrumb trail.
     *
     * @return static|null Returns null if component should not render.
     */
    public static function make(
        array $classes = [],
        ?array $back_link = null,
        ...$others
    ): ?static {
        return static::createFromArgs(static::mergeArgs(get_defined_vars()));
    }
}
