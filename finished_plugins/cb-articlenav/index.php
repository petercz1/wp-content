<?php
namespace chipbug\toc;

/*
Plugin name: cb post menu builder
Description: builds a wiki-style menu of links based on the post headings used
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

new Setup();
new Operations();

if (is_admin()) {
    new Admin_Install();
    new Admin_Setup();
    new Admin_Operations();
}
