<?php

namespace Theme\Modules\Trips;

class TripLookup
{
    /**
     * Find published Trip posts that reference a given post via an ACF post_object field.
     *
     * @return \WP_Post[]
     */
    public static function findTripsByRelation(int $post_id, string $field): array
    {
        if ($post_id <= 0 || $field === '') {
            return [];
        }

        $query = new \WP_Query([
            'post_type' => 'trip',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'no_found_rows' => true,
            'fields' => 'all',
            'meta_query' => [
                [
                    'key' => $field,
                    'value' => (string) $post_id,
                    'compare' => '=',
                ],
            ],
        ]);

        return $query->posts;
    }
}
