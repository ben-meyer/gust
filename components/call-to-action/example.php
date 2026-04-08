<?php

/**
 * CallToAction Component Examples
 */

use Gust\Components\CallToAction;

?>

<section class="component-example-section">
    <h2 class="component-example-section__title">Call To Action - Default</h2>
    <p class="component-example-section__description">CTA with primary heading, secondary heading, and a row of three cards.</p>
    <div class="component-example-section__preview">
        <?= CallToAction::make(
            heading: 'First timer?',
            subheading: 'Dip your toes',
            cards: [
                ['title' => 'Browse Trips'],
                ['title' => 'Talk To Our Team'],
                ['title' => 'Request A Brochure'],
            ],
        ); ?>
    </div>
</section>
