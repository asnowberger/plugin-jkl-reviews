<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Plugins_Admin' ) ) {
    
/** 
 * JKL Plugins Admin
 * 
 * Creates a Main Menu if none exists
 * 
 * @author Aaron Snowberger
 */
    
class JKL_Plugins_Admin {

    /**
     * CONSTRUCTOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    public function __construct() {

        add_action( 'admin_menu', array( &$this, 'jkl_add_plugins_menu' ) );
        
    } // END __construct()
    
    /**
     * ADD MAIN PLUGIN MENU ----------------------------------------------------
     */
    public function jkl_add_plugins_menu() {

        /**
         * Create a top-level menu item
         */
         add_menu_page(
                 __( 'JKL Plugins', 'jkl-reviews' ),
                 __( 'JKL Plugins', 'jkl-reviews' ),
                 'manage_options',
                 'jkl-plugins-main-menu',
                 'jkl_plugins_main_page',
                 'dashicons-admin-plugins'
         );
         
    }
    
} // END JKL_Plugins_Admin
} // END if ( ! class_exists( 'JKL_Plugins_Admin' )