<?php

namespace Theme\Controllers;

use Gust\Components\Cards;
use Gust\Components\NoContent;

class TripStylesController
{
    public static function renderContent(): string
    {
        $terms = \get_terms([
            'taxonomy' => 'trip_style',
            'hide_empty' => false,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ]);

        if (\is_wp_error($terms) || empty($terms)) {
            return (string) NoContent::make();
        }

        $items = array_map(fn ($term) => ['object' => $term], $terms);

        \ob_start();
        echo Cards::make(
            items: $items,
            image_size: 'gust_card_square',
        );

        return \ob_get_clean();
    }
}
