<?php

function chipbug_version_finder_add_sub_menu()
{
    add_submenu_page('options-general.php', 'php version', 'php version ' . chipbug_version_finder_get_version(), 'manage_options', 'php-version', 'chipbug_version_finder_options_page');
}

function chipbug_version_finder_options_page()
{
    include 'options-page.php';
}

function chipbug_version_finder_get_version()
{
    $php_version_array = explode('.', phpversion());
    return $php_version_array[0] . '.' . $php_version_array[1];
}

function chipbug_version_finder_info()
{
    global $wp_version;
    return 'You are running WordPress version ' . $wp_version . ' on php version ' . chipbug_version_finder_get_version();
}
