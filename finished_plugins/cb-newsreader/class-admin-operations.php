<?php
namespace chipbug\newsreader;

class Admin_Operations
{
    public function __construct()
    {
        $operations = new Operations;
        add_action('wp_ajax_loadallfeeds', array($operations, 'loadallfeeds'));
        add_action('wp_ajax_loadsinglefeed', array($operations, 'loadsinglefeed'));
        add_shortcode('cbnewsreader', array($operations, 'add_shortcode'));

        //add_action('admin_enqueue_scripts', array($this, 'add_hooks'));
        add_action('wp_ajax_update', array($this, 'update'));
        add_action('wp_ajax_insert', array($this, 'insert'));
        add_action('wp_ajax_delete', array($this, 'delete'));
        add_action('wp_ajax_select', array($this, 'select'));
        add_action('wp_ajax_reorder', array($this, 'reorder'));
    }

    public function update()
    {
        global $wpdb;
        if ($this->check_nonce()) {
            $feed_name = $_POST['feed_name'];
            $feed_url = $_POST['feed_url'];
            $feed_qty = $_POST['feed_qty'];
            $row = $_POST['row'];
            $table = $wpdb->prefix . 'cb_newsreader';
            $update = array('feed_name'=>$feed_name, 'feed_url'=>$feed_url, 'feed_qty'=>$feed_qty);
            $where = array('id'=> $row);
            $wpdb->update($table, $update, $where);
            echo 'updated ' . $feed_name;
        }
        wp_die();
    }

    public function insert()
    {
        global $wpdb;
        if ($this->check_nonce()) {
            $feed_name = $_POST['feed_name'];
            $feed_url = $_POST['feed_url'];
            $feed_qty = $_POST['feed_qty'];
            if (is_wp_error(fetch_feed($feed_url))) {
                write_log('error fetching feed');
                echo 'feed error';
                die;
            }
            $table = $wpdb->prefix . 'cb_newsreader';
            $sql_max_value = "SELECT max(feed_order) FROM $table";
            $max = $wpdb->get_var($sql_max_value);
            $data = array('feed_name'=>$feed_name, 'feed_url'=>$feed_url, 'feed_qty'=>$feed_qty, 'feed_order'=> $max + 1);
            $wpdb->insert($table, $data);
            echo 'inserted ' . $feed_name;
        }
        wp_die();
    }

    public function delete()
    {
        global $wpdb;
        if ($this->check_nonce()) {
            $row = $_POST['row'];
            $table = $wpdb->prefix . 'cb_newsreader';
            $where = array('id'=>$row);
            write_log($wpdb->delete($table, $where));
            echo 'deleted row ' + $row;
        }
        wp_die();
    }

    public function select()
    {
        global $wpdb;
        if ($this->check_nonce()) {
            $data = $wpdb->get_results('select * from ' . $wpdb->prefix . 'cb_newsreader order by feed_order');
            echo  json_encode($data);
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

    public function reorder()
    {
        if ($this->check_nonce()) {
            write_log('inside reorder');
            global $wpdb;
            $new_sort_order = explode("row[]=", $_POST['new_sort_order']);
            $new_sort_order = str_replace('&', '', $new_sort_order);
            $counter = 0;
            foreach ($new_sort_order as $item_order) {
                write_log('item: ' . $item_order);
                $table = $wpdb->prefix . 'cb_newsreader';
                $update = array('feed_order'=>$counter);
                $where = array('id'=> $item_order);
                $wpdb->update($table, $update, $where);
                $counter++;
            }
        }
        wp_die();
    }
}
