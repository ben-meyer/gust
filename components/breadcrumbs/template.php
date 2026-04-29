<?php if (! empty($this->back_link['url']) && ! empty($this->back_link['label'])) { ?>
    <nav class="<?= classes('breadcrumbs', 'breadcrumbs--back', $this->classes) ?>" <?= attributes($this->attributes) ?>>
        <a class="breadcrumbs__back-link" href="<?= esc_url($this->back_link['url']) ?>">
            <span class="breadcrumbs__back-chevron" aria-hidden="true"></span>
            <?= sprintf(
                /* translators: %s: target page title (e.g. trip name, archive label) */
                esc_html__('Back to %s', 'gust'),
                esc_html($this->back_link['label'])
            ) ?>
        </a>
    </nav>
<?php } elseif (function_exists('yoast_breadcrumb')) { ?>
    <nav class="<?= classes('breadcrumbs', $this->classes) ?>" <?= attributes($this->attributes) ?>>
        <?php \yoast_breadcrumb('', ''); ?>
    </nav>
<?php } ?>
