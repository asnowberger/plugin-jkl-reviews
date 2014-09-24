<?php
/*
 * Plugin Name: JKL Reviews
 * Plugin URI: http://www.jekkilekki.com
 * Description: A simple Reviews plugin to review books, music, movies, products, or online courses with Star Ratings and links out to related sites.
 * Version: 0.1
 * Author: Aaron Snowberger
 * Author URI: http://www.aaronsnowberger.com
 * Text Domain: jkl-reviews
 * License: GPL2
 */

/*
 * Text Domain: (above) is used for Internationalization and must match the 'slug' of the plugin.
 * Doc: http://codex.wordpress.org/I18n_for_WordPress_Developers
 * 
 * Complex Meta boxes in WP (Reference): http://www.wproots.com/complex-meta-boxes-in-wordpress/
 */

/*
 * Reference Section: (Custom Meta Boxes)
 * http://www.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/
 * http://themefoundation.com/wordpress-meta-boxes-guide/
 * http://code.tutsplus.com/tutorials/how-to-create-custom-wordpress-writemeta-boxes--wp-20336
 */


// ##1 : Create metabox in Post editing page
add_action( 'add_meta_boxes', 'jkl_add_review_metabox' );

// ##2 : Display the actual Metabox and fields
// ##3 : Add and Use the WP Image Manager
add_action( 'admin_enqueue_scripts', 'jklrv_image_enqueue' );

// ##4 : Save metabox data
add_action( 'save_post', 'jkl_save_review_metabox' );

// ##5 : Add a shortcode to display the content box on the page
add_shortcode( 'review', 'jkl_review_box' );

// Register widgets
add_action( 'widgets_init', 'jkl_review_widget_init' );

/*
 * ##### 1 #####
 * First, ADD the metabox
 */

function jkl_add_review_metabox() {
    /* 
     * Doc http://codex.wordpress.org/Function_Reference/add_meta_box/
     * add_meta_box( $id, $title, $callback, $post_type, $context*, $priority*, $callback_args* ); 
     * $post_type cannot take an array of values
     * $context, $priority, $callback_args are optional values
     */ 
    
    add_meta_box( 
            'review_info', 
            __('Review Information', 'jkl-reviews'), 
            'display_jkl_review_metabox', 
            'post' 
    );
}


/*
 * ##### 2 #####
 * Second, DISPLAY Metabox (i.e. This is the Metabox handler)
 * 
 * @param WP_Post $post The object for the current post/page
 */

function display_jkl_review_metabox( $post ) {
    /*
     * Documentation on nonces: 
     * http://markjaquith.wordpress.com/2006/06/02/wordpress-203-nonces/
     * http://www.prelovac.com/vladimir/improving-security-in-wordpress-plugins-using-nonces
     */
    wp_nonce_field( basename(__FILE__), 'jklrv_nonce' ); // Add two hidden fields to protect against cross-site scripting.
    
    // Retrieve the current data based on Post ID
    $jklrv_stored_meta = get_post_meta( $post->ID );
    
    ?>

    <div class="wrap"> 
        <!-- Cover image. This should accept and display an image (like a Featured Image) using WP's image Uploader/chooser. -->
        <p> 
            <label for="jkl_review_cover" class="jkl_review_cover"><?php _e('Cover Image: ', 'jkl-reviews')?></label>
            <input type="text" id="jkl_review_cover" name="jkl_review_cover" 
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_cover'] ) ) echo $jklrv_stored_meta['jkl_review_cover'][0]; ?>" />
            <input type="button" id="jkl_review_cover_button" class="button" value="<?php _e( 'Choose or Upload an Image', 'jkl_review_cover' )?>" />
        </p>

        <!-- Title -->
        <p>
            <label for="jkl_review_title"><?php _e('Title: ', 'jkl-reviews')?></label>
            <input type="text" id="jkl_review_title" name="jkl_review_title" 
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_title'] ) ) echo $jklrv_stored_meta['jkl_review_title'][0]; ?>" />
        </p>

        <!-- Author. Should accept a String input, or also be able to select from a list of "most used" authors in a checkbox list. -->
        <p>
            <label for="jkl_review_author"><?php _e('Author: ', 'jkl-reviews')?></label>
            <input type="checkbox" id="jkl_review_author" name="jkl_review_author" 
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_author'] ) ) echo $jklrv_stored_meta['jkl_review_author'][0]; ?>" />
        </p>

        <!-- 
            Rating. This should be a range - able to accept numbers at least up to 5, possibly up to 10. 
            Create a range slider with JS as well: http://www.developerdrive.com/2012/07/creating-a-slider-control-with-the-html5-range-input/
        -->
        <p>
            <label for="jkl_review_rating"><?php _e('Rating: ', 'jkl-reviews')?></label>
            <input type="range" min="0" max="5" step="0.5" onchange="updateSlider(this.value)" 
                       id="jkl_review_rating" name="jkl_review_rating" 
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_rating'] ) ) echo $jklrv_stored_meta['jkl_review_rating'][0]; ?>" />
        </p>

        <!-- Series. Similar to Author. Accepts a String, or also a checkbox input of "most used" series. -->
        <p>
            <label for="jkl_review_series"><?php _e('Series: ', 'jkl-reviews')?></label>
            <input type="text" id="jkl_review_series" name="jkl_review_series" 
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_series'] ) ) echo $jklrv_stored_meta['jkl_review_series'][0]; ?>" />
        </p>

        <!-- Category. Similar to Author and Series. Actual functionality is like WP's native Categories. -->
        <p>
            <label for="jkl_review_category"><?php _e('Category: ', 'jkl-reviews')?></label>
            <input type="text" id="jkl_review_category" name="jkl_review_category" 
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_category'] ) ) echo $jklrv_stored_meta['jkl_review_category'][0]; ?>" />
        </p>

        <!-- Links. Should be able to select from a checkbox list of available links (like Amazon, product page, author's site, resources site, etc) and also accept a URL to those sites. -->
        <p>
            <label for="jkl_review_links"><?php _e('Links: ', 'jkl-reviews')?></label>
            <input type="checkbox" id="jkl_review_links" name="jkl_review_links" 
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_links'] ) ) echo $jklrv_stored_meta['jkl_review_links'][0]; ?>" />
        </p>
    </div>

    <?php
} 


/*
 * ##### 3 #####
 * Third, use the WP IMAGE MANAGER (i.e. load Image Management JS)
 */

function jklrv_image_enqueue() {
    global $typenow;
    if( $typenow == 'post' ) {
        wp_enqueue_media();
        
        // Registers and enqueues the required JS
        wp_register_script( 'jkl-upload-image', plugin_dir_url( __FILE__ ) . 'js/jkl-upload-image.js', array( 'jquery' ) );
        wp_localize_script( 'jkl-upload-image', 'jkl_review_cover',
                array(
                    'title' => __( 'Choose or Upload an Image', 'jkl-reviews' ),
                    'button' => __( 'Use this image', 'jkl-reviews' ),
                )
        );
        wp_enqueue_script( 'jkl-upload-image' );
    }
}


/*
 * ##### 4 #####
 * Fourth, Save the custom metadata
 */
function jkl_save_review_metabox($post_id) {
    
    /*
     * Verify this came from our screen and with proper authorization and that we're ready to save.
     */
    
    // Check if nonce is set
    if ( !isset( $_POST['jklrv_nonce'] ) ) return;
    
    // Verify the nonce is valid
    if ( !wp_verify_nonce( $_POST['jklrv_nonce'], basename(__FILE__) ) ) return;
    
    // Check for autosave (don't save metabox on autosave)
    if ( defined ('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    
    // Check user's editing permissions
    if ( !current_user_can( 'edit_page', $post_id ) ) return;
    
    /*
     * OK, after all those checks, now it's OK to save our data
     */
    
    // Save the Cover: Checks for input and saves image if needed
    if( isset($_POST[ 'jkl_review_cover' ] ) ) {
        update_post_meta();
    } 
    
    // Save the Title: Checks for input and sanitizes/saves if needed
    if( isset($_POST['jkl_review_title'] ) ) {
        update_post_meta( $post_id, 'jkl_review_title', $_POST['jkl_review_title'] );
    } 
    
    // Save the Author:
    if( isset($_POST['jkl_review_author'] ) ) {
        update_post_meta( $post_id, 'jkl_review_author', $_POST['jkl_review_author'] );
    } 
    
    // Save the Rating:
    if( isset($_POST['jkl_review_rating'] ) ) {
        update_post_meta( $post_id, 'jkl_review_rating', $_POST['jkl_review_rating'] );
    } 
    
    // Save the Series:
    if( isset($_POST['jkl_review_series'] ) ) {
        update_post_meta( $post_id, 'jkl_review_series', $_POST['jkl_review_series'] );
    }
    
    // Save the Category:
    if( isset($_POST['jkl_review_category'] ) ) {
        update_post_meta( $post_id, 'jkl_review_category', $_POST['jkl_review_category'] );
    } 
    
    // Save the Links:
    if( isset($_POST['jkl_review_links'] ) ) {
        update_post_meta( $post_id, 'jkl_review_links', $_POST['jkl_review_links'] );
    } 
}


/*
 * Shortcode Function
 */
function jkl_review_box($atts, $content) {
    $options = shortcode_atts(      // can also call this variable $atts if you want and just override the original - it'll work, but possibly not so clear as to what it's doing
        array(
            'size' => 'big',
            'content' => !empty($content) ? $content : ''
        ), $atts
    );
    
    extract($options);  // This extracts all the variables from the array to $size and $content, etc
    
    return ""; // Here is the actual (responsive) page styling for the box
}

/*
 * Register widget
 */
function jkl_review_widget_init() {
    register_widget(JKL_Review_Widget);
}

/*
 * Widget class
 */
class JKL_Review_Widget extends WP_Widget {
    /*
     *  Constructor + several settings (including CSS classes, etc)
     */
    function JKL_Review_Widget() {
        $widget_options = array(
            'classname' => 'jklrv_class', // CSS
            'description' => 'Show product review information from post metadata'
        );
        
        $this->WP_Widget('jklrv_id', 'Review Info', $widget_options);
    }
    
    /*
     * Show widget form in Appearance/Widgets
     */
    function form($instance) {
        $defaults = array('title' => 'Review Info');
        $instance = wp_parse_args( (array) $instance, $defaults );
        
        $title = esc_attr($instance['title']);
        
        echo '<p>Title <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'" /></p>';
    }
    
    /*
     * Save widget form
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    
    /*
     * Show widget in Post/Page
     */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        
        // Show only if single post
        if(is_single()) {
            echo $before_widget;
            echo $before_title.$title.$after_title;
            
            // Get Post metadata
            $review_info = esc_attr(get_post_meta(get_the_ID(), 'jkl_review_rating', true));
            
            // Print widget content
            echo '<iframe width="200" height="200" frameborder="0" allowfullscreen src="http://www.youtube.com/embed/'.get_yt_videoid($review_info).'"></iframe>';
            
            echo $after_widget;
        }
    }
}

/*
 * Get YouTube video ID from link
 * From: http://stackoverflow.com/questions/3392993/php-regex-to-get-youtube-video-id/
 */
function get_yt_videoid($url) {
    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
    return $my_array_of_vars['v'];
}
?>