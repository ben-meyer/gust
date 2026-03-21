<?php

namespace Theme\Modules\ContactForm7;

class ContactForm7Module
{
    public static function init(): void
    {
        \add_action('wp_footer', [__CLASS__, 'newsletterRedirectScript']);
    }

    /**
     * Output a script that redirects to the thank-you page after the
     * newsletter CF7 form is successfully submitted.
     */
    public static function newsletterRedirectScript(): void
    {
        $redirect_url = \esc_url(\get_home_url(null, '/thank-you-newsletter'));
        ?>
        <script>
        document.addEventListener('wpcf7mailsent', function () {
            window.location = <?= \wp_json_encode($redirect_url); ?>;
        }, false);
        </script>
        <?php
    }
}
