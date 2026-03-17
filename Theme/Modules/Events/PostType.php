<?php

namespace Theme\Modules\Events;

class PostType
{
    protected const SLUG = 'event';

    public static function init(): void
    {
        \add_action('init', [__CLASS__, 'register']);
        \add_filter('gust/templates/post-types', [__CLASS__, 'filterGustTemplatesPostTypes']);
    }

    public static function register(): void
    {
        if (! function_exists('register_extended_post_type')) {
            return;
        }

        \register_extended_post_type(self::SLUG, [
            'public' => true,
            'has_archive' => true,
            'hierarchical' => false,
            'show_in_rest' => true,
            'menu_position' => 6,
            'menu_icon' => 'dashicons-calendar-alt',
            'enter_title_here' => 'Event Name',
            'supports' => [
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'revisions',
                'custom-fields',
            ],
            'taxonomies' => [
                'trip_style',
                'swim_type',
                'skill_level',
                'country',
                'city',
            ],
            'admin_filters' => [
                'trip_style' => ['taxonomy' => 'trip_style'],
                'swim_type' => ['taxonomy' => 'swim_type'],
                'country' => ['taxonomy' => 'country'],
            ],
            'admin_cols' => [
                'thumbnail' => [
                    'title' => 'Thumbnail',
                    'featured_image' => 'thumbnail',
                    'width' => 80,
                    'height' => 80,
                ],
                'title' => ['title' => 'Title'],
                'country' => ['taxonomy' => 'country'],
                'city' => ['taxonomy' => 'city'],
                'trip_style' => ['taxonomy' => 'trip_style'],
                'swim_type' => ['taxonomy' => 'swim_type'],
                'updated' => [
                    'title' => 'Updated',
                    'post_field' => 'post_modified',
                    'date_format' => 'Y/m/d',
                ],
            ],
        ], [
            'singular' => __('Event', 'gust'),
            'plural' => __('Events', 'gust'),
            'slug' => self::SLUG,
        ]);
    }

    public static function filterGustTemplatesPostTypes(array $postTypes): array
    {
        $postTypes[] = self::SLUG;

        return $postTypes;
    }
}
