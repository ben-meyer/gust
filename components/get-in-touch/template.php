<?php
/**
 * GetInTouch Template
 *
 * @var \Gust\Components\GetInTouch $this
 */

use Gust\Helpers;
?>

<div class="<?= classes('get-in-touch', $this->classes) ?>" <?= attributes($this->attributes) ?>>
    <div class="get-in-touch__content">
        <p class="get-in-touch__label">Get in touch</p>
        <div class="get-in-touch__contacts-wrapper">
        <?php
        $phones = array_filter($this->contacts, fn($c) => $c['type'] !== 'Email');
        $emails = array_filter($this->contacts, fn($c) => $c['type'] === 'Email');
        ?>
        <?php if (!empty($phones)): ?>
            <ul class="get-in-touch__contacts get-in-touch__phones">
                <?php foreach ($phones as $contact): ?>
                    <li><?= \Gust\SVG::get(get_theme_file_path('assets/images/icons/phone.svg'), ['asset' => false, 'width' => 16, 'height' => 16]); ?> <strong><?php echo esc_html($contact['type']); ?>:</strong><span>&nbsp;<?php echo esc_html($contact['value']); ?></span></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if (!empty($emails)): ?>
            <ul class="get-in-touch__contacts get-in-touch__emails">
                <?php foreach ($emails as $contact): ?>
                    <li><?= \Gust\SVG::get(get_theme_file_path('assets/images/icons/email.svg'), ['asset' => false, 'width' => 16, 'height' => 16]); ?> <?php echo esc_html($contact['value']); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        </div>
    </div>
</div>
