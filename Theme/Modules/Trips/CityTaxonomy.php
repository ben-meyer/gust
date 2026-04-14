<?php

namespace Theme\Modules\Trips;

class CityTaxonomy
{
    protected const SLUG = 'city';

    public static function init(): void
    {
        \add_action('init', [__CLASS__, 'register']);
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
                'public' => false,
                'rewrite' => false,
            ],
            [
                'singular' => __('City', 'gust'),
                'plural' => __('Cities', 'gust'),
                'slug' => 'city',
            ]
        );
    }
}
