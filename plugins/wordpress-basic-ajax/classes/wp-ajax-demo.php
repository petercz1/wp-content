<?php
namespace chipbug\basic\ajax;

class WP_Ajax_Demo
{
    public function init()
    {
        $wp_ajax_loadcss = new WP_Ajax_Loadcss();
        add_action('admin_enqueue_scripts', array($wp_ajax_loadcss, 'init')); 	// loads css

        $wp_ajax_menuitem = new WP_Ajax_Menuitem();
        add_action('admin_menu', array($wp_ajax_menuitem, 'init'));			// loads menu item

        $wp_ajax_js = new WP_Ajax_Js();
        add_action('admin_footer', array($wp_ajax_js, 'init'));				// loads ajax js

        // this is the weird one. The WordPress ajax handler needs 'wp_ajax_' in front of the requested function...
        $wp_ajax_handler = new WP_Ajax_Db_Handler();
        add_action('wp_ajax_WP_ajax_handler', array($wp_ajax_handler, 'init')); // loads server-side ajax handler 
    }
}