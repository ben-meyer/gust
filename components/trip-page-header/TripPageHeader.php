<?php

namespace Gust\Components;

use Gust\ComponentBase;
use Theme\Utils\TripData;

class TripPageHeader extends ComponentBase
{
    protected static string $name = 'trip-page-header';

    public static function make(
        int $post_id = 0,
        array $classes = [],
        ...$others
    ): ?static {
        return static::createFromArgs(static::mergeArgs(get_defined_vars()));
    }

    protected static function transform(array $args): array
    {
        $postId = ! empty($args['post_id']) ? (int) $args['post_id'] : \get_the_ID();
        $post = \get_post($postId);

        if (! $post) {
            return $args;
        }

        $heading = \get_field('trip_heading', $postId);
        $description = \get_field('trip_description', $postId);
        $image = \get_field('trip_header_image', $postId);

        $imageId = $image['ID'] ?? $image['id'] ?? \get_post_thumbnail_id($postId);

        if (! empty($imageId)) {
            $args['image'] = Image::make(
                id: $imageId,
                size: 'gust_super',
                sizes: '100vw',
            );
        }

        $args['heading'] = $heading ?: $post->post_title;
        $args['description'] = $description ?? '';

        $args['summary_items'] = array_values(array_filter([
            [
                'icon' => 'calendar',
                'label' => TripData::getHeaderDateLabel($postId),
            ],
            [
                'icon' => 'location',
                'label' => TripData::getLocationLabel($postId),
            ],
            [
                'icon' => 'price',
                'label' => TripData::getPriceFromLabel($postId),
            ],
        ], fn ($item) => ! empty($item['label'])));

        $args['stats'] = array_values(array_filter([
            [
                'value' => ! empty($args['duration_nights']) ? $args['duration_nights'].' '.__('Nights', 'gust') : null,
                'label' => __('Duration', 'gust'),
            ],
            [
                'value' => self::formatRange($args['distance_min_km'] ?? null, $args['distance_max_km'] ?? null, 'km'),
                'label' => __('Distance per day', 'gust'),
            ],
            [
                'value' => self::formatRange($args['water_temp_min_c'] ?? null, $args['water_temp_max_c'] ?? null, '°C'),
                'label' => __('Water temperature', 'gust'),
            ],
            [
                'value' => $args['max_group_size'] ?? null,
                'label' => __('Max. group size', 'gust'),
            ],
            [
                'value' => TripData::getTaxonomyLabel($postId, 'skill_level'),
                'label' => __('Ability level', 'gust'),
            ],
            [
                'value' => TripData::getTaxonomyLabel($postId, 'swim_type'),
                'label' => __('Swim type', 'gust'),
            ],
            [
                'value' => $args['welcome_text'] ?? null,
                'label' => __('Welcome', 'gust'),
            ],
            [
                'value' => $args['technique_coaching_text'] ?? null,
                'label' => __('Technique coaching', 'gust'),
            ],
        ], fn ($item) => ! empty($item['value'])));

        return $args;
    }

    protected static function formatRange(mixed $min, mixed $max, string $suffix): ?string
    {
        if ($min === null && $max === null) {
            return null;
        }

        if ($min !== null && $max !== null) {
            if ((string) $min === (string) $max) {
                return $min.$suffix;
            }

            return $min.'-'.$max.$suffix;
        }

        return ($min ?? $max).$suffix;
    }
}
