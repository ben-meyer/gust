<?php

namespace Gust\Components;

use Gust\Component;
use Gust\ComponentBase;

/**
 * Image Component
 *
 * Usage:
 *   use Gust\Components\Image;
 *
 *   echo Image::make();
 */
class Image extends ComponentBase
{
    protected static string $name = 'image';

    protected static function getDefaults(): array
    {
        return [
            'size' => 'medium_large',
        ];
    }

    /**
     * Create a new Image component.
     *
     * @return static|null Returns null if component should not render.
     */
    public static function make(
        array $classes = [],
        mixed $id = null,
        ?string $title = null,
        ?string $alt = null,
        ?string $size = null,
        array $attributes = [],
        ...$others
    ): ?static {
        return static::createFromArgs(static::mergeArgs(get_defined_vars()));
    }

    protected static function transform(array $args): array
    {
        if (! empty($args['ID'])) {
            $args['id'] = $args['ID'];
        }

        if (! empty($args['sizes']) && ! is_array($args['sizes'])) {
            $args['attributes']['sizes'] = $args['sizes'];
        }

        // Check if 'full_width' class is present or size is set to 'full_width'
        $isFullWidth = isset($args['size']) && $args['size'] === 'full_width';
        if (! $isFullWidth && ! empty($args['classes']) && in_array('full_width', $args['classes'])) {
            $isFullWidth = true;
            $args['size'] = 'full_width'; // Ensure WP uses the registered size
        }

        if ($isFullWidth) {
            // Ensure registered image size and forced 600px height styling.
            $args['size'] = 'full_width';

            $existingClass = trim($args['attributes']['class'] ?? '');
            $args['attributes']['class'] = trim(($existingClass ? $existingClass . ' ' : '') . 'h-[600px] object-cover block');

            $existingStyle = trim($args['attributes']['style'] ?? '');
            $args['attributes']['style'] = trim(($existingStyle ? $existingStyle . '; ' : '') . 'position:relative;left:50%;margin-left:-50vw;width:100vw;max-width:100vw;min-width:100vw;height:min(600px,100vw);object-fit:cover;display:block;');

            if (empty($args['attributes']['sizes'])) {
                $args['attributes']['sizes'] = '100vw';
            }
        }

        if (! empty($args['id'])) {
            $args['output'] = wp_get_attachment_image(
                $args['id'],
                $args['size'],
                false,
                $args['attributes']
            );
        }

        return $args;
    }
}
