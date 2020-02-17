<?php
namespace chipbug\basic\ajax;

class WP_Ajax_Loadcss
{
    public function init()
    {
        error_log('loading css...');
        wp_enqueue_style('WP-ajax-tester-css', plugins_url('css/WP-ajax.css', __FILE__));
    }
}
