<?= \Gust\Components\Cards::make(
    heading: __('Related trips', 'gust'),
    items: $this->items,
    columns: '3',
    classes: ['trip-related-trips'],
); ?>
