<?php
namespace chipbug\newsreader;

class Operations
{
    public function __construct()
    {
        add_action('wp_ajax_nopriv_loadallfeeds', array($this, 'loadallfeeds'));
        add_action('wp_ajax_nopriv_loadsinglefeed', array($this, 'loadsinglefeed'));
        add_shortcode('cbnewsreader', array($this, 'add_shortcode'));
    }

    public function loadallfeeds()
    {
        global $wpdb;
        $feeds = $wpdb->get_results('select * from ' . $wpdb->prefix . 'cb_newsreader order by feed_order');
        echo  json_encode($feeds);
        wp_die();

        // $feeds = file_get_contents(plugin_dir_path(__FILE__) . 'rss-feeds.json');
        // echo $feeds;
        // die();
    }

    public function loadsinglefeed()
    {
        $feed_id = $_POST['feed_id'];
        $feed_url = $_POST['feed_url'];
        $feed_qty = $_POST['feed_qty'];
        $returned_array = array();
        if (is_wp_error(fetch_feed($feed_url))) {
            write_log('error fetching feed');
            echo json_encode($feed_id);
            die;
        }
        $rss = \fetch_feed($feed_url);
        $maxitems = $rss->get_item_quantity($feed_qty);
        $rss_items = $rss->get_items(0, $maxitems);
        foreach ($rss_items as $rss_item) {
            $single_feed = array();
            $single_feed['feed_id'] = $feed_id;
            $single_feed['url'] = $rss_item->get_permalink();
            $single_feed['title'] = $rss_item->get_title();
            $single_feed['date'] = $rss_item->get_date();
            $single_feed['description'] = strip_tags($rss_item->get_description(), '<p><img><ol><li><a><font>');
            $single_feed['content'] = strip_tags($rss_item->get_content(), '<p><img><ol><li><a><font>');
            if ($enclosure = $rss_item->get_enclosure()) {
                $single_feed['thumbnail'] = $enclosure->get_link();
            }
            array_push($returned_array, $single_feed);
        }
        echo json_encode($returned_array);
        die();
    }
    public function add_shortcode($hook)
    {
        wp_enqueue_style('newsfeeds-css');
        wp_enqueue_script('newsfeeds-js');
        $array_of_values_to_be_used_in_client_js = array( 'ajax_url' => admin_url('admin-ajax.php'));
        wp_localize_script('newsfeeds-js', 'newsfeed', $array_of_values_to_be_used_in_client_js);
        include 'cb-shortcode.html';
        return;
    }
}
