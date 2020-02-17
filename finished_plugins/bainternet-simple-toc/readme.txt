=== Simple TOC ===
Contributors: bainternet, adsbycb 
Donate link:http://en.bainternet.info/donations
Tags: table of contents, toc, wiki like toc
Requires at least: 3.4.0
Tested up to: 4.7.0
Stable tag: 0.9.0

create a wiki like TOC (table of contents) in your posts or pages using shortcode.

== Description ==

This plugin makes it easy to create a wiki like TOC (table of contents) in your posts or pages using shortcode, no linking or creating anchor is needed.

= Features: =

* Auto generate heding links in TOC based on given tag eg: h2,h3 (new)
* New TinyMCE (WordPress editor) button. (new)
* Added a new heading for TOC. (new)
* Create as many TOC as you want.
* TOC is per page/post basis.
* No coding or coding knowlage is required.

Any feedback or suggestions are welcome.

Also check out my <a href=\"http://en.bainternet.info/category/plugins\">other plugins</a>

== Installation ==

1.  Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation.
2.  Then activate the Plugin from Plugins page.
3.  Done!

== Frequently Asked Questions ==

= How to use? =

*New way

Simpler use the TinyMCE editor button.

*Old way

Simple, place `<---TOC--->` anywhere in you post or page where you want to the TOC to show.
Then for each eading you want added to the TOC add `<---TOC Heading:Heading_name--->` and change `Heading_name` with the actual mane you want the TOC heading link to be.

Now that is the old way, the new way would be to use the new tinymce button I've added to the plugin and simply select what you want to insert for example just click the new tinymce button select "Auto TOC heading" specify an html tag you use for headings like h2 or h3 and click insert.

= How to style the TOC =

I left the styling up to you but if you want the defualt style of wikipedia then add to your styles.css file:
`.toc{
    background-color: #F9F9F9;
    border: 1px solid #AAAAAA;
    padding: 5px;
}`
= I have Found a Bug, Now what? =

Simply use the <a href=\"http://wordpress.org/tags/bainternet-simple-toc?forum_id=10\">Support Forum</a> and thanks a head for doing that.
== Screenshots ==
1. TinyMCE button.

2. Simple interface for shortcode insertion.

3. Table of contents generated using Simple toc.


== Changelog ==
0.9.0 Updated Tinymce button to use the native tinymce window manager.

0.8.1 fixed WordPress 4.0.1 replacing 3 dashes `---` with a wide dash `—`

0.8.0 A much cleaner login for adding anchor tags which is now numeric and dosn't fail with wierd chars.

0.7.4 Fixed `Undefined variable: post in line 172` props to Stephen Harris.

0.7.3 Fixed Typo and added plugin row links.

0.7.2 internal release

0.7.1 Quick var_dupm clean.

0.7 Fixed utf-8 encoded bug on auto generated toc.
removed external Javascript file.

0.6 Fixed typo which caused Fatal error: Call to undefined function anitize_title().

0.5 Added filter hooks all over.

0.4 Added warring notice suppretion.

0.3 new auto heading generation, fixed html errors

0.2 New tinymce button for easy shortcode insertion.
added a header for TOC.

0.1 inital release.