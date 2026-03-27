<?php

namespace Theme\Modules\Trips;

class PostType
{
    protected const SLUG = 'trip';

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
            'has_archive' => false,
            'hierarchical' => false,
            'show_in_rest' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-palmtree',
            'enter_title_here' => 'Trip Name',
            'supports' => [
                'title',
                'editor',
                'excerpt',
                'thumbnail',
                'revisions',
                'custom-fields',
                'slug',
            ],
            'taxonomies' => [
                'trip_style',
                'skill_level',
                'swim_type',
                'country',
                'city',
            ],
            // Template is fully locked. Add new blocks here as they are built.
            // The core/group in the middle is a free editing zone for body content.
            // To add a new block to the template, append it to this array:
            //   ['acf/your-block', []],
            'template' => [
                ['acf/page-header', []],
                ['core/group', [
                    'className' => 'trip-body',
                    'layout' => ['type' => 'constrained'],
                ], []],
                ['acf/trip-dates', []],
            ],
            'template_lock' => 'all',
            'admin_filters' => [
                'trip_style' => ['taxonomy' => 'trip_style'],
                'country' => ['taxonomy' => 'country'],
                'swim_type' => ['taxonomy' => 'swim_type'],
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
            'singular' => __('Trip', 'gust'),
            'plural' => __('Trips', 'gust'),
            'slug' => self::SLUG,
        ]);
    }

    public static function filterGustTemplatesPostTypes(array $postTypes): array
    {
        $postTypes[] = self::SLUG;

        return $postTypes;
    }
}
