<?php

namespace Gust\Components;

use Gust\Component;
use Gust\ComponentBase;

/**
 * Cards Component
 *
 * Usage:
 *   use Gust\Components\Cards;
 *
 *   echo Cards::make();
 */
class Cards extends ComponentBase
{
    protected static string $name = 'cards';

    protected static function getDefaults(): array
    {
        return [
            'type' => 'default',
            'align' => 'full',
        ];
    }

    /**
     * Create a new Cards component.
     *
     * @return static|null Returns null if component should not render.
     */
    public static function make(
        ?string $type = null,
        array $items = [],
        mixed $link = null,
        ?string $align = null,
        array $classes = [],
        ?string $columns = null,
        ?string $card_type = null,
        ?bool $slider_on_mobile = null,
        ...$others
    ): ?static {
        return static::createFromArgs(static::mergeArgs(get_defined_vars()));
    }

    protected static function transform(array $args): array
    {
        if (! empty($args['card_source'])) {
            if ($args['card_source'] === 'custom') {
                if (! empty($args['custom_cards'])) {
                    foreach ($args['custom_cards'] as $card) {
                        $args['items'][] = ['content' => $card];
                    }
                }
            } else {
                if ($args['card_source'] === 'recent') {
                    $query = [
                        'post_type' => $args['post_type'],
                        'posts_per_page' => $args['limit'],
                        'exclude' => get_the_ID(),
                        'no_found_rows' => true,
                        'ignore_sticky_posts' => true,
                    ];

                    if (! empty($args['tag'])) {
                        $query['tag__in'] = $args['tag'];
                    }

                    $query = new \WP_Query($query);
                    $objects = $query->posts;
                } elseif ($args['card_source'] === 'selected') {
                    $objects = $args['selected'];
                } elseif ($args['card_source'] === 'trip_styles') {
                    if (! empty($args['selected_trip_styles'])) {
                        $objects = $args['selected_trip_styles'];
                    } else {
                        $objects = get_terms([
                            'taxonomy' => 'trip_style',
                            'hide_empty' => false,
                        ]);
                    }
                } elseif ($args['card_source'] === 'destinations') {
                    if (! empty($args['selected_destinations'])) {
                        $objects = $args['selected_destinations'];
                    } else {
                        $objects = get_terms([
                            'taxonomy' => 'country',
                            'hide_empty' => false,
                        ]);
                    }
                }

                if (! empty($objects)) {
                    foreach ($objects as $key => $object) {
                        $args['items'][$key] = ['object' => $object];
                    }
                }
            }
        }

        if (! empty($args['type']) && $args['type'] === 'horizontal') {
            $args['card_type'] = 'horizontal';
            $args['columns'] = '2';
        }

        if (! empty($args['button'])) {
            $args['button']['classes'] = ['btn', 'color-context-white'];
        }

        if (! empty($args['items'])) {
            foreach ($args['items'] as $key => $card) {
                $args['items'][$key] = array_merge(['type' => $args['card_type'] ?? ''], $args['items'][$key]);

                if (\Gust\Helpers::isTaxonomy()) {
                    $args['items'][$key]['classes'][] = 'align-none';
                }

                if (! empty($args['card_background_color']) && $args['card_background_color'] !== 'default') {
                    $args['items'][$key]['background'] = $args['card_background_color'];
                }

                if (! empty($args['card_image_fit']) && $args['card_image_fit'] !== 'default') {
                    $args['items'][$key]['image_fit'] = $args['card_image_fit'];
                }

                if (
                    ($args['card_source'] ?? null) === 'custom'
                    && ! empty($args['items'][$key]['content']['image'])
                    && empty($args['items'][$key]['image_size'])
                ) {
                    $args['items'][$key]['image_size'] = 'gust_card_square';
                }

                if ($args['type'] === 'horizontal') {
                    $args['items'][$key]['show_read_more'] = false;
                }
            }
        }

        if (! empty($args['columns']) && $args['columns'] !== 'default') {
            $args['classes'][] = 'cards--columns-'.$args['columns'];
        }

        $args['classes'][] = 'cards--type--'.($args['type'] ?? 'default');
        $args['classes'][] = ($args['card_source'] ?? null) === 'custom' ? 'cards--source--custom' : null;
        $args['classes'][] = ! empty($args['slider_on_mobile']) ? 'cards--slider-on-mobile' : null;

        return $args;
    }
}
