<?php

/**
 * Represents the JKL Reviews Meta Box.
 * 
 * @since       2.0.0
 * 
 * @package     JKL_Reviews
 * @subpackage  JKL_Reviews/inc
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 * 
 * @link: https://github.com/tutsplus/authors-commentary
 * @link: http://code.tutsplus.com/tutorials/creating-maintainable-wordpress-meta-boxes--cms-22189
 * @link: https://tommcfarlin.com/object-oriented-wordpress-meta-boxes/
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
                array( $this, 'jkl_display_metabox' ),
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
    public function jkl_display_metabox() {
        
        global $post;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;
        
        include_once( 'template-parts/jkl-reviews-nav.php' );
        
    } // END jkl_display_meta_box()
    
    /**
     * Save the meta box information
     * 
     * @since   2.0.1
     */
    public function jkl_save_review_metabox() {

        /*
        * Ref: WP Codex: http://codex.wordpress.org/Function_Reference/add_meta_box
        * Verify this came from our screen and with proper authorization and that we're ready to save.
        */
        global $post;
        
        // Check nonce is set
        if ( !isset( $_POST[ 'jkl_reviews_nonce' ] ) ) return;
        
        // Verify the nonce is valid
        if ( !wp_verify_nonce( $_POST[ 'jkl_reviews_nonce' ], basename( __FILE__ ) ) ) return;
        
        // Check for autosave (don't save on autosave)
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        
        // Check user's editing permissions
        if ( !current_user_can( 'edit_page', $post_id ) ) return;
        
        ?><script>alert($_POST['cover']);</script>
        <?php
        /*
         * After all those checks, save the metadata.
         */
        update_post_meta( $post->ID, 'cover', $_POST['cover']);
        update_post_meta( $post->ID, 'title', $_POST['title']);
        update_post_meta( $post->ID, 'author', $_POST['author']);
        update_post_meta( $post->ID, 'publisher', $_POST['publisher']);
        update_post_meta( $post->ID, 'genre', $_POST['genre']);
        update_post_meta( $post->ID, 'series', $_POST['series']);
        update_post_meta( $post->ID, 'date', $_POST['date']);
        update_post_meta( $post->ID, 'length', $_POST['length']);
        update_post_meta( $post->ID, 'format', $_POST['format']);
        update_post_meta( $post->ID, 'description', $_POST['description']);
        update_post_meta( $post->ID, 'label', $_POST['label']);
        update_post_meta( $post->ID, 'details-1', $_POST['details-1']); // Array of values
        update_post_meta( $post->ID, 'details-2', $_POST['details-2']); // Array of values
        
    }
    
} // END JKL_Reviews_Metabox
} // END if ( ! class_exists( 'JKL_Reviews_Metabox' )
