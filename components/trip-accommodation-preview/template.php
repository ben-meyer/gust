<section id="trip-accommodation" class="<?= classes('trip-accommodation-preview', 'wp-block', $this->classes) ?>" <?= attributes($this->attributes) ?>>
    <div class="trip-accommodation-preview__inner content-width-lg">
        <?= \Gust\Components\Heading::make(
            heading: __('Accommodation', 'gust'),
            classes: ['trip-accommodation-preview__heading'],
        ); ?>

        <div class="trip-accommodation-preview__summary">
            <div class="trip-accommodation-preview__header">
                <?php if (! empty($this->title)) { ?>
                    <?= \Gust\Components\Heading::make(
                        heading: $this->title,
                        el: 'h3',
                        classes: ['trip-accommodation-preview__title'],
                    ); ?>
                <?php } ?>

                <?php if ($this->star_rating) { ?>
                    <div class="trip-accommodation-preview__rating"><?= str_repeat('★', (int) $this->star_rating); ?></div>
                <?php } ?>
            </div>

            <?php if (! empty($this->tags)) { ?>
                <ul class="trip-accommodation-preview__tags">
                    <?php foreach ($this->tags as $tag) { ?>
                        <li><?= esc_html($tag); ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>

            <?php if (! empty($this->description)) { ?>
                <div class="trip-accommodation-preview__description"><?= wp_kses_post($this->description); ?></div>
            <?php } ?>

            <?php if (! empty($this->gallery)) { ?>
                <div class="trip-accommodation-preview__gallery">
                    <?php foreach ($this->gallery as $image) { ?>
                        <div class="trip-accommodation-preview__gallery-item">
                            <div class="trip-accommodation-preview__gallery-item-inner img-fit">
                                <?= $image; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <?php if (! empty($this->rooms_intro) || ! empty($this->url)) { ?>
            <div class="trip-accommodation-preview__rooms">
                <?php if (! empty($this->rooms_intro)) { ?>
                    <div class="trip-accommodation-preview__rooms-copy">
                        <h3><?= esc_html__('Rooms', 'gust'); ?></h3>
                        <div><?= wp_kses_post($this->rooms_intro); ?></div>
                    </div>
                <?php } ?>

                <?php if (! empty($this->url)) { ?>
                    <?= \Gust\Components\Link::make(
                        title: __('View accommodation', 'gust'),
                        url: $this->url,
                        classes: ['btn', 'btn--secondary'],
                    ); ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
