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


// ##0 : Add the Admin CSS styles for the metabox
add_action( 'admin_enqueue_scripts', 'jkl_review_style');

// ##1 : Create metabox in Post editing page
add_action( 'add_meta_boxes', 'jkl_add_review_metabox' );

// ##2 : Display the actual Metabox and fields
// ##3 : Add and Use the WP Image Manager
add_action( 'admin_enqueue_scripts', 'jklrv_image_enqueue' );

// ##4 : Save metabox data
add_action( 'save_post', 'jkl_save_review_metabox' );

// ##5 : Add a shortcode to display the content box on the page
add_shortcode( 'review', 'jkl_review_box' );

// ##5B : Just display it straight up on a Post (TutsPlus)
add_action( 'the_content', 'jkl_display_review_box' );
add_action( 'the_content', 'jkl_get_review_box_style');

// Register widgets
add_action( 'widgets_init', 'jkl_review_widget_init' );

/*
 * ##### 0 #####
 * Before everything else, queue up the CSS styles for this metabox
 */
function jkl_review_style() {
    wp_register_style( 'jkl_review_css', plugin_dir_url( __FILE__ ) . '/css/style.css', false, '1.0.0' );
    wp_enqueue_style( 'jkl_review_css' );
}

function jkl_get_review_box_style() {
    wp_register_style( 'jkl_review_box_display_css', plugin_dir_url( __FILE__ ) . '/css/boxstyle.css', false, '1.0.0' );
    wp_enqueue_style( 'jkl_review_box_display_css' );
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
            'review_info',                              // Unique ID
            __('Review Information', 'jkl-reviews'),    // Title
            'display_jkl_review_metabox',               // Callback function
            'post'                                      // Post type to display on
                                                        // Context
                                                        // Priority
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
    
    /*
     * Metabox fields
     * 1. Cover Image
     * 2. Title
     * 3. Author
     * 4. Series
     * 5. Category
     * 6. Rating
     * 7. Affiliate Link Option 
     * 8. Affiliate Link
     * 9. Product Link Option
     * 10. Product Link
     * 11. Author Link Option
     * 12. Author Link
     * 13. Resources Link Option
     * 14. Resources Link
     */
    
    // Ref: TutsPlus Working with Meta Boxes Video Course
    
    // If we want to show the values we've stored, there are 2 ways to do that:
    // 0. $jklrv_stored_meta = get_post_meta( $post->ID );
    // 1. if ( isset ( $jklrv_stored_meta['identifier'] ) ) echo $jklrv_stored_meta['identifier'][0];
    // 2. $html .= <input type="text" value="' . get_post_meta( $post->ID, 'identifier', true ) . '" />';
    
    // Test your saved values are stripped of tags by trying to save:
    // <script>alert('Hello world!');</script>
    ?>

    <!-- PRODUCT INFORMATION TABLE -->
    <table class="jkl_review"> 
        <tr><th colspan="2">Product Information</th></tr>
        <tr class="divider"></tr>
        
        <!-- Product Type. Select the radio button corresponding to the product you are reviewing -->
        <tr>
            <td class="left-label">
                <label for="jkl-product-type" class="jkl_label"><?php _e('Product Type: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <label for="jkl-book-type" id="jkl-book-type" class="note">
                    <input type="radio" name="jkl_radio" id="jkl-radio-book" value="book" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'book' ); ?>>
                    <?php _e('Book', 'jkl-reviews/languages')?>
                </label>
                <label for="jkl-audio-type" id="jkl-audio-type" class="note">
                    <input type="radio" name="jkl_radio" id="jkl-radio-audio" value="audio" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'audio' ); ?>>
                    <?php _e('Audio', 'jkl-reviews/languages')?>
                </label>
                <label for="jkl-video-type" id="jkl-video-type" class="note">
                    <input type="radio" name="jkl_radio" id="jkl-radio-video" value="video" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'video' ); ?>>
                    <?php _e('Video', 'jkl-reviews/languages')?>
                </label>
                <label for="jkl-course-type" id="jkl-course-type" class="note">
                    <input type="radio" name="jkl_radio" id="jkl-radio-course" value="course" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'course' ); ?>>
                    <?php _e('Course', 'jkl-reviews/languages')?>
                </label>
                <label for="jkl-product-type" id="jkl-product-type" class="note">
                    <input type="radio" name="jkl_radio" id="jkl-radio-product" value="product" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'product' ); ?>>
                    <?php _e('Product', 'jkl-reviews/languages')?>
                </label>
                <label for="jkl-service-type" id="jkl-service-type" class="note">
                    <input type="radio" name="jkl_radio" id="jkl-radio-service" value="service" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'service' ); ?>>
                    <?php _e('Service', 'jkl-reviews/languages')?>
                </label>
                <label for="jkl-other-type" id="jkl-other-type" class="note">
                    <input type="radio" name="jkl_radio" id="jkl-radio-other" value="other" <?php if ( isset( $jklrv_stored_meta['jkl_radio'] ) ) checked( $jklrv_stored_meta['jkl_radio'][0], 'other' ); ?>>
                    <?php _e('Other', 'jkl-reviews/languages')?>
                </label>
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
                <label for="jkl_review_author" class="jkl_label"><?php _e('Author: ', 'jkl-reviews')?></label>
            </td>
            <td>
                <input type="text" class="input-text" id="jkl_review_author" name="jkl_review_author" 
                           value="<?php if( isset( $jklrv_stored_meta['jkl_review_author'] ) ) echo $jklrv_stored_meta['jkl_review_author'][0]; ?>" />
            </td>
        </tr>

        <!-- Series. Similar to Author. Accepts a String, or also a checkbox input of "most used" series. -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_series" class="jkl_label"><?php _e('Series: ', 'jkl-reviews')?></label>
            </td>
            <td>
                <input type="text" class="input-text" id="jkl_review_series" name="jkl_review_series" 
                           value="<?php if( isset( $jklrv_stored_meta['jkl_review_series'] ) ) echo $jklrv_stored_meta['jkl_review_series'][0]; ?>" />
            </td>
        </tr>

        <!-- Category. Should act as WP Tags, separate-able by commas, including the list + X marks to remove categories -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_category" class="jkl_label"><?php _e('Category: ', 'jkl-reviews')?></label>
            </td>
            <td>
                <input type="text" class="input-text" id="jkl_review_category" name="jkl_review_category" 
                           value="<?php if( isset( $jklrv_stored_meta['jkl_review_category'] ) ) echo $jklrv_stored_meta['jkl_review_category'][0]; ?>" />
                <p class="note">Separate multiple values with commas.</p>
            </td>
        </tr>
    </table>
      
    <!-- ##### PRODUCT RATING TABLE -->
    <table class="jkl_review">
        <tr><th colspan="2">Product Rating</th></tr>
        <tr class="divider"></tr>
        <!-- 
            Rating. This should be a range - able to accept numbers at least up to 5, possibly up to 10. 
            Create a range slider with JS as well: http://www.developerdrive.com/2012/07/creating-a-slider-control-with-the-html5-range-input/
        -->
        <tr>
            <td class="left-label rating-label">
                <label for="jkl_review_rating" class="jkl_label"><?php _e('Rating: ', 'jkl-reviews')?></label>
            </td>
            <td>
                <span class="range-number-left">0</span> 
                <input type="range" min="0" max="5" step="0.5" list="stars" onchange="showValue(this.value)" 
                           id="jkl-review-rating" name="jkl_review_rating" 
                           value="<?php if( isset( $jklrv_stored_meta['jkl_review_rating'] ) ) echo $jklrv_stored_meta['jkl_review_rating'][0]; ?>" />
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
                    <?php echo isset( $jklrv_stored_meta['jkl_review_rating'] ) ? $jklrv_stored_meta['jkl_review_rating'][0] : 2.5; ?>
                </output>
                <span id="star-rating-text">Stars</span>
                
                <!-- Simple function to dynamically update the output value of the range slider -->
                <script>
                function showValue(rating) {
                    document.querySelector('#star-rating').value = rating;
                }
                </script>
            </td>
        </tr>
        <tr>
            <td class="left-label">
                <label for=jkl_review_summary" class="jkl_label"><?php _e('Summary: ', 'languages/jkl-reviews')?></label>
            </td>
            <td>
                <textarea id="jkl_review_summary_area" name="jkl_review_summary_area"><?php if( isset( $jklrv_stored_meta['jkl_review_summary_area'] ) ) echo $jklrv_stored_meta['jkl_review_summary_area'][0]; ?>
                </textarea>
            </td>
        </tr>
    </table>

    <!-- ##### PRODUCT LINKS TABLE ##### -->
    <table class="jkl_review">
        <tr><th colspan="2">Product Links</th></tr>
        <tr class="divider"></tr>
        
        <!-- Links. Should be able to select from a dropdown list of available links (like Amazon, product page, author's site, resources site, etc) and also accept a URL to those sites. -->
        <!-- Affiliate Link -->
        <tr>
            <td class="left-label">
                <label for="jkl_affiliate_uri" class="jkl_label"><?php _e('Affiliate Link: ', 'jkl-reviews/languages')?></label>
            </td>
            
            <!-- Affiliate Link URL -->
            <td>
                <input type="url" id="jkl_affiliate_uri" name="jkl_review_affiliate_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_affiliate_uri'] ) ) echo $jklrv_stored_meta['jkl_review_affiliate_uri'][0]; ?>" />
        </tr>
        
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
    global $typenow;
    
    if( $typenow == 'post' ) {
        wp_enqueue_media();
        
        // Registers and enqueues the required JS
        wp_register_script( 'upload-image', plugin_dir_url( __FILE__ ) . 'js/upload-image.js', array( 'jquery' ) );
        wp_localize_script( 'upload-image', 'jkl_review_cover',
                array(
                    'title' => __( 'Select a Cover', 'jkl-reviews' ),
                    'button' => __( 'Use this Cover', 'jkl-reviews' ),
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
     * Verify this came from our screen and with proper authorization and that we're ready to save.
     */
    
    // The following commented code is found directly on the WP Codex
    // Check if nonce is set
    if ( !isset( $_POST['jklrv_nonce'] ) ) return;
    
    // Verify the nonce is valid
    if ( !wp_verify_nonce( $_POST['jklrv_nonce'], basename(__FILE__) ) ) return;
    
    // Check for autosave (don't save metabox on autosave)
    if ( defined ('DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    
    // Check user's editing permissions
    if ( !current_user_can( 'edit_page', $post_id ) ) return;

    
    /*
     * After all those checks, save.
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
 * Fifth, create the Shortcode Function
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
 * ##### 5B #####
 * Fifth Plus, just display the content straight up on a Post
 */
function jkl_display_review_box( $content ) {
    
    if ( is_single() ) {
        
    // $jklrv_stored_meta = get_post_meta( get_the_ID(), 'jkl_review_title', true ); (Help from TutsPlus)
    $jklrv_stored_meta = get_post_meta( get_the_ID() );
    
    echo '<div id="jkl_review_box"><div id="jkl_review_box_head">';    
        echo '<img src="' . plugins_url( 'imgs/' . $jklrv_stored_meta['jkl_radio'][0] . '.png', __FILE__ ) . '" alt="' . $jklrv_stored_meta['jkl_radio'][0] . '" />';
        echo '<p id="jkl_review_box_categories">' . $jklrv_stored_meta['jkl_review_category'][0] . '</p>';
    echo '</div>'; // End review box head
    echo '<div id="jkl_review_box_body">';
        echo '<img id="jkl_review_box_cover" src=' . $jklrv_stored_meta['jkl_review_cover'][0] . ' alt="' . $jklrv_stored_meta['jkl_review_title'][0] . '" />';
        echo '<div id="jkl_review_box_info">';
            echo '<p><strong>' . $jklrv_stored_meta['jkl_review_title'][0] . '</strong></p>'; // Title
            echo '<p><em>by: ' . $jklrv_stored_meta['jkl_review_author'][0] . '</em></p>'; // Author
            echo '<p>Series: ' . $jklrv_stored_meta['jkl_review_series'][0] . '</p>'; // Series
            echo '<p>' . $jklrv_stored_meta['jkl_review_rating'][0] . '</p>'; // Rating
            echo '<div id="jkl_review_box_links_box">'; // Links box
                echo '<a href="' . $jklrv_stored_meta['jkl_review_affiliate_uri'][0] . '"><img src="' . plugins_url( 'imgs/affiliate.png', __FILE__ ) . '" alt="Affiliate link" />Purchase</a>'; // Affiliate link
                echo '<a href="' . $jklrv_stored_meta['jkl_review_homepage_uri'][0] . '"><img src="' . plugins_url( 'imgs/' . $jklrv_stored_meta['jkl_radio'][0] . '-dk.png', __FILE__ ) . '" alt="Product link" />Home Page</a>'; // Product link
                echo '<a href="' . $jklrv_stored_meta['jkl_review_authorpage_uri'][0] . '"><img src="' . plugins_url( 'imgs/author.png', __FILE__ ) . '" alt="Author link" />Author Page</a>'; // Author page link
                echo '<a href="' . $jklrv_stored_meta['jkl_review_resources_uri'][0] . '"><img src="' . plugins_url( 'imgs/resources.png', __FILE__ ) . '" alt="Resources link" />Resources</a>'; // Resources page link
            echo '</div>'; // End links box
        echo '</div>'; // End review box info
    echo '</div><div class="jkl_clear"></div></div>'; // End review box body & box
    
    echo '<div class="jkl_summary"><h6>3-Sentence Summary</h6><p><em>' . $jklrv_stored_meta['jkl_review_summary_area'][0] . '</em></p></div>';
    }
    
    return $content; 
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