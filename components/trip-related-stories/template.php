<?= \Gust\Components\Cards::make(
    heading: __('Related stories', 'gust'),
    items: $this->items,
    columns: '2',
    classes: ['trip-related-stories'],
); ?>
