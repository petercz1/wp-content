<?php
namespace chipbug\basic\ajax;

/*
 * The AJAX handler function
 */
class WP_Ajax_Db_Handler{
    public function init()
    {
        error_log('firing php handler for WP_ajax_handler...');
        global $wpdb;
    
        $id = $_POST['id'];
        // scrub the data
        $prepare = $wpdb->prepare("SELECT * FROM wp_options WHERE option_id = %d", $id);
        
        // now execute it
        $data = $wpdb->get_row($prepare, ARRAY_A);
        error_log(print_r($data, true));
    
        // send it back as json
        echo json_encode($data);
        wp_die(); // just to be safe
    }
}