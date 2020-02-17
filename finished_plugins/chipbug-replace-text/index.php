<?php
/*
Plugin Name: text replacement plugin
Description: simple text find-and-replace plugin
Version: 1.0.0
Author: your name here
*/
function yn_post_checker($incoming_text)
{
    $items_to_search_for = array('hte', 'javascript', 'zzhand');
    $replace_with = array('the', 'JavaScript', 'Have a nice day');
    return str_replace($items_to_search_for, $replace_with, $incoming_text);
}
add_action('content_save_pre', 'yn_post_checker');
