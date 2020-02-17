<?php
namespace chipbug\toc;

class Setup
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'queue_browser_scripts'));
    }

    public function queue_browser_scripts()
    {
        wp_register_script('articlenav-js', plugins_url('/js/javascript.js', __FILE__), array('jquery'), '1.0.0', true);
        wp_register_style('articlenav-css', plugins_url('/css/style.css', __FILE__));
    }
}
