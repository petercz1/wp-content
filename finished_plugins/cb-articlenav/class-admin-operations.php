<?php
namespace chipbug\toc;

class Admin_Operations
{
    public function __construct()
    {
        $operations = new Operations;
        add_shortcode('cbnewsreader', array($operations, 'add_shortcode'));
        add_action('wp_ajax_save_options', array($this, 'save_options'));
        add_action('wp_ajax_get_options', array($this, 'get_options'));
    }

    public function save_options()
    {
        if ($this->check_nonce()) {
            update_option('cb_toc_options', $_POST['cb_toc_options']);
            write_log($_POST);
            write_log($_POST['cb_toc_options']);
            echo 'updated in db!';
            wp_die();
        }
    }

    public function get_options()
    {
        $default_options = array();
        $options = get_option('cb_toc_options', $default_options);
        echo json_encode($options);
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
}
