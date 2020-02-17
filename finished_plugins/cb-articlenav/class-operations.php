<?php
namespace chipbug\toc;

class Operations
{
    private $the_post;
    private $options;
    private $return_text;

    public function __construct()
    {
        $this->options = get_option('cb_toc_options');
        add_shortcode('cb-toc', array($this, 'add_shortcode'));
        add_filter('the_content', array($this, 'add_links_to_headings'), 10, 2);
    }

    public function add_shortcode()
    {
        wp_enqueue_style('articlenav-css');
        wp_enqueue_script('articlenav-js');
        $array_of_values_to_be_used_in_client_js = array( 'ajax_url' => admin_url('admin-ajax.php'), 'toc_options'=>$this->options);
        wp_localize_script('articlenav-js', 'cb_articlenav', $array_of_values_to_be_used_in_client_js);
        $h1 = $h2 = $h3 = $h4 = $h5 = $h6 = 'h';
        foreach ($this->options as $key=> $value) {
            if (isset($value['checked'])) {
                switch ($value['name']) {
                case 'headings_1':
                $h1 = 'h1';
                break;
                case 'headings_2':
                $h2 = 'h2';
                break;
                case 'headings_3':
                $h3 = 'h3';
                break;
                case 'headings_4':
                $h4 = 'h4';
                break;
                case 'headings_5':
                $h5 = 'h5';
                break;
                case 'headings_6':
                $h6 = 'h6';
                break;
              }
            }
        }
        write_log('h1: ' . $h1);
        write_log('h2: ' . $h2);
        write_log('h3: ' . $h3);
        write_log('h4: ' . $h4);
        write_log('h5: ' . $h5);
        write_log('h6: ' . $h6);

        global $post;
        // add 'return to TOC' links
        $content = $this->add_links_to_headings($post->post_content, false);
        //$heading_counter = 0;
        $html_doc = new \DOMDocument();
        $toc = new \DOMDocument();
        $html_doc->loadHTML($content);
        $toc->loadHTML('<div class="wrap"><div id="cb-articlenav-container"></div></div>');
        $heading_xpath = new \DOMXpath($html_doc);
        $headings = $heading_xpath->query("//{$h1} | //{$h2} |//{$h3} | //{$h4} |//{$h5} | //{$h6} ");
        foreach ($headings as $elem) {
            $toc_link = $html_doc->createElement('a');
            $toc_link->setAttribute('href', '#' . $elem->getAttribute('id'));
            $toc_link->setAttribute('class', strtolower('articlenav_' . $elem->tagName));
            $toc_link->nodeValue = $elem->nodeValue;
            $toc->getElementById('cb-articlenav-container')->appendChild($toc->importNode($toc_link, true));
        }
        return $toc->saveHTML();
        wp_die();
    }

    public function add_links_to_headings($content, $add_return= true)
    {
        foreach ($this->options as $key=> $value) {
            if ($value['name'] == 'return_text') {
                $this->return_text = $value['value'];
            }
        }
        $heading_counter = 0;
        $html_doc = new \DOMDocument();
        $html_doc->loadHTML($content);
        $heading_xpath = new \DOMXpath($html_doc);
        $headings = $heading_xpath->query('//h1 | //h2 |//h3 | //h4 |//h5 | //h6');
        foreach ($headings as $elem) {
            $attribs = $elem->attributes;
            if (!$elem->hasAttribute('id')) {
                $elem->setAttribute('id', 'articlenav_id_' . $heading_counter++);
            }
            // create 'return' element
            $return_link = $html_doc->createElement('a');
            $return_link->setAttribute('href', '#cb-articlenav-container');
            $return_link->setAttribute('class', 'cb-articlenav-returnlink');
            $return_link->nodeValue = $this->return_text;
            if ($add_return) {
                $elem->appendChild($return_link);
            }
        }
        $content_with_links = $html_doc->saveHTML();
        return $content_with_links;
    }
}
