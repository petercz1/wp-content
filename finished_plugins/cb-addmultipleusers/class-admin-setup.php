<?php
namespace chipbug\addbulkusers;

class Admin_Setup
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_submenu'));
        add_action('admin_enqueue_scripts', array($this, 'queue_admin_scripts'));
    }

    public function add_submenu()
    {
        // add_submenu_page(parent-slug or standard WP admin page, page title, menu title,
// capabilities, menu slug, function to call)
add_submenu_page('options-general.php', 'cb add bulk users', 'cb add bulk users', 'manage_options', 'cb-add-bulk-users', array($this,'include_admin_page'));
    }

    public function include_admin_page()
    {
        include 'admin-page.html';
    }

    public function queue_admin_scripts($hook)
    {
        if ($hook !== 'settings_page_cb-add-bulk-users') {
            return;
        }
        wp_enqueue_style('addbulkusers-css', plugins_url('/css/style.css', __FILE__));
        wp_enqueue_script('admin-tablesorter-js', plugins_url('/js/tablesorter.js', __FILE__), array('jquery'), '1.0.0', true);
        wp_enqueue_script('admin-addbulkusers-js', plugins_url('/js/admin.js', __FILE__), array('jquery'), '1.0.0', true);
        $ajax_nonce = wp_create_nonce("number_used_once");
        $array_of_values_to_be_used_in_client_js = array( 'ajax_url' => admin_url('admin-ajax.php'),'nonce'=>$ajax_nonce);
        wp_localize_script('admin-addbulkusers-js', 'cb_addbulkusers', $array_of_values_to_be_used_in_client_js);
    }
}
