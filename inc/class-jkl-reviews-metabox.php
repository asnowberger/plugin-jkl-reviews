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
        add_action( 'save_post', array( $this, 'jkl_save_review_metabox' ) );
        
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
    
    /**
     * Sanitizes and serializes the information associated with this post.
     * 
     * @since   2.0.1
     * 
     * @param   int     $post_id    The ID of the post that's currently being edited.
     */
    public function jkl_save_review_metabox() {
//        
//        // If not the right Post type or the user doesn't have privilege to save, exit
//        if ( ! $this->jkl_is_valid_post_type() || ! $this->jkl_user_can_save( $post_id, 'jkl_page_ss_nonce', 'jkl_page_ss_save' ) ) {
//            exit;
//        }
//        
    } // END jkl_save_post()
    
    /**
     * Verifies that the post type being saved is actually a Post.
     * 
     * @since   2.0.1
     * @access  private
     * @return  bool    Return true if we're in a post.
     */
//    private function jkl_is_valid_post_type() {
//        return ! empty( $_POST[ 'post_type' ] ) && 'post' == $_POST[ 'post_type' ];
//    }
    
    /**
     * Determines whether or not this user has the ability to Save the post
     * 
     * @since   2.0.1
     * @access  private
     * @param   int     $post_id        The ID of the post being saved.
     * @param   string  $nonce_action   The name of the action associated with the nonce.
     * @param   string  $nonce_id       The ID of the nonce field.
     * @return  bool                    Whether or not the user has the ability to Save.
     */
//    private function jkl_user_can_save( $post_id, $nonce_action, $nonce_id ) {
//        
//        $is_autosave = wp_is_post_autosave( $post_id );
//        $is_revision = wp_is_post_revision( $post_id );
//        $is_valid_nonce = ( isset( $_POST[ $nonce_action ] ) && wp_verify_nonce( $_POST[ $nonce_action ], $nonce_id ) );
//        
//        // Return true if the user is able to save
//        return ! ( $is_autosave || $is_revision ) && $is_valid_nonce;
//        
//    }
    
    
    
    
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
