<?php

namespace Theme\Controllers;

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
            'update_post_term_cache' => false,
            'suppress_filters' => false,
        ]);

        if (empty($postIds)) {
            return '';
        }

        \update_meta_cache('post', $postIds);

        $today = \current_time('Y-m-d');
        $items = [];

        foreach ($postIds as $postId) {
            $nearestDate = static::getNearestUpcomingDate((int) $postId, $today);

            if ($nearestDate === null) {
                continue;
            }

            $items[] = [
                'post_id' => (int) $postId,
                'title' => \get_the_title($postId),
                'url' => \get_permalink($postId),
                'date' => $nearestDate,
                'timestamp' => (int) \strtotime($nearestDate),
            ];
        }

        if (empty($items)) {
            return '';
        }

        \usort($items, static function (array $left, array $right): int {
            return [$left['timestamp'], $left['title']] <=> [$right['timestamp'], $right['title']];
        });

        $grouped = [];

        foreach ($items as $item) {
            $year = \gmdate('Y', $item['timestamp']);
            $month = \gmdate('F', $item['timestamp']);

            $grouped[$year][$month][] = $item;
        }

        $html = '';

        foreach ($grouped as $year => $months) {
            $html .= '<section class="calendar-group">';
            $html .= '<h2>'.\esc_html($year).'</h2>';

            foreach ($months as $month => $monthItems) {
                $html .= '<div class="calendar-group__month">';
                $html .= '<h3>'.\esc_html($month).'</h3>';
                $html .= '<ul>';

                foreach ($monthItems as $item) {
                    $html .= '<li>';
                    $html .= '<a href="'.\esc_url($item['url']).'">'.\esc_html($item['title']).'</a>';
                    $html .= ' <span>'.\esc_html(\wp_date('j M Y', $item['timestamp'])).'</span>';
                    $html .= '</li>';
                }

                $html .= '</ul>';
                $html .= '</div>';
            }

            $html .= '</section>';
        }

        return $html;
    }

    protected static function getNearestUpcomingDate(int $postId, string $today): ?string
    {
        $rowCount = (int) \get_post_meta($postId, 'dates', true);

        if ($rowCount < 1) {
            return null;
        }

        $nearestDate = null;

        for ($index = 0; $index < $rowCount; $index++) {
            $startDate = (string) \get_post_meta($postId, "dates_{$index}_start_date", true);

            if ($startDate === '' || $startDate < $today) {
                continue;
            }

            if ($nearestDate === null || $startDate < $nearestDate) {
                $nearestDate = $startDate;
            }
        }

        return $nearestDate;
    }
}
