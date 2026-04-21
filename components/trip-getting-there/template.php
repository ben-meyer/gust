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
                        el: 'h5',
                    ); ?>
                <?php } ?>

                <?php if (! empty($stage['steps'])) { ?>
                    <div class="trip-getting-there__steps">
                        <?php foreach ($stage['steps'] as $step) { ?>
                            <article class="trip-getting-there__step">
                                <?php if (! empty($step['title'])) { ?>
                                    <?php
                                        $icon = ! empty($step['icon']) ? strtolower((string) $step['icon']) : '';
                                        $iconMap = [
                                            'plane' => 'plane.svg',
                                            'ferry' => 'ferry.svg',
                                            'car' => 'car.svg',
                                            'bus' => 'bus.svg',
                                            'train' => 'quote.svg',
                                        ];
                                        $iconFile = $iconMap[$icon] ?? 'car.svg';
                                    ?>
                                    <h6 class="trip-getting-there__step-title">
                                        <span class="trip-getting-there__step-title-icon" aria-hidden="true">
                                            <?= \Gust\SVG::get(get_theme_file_path('public/build/images/icons/' . $iconFile), ['asset' => false, 'width' => 16, 'height' => 16]); ?>
                                        </span>
                                        <span><?= esc_html($step['title']); ?></span>
                                    </h6>
                                <?php } ?>

                                <?php if (! empty($step['description'])) { ?>
                                    <div class="trip-getting-there__step-description"><?= wp_kses_post($step['description']); ?></div>
                                <?php } ?>
                            </article>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
