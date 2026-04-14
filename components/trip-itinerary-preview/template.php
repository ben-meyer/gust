<section id="trip-itinerary" class="<?= classes('trip-itinerary-preview', 'wp-block', $this->classes) ?>" <?= attributes($this->attributes) ?>>
    <div class="trip-itinerary-preview__inner content-width-md">
        <?= \Gust\Components\Heading::make(
            heading: __('Itinerary', 'gust'),
            classes: ['trip-itinerary-preview__heading'],
        ); ?>

        <?php if (! empty($this->title)) { ?>
            <?= \Gust\Components\Heading::make(
                heading: $this->title,
                el: 'h3',
                classes: ['trip-itinerary-preview__title'],
            ); ?>
        <?php } ?>

        <?php if (! empty($this->preview)) { ?>
            <div class="trip-itinerary-preview__content"><?= esc_html($this->preview); ?></div>
        <?php } ?>

        <?php if (! empty($this->url)) { ?>
            <?= \Gust\Components\Link::make(
                title: __('View full itinerary', 'gust'),
                url: $this->url,
                classes: ['btn'],
            ); ?>
        <?php } ?>
    </div>
</section>
