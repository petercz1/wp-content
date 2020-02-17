<?php
/*
Plugin name: get php version
Description: does what it says. Unfortunately namespaces can't be used as a user might have php < 5.3, hence the ridiculously long unique qualifying names for functions
Author: PC
Author URI: https://chipbug.com
Version: 1.0.0
*/

// this loads the functions needed
require_once 'include-functions.php';

add_action('admin_menu', 'chipbug_version_finder_add_sub_menu');
