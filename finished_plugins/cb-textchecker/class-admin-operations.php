<?php
namespace chipbug\textchecker;

class Admin_Operations
{
    public function __construct()
    {
        // load ajax stuff
        add_action('wp_ajax_update', array($this, 'update'));
        add_action('wp_ajax_insert', array($this, 'insert'));
        add_action('wp_ajax_delete', array($this, 'delete'));
        add_action('wp_ajax_select', array($this, 'select'));
        add_action('admin_enqueue_scripts', array($this, 'add_scripts'));
        // fire this off every time content is saved
        add_action('content_save_pre', array($this, 'check'));
    }
    public function check($incoming_text)
    {
        // runs every time a post is saved
    global $wpdb;
        $items_to_check = $wpdb->get_results('select find_text, replace_text from ' . $wpdb->prefix . 'textchecker order by id');
        write_log($items_to_check);
        $items_to_search_for = array();
        $replace_with = array();
        foreach ($items_to_check as $item) {
            array_push($items_to_search_for, $item->find_text);
            array_push($replace_with, $item->replace_text);
        }
        return str_replace($items_to_search_for, $replace_with, $incoming_text);
    }

    public function update()
    {
        write_log('php updating...');
        global $wpdb;
        if ($this->check_nonce()) {
            $row = $_POST['row'];
            $find_text = $_POST['find_text'];
            $replace_text = $_POST['replace_text'];
            echo $find_text . ': ' . $replace_text . ', row: ' . $row;
            $table = $wpdb->prefix . 'textchecker';
            $update = array('find_text'=>$find_text, 'replace_text'=>$replace_text);
            $where = array('id'=> $row);
            $wpdb->update($table, $update, $where);
        }
        wp_die();
    }

    public function insert()
    {
        write_log('php inserting...');
        global $wpdb;
        if ($this->check_nonce()) {
            $find_text = $_POST['find_text'];
            $replace_text = $_POST['replace_text'];
            echo $find_text . ': ' . $replace_text;
            $table = $wpdb->prefix . 'textchecker';
            $data = array('find_text'=>$find_text, 'replace_text'=>$replace_text);
            $wpdb->insert($table, $data);
        }
        wp_die();
    }

    public function delete()
    {
        write_log('php deleting...');
        global $wpdb;
        if ($this->check_nonce()) {
            $row = $_POST['row'];
            $table = $wpdb->prefix . 'textchecker';
            $where = array('id'=>$row);
            write_log($wpdb->delete($table, $where));
            echo 'php deleted ' + $row;
        }
        wp_die();
    }

    public function select()
    {
        write_log('selecting...');
        global $wpdb;
        if ($this->check_nonce()) {
            $data = $wpdb->get_results('select * from ' . $wpdb->prefix . 'textchecker order by replace_text');
            echo  json_encode($data);
        } else {
            echo 'blow up?';
        }
        wp_die();
    }

    public function check_nonce()
    {
        $nonce = $_POST['nonce'];
        if (wp_verify_nonce($nonce, 'number_used_once')) {
            return true;
        } else {
            return false;
        }
    }

    public function add_scripts($hook)
    {
        if ($hook !== 'settings_page_cb-textcheck') {
            return;
        }
        wp_enqueue_script('textchecker-js');
        $ajax_nonce = wp_create_nonce("number_used_once");
        $array_of_values_to_be_used_in_client_js = array( 'ajax_url' => admin_url('admin-ajax.php'),'nonce'=>$ajax_nonce);
        wp_localize_script('textchecker-js', 'cb_textcheck', $array_of_values_to_be_used_in_client_js);
    }
}
