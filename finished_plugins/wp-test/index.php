<?php
namespace chipbug\wptest;

/*
Plugin name: wordpress test bed
Description: lets me test wordpress stuff...
Author: PC
Author URI: https://chipbug.com
Version: 1.0.0
*/

// this loads the functions needed

defined('ABSPATH') or exit;
new Wp_Test;

class Wp_Test
{
    public function __construct()
    {
        write_log('');
        add_filter('spec', array($this,'chop_stuff'));
        add_filter('spec', array($this,'do_caps'));
        $this->do_filters();
    }

    public function do_filters()
    {
        write_log('do_filters');
        $post_test = get_post(167);
        write_log('id: ' . get_the_id($post_test));

        write_log('title: ' . $post_test->post_title);

        $resp = apply_filters('spec', $post_test->post_content);
        write_log('post title after filter: ' . $resp);
    }

    public function chop_stuff($content)
    {
        write_log('chop_stuff: ');
        return substr($content, 0, 200);
    }

    public function do_caps($content)
    {
        write_log('do caps: ');
        return strtoupper($content);
    }
}
