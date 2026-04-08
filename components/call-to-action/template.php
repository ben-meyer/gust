<?php
/**
 * CallToAction Template
 *
 * @var \Gust\Components\CallToAction $this
 */

use Gust\Helpers;
?>

<div class="<?= classes('call-to-action', $this->classes) ?>" <?= attributes($this->attributes); ?>>
    <?php if (!empty($this->heading)): ?>
        <h1 class="call-to-action__heading"><?= esc_html($this->heading); ?></h1>
    <?php endif; ?>

    <?php if (!empty($this->subheading)): ?>
        <h2 class="call-to-action__subheading"><?= esc_html($this->subheading); ?></h2>
    <?php endif; ?>

    <div class="call-to-action__cards" aria-label="Call to action cards">
        <?php foreach ($this->cards as $card): ?>
            <div class="call-to-action__card">
                <?php if (!empty($card['title'])): ?>
                    <h3 class="call-to-action__card-title"><?= esc_html($card['title']); ?></h3>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
