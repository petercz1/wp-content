<?php
namespace chipbug\newsreader;

class Admin_Install
{
    public function __construct()
    {
        register_activation_hook(__DIR__ . '/index.php', array($this,'install_table'));
        register_activation_hook(__DIR__ . '/index.php', array($this,'add_data'));
        register_deactivation_hook(__DIR__ . '/index.php', array($this,'remove_table'));
    }

    public static function install_table()
    {
        if (! current_user_can('activate_plugins')) {
            return;
        }
        write_log('installing table');

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'cb_newsreader';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $sql = "CREATE TABLE $table_name (
    		          id mediumint(9) NOT NULL AUTO_INCREMENT,
                  feed_name varchar(255) NOT NULL,
                  feed_url varchar(255) NOT NULL,
                  feed_qty int NOT NULL,
                  feed_order int NOT NULL,
    		          PRIMARY KEY  (id)
	             ) $charset_collate;";
        dbDelta($sql);
    }

    public static function add_data()
    {
        if (! current_user_can('activate_plugins')) {
            return;
        }
        write_log('adding data');
        global $wpdb;
        $table_name = $wpdb->prefix . 'cb_newsreader';

        $wpdb->insert(
        $table_name,
        array(
          'feed_name' => 'France 24',
          'feed_url' => 'http://www.france24.com/en/france/rss',
          'feed_order' => 0
        )
    );
    }

    public static function remove_table()
    {
        if (! current_user_can('activate_plugins')) {
            return;
        }
        write_log('removing table');

        global $wpdb;
        $table_name = $wpdb->prefix . 'cb_newsreader';
        $sql = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($sql);
    }
}
