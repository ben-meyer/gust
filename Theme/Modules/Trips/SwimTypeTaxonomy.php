<?php

namespace Theme\Modules\Trips;

class SwimTypeTaxonomy
{
    protected const SLUG = 'swim_type';

    public static function init(): void
    {
        \add_action('init', [__CLASS__, 'register']);
        \add_filter('gust/templates/taxonomies', [__CLASS__, 'filterGustTemplatesTaxonomies']);
    }

    public static function register(): void
    {
        if (! function_exists('register_extended_taxonomy')) {
            return;
        }

        \register_extended_taxonomy(
            self::SLUG,
            ['trip', 'event'],
            [
                'hierarchical' => false,
                'show_admin_column' => true,
                'show_in_rest' => true,
                'meta_box' => 'simple',
                'rewrite' => ['slug' => 'swim-type'],
            ],
            [
                'singular' => __('Swim Type', 'gust'),
                'plural' => __('Swim Types', 'gust'),
                'slug' => 'swim-type',
            ]
        );
    }

    public static function filterGustTemplatesTaxonomies(array $taxonomies): array
    {
        $taxonomies[] = self::SLUG;

        return $taxonomies;
    }
}
