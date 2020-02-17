<?php
namespace chipbug\basic\ajax;

/*
 * Create the admin menu item
 */
class WP_Ajax_Menuitem
{
    public function init()
    {
        error_log('adding menu stuff');
        add_menu_page('AJAX Tester', 'AJAX Tester', 'edit_pages', 'WP_ajax_adminpage', 'chipbug\basic\ajax\WP_ajax_adminpage', 'dashicons-clipboard', 49);
    }
}