<?php
/*
 * The main plugin class that handles all other plugin parts.
 * 
 * Defines the plugin name, version, and hooks for enqueing the stylesheet and JavaScript.
 * 
 * @package     JKL_Reviews
 * @subpackage  JKL_Reviews/inc
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 */

/* Prevent direct access */
//defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Reviews' ) ) {
    
    class JKL_Reviews {
        
        /**
         * The ID of this plugin.
         * 
         * @since   2.0.1
         * @access  private
         * @var     string  $name       The ID of this plugin.
         */
        private $name;
        
        /**
         * Current version of the plugin.
         * 
         * @since   2.0.0
         * @access  private
         * @var     string  $version    The current version of this plugin.
         */
        private $version; 
        
        /**
         * Admin Settings Page
         * 
         * @since   2.0.1
         * @access  private
         * @var     JKL_Reviews_Settings    $settings_page  A reference to the admin settings page.
         */
        private $settings_page;
        
        /**
         * Metabox
         * 
         * @since   2.0.1
         * @access  private
         * @var     JKL_Reviews_Metabox     $meta_box   A reference to the meta box.
         */
        private $meta_box;
        
        
        /**
         * CONSTRUCTOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         * Initializes the JKL_Reviews object and set its properties
         * 
         * @since   2.0.0
         * @var     string  $name       The name of this plugin.
         * @var     string  $version    The version of this plugin.
         */
        public function __construct( $name, $version ) {
            
            // Set the name and version number
            $this->name = $name;
            $this->version = $version;
            //$this->plugin_slug = 'jkl-reviews-slug';
            
            // Get the initial plugin options (should it be 'protected' or 'public'?
            //$this->options = get_option( 'jkl_reviews_options' );;
            
            $this->settings_page = new JKL_Reviews_Settings();
            $this->meta_box = new JKL_Reviews_Metabox();
            
            add_action( 'admin_enqueue_scripts', array( $this, 'jkl_enqueue_admin_styles' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'jkl_enqueue_admin_scripts' ) );

            /**
             * Load optional plugin components
             */

            // Incorporate Shortcode
            //if( $this->options[ 'use_shortcode' ] ) {
                //require_once( sprintf ( "%s/inc/class-jkl-reviews-shortcode.php", dirname( __FILE__ ) ) );
                //$JKL_Reviews_Shortcode = new JKL_Reviews_Shortcode();
            //}
            
            // Incorporate Post Type
            //if( $this->options[ 'use_cpt' ] ) {
                //require_once( sprintf ( "%s/inc/class-jkl-reviews-post-type.php", dirname( __FILE__ ) ) );
                //$JKL_Reviews_Post_Type = new JKL_Reviews_Post_Type();
            //}
            
            // Incorporate Widget
            //if( $this->options[ 'use_widget' ] ) {
                //require_once( sprintf ( "%s/inc/class-jkl-reviews-widget.php", dirname( __FILE__ ) ) );
                //$JKL_Reviews_Widget = new JKL_Reviews_Widget();
            //}
            
            // Incorporate Giveaways
            //if( $this->options[ 'use_giveaways' ] ) {
                //require_once( sprintf ( "%s/inc/class-jkl-reviews-giveaways.php", dirname( __FILE__ ) ) );
                //$JKL_Reviews_Giveaways = new JKL_Reviews_Giveaways();
            //}
            
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
         * Enqueues all files specifically for the dashboard.
         * 
         * @since   0.1.0
         */
        public function jkl_enqueue_admin_styles() {
            
            // Add FontAwesome for our lovely font icons
            wp_enqueue_style( 
                    'fontawesome', 
                    '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css'
            );
            
            wp_enqueue_style(
                    $this->name . '-admin',
                    plugins_url( 'jkl-reviews-working/admin/css/admin.css' ),
                    false,
                    $this->version
            );
            
            wp_enqueue_style(
                    $this->name . '-datepicker',
                    plugins_url( 'jkl-reviews-working/admin/css/datepicker.css' ),
                    false,
                    $this->version
            );
            
            wp_enqueue_style(
                    $this->name . '-rangeslider',
                    plugins_url( 'jkl-reviews-working/admin/css/rangeslider.css' ),
                    false,
                    $this->version
            );
            
        } // END jkl_enqueue_admin_styles()
        
        /**
         * Enqueues Javascript file that is necessary to control the toggling of the meta box
         */
        public function jkl_enqueue_admin_scripts() {
            
            if ( 'post' === get_current_screen()->id ) {
                
                wp_enqueue_media();
                
                wp_enqueue_script( 'jquery-ui-datepicker' );
                wp_enqueue_script( 'jquery-ui-sortable' );
                wp_enqueue_script( 'jquery-ui-slider' );
                
                wp_enqueue_script(
                        $this->name . '-tabs',
                        plugins_url( 'jkl-reviews-working/inc/js/tabs.js' ),
                        array( 'jquery' ),
                        $this->version
                );
                
                wp_enqueue_script(
                        $this->name . '-review-type',
                        plugins_url( 'jkl-reviews-working/inc/js/review-type.js' ),
                        array( 'jquery' ),
                        $this->version
                );
                
                wp_enqueue_script(
                        $this->name . '-links',
                        plugins_url( 'jkl-reviews-working/inc/js/add-links.js' ),
                        array( 'jquery' ),
                        $this->version
                );
                
                wp_enqueue_script(
                        $this->name . '-details',
                        plugins_url( 'jkl-reviews-working/inc/js/add-details.js' ),
                        array( 'jquery' ),
                        $this->version
                );
                
                wp_enqueue_script(
                        $this->name . '-ratings',
                        plugins_url( 'jkl-reviews-working/inc/js/add-rating.js' ),
                        array( 'jquery' ),
                        $this->version
                );
                
                wp_enqueue_script(
                        $this->name . '-media',
                        plugins_url( 'jkl-reviews-working/inc/js/upload-cover.js' ),
                        array( 'jquery' ),
                        $this->version
                );
                
            }
            
        } // END jkl_enqueue_admin_scripts()
        
        /**
         * SETUP !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         */
        
        /**
         *  Load text domain for localization 
         */
        
  

    } // END class JKL_Reviews
} // END if(!class_exists())


