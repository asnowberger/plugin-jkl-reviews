<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Reviews_Metabox' ) ) {

/**
 * JKL Reviews Metaboxes
 * Doc: https://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes
 * 
 * @author Aaron Snowberger
 * @project JKL-Reviews
 */
    
class JKL_Reviews_Metabox {

    /**
     * Be sure we're using the most recent version - don't load old cached files
     * @var type 
     */
    private $version;
    
    /**
     * CONSTRUCTOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     * @param type $version
     */
    public function __construct( $version ) {
        
        $this->version = $version;
        
    } // END __construct()
    
    
    /**
     * METHODS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    
    /**
     * Enqueues the stylesheet to display the Single Post Metabox on the Dashboard
     */
    public function jkl_single_meta_box_style() {
        
        wp_enqueue_style(
                'jkl-single-post-meta-box',
                plugin_dir_url( __FILE__ ) . 'css/single-post-metabox.css',
                array(),
                $this->version,
                FALSE
        );
        
    } // END jkl_single_meta_box_style()
    
    /**
     * Add Metabox to the Post content type
     * Doc: http://codex.wordpress.org/Function_Reference/add_meta_box/
     */
    public function jkl_add_meta_box() {
        
        add_meta_box( 
            'review_info',                                  // Unique ID
            __('Review Information', 'jkl-reviews'),        // Title
            array( $this, 'jkl_render_meta_box' ),          // Callback function
            'post',                                         // Post type to display on
            'normal',                                       // Context
            'core'                                          // Priority
                                                            // Callback_args
        );
        
    } // END jkl_add_meta_box()
    
    /**
     * Callback to get the file to create the metabox
     */
    public function jkl_render_meta_box() {
        
        require_once plugin_dir_path( __FILE__ ) . 'template-parts/single-post-metabox.php';
        
    } // END jkl_render_meta_box()
    
} // END JKL_Reviews_Metabox
} // END if ( ! class_exists( 'JKL_Reviews_Metabox' )
