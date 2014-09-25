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
    
    ?>

    <!-- PRODUCT INFORMATION TABLE -->
    <table class="jkl_review"> 
        <tr><th colspan="2">Product Information</th></tr>
        <tr class="divider"></tr>
        
        <!-- Cover image. This should accept and display an image (like a Featured Image) using WP's image Uploader/chooser. -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_cover" class="jkl_label"><?php _e('Product Image: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_cover" name="jkl_review_cover" 
                           value="<?php if( isset( $jklrv_stored_meta['jkl_review_cover'] ) ) echo $jklrv_stored_meta['jkl_review_cover'][0]; ?>" />
                <input type="button" id="jkl_review_cover_button" class="button" value="<?php _e( 'Choose or Upload an Image', 'jkl_review_cover' )?>" />
            </td>
        </tr>

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

        <!-- Category. Similar to Author and Series. Actual functionality is like WP's native Categories. -->
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
                    <?php if( isset( $jklrv_stored_meta['jkl_review_rating'] ) ) echo $jklrv_stored_meta['jkl_review_rating'][0]; ?>
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
                <textarea row="4" cols="50" id="jkl_review_summary_area" name="jkl_review_summary_area">
                    <?php if( isset( $jklrv_stored_meta['jkl_review_summary'] ) ) echo $jklrv_stored_meta['jkl_review_summary'][0]; ?>
                </textarea>
            </td>
        </tr>
    </table>

    <!-- ##### PRODUCT LINKS TABLE ##### -->
    <table class="jkl_review">
        <tr><th colspan="2">Product Links</th></tr>
        <tr class="divider"></tr>
        
        <!-- Links. Should be able to select from a checkbox list of available links (like Amazon, product page, author's site, resources site, etc) and also accept a URL to those sites. -->
        <!-- Affiliate Link -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_affiliate_uri" class="jkl_label"><?php _e('Affiliate Link: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_affiliate_uri" name="jkl_review_affiliate_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_affiliate_uri'] ) ) echo $jklrv_stored_meta['jkl_review_affiliate_uri'][0]; ?>" />
            
                <!-- Give option to display the link or not -->
                <input type="checkbox" id="jkl_review_use_affiliate_uri" name="jkl_review_use_affiliate_uri" 
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_use_affiliate_uri'] ) ) echo $jklrv_stored_meta['jkl_review_use_affiliate_uri'][0]; ?>" />
                <span class="note">Show link?</span>
            </td>
        </tr>        
        <tr>
            <!-- Select icon -->
            <td>
                <label for="jkl_review_affiliate_icon" class="icon-select"><?php _e('Select Affiliate Icon: ', 'jkl-reviews/languages')?></label>
            </td>
            <td> 
                <select name="jkl_review_affiliate_icon" id="jkl_review_affiliate_icon" class="select-dropdown">
                    <option value="default" <?php if ( isset ( $jklrv_stored_meta['jkl_review_affiliate_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_affiliate_icon'], 'default' ); ?>><?php _e( 'Default', 'jkl-reviews/languages' )?></option>';
                    <option value="amazon" <?php if ( isset ( $jklrv_stored_meta['jkl_review_affiliate_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_affiliate_icon'], 'amazon' ); ?>><?php _e( 'Amazon', 'jkl-reviews/languages' )?></option>';
                    <option value="audible" <?php if ( isset ( $jklrv_stored_meta['jkl_review_affiliate_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_affiliate_icon'], 'audible' ); ?>><?php _e( 'Audible', 'jkl-reviews/languages' )?></option>';
                    <option value="udemy" <?php if ( isset ( $jklrv_stored_meta['jkl_review_affiliate_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_affiliate_icon'], 'udemy' ); ?>><?php _e( 'Udemy', 'jkl-reviews/languages' )?></option>';
                </select>
                
                <!-- Give option to display an icon with the link or not -->
                <input type="checkbox" id="jkl_review_show_affiliate_icon" name="jkl_review_show_affiliate_icon" 
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_show_affiliate_icon'] ) ) echo $jklrv_stored_meta['jkl_review_show_affiliate_icon'][0]; ?>" />
                <span class="note">Show icon?</span>
            </td>
        </tr>
        
        <tr><td colspan="2"><div class="divider-lite"></div></td></tr>
        
        <!-- Product Homepage -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_product_uri" class="jkl_label"><?php _e('Link to Product Page: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_product_uri" name="jkl_review_product_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_product_uri'] ) ) echo $jklrv_stored_meta['jkl_review_product_uri'][0]; ?>" />
            
                <!-- Give option to display the link or not -->
                <input type="checkbox" id="jkl_review_use_product_uri" name="jkl_review_use_product_uri" 
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_use_product_uri'] ) ) echo $jklrv_stored_meta['jkl_review_use_product_uri'][0]; ?>" />
                <span class="note">Show link?</span>
            </td>
        </tr>        
        <tr>
            <!-- Select icon -->
            <td>
                <label for="jkl_review_product_icon" class="icon-select"><?php _e('Select Product Icon: ', 'jkl-reviews/languages')?></label>
            </td>
            <td> 
                <select name="jkl_review_product_icon" id="jkl_review_product_icon" class="select-dropdown">
                    <option value="default" <?php if ( isset ( $jklrv_stored_meta['jkl_review_product_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_product_icon'], 'default' ); ?>><?php _e( 'Default', 'jkl-reviews/languages' )?></option>';
                    <option value="book" <?php if ( isset ( $jklrv_stored_meta['jkl_review_product_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_product_icon'], 'book' ); ?>><?php _e( 'Book', 'jkl-reviews/languages' )?></option>';
                    <option value="audio" <?php if ( isset ( $jklrv_stored_meta['jkl_review_product_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_product_icon'], 'audio' ); ?>><?php _e( 'Audio', 'jkl-reviews/languages' )?></option>';
                    <option value="video" <?php if ( isset ( $jklrv_stored_meta['jkl_review_product_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_product_icon'], 'video' ); ?>><?php _e( 'Video', 'jkl-reviews/languages' )?></option>';
                    <option value="course" <?php if ( isset ( $jklrv_stored_meta['jkl_review_product_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_product_icon'], 'course' ); ?>><?php _e( 'Course', 'jkl-reviews/languages' )?></option>';
                    <option value="product" <?php if ( isset ( $jklrv_stored_meta['jkl_review_product_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_product_icon'], 'product' ); ?>><?php _e( 'Product', 'jkl-reviews/languages' )?></option>';
                    <option value="site" <?php if ( isset ( $jklrv_stored_meta['jkl_review_product_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_product_icon'], 'site' ); ?>><?php _e( 'Site', 'jkl-reviews/languages' )?></option>';
                </select>
                
                <!-- Give option to display an icon with the link or not -->
                <input type="checkbox" id="jkl_review_show_homepage_icon" name="jkl_review_show_homepage_icon" 
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_show_homepage_icon'] ) ) echo $jklrv_stored_meta['jkl_review_show_homepage_icon'][0]; ?>" />
                <span class="note">Show icon?</span>
            </td>
        </tr>
        
        <tr><td colspan="2"><div class="divider-lite"></div></td></tr>
        
        <!-- Author Homepage -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_author_uri" class="jkl_label"><?php _e('Link to Author Homepage: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_author_uri" name="jkl_review_author_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_author_uri'] ) ) echo $jklrv_stored_meta['jkl_review_author_uri'][0]; ?>" />
            
                <!-- Give option to display the link or not -->
                <input type="checkbox" id="jkl_review_use_author_uri" name="jkl_review_use_author_uri" 
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_use_author_uri'] ) ) echo $jklrv_stored_meta['jkl_review_use_author_uri'][0]; ?>" />
                <span class="note">Show link?</span>
            </td>
        </tr>       
        <tr> 
            <!-- Select icon -->
            <td>
                <label for="jkl_review_author_icon" class="icon-select"><?php _e('Select Author Icon: ', 'jkl-reviews/languages')?></label>
            </td>
            <td> 
                <select name="jkl_review_author_icon" id="jkl_review_author_icon" class="select-dropdown">
                    <option value="default" <?php if ( isset ( $jklrv_stored_meta['jkl_review_author_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_author_icon'], 'default' ); ?>><?php _e( 'Default', 'jkl-reviews/languages' )?></option>';
                    <option value="male" <?php if ( isset ( $jklrv_stored_meta['jkl_review_author_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_author_icon'], 'male' ); ?>><?php _e( 'Male Author', 'jkl-reviews/languages' )?></option>';
                    <option value="female" <?php if ( isset ( $jklrv_stored_meta['jkl_review_author_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_author_icon'], 'female' ); ?>><?php _e( 'Female Author', 'jkl-reviews/languages' )?></option>';
                    <option value="team" <?php if ( isset ( $jklrv_stored_meta['jkl_review_author_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_author_icon'], 'team' ); ?>><?php _e( 'Team', 'jkl-reviews/languages' )?></option>';
                </select>
                
                <!-- Give option to display an icon with the link or not -->
                <input type="checkbox" id="jkl_review_show_authorpage_icon" name="jkl_review_show_authorpage_icon" 
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_show_authorpage_icon'] ) ) echo $jklrv_stored_meta['jkl_review_show_authorpage_icon'][0]; ?>" />
                <span class="note">Show icon?</span>
            </td>
        </tr>
        
        <tr><td colspan="2"><div class="divider-lite"></div></td></tr>
        
        <!-- Resources Page -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_resources_uri" class="jkl_label"><?php _e('Link to Resources Page: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_resources_uri" name="jkl_review_resources_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_resources_uri'] ) ) echo $jklrv_stored_meta['jkl_review_resources_uri'][0]; ?>" />
            
                <!-- Give option to display the link or not -->
                <input type="checkbox" id="jkl_review_use_resources_uri" name="jkl_review_use_resources_uri" 
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_use_resources_uri'] ) ) echo $jklrv_stored_meta['jkl_review_use_resources_uri'][0]; ?>" />
                <span class="note">Show link?</span>
            </td>
        </tr>        
        <tr> 
            <!-- Select icon -->
            <td>
                <label for="jkl_review_resources_icon" class="icon-select"><?php _e('Select Resources Icon: ', 'jkl-reviews/languages')?></label>
            </td>
            <td> 
                <select name="jkl_review_resources_icon" id="jkl_review_resources_icon" class="select-dropdown">
                    <option value="default" <?php if ( isset ( $jklrv_stored_meta['jkl_review_resources_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_resources_icon'], 'default' ); ?>><?php _e( 'Default', 'jkl-reviews/languages' )?></option>';
                    <option value="website" <?php if ( isset ( $jklrv_stored_meta['jkl_review_resources_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_resources_icon'], 'website' ); ?>><?php _e( 'Website', 'jkl-reviews/languages' )?></option>';
                    <option value="download" <?php if ( isset ( $jklrv_stored_meta['jkl_review_resources_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_resources_icon'], 'download' ); ?>><?php _e( 'Download', 'jkl-reviews/languages' )?></option>';
                    <option value="link" <?php if ( isset ( $jklrv_stored_meta['jkl_review_resources_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_resources_icon'], 'link' ); ?>><?php _e( 'Link', 'jkl-reviews/languages' )?></option>';
                    <option value="forum" <?php if ( isset ( $jklrv_stored_meta['jkl_review_resources_icon'] ) ) selected( $jklrv_stored_meta['jkl_review_resources_icon'], 'forum' ); ?>><?php _e( 'Forum', 'jkl-reviews/languages' )?></option>';
                </select>
                
                <!-- Give option to display an icon with the link or not -->
                <input type="checkbox" id="jkl_review_show_homepage_icon" name="jkl_review_show_homepage_icon" 
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_show_homepage_icon'] ) ) echo $jklrv_stored_meta['jkl_review_show_homepage_icon'][0]; ?>" />
                <span class="note">Show icon?</span>
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
    
    // Links and Options Below:
    // Check the Checkbox Options:
    $chk_affiliate = isset( $_POST['jkl_review_use_affiliate_link'] ) && $_POST['jkl_review_use_affiliate_link'] ? 'on' : 'off';
    $chk_product = isset( $_POST['jkl_review_use_product_link'] ) && $_POST['jkl_review_use_product_link'] ? 'on' : 'off';
    $chk_author = isset( $_POST['jkl_review_use_author_link'] ) && $_POST['jkl_review_use_author_link'] ? 'on' : 'off';
    $chk_resources = isset( $_POST['jkl_review_use_resources_link'] ) && $_POST['jkl_review_use_resources_link'] ? 'on' : 'off';
    
    // Save Checkbox Statuses:
    update_post_meta( $post_id, 'jkl_review_use_affiliate_link', $chk_affiliate );
    update_post_meta( $post_id, 'jkl_review_use_product_link', $chk_product );
    update_post_meta( $post_id, 'jkl_review_use_author_link', $chk_author );
    update_post_meta( $post_id, 'jkl_review_use_resources_link', $chk_resources );
    
    // Save the Links:
    if( isset($_POST['jkl_review_affiliate_link'] ) ) {
        update_post_meta( $post_id, 'jkl_review_affiliate_link', $_POST['jkl_review_affiliate_link'] );
    }
    if( isset($_POST['jkl_review_product_link'] ) ) {
        update_post_meta( $post_id, 'jkl_review_product_link', $_POST['jkl_review_product_link'] );
    }
    if( isset($_POST['jkl_review_author_link'] ) ) {
        update_post_meta( $post_id, 'jkl_review_author_link', $_POST['jkl_review_author_link'] );
    }
    if( isset($_POST['jkl_review_resources_link'] ) ) {
        update_post_meta( $post_id, 'jkl_review_resources_link', $_POST['jkl_review_resources_link'] );
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