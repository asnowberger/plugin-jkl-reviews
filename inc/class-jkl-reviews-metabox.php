<?php

/**
 * Represents the JKL Reviews Meta Box.
 * 
 * @since       2.0.0
 * 
 * @package     JKL_Reviews
 * @subpackage  JKL_Reviews/inc
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 */

/**
 * Represents the JKL Reviews Meta Box.
 * 
 * Registers the meta boxes with the WordPress API, sets the properties and 
 * renders the content by including the markup from its associated view.
 * 
 * Doc: https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 */

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Reviews_Metabox' ) ) {
    
class JKL_Reviews_Metabox {
    
    /**
     * Array of the labels for each of the Review Types in the Meta box
     * 
     * @since   2.0.1
     * 
     * @var     array
     */
    private $review_info = array();
    
    /**
     * CONSTRUCTOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * Register this class with the WordPress API
     * 
     * @since   2.0.0
     */
    public function __construct() {
        
        add_action( 'add_meta_boxes', array( $this, 'jkl_add_review_metabox' ) );
        //add_action( 'save_post', array( $this, 'jkl_save_review_metabox' ) );
        //add_action( 'admin_enqueue_scripts', array( $this, 'jkl_add_media_button' ) );
        
    } // END __construct()
    
    
    /**
     * METHODS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */

    /**
     * This function is responsible for creating the actual meta box
     * 
     * @since   2.0.0
     */
    public function jkl_add_review_metabox() {
        
        add_meta_box(
                'jkl-review-info-meta-box',
                __( 'JKL Reviews & Giveaways', 'jkl-reviews' ),
                array( $this, 'jkl_display_meta_box' ),
                'post',     // @TODO: Later, let the settings determine where to create this meta box
                'normal',
                'default'
        );
        
    } // END jkl_add_review_meta_box()
    
    /**
     * Render the content of the meta box
     * 
     * @since   2.0.0
     */
    public function jkl_display_meta_box() {
        
        include_once( 'template-parts/jkl-reviews-nav.php' );
        
    } // END jkl_display_meta_box()
    
} // END JKL_Reviews_Metabox
} // END if ( ! class_exists( 'JKL_Reviews_Metabox' )
