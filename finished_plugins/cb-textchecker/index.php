<?php
namespace chipbug\textchecker;

/*
Plugin name: cb textchecker
Description: checks your post text for errors and makes corrections you specify
Author: PC
Author URI: https://chipbug.com
Version: 1.0.0
*/

// this loads the functions needed

defined('ABSPATH') or exit;

require_once 'class-admin-install.php';
require_once 'class-admin-setup.php';
require_once 'class-admin-operations.php';

if (is_admin()) {
    new Admin_Install();
    new Admin_Setup();
    new Admin_Operations();
}