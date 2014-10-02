<?php
/*
 * Plugin Name: JKL Reviews
 * Plugin URI: http://www.jekkilekki.com
 * Description: A simple Reviews plugin to review books, music, movies, products, or online courses with Star Ratings and links out to related sites.
 * Version: 0.1
 * Author: Aaron Snowberger
 * Author URI: http://www.aaronsnowberger.com
 * Text Domain: jkl-reviews/languages
 * License: GPL2
 */

/*
 * Text Domain: (above) is used for Internationalization and must match the 'slug' of the plugin.
 * Doc: http://codex.wordpress.org/I18n_for_WordPress_Developers
 */

/*
 * Reference Section: (Custom Meta Boxes)
 * Complex Meta boxes in WP (Reference): http://www.wproots.com/complex-meta-boxes-in-wordpress/
 * http://www.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/
 * http://themefoundation.com/wordpress-meta-boxes-guide/
 * http://code.tutsplus.com/tutorials/how-to-create-custom-wordpress-writemeta-boxes--wp-20336
 */


// ##0 : Enqueue the CSS styles for the metabox (both admin and in the_content)
add_action( 'admin_enqueue_scripts', 'jkl_review_style');
add_action( 'the_content', 'jkl_get_review_box_style');

// ##1 : Create metabox in Post editing page
add_action( 'add_meta_boxes', 'jkl_add_review_metabox' );

// ##2 : Display the actual Metabox and fields
// ##3 : Add and Use the WP Image Manager
add_action( 'admin_enqueue_scripts', 'jklrv_image_enqueue' );

// ##4 : Save metabox data
add_action( 'save_post', 'jkl_save_review_metabox' );

// ##5 : Display metabox data (and CSS style) straight up on a Post
add_action( 'the_content', 'jkl_display_review_box' );

// ##6 : Call various helper functions for displaying the metabox (no hooks necessary)


/*
 * ##### 0 #####
 * Before everything else, queue up the CSS styles for this metabox
 */

// CSS styles for the admin area
function jkl_review_style() {
    wp_register_style( 'jkl_review_css', plugin_dir_url( __FILE__ ) . '/css/style.css', false, '1.0.0' );
    wp_enqueue_style( 'jkl_review_css' );
    
    // Also, add Font Awesome to our back-end styles
    wp_enqueue_style( 'fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' );
}

// CSS styles for the Post
function jkl_get_review_box_style() {
    wp_register_style( 'jkl_review_box_display_css', plugin_dir_url( __FILE__ ) . '/css/boxstyle.css', false, '1.0.0' );
    wp_enqueue_style( 'jkl_review_box_display_css' );
    
    // Also, add Font Awesome to our front-end styles
    wp_enqueue_style( 'fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' );
}


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
            'review_info',                                      // Unique ID
            __('Review Information', 'jkl-reviews/languages'),  // Title
            'display_jkl_review_metabox',                       // Callback function
            'post'                                              // Post type to display on
                                                                // Context
                                                                // Priority
                                                                // Callback_args
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
    
    // Call a separate function to evaluate the value stored for the radio button and return a string to correspond to its FontAwesome icon
    $jklrv_fa_icon = jkl_get_fa_icon( $jklrv_stored_meta['jkl-radio'][0] );
    
    /*
     * Metabox fields
     * 0. Review Type (radio)       => jkl_radio
     * 1. Cover Image               => jkl_review_cover
     * 2. Title                     => jkl_review_title
     * 3. Author                    => jkl_review_author
     * 4. Series                    => jkl_review_series
     * 5. Category                  => jkl_review_category
     * 6. Rating                    => jkl_review_rating
     * 7. Summary                   => jkl_review_summary_area
     * 8. Affiliate Link            => jkl_review_affiliate_uri
     * 9. Product Link              => jkl_review_product_uri
     * 10. Author Link              => jkl_review_author_uri
     * 11. Resources Link           => jkl_review_resources_uri
     */
    
    // Ref: TutsPlus Working with Meta Boxes Video Course
    
    // If we want to show the values we've stored, there are 2 ways to do that:
    // 0. $jklrv_stored_meta = get_post_meta( $post->ID );
    // 1. if ( isset ( $jklrv_stored_meta['identifier'] ) ) echo $jklrv_stored_meta['identifier'][0];
    // 2. $html .= <input type="text" value="' . get_post_meta( $post->ID, 'identifier', true ) . '" />';
    
    // Test your saved values are stripped of tags by trying to save:
    // <script>alert('Hello world!');</script>
    
    // TODO: Be sure all data validation/sanitization is complete
    ?>

    <!-- REVIEW INFORMATION TABLE -->
    <table class="jkl_review"> 
        
        <!-- ##### PRODUCT INFORMATION TABLE -->
        <tr><th colspan="2"><?php _e( 'Product Information', 'jkl-reviews/languages') ?></th></tr>
        <tr class="divider"></tr>
        
        <!-- Product Type. Select the radio button corresponding to the product you are reviewing -->
        <tr>
            <td class="left-label">
                <label for="jkl-product-type" class="jkl_label"><?php _e('Product Type: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <div class="radio">
                <label for="jkl-book-type" id="jkl-book-type">
                    <input type="radio" name="jkl_radio" id="jkl-radio-book" value="book" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'book' ); ?>>
                    <i class="fa fa-book"></i><span class="note"><?php _e('Book', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-audio-type" id="jkl-audio-type">
                    <input type="radio" name="jkl_radio" id="jkl-radio-audio" value="audio" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'audio' ); ?>>
                    <i class="fa fa-headphones"></i><span class="note"><?php _e('Audio', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-video-type" id="jkl-video-type">
                    <input type="radio" name="jkl_radio" id="jkl-radio-video" value="video" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'video' ); ?>>
                    <i class="fa fa-play-circle"></i><span class="note"><?php _e('Video', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-course-type" id="jkl-course-type">
                    <input type="radio" name="jkl_radio" id="jkl-radio-course" value="course" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'course' ); ?>>
                    <i class="fa fa-pencil-square-o"></i><span class="note"><?php _e('Course', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-product-type" id="jkl-product-type">
                    <input type="radio" name="jkl_radio" id="jkl-radio-product" value="product" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'product' ); ?>>
                    <i class="fa fa-archive"></i><span class="note"><?php _e('Product', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-service-type" id="jkl-service-type">
                    <input type="radio" name="jkl_radio" id="jkl-radio-service" value="service" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'service' ); ?>>
                    <i class="fa fa-gift"></i><span class="note"><?php _e('Service', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-other-type" id="jkl-other-type">
                    <input type="radio" name="jkl_radio" id="jkl-radio-other" value="other" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'other' ); ?>>
                    <i class="fa fa-star"></i><span class="note"><?php _e('Other', 'jkl-reviews/languages')?></span>
                </label>
                </div>
            </td>
        </tr>
        
        <tr><td colspan="2"><div class="divider-lite"></div></td></tr>
        
        <!-- Cover image. This should accept and display an image (like a Featured Image) using WP's image Uploader/chooser. -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_cover" class="jkl_label"><?php _e('Product Image: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_cover" name="jkl_review_cover" 
                           value="<?php if( isset( $jklrv_stored_meta['jkl_review_cover'] ) ) echo esc_url( $jklrv_stored_meta['jkl_review_cover'][0] ); ?>" />
                <input type="button" id="jkl_review_cover_button" class="button" value="<?php _e( 'Choose or Upload an Image', 'jkl_review/languages' )?>" />
            </td>
        </tr>
        
        <!-- Cover image preview. This should only display the cover image IF THERE IS ONE. -->
        <?php if ( $jklrv_stored_meta['jkl_review_cover'][0] != '' ) { ?>
        <tr>
            <td class="left-label">
                <label for="jkl_review_cover_preview" class="jkl_label"><?php _e('Product Image Preview: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <div id="jkl_cover_preview">
                    <img src="<?php echo esc_url( $jklrv_stored_meta['jkl_review_cover'][0] ); ?>" />
                </div>
            </td>
        </tr>
        <?php } ?>

        <!-- Title -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_title" class="jkl_label"><?php _e('Title: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="text" class="input-text" id="jkl_review_title" name="jkl_review_title" 
                           value="<?php if( isset( $jklrv_stored_meta['jkl_review_title'] ) ) echo $jklrv_stored_meta['jkl_review_title'][0]; ?>" />
            </td>
        </tr>

        <!-- Author -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_author" class="jkl_label"><?php _e('Author: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="text" class="input-text" id="jkl_review_author" name="jkl_review_author" 
                           value="<?php if( isset( $jklrv_stored_meta['jkl_review_author'] ) ) echo $jklrv_stored_meta['jkl_review_author'][0]; ?>" />
            </td>
        </tr>

        <!-- Series -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_series" class="jkl_label"><?php _e('Series: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="text" class="input-text" id="jkl_review_series" name="jkl_review_series" 
                           value="<?php if( isset( $jklrv_stored_meta['jkl_review_series'] ) ) echo $jklrv_stored_meta['jkl_review_series'][0]; ?>" />
            </td>
        </tr>

        <!-- Category. Should (eventually) act as WP Tags, separate-able by commas, including the list + X marks to remove categories -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_category" class="jkl_label"><?php _e('Category: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="text" class="input-text" id="jkl_review_category" name="jkl_review_category" 
                           value="<?php if( isset( $jklrv_stored_meta['jkl_review_category'] ) ) echo $jklrv_stored_meta['jkl_review_category'][0]; ?>" />
                <p class="note"><?php _e( 'Separate multiple values with commas.', 'jkl-reviews/languages' ) ?></p>
            </td>
        </tr>
    </table>
      
    <!-- ##### PRODUCT RATING TABLE -->
    <table class="jkl_review">
        <tr><th colspan="2"><?php _e( 'Product Rating', 'jkl-reviews/languages' ) ?></th></tr>
        <tr class="divider"></tr>
        <!-- 
            Rating. This is a range slider from 0-5 with 0.5 step increments.
            Consider implementing a fallback for older browsers.
            Ref: JS range slider: http://www.developerdrive.com/2012/07/creating-a-slider-control-with-the-html5-range-input/
        -->
        <tr>
            <td class="left-label rating-label">
                <label for="jkl_review_rating" class="jkl_label"><?php _e('Rating: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <span class="range-number-left">0</span> 
                <input type="range" min="0" max="5" step="0.5" list="stars" onchange="showValue(this.value)" 
                           id="jkl-review-rating" name="jkl_review_rating" 
                           value="<?php echo isset( $jklrv_stored_meta['jkl_review_rating'] ) ? $jklrv_stored_meta['jkl_review_rating'][0] : 0; ?>" />
                <datalist id="stars">
                    <option>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </datalist>
                <span class="range-number-right">5</span>
                
                <output for="jkl_review_rating" id="star-rating">
                    <?php echo isset( $jklrv_stored_meta['jkl_review_rating'] ) ? $jklrv_stored_meta['jkl_review_rating'][0] : 0; ?>
                </output>
                <span id="star-rating-text"><?php _e( 'Stars', 'jkl-reviews/languages' ) ?></span>
                
                <!-- Simple function to dynamically update the output value of the range slider after user releases the mouse button -->
                <script>
                function showValue(rating) {
                    document.querySelector('#star-rating').value = rating;
                }
                </script>
            </td>
        </tr>
        <tr>
            <td class="left-label">
                <label for=jkl_review_summary" class="jkl_label"><?php _e('Summary: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <textarea id="jkl_review_summary_area" name="jkl_review_summary_area"><?php if( isset( $jklrv_stored_meta['jkl_review_summary_area'] ) ) echo $jklrv_stored_meta['jkl_review_summary_area'][0]; ?></textarea>
            </td>
        </tr>
    </table>

    <!-- ##### PRODUCT LINKS TABLE -->
    <table class="jkl_review">
        <tr><th colspan="2"><?php _e( 'Product Links', 'jkl-reviews/languages' ) ?></th></tr>
        <tr class="divider"></tr>
        
        <!-- Affiliate Link -->
        <tr>
            <td class="left-label">
                <label for="jkl_affiliate_uri" class="jkl_label"><?php _e('Affiliate Link: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_affiliate_uri" name="jkl_review_affiliate_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_affiliate_uri'] ) ) echo $jklrv_stored_meta['jkl_review_affiliate_uri'][0]; ?>" />
        </tr> <!-- TODO: Implement an Affiliate link Disclaimer message and checkbox option to turn it on/off. -->
        
        <!-- Product Homepage -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_product_uri" class="jkl_label"><?php _e('Link to Product Page: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_product_uri" name="jkl_review_product_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_product_uri'] ) ) echo $jklrv_stored_meta['jkl_review_product_uri'][0]; ?>" />
        </tr>
        
        <!-- Author Homepage -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_author_uri" class="jkl_label"><?php _e('Link to Author Homepage: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_author_uri" name="jkl_review_author_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_author_uri'] ) ) echo $jklrv_stored_meta['jkl_review_author_uri'][0]; ?>" />
            </td>
        </tr>       
        
        <!-- Resources Page -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_resources_uri" class="jkl_label"><?php _e('Link to Resources Page: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_resources_uri" name="jkl_review_resources_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_resources_uri'] ) ) echo $jklrv_stored_meta['jkl_review_resources_uri'][0]; ?>" />
            </td>
        </tr>        
        
    </table>

    <?php
} 


/*
 * ##### 3 #####
 * Third, use the WP IMAGE MANAGER (i.e. load Image Management JS)
 */

function jklrv_image_enqueue() {
    // Determine the current Post type
    global $typenow;
    
    if( $typenow == 'post' ) {
        wp_enqueue_media();
        
        // Registers and enqueues the required JS
        wp_register_script( 'upload-image', plugin_dir_url( __FILE__ ) . 'js/upload-image.js', array( 'jquery' ) );
        wp_localize_script( 'upload-image', 'jkl_review_cover',
                array(
                    'title' => __( 'Select a Cover', 'jkl-reviews/languages' ),
                    'button' => __( 'Use this Cover', 'jkl-reviews/languages' ),
                )
        );
        wp_enqueue_script( 'upload-image' );
    }
}


/*
 * ##### 4 #####
 * Fourth, Save the custom metadata
 */
function jkl_save_review_metabox($post_id) {
    
    /*
     * Ref: WP Codex: http://codex.wordpress.org/Function_Reference/add_meta_box
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
     * After all those checks, save. TODO: Sanitize
     */
    
    // Save the Review Type (radio button selection)
    if( isset($_POST[ 'jkl_radio' ] ) ) {
        update_post_meta( $post_id, 'jkl_radio', $_POST['jkl_radio'] );
    }

    // Save the Cover: Checks for input and saves image if needed
    if( isset($_POST[ 'jkl_review_cover' ] ) ) {
        update_post_meta( $post_id, 'jkl_review_cover', $_POST['jkl_review_cover'] );
    } 

    // Save the Title: Checks for input and sanitizes/saves if needed
    if( isset($_POST['jkl_review_title'] ) ) {
        update_post_meta( $post_id, 'jkl_review_title', $_POST['jkl_review_title'] );
    } 

    // Save the Author:
    if( isset($_POST['jkl_review_author'] ) ) {
        update_post_meta( $post_id, 'jkl_review_author', $_POST['jkl_review_author'] );
    } 

    // Save the Series:
    if( isset($_POST['jkl_review_series'] ) ) {
        update_post_meta( $post_id, 'jkl_review_series', $_POST['jkl_review_series'] );
    }

    // Save the Category:
    if( isset($_POST['jkl_review_category'] ) ) {
        update_post_meta( $post_id, 'jkl_review_category', $_POST['jkl_review_category'] );
    } 

    // Save the Rating:
    if( isset($_POST['jkl_review_rating'] ) ) {
        update_post_meta( $post_id, 'jkl_review_rating', $_POST['jkl_review_rating'] );
    } 

    // Save the Summary:
    if( isset($_POST['jkl_review_summary_area'] ) ) {
        update_post_meta( $post_id, 'jkl_review_summary_area', $_POST['jkl_review_summary_area'] );
    } 

    // Links and Options Below:
    // Save the Links:
    if( isset($_POST['jkl_review_affiliate_uri'] ) ) {
        update_post_meta( $post_id, 'jkl_review_affiliate_uri', $_POST['jkl_review_affiliate_uri'] );
    }
    if( isset($_POST['jkl_review_product_uri'] ) ) {
        update_post_meta( $post_id, 'jkl_review_product_uri', $_POST['jkl_review_product_uri'] );
    }
    if( isset($_POST['jkl_review_author_uri'] ) ) {
        update_post_meta( $post_id, 'jkl_review_author_uri', $_POST['jkl_review_author_uri'] );
    }
    if( isset($_POST['jkl_review_resources_uri'] ) ) {
        update_post_meta( $post_id, 'jkl_review_resources_uri', $_POST['jkl_review_resources_uri'] );
    }
}


/*
 * ##### 5 #####
 * Fifth, just display the review content straight up on a Post
 */
function jkl_display_review_box( $content ) {
    
    // Make sure that this is a single post and not an index page
    if ( is_single() ) {
        
    // Retrieve Post meta info
    $jklrv_stored_meta = get_post_meta( get_the_ID() );
    // Get the appropriate string to display the correct FontAwesome icon per Review Type
    $jklrv_fa_icon = jkl_get_fa_icon( $jklrv_stored_meta['jkl_radio'][0] );
    // Get the correct number of FontAwesome stars string
    $jklrv_fa_rating = jkl_get_fa_rating( $jklrv_stored_meta['jkl_review_rating'][0] );
    
    /*
     * By the way, don't forget, this is how to add images from your plugin directory
     * <img src="' . plugins_url( 'imgs/' . $jklrv_stored_meta['jkl_radio'][0] . '-dk.png', __FILE__ ) . '" alt="Product link" />
     */
    
    /*
     * If there's AT LEAST a Review Type selected AND a Title, create the display box
     * If there is no Review Type AND no Title (you need both) just return the $content (below)
     */
    
    if ( $jklrv_stored_meta['jkl_radio'][0] !== '' && $jklrv_stored_meta['jkl_review_title'][0] !== '' ) {
    
        echo '<div id="jkl_review_box"><div id="jkl_review_box_head">';  
            // Display the FontAwesome Review Type icon
            echo '<i id="jkl_fa_icon" class="fa fa-' . $jklrv_fa_icon . '"></i>';
        
            // If there's a Category set, display it, otherwise, display nothing (only the Review Type icon)
            if ( $jklrv_stored_meta['jkl_review_category'][0] !== '' )
                echo '<p id="jkl_review_box_categories">' . $jklrv_stored_meta['jkl_review_category'][0] . '</p>';
            echo '</div>'; // End review box head
            
        // We already checked for a Review Type and Title, so this <div> is safe to create
        echo '<div id="jkl_review_box_body">';
            
            // If there's no Cover Image set, just show a larger Review Type icon
            if ( $jklrv_stored_meta['jkl_review_cover'][0] === '' ) {
                echo '<h1 id="jkl_review_box_cover" class="fa fa-' . $jklrv_fa_icon . '"></h1>';
            } else {
                echo '<img id="jkl_review_box_cover" src=' . $jklrv_stored_meta['jkl_review_cover'][0] . ' alt="' . $jklrv_stored_meta['jkl_review_title'][0] . '" />';
            }
            
            // This is where Review data goes
            echo '<div id="jkl_review_box_info">';
            
                // Show the title (since we already checked for it before showing the Review box itself)
                echo '<p><strong>' . $jklrv_stored_meta['jkl_review_title'][0] . '</strong></p>'; // Title
                
                // Check all the other info and if present, show it, but if not, don't show it
                if ( $jklrv_stored_meta['jkl_review_author'][0] !== '' )
                    echo jkl_get_author_link ($jklrv_stored_meta['jkl_review_author'][0], $jklrv_stored_meta['jkl_review_author_uri'][0] );  // Author
                if ( $jklrv_stored_meta['jkl_review_series'][0] !== '' )
                    echo '<p>' . _e( 'Series', 'jkl-reviews/languages' ) . ': ' . $jklrv_stored_meta['jkl_review_series'][0] . '</p>'; // Series
                if ( $jklrv_stored_meta['jkl_review_rating'][0] != 0 )
                    echo '<p>' . $jklrv_fa_rating . '<span>' . $jklrv_stored_meta['jkl_review_rating'][0] . ' ' . _e( 'Stars', 'jkl-reviews/languages') . '</span></p>'; // Rating
                
                // Check that there's AT LEAST ONE external link. If not, don't even create the links box.
                if ( $jklrv_stored_meta['jkl_review_affiliate_uri'][0] !== '' or $jklrv_stored_meta['jkl_review_homepage_uri'][0] !== '' or $jklrv_stored_meta['jkl_review_authorpage_uri'][0] !== '' or $jklrv_stored_meta['jkl_review_resources_uri'][0] !== '' ) {
                echo '<div id="jkl_review_box_links_box">'; // Links box
                
                    // Check all the links and if present, show them, if not, don't show them
                    if ( $jklrv_stored_meta['jkl_review_affiliate_uri'][0] !== '' )
                        echo '<a class="fa fa-dollar" href="' . $jklrv_stored_meta['jkl_review_affiliate_uri'][0] . '"> ' . _e( 'Purchase', 'jkl-reviews/languages') . '</a>'; // Affiliate link
                    if ( $jklrv_stored_meta['jkl_review_product_uri'][0] !== '' )
                        echo '<a class="fa fa-' . $jklrv_fa_icon . '" href="' . $jklrv_stored_meta['jkl_review_product_uri'][0] . '"> ' . _e( 'Home Page', 'jkl-reviews/languages') . '</a>'; // Product link
                    if ( $jklrv_stored_meta['jkl_review_author_uri'][0] !== '' )
                        echo '<a class="fa fa-user" href="' . $jklrv_stored_meta['jkl_review_author_uri'][0] . '"> ' . _e( 'Author Page', 'jkl-reviews/languages') . '</a>'; // Author page link
                    if ( $jklrv_stored_meta['jkl_review_resources_uri'][0] !== '' )
                        echo '<a class="fa fa-link" href="' . $jklrv_stored_meta['jkl_review_resources_uri'][0] . '"> ' . _e( 'Resources', 'jkl-reviews/languages') . '</a>'; // Resources page link
                echo '</div>'; // End links box
                } // End links box IF check
                
            echo '</div>'; // End review info box
        echo '</div><div class="jkl_clear"></div></div>'; // End review box body & box (clear is added to give sufficient height to the background-color of taller boxes)
    
        // Check to see if there's a summary. If not, don't display anything.
        if ( $jklrv_stored_meta['jkl_review_summary_area'][0] !== '' )
            echo '<div class="jkl_summary"><p><strong>' . _e( 'Summary', 'jkl-reviews/languages') . '</strong></p><p><em>' . $jklrv_stored_meta['jkl_review_summary_area'][0] . '</em></p></div>';
    } // End the check for Review Type and Title
    
    return $content; 
    } // End the check for is_singular()
    
    else {
        return $content;
    }
}


/* 
 * ##### 6 #####
 * Helper functions for the rest of the code. No WordPress hooks needed here.
 */

/*
 * Take the current Review Type value (stored in the radio button) and return a 
 * string that corresponds with the FontAwesome icon linked to that type.
 */
function jkl_get_fa_icon( $name ) {
    switch( $name ) {
        case 'book' : return 'book';
            break;
        case 'audio' : return 'headphones';
            break;
        case 'video' : return 'play-circle';
            break;
        case 'course' : return 'pencil-square-o';
            break;
        case 'product' : return 'archive';
            break;
        case 'service' : return 'gift';
            break;
        default : return 'star';
    }
}

/*
 * This function returns either the author's name WITH a link (if there is one), 
 * or without if no author link is saved
 */
function jkl_get_author_link( $author, $authorlink ) {
    if ( $authorlink == '' ) {
        return '<p><em>' . _e( 'by', 'jkl-reviews/languages' ) . ': ' . $author . '</em></p>';
    } else {
        return '<p><em>' . _e( 'by', 'jkl-reviews/languages' ) . ': <a href="' . $authorlink . '">' . $author . '</a></em></p>';
    }
}

/*
 * Get the rating value (input via the range slider) and return a string of 
 * FontAwesome star icons that correspond to that numeric value.
 */
function jkl_get_fa_rating( $number ) {
    switch( $number ) {
        case 0 : return '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>';
            break;
        case 0.5 : return '<i class="fa fa-star-half-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>';
            break;
        case 1 : return '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>';
            break;
        case 1.5 : return '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star-half-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>';
            break;
        case 2 : return '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>';
            break;
        case 2.5 : return '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star-half-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>';
            break;
        case 3 : return '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>';
            break;
        case 3.5 : return '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star-half-o"></i>'
                    . '<i class="fa fa-star-o"></i>';
            break;
        case 4 : return '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star-o"></i>';
            break;
        case 4.5 : return '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star-half-o"></i>';
            break;
        case 5 : return '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>'
                    . '<i class="fa fa-star"></i>';
            break;
        default: return '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i>'
                    . '<i class="fa fa-star-o"></i><span>' . _e( 'No rating available.', 'jkl-reviews/languages') . '</span>';
    }
}

?>