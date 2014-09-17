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


// Show metabox in Post editing page
add_action( 'add_meta_boxes', 'jkl_add_metabox' );

// Save metabox data
add_action( 'save_post', 'jkl_save_metabox' );

// Register widgets
add_action( 'widgets_init', 'jkl_review_widget_init' );

function jkl_add_metabox() {
    /* 
     * Doc http://codex.wordpress.org/Function_Reference/add_meta_box/
     * add_meta_box( $id, $title, $callback, $post_type, $context*, $priority*, $callback_args* ); 
     * $post_type cannot take an array of values
     * $context, $priority, $callback_args are optional values
     */ 
    add_meta_box( 
            'review_info', 
            __('Review Information', 'jkl-reviews'), 
            'jkl_review_info', 
            'post' 
    );
}

/*
 * Meta box handler (i.e. Display Meta box)
 */
function jkl_review_info() {
    $value = get_post_custom($post->ID);
    
    /*
     * Documentation on nonces: 
     * http://markjaquith.wordpress.com/2006/06/02/wordpress-203-nonces/
     * http://www.prelovac.com/vladimir/improving-security-in-wordpress-plugins-using-nonces
     */
    wp_nonce_field( plugins_url(__FILE__), 'jkl_noncename' ); // Add two hidden fields to protect against cross-site scripting.
    
    ?> <p> 
        <label for="jklrv_cover"><?php _e('Cover Image: ', 'jkl-reviews'); ?>: </label>
        <input type="url" name="jklrv_cover" value="<?php echo get_post_meta($value, 'jklrv_cover', true); ?>" />
        <em>Must be a URL</em>
    </p>
    <?php
    /*
     * From Zenva Academy
     * 
    $cover = esc_attr($value['jkl_review_cover'][0]);
    echo '<label for="review_info">'._e('Cover Image: ', 'jkl-reviews').'</lable><input type="text" id="jkl_review_cover" name="jkl_review_cover" value="'.$cover.'" /><br />';
    
    $rating = esc_attr($value['jkl_review_rating'][0]);
    echo '<label for="review_info">'._e('Rating: ', 'jkl-reviews').'</label><input type="text" id="jkl_review_rating" name="jkl_review_rating" value="'.$rating.'" />';
     */
} 

/*
 * Save metadata
 */
function jkl_save_metabox($post_id) {
    // Don't save metadata if it's autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Check if user can edit the post
    if( !current_user_can( 'edit_post' ) ) {
        return;
    }
    
    if( isset($_POST['jkl_review_rating'] ) ) {
        // update_post_meta( $post_id, 'jkl_review_rating' esc_url($_POST['jkl_review_rating']));
    }
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