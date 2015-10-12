<?php
/**
 * The plugin bootstrap file
 * 
 * This file is responsible for starting the plugin using the main plugin class file.
 * 
 * @since       2.0.0
 * @package     JKL_Reviews
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 * 
 * @wordpress-plugin
 * Plugin Name: JKL Reviews Working
 * Plugin URI:  https://github.com/jekkilekki/plugin-jkl-reviews
 * Description: A simple Reviews plugin to review books, music, movies, products, or online courses with Star Ratings and links out to related sites.
 * Version:     2.0.0
 * Author:      Aaron Snowberger
 * Author URI:  http://www.aaronsnowberger.com
 * Text Domain: jkl-reviews
 * License:     GPL2
 * 
 * Requires at least: 3.5
 * Tested up to: 4.3.1
 */

/**
 * JKL Reviews allows you to add product reviews to your site & display them as Google does.
 * Copyright (C) 2015  AARON SNOWBERGER (email: JEKKILEKKI@GMAIL.COM)
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/* 
 * Plugin Notes:
 * 
 * 1. WP Options Page (CPT or Shortcode or both?)
 * 2. CPT Constructor
 * 3. Shortcode
 * 4. Widget Code
 * 5. Styling
 */

/*
 * TO FIX (GITHUB ISSUES):
 * 1. Breaks "more" tag (displays all content)
 * 2. Make option to have smaller box on the side (perhaps Widget?)
 * 3. Allow Users to define Product Types (CPT)
 * 4. Allow User positioning (Shortcode)
 * 
 * TODO:
 * 1. Add i18n with EN + KO ( load_plugin_textdomain() )
 * 2. Allow input of mutliple categories as Terms (like Tags) (CPT)
 * 
 * UPCOMING:
 * 1. Shortcode to allow insertion anywhere in the post (beginning or end)
 * 2. Shortcode parameter 'small' to show a minimalized version of the box
 * 3. Sidebar widget to show latest books/products reviewed (might be dependent on...)
 * 4. Custom Post Type with custom Taxonomies for Review Types (can sort and display in widgets/index pages)
 * 5. WordPress options page to modify box CSS styles
 * 6. Incorporate AJAX for image chooser, Material Connection disclosure, CSS box styles, etc
 */

/**
 * Current OOP References:
 * @link WOW http://code.tutsplus.com/articles/object-oriented-programming-in-wordpress-building-the-plugin-i--cms-21083
 * 
 * @link http://code.tutsplus.com/articles/create-wordpress-plugins-with-oop-techniques--net-20153
 * @link http://www.yaconiello.com/blog/how-to-write-wordpress-plugin/ (MAIN SOURCE)
 * @link http://codex.wordpress.org/Function_Reference/add_options_page
 * @link https://catn.com/2014/10/06/tutorial-writing-a-simple-wordpress-plugin-from-scratch/
 * @link http://www.slideshare.net/mtoppa/object-oriented-programming-for-wordpress-plugin-development
 * @link https://iandunn.name/designing-object-oriented-plugins-for-a-procedural-application/
 * @link https://iandunn.name/content/presentations/wp-oop-mvc/oop.php#/
 * @link https://iandunn.name/content/presentations/wp-oop-mvc/mvc.php#/
 */

/* Prevent direct access */
if ( ! defined( 'WPINC' ) ) die;

/**
 * The class that represents the admin settings page
 */
require_once plugin_dir_path( __FILE__ ) . 'admin/admin-plugins-admin.php';

/**
 * The class that represents the meta box that will display the fields for the meta box
 */
require_once plugin_dir_path( __FILE__ ) . 'admin/class-jkl-reviews-settings.php';

/**
 * Load the core plugin class that is used to define the meta boxes, settings, etc
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/class-jkl-reviews.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/class-jkl-reviews-metabox.php';



function run_reviews() {
    // Instantiate the plugin class
    $JKL_Reviews = new JKL_Reviews( 'jkl-reviews', '2.0.0' );
}

run_reviews();
