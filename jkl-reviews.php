<?php
/*
 * Plugin Name: JKL Reviews Working
 * Plugin URI: http://www.jekkilekki.com
 * Description: A simple Reviews plugin to review books, music, movies, products, or online courses with Star Ratings and links out to related sites.
 * Version: 2.0
 * Author: Aaron Snowberger
 * Author URI: http://www.aaronsnowberger.com
 * Text Domain: jkl-reviews
 * License: GPLv2
 * 
 * Requires at least: 3.8
 * Tested up to: 4.2.2
 *
 * @package 	JKL-Reviews
 * @category 	Core
 * @author 	Aaron Snowberger
 */

/*
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
//defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Reviews' ) ) {
    
    class JKL_Reviews {
        
        /**
         * Current version of the plugin.
         * @var string
         */
        protected $version; 
        
        /**
         * Type of plugin to run (Meta-boxes, CPT, or both).
         * @var string
         */
        protected $plugin_slug;
        
        /**
         * Default plugin options
         * @var array
         */
        protected $options;
        
        /**
         * Loader
         * @var array
         */
        protected $loader;
        
        
        /**
         * CONSTRUCTOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         * Initializes the JKL_Reviews object
         */
        public function __construct() {
            
            // Set the version number
            $this->version = '2.0';
            $this->plugin_slug = 'jkl-reviews-slug';
            
            // Get the initial plugin options (should it be 'protected' or 'public'?
            $this->options = get_option( 'jkl_reviews_options' );;
            $this->loader = [];
            
            // 
            //$this->load_dependencies();
            //$this->define_admin_hooks();
            
            
            // Incorporate Metaboxes
            require_once( sprintf ( "%s/inc/metaboxes.php", dirname( __FILE__ ) ) );
            $JKL_Reviews_Metabox = new JKL_Reviews_Metabox();
            
            // Incorporate Settings
            $this->jkl_admin_init();
//            require_once( sprintf ( "%s/admin/settings.php", dirname( __FILE__ ) ) );
//            $JKL_Reviews_Settings = new JKL_Reviews_Settings();
            
            // Incorporate Shortcode
            require_once( sprintf ( "%s/inc/shortcode.php", dirname( __FILE__ ) ) );
            $JKL_Reviews_Shortcode = new JKL_Reviews_Shortcode();
            
            // Incorporate Post Type
            require_once( sprintf ( "%s/inc/post-type.php", dirname( __FILE__ ) ) );
            $JKL_Reviews_Post_Type = new JKL_Reviews_Post_Type();
            
            // Incorporate Widget
            require_once( sprintf ( "%s/inc/widget.php", dirname( __FILE__ ) ) );
            $JKL_Reviews_Widget = new JKL_Reviews_Widget();
            
            // Incorporate Giveaways
            require_once( sprintf ( "%s/inc/giveaways.php", dirname( __FILE__ ) ) );
            $JKL_Reviews_Giveaways = new JKL_Reviews_Giveaways();
            
        } // END __contstruct
        
        /**
         * ACTIVATION !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         */
        
        /*
         * Activate the plugin
         */
        public static function activate() {
            
        } // END activate
        
        /*
         * Deactivate the plugin
         */
        public static function deactivate() {
            
        } // END deactivate
        
        public function get_version() {
            return $this->version;
        }
        
        /**
         * SETUP !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         */
        
        /**
         *  Load text domain for localization 
         */
        public function jkl_admin_init() {
            // Set up the settings for this plugin
            $this->jkl_init_settings();
            // Possibly do additional admin_init tasks
        } // END admin_init
        
        /*
         * Initialize some custom settings
         */
        public function jkl_init_settings() {
            
            /** 
             * Register the settings for this plugin
             * @source: http://codex.wordpress.org/Function_Reference/register_setting
             */
            require_once( sprintf( "%s/admin/settings.php", dirname( __FILE__ ) ) );
            $JKL_Reviews_Settings = new JKL_Reviews_Settings();
            
        } // END public function init_settings
  

    } // END class JKL_Reviews
} // END if(!class_exists())

/**
 * BUILD OBJECT !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */
if ( class_exists( 'JKL_Reviews' ) ) {
    
    // Installation and uninstallation hooks
    register_activation_hook( __FILE__, array( 'JKL_Reviews', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'JKL_Reviews', 'deactivate' ) );
    
    // Instantiate the plugin class
    $jklreviews = new JKL_Reviews();
    
    // Add a link to the settings page onto the plugin page
    if ( isset ( $jklreviews ) ) {
        
        // Add the settings link to the plugins page
        function jkl_plugin_settings_link( $links ) {
            $settings_link = '<a href="admin.php?page=jkl_reviews_settings">Settings</a>';
            array_unshift( $links, $settings_link );
            return $links;
        }
        
        $plugin = plugin_basename( __FILE__ );
        add_filter( "plugin_action_links_$plugin", 'jkl_plugin_settings_link' );
    }
}
