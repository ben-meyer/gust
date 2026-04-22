<?php

namespace Theme\Controllers;

use Gust\Components\CalendarListings;
use Gust\Components\NoContent;
use Theme\Utils\TripData;

class CalendarController
{
    public static function renderContent(): string
    {
        $postIds = \get_posts([
            'post_type' => 'trip',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'fields' => 'ids',
            'no_found_rows' => true,
            'update_post_meta_cache' => true,
            'update_post_term_cache' => true,
            'suppress_filters' => false,
        ]);

        if (empty($postIds)) {
            return (string) NoContent::make();
        }

        \update_meta_cache('post', $postIds);

        $today = \current_time('Y-m-d');
        $items = [];

        foreach ($postIds as $postId) {
            $postId = (int) $postId;
            $dateRow = static::getNearestUpcomingDateRow($postId, $today);

            if ($dateRow === null) {
                continue;
            }

            $items[] = [
                'object' => \get_post($postId),
                'date_row' => $dateRow,
                'timestamp' => (int) \strtotime($dateRow['start_date']),
            ];
        }

        if (empty($items)) {
            return (string) NoContent::make();
        }

        \usort($items, static fn (array $a, array $b) => [$a['timestamp'], $a['object']->post_title] <=> [$b['timestamp'], $b['object']->post_title]);

        // Group by month
        $groups = [];

        foreach ($items as $item) {
            $key = \date_i18n("F 'y", $item['timestamp']);

            if (! isset($groups[$key])) {
                $groups[$key] = [
                    'heading' => $key,
                    'items' => [],
                ];
            }

            $groups[$key]['items'][] = $item;
        }

        return (string) CalendarListings::make(
            groups: array_values($groups),
        );
    }

    /**
     * Get the nearest upcoming date row for a trip.
     */
    protected static function getNearestUpcomingDateRow(int $postId, string $today): ?array
    {
        $rows = TripData::getDateRows($postId);
        $nearest = null;

        foreach ($rows as $row) {
            if (empty($row['start_date']) || $row['start_date'] < $today) {
                continue;
            }

            if ($nearest === null || $row['start_date'] < $nearest['start_date']) {
                $nearest = $row;
            }
        }

        return $nearest;
    }
}
