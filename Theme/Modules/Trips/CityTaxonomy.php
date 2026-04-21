<?php

namespace Theme\Modules\Trips;

class CityTaxonomy
{
    protected const SLUG = 'city';

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
                'rewrite' => ['slug' => 'cities'],
            ],
            [
                'singular' => __('City', 'gust'),
                'plural' => __('Cities', 'gust'),
                'slug' => 'cities',
            ]
        );
    }

    public static function filterGustTemplatesTaxonomies(array $taxonomies): array
    {
        $taxonomies[] = self::SLUG;

        return $taxonomies;
    }
}
