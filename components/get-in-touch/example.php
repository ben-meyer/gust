<?php

/**
 * GetInTouch Component Examples
 */

use Gust\Components\GetInTouch;

?>

<section class="component-example-section">
    <h2 class="component-example-section__title">Get In Touch</h2>
    <p class="component-example-section__description">Example rendering of the GetInTouch component with contact information.</p>
    <div class="component-example-section__preview">
        <?= GetInTouch::make(contacts: [
            ['type' => 'Office', 'value' => '+44(0)12 3456 7890'],
            ['type' => 'Person 1', 'value' => '+44(0)7987 654 321'],
            ['type' => 'Person 2', 'value' => '+44(0)7123 456 789'],
            ['type' => 'Email', 'value' => 'example@swimquest.com'],
        ]); ?>
    </div>
</section>
