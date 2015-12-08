<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Reviews_Shortcode' ) ) {

/**
 * JKL Reviews Shortcode
 * Doc: https://codex.wordpress.org/Shortcode_API
 * 
 * @author Aaron Snowberger
 * @project JKL-Reviews
 * @link http://solislab.com/blog/how-to-make-shortcodes-user-friendly/
 */
    
class JKL_Reviews_Shortcode {

    public function __construct() {
        
        add_shortcode( 'jkl-reviews', array( $this, 'create_jkl_reviews_shortcode' ) );
        
        // Add shortcode support for widgets
        add_filter( 'widget_text', 'do_shortcode' );
        
    } // END __construct()
    
    /**
     * 
     */
    public function create_jkl_reviews_shortcode( $atts ) {
        
        // extract the attributes into variables
        extract( shortcode_atts( array(
            
        ), $atts ) );
        
        // pass the attributes to the makeReviewBox function to render the box
        return $this->makeReviewBox( $atts[ '' ] );
    }
    
} // END JKL_Reviews_Shortcode
} // END if ( ! class_exists( 'JKL_Reviews_Shortcode' )
