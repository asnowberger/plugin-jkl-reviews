=== Plugin Name ===
Contributors: jekkilekki
Donate link: http://example.com/
Tags: affiliate, content, custom, custom meta box, review, book, music, movies, products, courses, services
Requires at least: 3.0.1
Tested up to: 4.0
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple Reviews plugin to review books, music, movies, products, or online courses with Star Ratings and links out to related sites.

== Description ==

As an avid reader, I wanted to create a plugin (using Custom Meta Boxes) that would allow me to quickly input and save things like:

* The Title
* Author name
* Cover image
* Category
* Book Series
* Star-rating
* Summary
* External links
** Affiliate/Product purchase link
** The Book's homepage
** The author's homepage
** The book resources page 

All these things print out neatly to the Post screen for reference, are responsive depending on screen width, 
and are Translation Ready. In addition to the Book Reviews type, there are also additional Review Type options:

* Book
* Audio
* Video
* Course
* Product
* Service
* Other

Each Review Type includes its own icon from FontAwesome. Both the Review Type icon and the Product page (external)
link updates depending on the Review Type selected.

== Installation ==

To install this plugin, simply download it from the WordPress Plugins database and install it as you would 
any other normal WordPress Plugin.

Alternatively, download the .ZIP folder, unzip it, then upload the `/jkl-reviews/` folder to your `/wp-content/plugins/` directory.

== Frequently Asked Questions ==

= How can I change the style of the plugin to match my website? =

While there are currently no built-in functions that allow for full customization of the plugin styles (though that is being
considered for future releases), each element within the `jkl_review_box` contains its own unique identifier, allowing you to 
hook into those in your own Custom CSS stylesheet.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets 
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png` 
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
Initial release

== Planned Upcoming Features ==

The following is a brief list of upcoming features that I'd like to further incorporate into this plugin.

1. Inclusion of FontAwesome
1. Custom Post Type
1. Custom Taxonomy
1. Shortcode
1. Parameters 'big' and 'small' to change the display box features
1. Option to change colors
1. Override (optional) the Post Featured Image with the Cover Image you choose
1. Overlay Star-ratings over the Featured Image on Archive pages
1. WordPress Options panel
1. CSS animations
1. Dropdown menu to select different icons for external links or Review Type

== A brief Markdown Example ==

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`