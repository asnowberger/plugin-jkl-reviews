<?php

   /*
    * Documentation on nonces: 
    * http://markjaquith.wordpress.com/2006/06/02/wordpress-203-nonces/
    * http://www.prelovac.com/vladimir/improving-security-in-wordpress-plugins-using-nonces
    */
   wp_nonce_field( basename(__FILE__), 'jklrv_nonce' ); // Add two hidden fields to protect against cross-site scripting.

   // Retrieve the current data based on Post ID
   $jklrv_stored_meta = get_post_meta( $post->ID );
   $jklrv_stored_options = get_option( 'jklrv_plugin_options' ); // Get options set on WP Options page

   // Call a separate function to evaluate the value stored for the radio button and return a string to correspond to its FontAwesome icon
   $jklrv_fa_icon = jkl_get_fa_icon( $jklrv_stored_meta['jkl-radio'][0] );

   /*
    * Metabox fields                                           Validated (on save)     Escaped (output)    Method
    * 0. Review Type (radio)       => jkl_radio                                        unnecessary?        (esc_attr breaks the code)
    * 1. Cover Image               => jkl_review_cover                                 back / front        esc_url
    * 2. Title                     => jkl_review_title         sanitize_text_field()   back / front        esc_attr
    * 3. Author                    => jkl_review_author        sanitize_text_field()   back / front        esc_attr
    * 4. Series                    => jkl_review_series        sanitize_text_field()   back / front        esc_attr
    * 5. Category                  => jkl_review_category      sanitize_text_field()   back / front        esc_attr
    * 6. Rating                    => jkl_review_rating        (float)                 unnecessary?        (use (float) to set as float, or floatval( $val ) to check it's a float
    * 7. Summary                   => jkl_review_summary_area                          back / front        wp_kses_post
    * 8. Affiliate Link            => jkl_review_affiliate_uri                         back / front        esc_url
    * 9. Product Link              => jkl_review_product_uri                           back / front        esc_url
    * 10. Author Link              => jkl_review_author_uri                            back / front        esc_url
    * 11. Resources Link           => jkl_review_resources_uri                         back / front        esc_url
    * 12. Disclosure Type (radio)  => jkl_disclose                                     unnecessary?
    */

   // Ref: TutsPlus Working with Meta Boxes Video Course

   // If we want to show the values we've stored, there are 2 ways to do that:
   // 0. $jklrv_stored_meta = get_post_meta( $post->ID );
   // 1. if ( isset ( $jklrv_stored_meta['identifier'] ) ) echo $jklrv_stored_meta['identifier'][0];
   // 2. $html .= <input type="text" value="' . get_post_meta( $post->ID, 'identifier', true ) . '" />';

   // Test your saved values are stripped of tags by trying to save:
   // <script>alert('Hello world!');</script>

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
                          value="<?php if( isset( $jklrv_stored_meta['jkl_review_title'] ) ) echo esc_attr( $jklrv_stored_meta['jkl_review_title'][0] ); ?>" />
           </td>
       </tr>

       <!-- Author -->
       <tr>
           <td class="left-label">
               <label for="jkl_review_author" class="jkl_label"><?php _e('Author: ', 'jkl-reviews/languages')?></label>
           </td>
           <td>
               <input type="text" class="input-text" id="jkl_review_author" name="jkl_review_author" 
                          value="<?php if( isset( $jklrv_stored_meta['jkl_review_author'] ) ) echo esc_attr( $jklrv_stored_meta['jkl_review_author'][0] ); ?>" />
           </td>
       </tr>

       <!-- Series -->
       <tr>
           <td class="left-label">
               <label for="jkl_review_series" class="jkl_label"><?php _e('Series: ', 'jkl-reviews/languages')?></label>
           </td>
           <td>
               <input type="text" class="input-text" id="jkl_review_series" name="jkl_review_series" 
                          value="<?php if( isset( $jklrv_stored_meta['jkl_review_series'] ) ) echo esc_attr( $jklrv_stored_meta['jkl_review_series'][0] ); ?>" />
           </td>
       </tr>

       <!-- Category. Should (eventually) act as WP Tags, separate-able by commas, including the list + X marks to remove categories -->
       <tr>
           <td class="left-label">
               <label for="jkl_review_category" class="jkl_label"><?php _e('Category: ', 'jkl-reviews/languages')?></label>
           </td>
           <td>
               <input type="text" class="input-text" id="jkl_review_category" name="jkl_review_category" 
                          value="<?php if( isset( $jklrv_stored_meta['jkl_review_category'] ) ) echo esc_attr( $jklrv_stored_meta['jkl_review_category'][0] ); ?>" />
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
               <label for=jkl_review_summary" class="jkl_label"><?php _e('Short <a href="#">(why?)</a>Summary: ', 'jkl-reviews/languages')?></label>
           </td>
           <td>
               <textarea id="jkl_review_summary_area" name="jkl_review_summary_area"><?php if( isset( $jklrv_stored_meta['jkl_review_summary_area'] ) ) echo wp_kses_post( $jklrv_stored_meta['jkl_review_summary_area'][0] ); ?></textarea>
               <p class="note"><?php _e( 'Enter any valid HTML in the Summary field.<br /><strong>Note:</strong> Any text entered will be in italics.', 'jkl-reviews/languages' ) ?></p>
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
               <label for="jkl_affiliate_uri" class="jkl_label"><?php _e('Affiliate or Purchase Link: ', 'jkl-reviews/languages')?></label>
           </td>
           <td>
               <input type="url" id="jkl_affiliate_uri" name="jkl_review_affiliate_uri"
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_affiliate_uri'] ) ) echo esc_url( $jklrv_stored_meta['jkl_review_affiliate_uri'][0] ); ?>" />
       </tr> <!-- TODO: Implement an Affiliate link Disclaimer message and checkbox option to turn it on/off. -->

       <!-- Product Homepage -->
       <tr>
           <td class="left-label">
               <label for="jkl_review_product_uri" class="jkl_label"><?php _e('Link to Product Page: ', 'jkl-reviews/languages')?></label>
           </td>
           <td>
               <input type="url" id="jkl_review_product_uri" name="jkl_review_product_uri"
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_product_uri'] ) ) echo esc_url( $jklrv_stored_meta['jkl_review_product_uri'][0] ); ?>" />
       </tr>

       <!-- Author Homepage -->
       <tr>
           <td class="left-label">
               <label for="jkl_review_author_uri" class="jkl_label"><?php _e('Link to Author Homepage: ', 'jkl-reviews/languages')?></label>
           </td>
           <td>
               <input type="url" id="jkl_review_author_uri" name="jkl_review_author_uri"
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_author_uri'] ) ) echo esc_url( $jklrv_stored_meta['jkl_review_author_uri'][0] ); ?>" />
           </td>
       </tr>       

       <!-- Resources Page -->
       <tr>
           <td class="left-label">
               <label for="jkl_review_resources_uri" class="jkl_label"><?php _e('Link to Resources Page: ', 'jkl-reviews/languages')?></label>
           </td>
           <td>
               <input type="url" id="jkl_review_resources_uri" name="jkl_review_resources_uri"
                       value="<?php if( isset( $jklrv_stored_meta['jkl_review_resources_uri'] ) ) echo esc_url( $jklrv_stored_meta['jkl_review_resources_uri'][0] ); ?>" />
           </td>
       </tr> 

       <?php if ( $jklrv_stored_options[ 'jklrv_display_disclosure' ] ) { // Only display the following IF Disclosure is enabled on WP Options page ?> 

       <tr><td colspan="2"><div class="divider-lite"></div></td></tr>

       <!-- Material Disclaimer Type. To comply with guidelines by the FTC (16 CFR, Part 255): http://www.access.gpo.gov/nara/cfr/waisidx_03/16cfr255_03.html -->
       <tr>
           <td class="left-label">
               <label for="jkl-disclosure-type" class="jkl_label"><?php _e('Material Disclosure: ', 'jkl-reviews/languages')?></label>
           </td>
           <td>
               <div class="radio">
               <label for="jkl-remove-type" id="jkl-remove-type">
                   <input type="radio" name="jkl_disclose" id="jkl-disclose-remove" value="remove" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'remove' ); ?>>
                   <span class="note"><?php _e('No Disclosure', 'jkl-reviews/languages')?></span>
               </label>
               </div>
               <div class="radio">
               <label for="jkl-no-type" id="jkl-no-type">
                   <input type="radio" name="jkl_disclose" id="jkl-disclose-none" value="none" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'none' ); ?>>
                   <span class="note"><?php _e('No Connection', 'jkl-reviews/languages')?></span>
               </label>
               </div>
               <div class="radio">
               <label for="jkl-aff-type" id="jkl-aff-type">
                   <input type="radio" name="jkl_disclose" id="jkl-disclose-aff" value="affiliate" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'affiliate' ); ?>>
                   <span class="note"><?php _e('Affiliate Link', 'jkl-reviews/languages')?></span>
               </label>
               </div>
               <div class="radio">
               <label for="jkl-sample-type" id="jkl-sample-type">
                   <input type="radio" name="jkl_disclose" id="jkl-disclose-sample" value="sample" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'sample' ); ?>>
                   <span class="note"><?php _e('Review or Sample', 'jkl-reviews/languages')?></span>
               </label>
               </div>
               <div class="radio">
               <label for="jkl-sponsored-type" id="jkl-sponsored-type">
                   <input type="radio" name="jkl_disclose" id="jkl-disclose-sponsor" value="sponsored" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'sponsored' ); ?>>
                   <span class="note"><?php _e('Sponsored Post', 'jkl-reviews/languages')?></span>
               </label>
               </div>
               <div class="radio">
               <label for="jkl-shareholder-type" id="jkl-shareholder-type">
                   <input type="radio" name="jkl_disclose" id="jkl-disclose-shareholder" value="shareholder" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'shareholder' ); ?>>
                   <span class="note"><?php _e('Employee/Shareholder', 'jkl-reviews/languages')?></span>
               </label>
               </div>
           </td>
       </tr>

       <?php if (isset( $jklrv_stored_meta['jkl_disclose'][0] ) && !checked( $jklrv_stored_meta['jkl_disclose'][0], 'remove' ) ) { ?>
       <tr><td colspan="2"><div class="divider-lite"></div></td></tr>

       <tr>
           <td class="left-label">
               <label for="jkl-disclosure-preview" class="jkl_label"><?php _e('Disclosure Preview: ', 'jkl-reviews/languages')?></label>
           </td>
           <td>
               <small class="note"><?php echo wp_kses_post( jkl_get_material_disclosure( $jklrv_stored_meta['jkl_disclose'][0] ) ); ?></small>
           </td>
       </tr>
       <?php 

           } // End Disclosure Type check
       } // End Show Material Disclosure from WP Options page check 

       ?>

   </table>

