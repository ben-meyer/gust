<section id="trip-getting-there" class="<?= classes('trip-getting-there', 'wp-block', $this->classes) ?>" <?= attributes($this->attributes) ?>>
    <div class="trip-getting-there__inner content-width-lg">
        <?= \Gust\Components\Heading::make(
            heading: __('Getting there', 'gust'),
            classes: ['trip-getting-there__heading'],
        ); ?>

        <?php foreach ($this->stages as $stage) { ?>
            <div class="trip-getting-there__stage">
                <?php if (! empty($stage['title'])) { ?>
                    <?= \Gust\Components\Heading::make(
                        heading: $stage['title'],
                        el: 'h3',
                    ); ?>
                <?php } ?>

                <?php if (! empty($stage['steps'])) { ?>
                    <div class="trip-getting-there__steps">
                        <?php foreach ($stage['steps'] as $step) { ?>
                            <article class="trip-getting-there__step">
                                <?php if (! empty($step['title'])) { ?>
                                    <h4><?= esc_html($step['title']); ?></h4>
                                <?php } ?>

                                <?php if (! empty($step['description'])) { ?>
                                    <div><?= wp_kses_post($step['description']); ?></div>
                                <?php } ?>
                            </article>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
