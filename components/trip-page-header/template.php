<section class="<?= classes('trip-page-header', 'wp-block', 'alignfull', $this->classes) ?>" <?= attributes($this->attributes) ?>>
    <?php if (! empty($this->image)) { ?>
        <div class="trip-page-header__media">
            <div class="trip-page-header__media-inner img-fit">
                <?= $this->image; ?>
            </div>
        </div>
    <?php } ?>

    <div class="trip-page-header__content">
        <div class="trip-page-header__inner content-width-lg">
            <?php if (! empty($this->heading)) { ?>
                <?= \Gust\Components\Heading::make(
                    heading: $this->heading,
                    el: 'h1',
                    classes: ['trip-page-header__heading', 'is-style-type-h1'],
                ); ?>
            <?php } ?>

            <?php if (! empty($this->summary_items)) { ?>
                <ul class="trip-page-header__summary">
                    <?php foreach ($this->summary_items as $item) { ?>
                        <li class="trip-page-header__summary-item">
                            <span><?= esc_html($item['label']); ?></span>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>

            <?php if (! empty($this->description)) { ?>
                <div class="trip-page-header__description">
                    <?= wp_kses_post($this->description); ?>
                </div>
            <?php } ?>

            <?php if (! empty($this->stats)) { ?>
                <div class="trip-page-header__stats">
                    <?php foreach ($this->stats as $stat) { ?>
                        <div class="trip-page-header__stat">
                            <div class="trip-page-header__stat-value"><?= esc_html($stat['value']); ?></div>
                            <div class="trip-page-header__stat-label"><?= esc_html($stat['label']); ?></div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
