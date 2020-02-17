<?php
/*
Plugin name: wp-config editor
Description: allows simple editing of the wp-config-php file - if the use has rights to do so!
Author: PC
Author URI: https://chipbug.com
Version: 1.0.0
*/

// this loads the functions needed
require_once 'include-functions.php';

add_action('admin_menu', 'chipbug_version_finder_add_sub_menu');
