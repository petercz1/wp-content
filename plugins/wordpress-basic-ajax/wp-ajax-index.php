<?php
namespace chipbug\basic\ajax;

/**
 * Plugin Name: WP Ajax tester
 * WordPress AJAX Tester
 * Plugin URI: http://WP.com
 * Description: A plugin for testing how AJAX calls work with WordPress
 * Version: 1.2
 * Author: PC
 * License: GPLv2
 */

require_once plugin_dir_path(__FILE__) . '/classes/wp-ajax-adminpage.php';
require_once plugin_dir_path(__FILE__) . '/classes/wp-ajax-demo.php';
require_once plugin_dir_path(__FILE__) . '/classes/wp-ajax-db-handler.php';
require_once plugin_dir_path(__FILE__) . '/classes/wp-ajax-js.php';
require_once plugin_dir_path(__FILE__) . '/classes/wp-ajax-loadcss.php';
require_once plugin_dir_path(__FILE__) . '/classes/wp-ajax-menuitem.php';

(new WP_Ajax_Demo)->init();
