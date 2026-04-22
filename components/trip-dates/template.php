<section class="<?= classes('trip-dates', 'wp-block', $this->classes) ?>" <?= attributes($this->attributes) ?>>
    <div class="trip-dates__inner content-width-sm">
        <h2 class="trip-dates__heading"><?= esc_html__('Dates & book', 'gust') ?></h2>

        <?php if (! empty($this->date_rows)) { ?>
            <ul class="trip-dates__list">
                <?php foreach ($this->date_rows as $row) { ?>
                    <li class="trip-dates__item <?= $row['is_sold_out'] ? 'is-sold-out' : '' ?>">
                        <span class="trip-dates__item__label">
                            <?= esc_html($row['label']) ?>
                            <!-- <?php if ($row['nights']) { ?>
                                <span class="trip-dates__item__nights">(<?= esc_html($row['nights']) ?> nights)</span>
                            <?php } ?> -->
                        </span>

                        <!-- <?php if ($row['price_display']) { ?>
                            <span class="trip-dates__item__price"><?= esc_html($row['price_display']) ?></span>
                        <?php } ?> -->

                        <?php if ($row['is_bookable']) { ?>
                            <a href="<?= esc_url($row['booking_url']) ?>" class="trip-dates__item__cta button btn" target="_blank" rel="noopener">
                                <?= esc_html__('Book Now', 'gust') ?>
                            </a>
                        <?php } elseif ($row['is_sold_out']) { ?>
                            <button class="trip-dates__item__cta trip-dates__item__cta--sold-out button btn" type="button" disabled>
                                <?= esc_html__('Sold Out', 'gust') ?>
                            </button>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } elseif ($this->is_preview) { ?>
            <p class="trip-dates__empty"><?= esc_html__('No departure dates added yet. Add dates in the Trip Fields panel.', 'gust') ?></p>
        <?php } ?>
    </div>
</section>
