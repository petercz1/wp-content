<?php
namespace chipbug\textchecker;

class Admin_Setup
{
    public function __construct()
    {
        // load this when the admin_menu is loaded
    add_action('admin_menu', array($this, 'add_sub_menu'));
    // load front-end javascript
    add_action('admin_enqueue_scripts', array($this, 'queue_browser_scripts'));
    }

    public function add_sub_menu()
    {
        // add_submenu_page(parent-slug or standard WP admin page, page title, menu title,
    // capabilities, menu slug, function to call)
    add_submenu_page('options-general.php', 'cb textcheck', 'cb textcheck', 'manage_options', 'cb-textcheck', array($this, 'load_admin_page'));
    }

    public function load_admin_page()
    {
        // load the postchecker admin page
    include 'admin-page.html';
    }

    public function queue_browser_scripts()
    {
        if (is_admin()) {
            wp_register_script('textchecker-js', plugins_url('/js/javascript.js', __FILE__), array('jquery'), '1.0.0', true);
        }
    }
}
