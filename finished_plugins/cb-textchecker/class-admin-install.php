<?php
namespace chipbug\textchecker;

class Admin_Install
{
    public function __construct()
    {
        register_activation_hook(__DIR__ . '/index.php', array($this, 'install_table'));
        register_activation_hook(__DIR__. '/index.php', array($this, 'add_data'));
        register_deactivation_hook(__DIR__. '/index.php', array($this, 'remove_table'));
    }

    public function install_table()
    {
        write_log('installing table for textchecker');
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'cb_textchecker';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
        find_text varchar(255) NOT NULL,
		replace_text varchar(255) NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
        dbDelta($sql);
    }

    public function add_data()
    {
        write_log('adding data for textchecker');
        global $wpdb;
        $table_name = $wpdb->prefix . 'cb_textchecker';

        $wpdb->insert(
        $table_name,
        array(
            'find_text' => 'hte',
            'replace_text' => 'the'
        )
    );
    }

    public function remove_table()
    {
        write_log('removing textchecker table');
        global $wpdb;
        $table_name = $wpdb->prefix . 'cb_textchecker';
        $sql = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($sql);
    }
}
