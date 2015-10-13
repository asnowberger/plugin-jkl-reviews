<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="inside hidden">
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
</div>
