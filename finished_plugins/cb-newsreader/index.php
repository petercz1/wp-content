<?php
namespace chipbug\newsreader;

/*
Plugin name: cb Google news reader
Description: reads Google rss feeds - https://support.google.com/news/answer/59255?hl=en
Author: PC
Author URI: https://chipbug.com
Version: 1.0.0
*/

defined('ABSPATH') or exit;

require_once 'class-setup.php';
require_once 'class-operations.php';
require_once 'class-admin-install.php';
require_once 'class-admin-setup.php';
require_once 'class-admin-operations.php';
require_once(ABSPATH . WPINC . '/feed.php');

new Setup();
new Operations();

if (is_admin()) {
    new Admin_Install();
    new Admin_Setup();
    new Admin_Operations();
}
