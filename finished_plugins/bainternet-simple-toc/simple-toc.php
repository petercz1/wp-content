<?php
/*
Plugin Name: Bainternet Simple TOC
Plugin URI: http://en.bainternet.info/2011/simple-toc-table-of-contents-plugin
Description: Automatically create a wiki like TOC (table of contents) in your posts or pages using shortcode based on your headings.
Version: 0.9.0
Author: Bainternet
Author URI: http://en.bainternet.info
*/
/*  Copyright 2012-2014 Ohad Raz aKa BaInternet  (email : admin@bainternet.info)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if (!class_exists('simple_toc')) {
    class simple_toc
    {
        public function __construct()
        {
            $this->hooks();
        }

        public function hooks()
        {
            add_action('admin_head', array( $this, 'admin_head' ));
            add_filter("the_content", array( $this, "bainternet_generate_toc" ));
            add_filter("the_content", array( $this, "bainternet_generate_toc_encoded" ));
            add_filter("the_content", array( $this, "toc_by_h_tags" ));
            //plugin links row
            add_filter('plugin_row_meta', array($this,'_my_plugin_links'), 10, 2);
            remove_filter('the_content', 'wptexturize');
            add_action('admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ));
        }

        public function admin_head()
        {
            // check user permissions
            if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
                return;
            }
            // check if WYSIWYG is enabled
            if ('true' == get_user_option('rich_editing')) {
                add_filter('mce_external_plugins', array($this, 'mce_external_plugins' ));
                add_filter('mce_buttons', array($this, 'mce_buttons' ));
            }
        }

        public function admin_enqueue_scripts()
        {
            wp_enqueue_style('simple_toc', plugins_url('/assets/css/simple_toc.css', __FILE__));
        }

        public function mce_external_plugins($plugin_array)
        {
            $plugin_array['simple_toc'] = plugin_dir_url(__FILE__) . 'assets/js/simple.toc.js';
            return $plugin_array;
        }

        public function mce_buttons($buttons)
        {
            array_push($buttons, 'simple_toc');
            return $buttons;
        }

        //when using tinymce button you need < > are encoded
        public function bainternet_generate_toc_encoded($content)
        {
            global $toc_u,$post;
            //$this->toc_by_h_tags($content);
            $pos = strpos($content, "[---TOC---]");
            if ($pos === false  || $toc_u) {
                return $content;
            }
            $pos = strpos($content, "[---TOC Header:");
            if ($pos >= 0) {
                $toc_header = '';
                $start = strpos($content, "[---TOC Header:");
                $end = strpos($content, "---]", $start);
                $h = substr($content, $start, ($end + 4 - $start));
                $he = str_replace('[---TOC Header:', '', $h);
                $he = str_replace('---]', '', $he);
                $toc = '<div class="toc"><div class="toc-head">'.apply_filters('Simple_TOC_Heading', $he, $post).'</div><div class="toc_list">';
                $content = str_replace($h, '', $content);
            } else {
                $toc = '<div class="toc"><div class="toc_list">';
            }
            $toc .= apply_filters('Simple_TOC_before_items', '', $post).'<ul>';
            $toc .= apply_filters('Simple_TOC_before_first_item', '', $post);
            $count = 0;
            while (strpos($content, "[---TOC Heading:") > 0) {
                $start = $end = $heading = $h = $anchor = '';
                $start = strpos($content, "[---TOC Heading:");
                $end = strpos($content, "---]", $start);
                $h = substr($content, $start, ($end + 4 - $start));
                $heading = str_replace("[---TOC Heading:", '', $h);
                $heading = str_replace("---]", '', $heading);
                $heading_slug = str_replace(" ", '-', $heading);
                //fix none unicode anchors?
                $heading_slug = apply_filters('Simple_TOC_Heading_Slugs', sanitize_title($heading_slug), $post);
                $anchor = '<a name="toc-'.$heading_slug.'" style="text-decoration: none;">&nbsp;&nbsp;</a>';
                $content = str_replace($h, $anchor, $content);
                $toc .= '<li class="toc_item"><a href="#toc-'.$heading_slug.'">'.$heading.'</a></li>';
                $count = $count + 1;
            }
            $toc .= apply_filters('Simple_TOC_After_Last_item', '', $post);
            $toc .= '</ul></div></div>';
            $content = str_replace("[---TOC---]", $toc, $content);
            $toc_u = true;
            return wptexturize($content);
        }

        //backwords capabilities
        public function bainternet_generate_toc($content)
        {
            global $toc_u;
            $pos = strpos($content, "<---TOC--->");
            if ($pos === false  || $toc_u) {
                return $content;
            }
            $toc = '<div class="toc"><div class="toc_list"><ul>';

            $count = 0;
            while (strpos($content, "<---TOC Heading:") > 0) {
                $start = $end = $heading = $h = $anchor = '';
                $start = strpos($content, "<---TOC Heading:");
                $end = strpos($content, "--->", $start);
                $h = substr($content, $start, ($end + 4 - $start));
                $heading = str_replace("<---TOC Heading:", '', $h);
                $heading = str_replace("--->", '', $heading);
                $heading_slug = str_replace(" ", '-', $heading);
                $anchor = '<a name="toc-'.$heading_slug.'" style="text-decoration: none;">&nbsp;&nbsp;</a>';
                $content = str_replace($h, $anchor, $content);
                $toc .= '<li class="toc_item"><a href="#toc-'.$heading_slug.'">'.$heading.'</a></li>';
                $count = $count + 1;
            }
            $toc .= '</ul></div></div>';
            $content = str_replace("<---TOC--->", $toc, $content);
            $toc_u = true;
            return $content;
        }


        public function toc_by_h_tags($content)
        {
            global $post;
            $pos = strpos($content, "[---ATOC---]");
            if ($pos === false) {
                return $content;
            }
            $pos = strpos($content, "[---TOC Header:");
            if ($pos != false) {
                $start = strpos($content, "[---TOC Header:");
                $end = strpos($content, "---]", $start);
                $h = substr($content, $start, ($end + 4 - $start));
                $he = str_replace('[---TOC Header:', '', $h);
                $he = str_replace('---]', '', $he);
                $toc = '<div class="toc"><div class="toc-head">'.apply_filters('Simple_TOC_Heading', $he, $post).'</div><div class="toc_list">';
                $content = str_replace($h, '', $content);
            } else {
                $toc = '<div class="toc"><div class="toc_list">';
            }
            $toc .= apply_filters('Simple_TOC_before_items', '', $post).'<ul>';
            $toc .= apply_filters('Simple_TOC_before_first_item', '', $post);
            //tag is?
            $start = $end = '';
            $start = strpos($content, "[---TAG:");
            $end = strpos($content, "---]", $start);
            $tag_c = substr($content, $start, ($end + 4 - $start));
            $tag = str_replace('[---TAG:', '', $tag_c);
            $tag = str_replace('---]', '', $tag);
            $content = str_replace($tag_c, '', $content);


            $count = 0;
            $doc = new DOMDocument();
            @$doc->loadHTML('<?xml encoding="'.get_bloginfo('charset').'">'.$content);
            $headings = $doc->getElementsByTagName($tag);
            foreach ($headings as $heading) {
                // Create the new element
                $anchor = $doc->createElement('a');
                $anchor->setAttribute('name', 'toc-'.$count);
                $anchor->setAttribute('style', 'text-decoration: none;');
                $anchor->innerHTML  = '&nbsp;&nbsp;';
                $heading->parentNode->insertBefore($anchor, $heading);
                $h = $heading_slug = $anchor = '';
                $h = $heading->nodeValue;
                $heading_slug = $count;
                $toc .= '<li class="toc_item"><a href="#toc-'.$heading_slug.'">'.$h.'</a></li>';
                $count++;
            }
            $content = $doc->saveHTML();
            $toc .= apply_filters('Simple_TOC_After_Last_item', '', $post);
            $toc .= '</ul></div></div>';

            $content = str_replace("[---ATOC---]", $toc, $content);
            return $content;
        }

        public function _my_plugin_links($links, $file)
        {
            $plugin = plugin_basename(__FILE__);
            if ($file == $plugin) { // only for this plugin
                    return array_merge($links,
                array( '<a href="http://en.bainternet.info/category/plugins">' . __('Other Plugins by this author') . '</a>' ),
                array( '<a href="http://wordpress.org/support/plugin/bainternet-simple-toc">' . __('Plugin Support') . '</a>' ),
                array( '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=K4MMGF5X3TM5L" target="_blank">' . __('Donate') . '</a>' )
            );
            }
            return $links;
        }
    } //end class
} //end if

$simple_toc = new simple_toc();
