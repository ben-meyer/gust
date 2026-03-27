<section id="trip-includes" class="<?= classes('trip-includes', 'wp-block', $this->classes) ?>" <?= attributes($this->attributes) ?>>
    <div class="trip-includes__inner content-width-lg">
        <?= \Gust\Components\Heading::make(
            heading: __("What's included", 'gust'),
            classes: ['trip-includes__heading'],
        ); ?>

        <div class="trip-includes__columns">
            <?php if (! empty($this->included_items)) { ?>
                <div>
                    <h3><?= esc_html__('Included', 'gust'); ?></h3>
                    <ul>
                        <?php foreach ($this->included_items as $item) { ?>
                            <li><?= esc_html($item); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <?php if (! empty($this->not_included_items)) { ?>
                <div>
                    <h3><?= esc_html__('Not included', 'gust'); ?></h3>
                    <ul>
                        <?php foreach ($this->not_included_items as $item) { ?>
                            <li><?= esc_html($item); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
