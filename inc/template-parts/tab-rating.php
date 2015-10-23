<?php

/**
 * Provides the "Rating" view for the corresponding tab in the Post Meta Box.
 * 
 * @since       2.0.1
 * 
 * @package     JKL_Reviews
 * @subpackage  JKL_Reviews/inc/template-parts
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 */

?>

<div class="jkl-review-meta hidden tab-rating">
    
    <!-- ##### PRODUCT RATING TAB -->
    <div id="jkl-review-rating" class="hidden">
        
        <p class="note"><?php _e( 'Select the Rating Scale type for this review first. '
                . 'You can then add as many Scales as you want to review and rank different features.', 'jkl-reviews' ); ?>
        </p>
        
        <div id="jkl-review-rating-type">
            <label for="jkl-review-star-rating" id="jkl-review-star-rating" class="jkl-label jkl-radio">
                <input type="radio" name="jkl-rating-radio" id="jkl-rating-radio-star" value="star" <?php if ( isset( $jklrv_stored_meta[ 'jkl_rating_radio' ] ) ) checked( $jklrv_stored_meta[ 'jkl_rating_radio' ][0], 'star-rating' ); ?>>
                <span><?php _e( '5 Star Scale', 'jkl-reviews' ); ?></span>
            </label>
            <label for="jkl-review-bar-rating" id="jkl-review-bar-rating" class="jkl-label jkl-radio">
                <input type="radio" name="jkl-rating-radio" id="jkl-rating-radio-bar" value="bar" <?php if ( isset( $jklrv_stored_meta[ 'jkl_rating_radio' ] ) ) checked( $jklrv_stored_meta[ 'jkl_rating_radio' ][0], 'bar-rating' ); ?>>
                <span><?php _e( '10 Bar Scale', 'jkl-reviews' ); ?></span>
            </label>
            <label for="jkl-review-percent-rating" id="jkl-review-percent-rating" class="jkl-label jkl-radio">
                <input type="radio" name="jkl-rating-radio" id="jkl-rating-radio-percent" value="percent" <?php if ( isset( $jklrv_stored_meta[ 'jkl_rating_radio' ] ) ) checked( $jklrv_stored_meta[ 'jkl_rating_radio' ][0], 'percent-rating' ); ?>>
                <span><?php _e( '100% Scale', 'jkl-reviews' ); ?></span>
            </label>
        </div>
        
        <p>
            <input type="submit" id="jkl-reviews-add-rating" class="button" value="+" />
            <span id="jkl-rating-add-alert" class="error notice is-dismissible hidden">Please select a Rating Scale first!</span>
        </p>
        
        <ol id="jkl-review-rating-scales"></ol>
        
        <?php // if ( $jklrv_stored_options[ 'jklrv_display_disclosure' ] ) { // Only display the following IF Disclosure is enabled on WP Options page ?> 
        
        <div class="divider"></div>
        
        <!-- Material Disclaimer Type. To comply with guidelines by the FTC (16 CFR, Part 255): http://www.access.gpo.gov/nara/cfr/waisidx_03/16cfr255_03.html -->
        <p class="jkl-label"><?php _e('Material Disclosure: ', 'jkl-reviews')?></p>
        
        <label for="jkl-remove-type" id="jkl-remove-type" class="jkl-radio">
            <input type="radio" name="jkl_disclose" id="jkl-disclose-remove" value="remove" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'remove' ); ?>>
            <span class="note"><?php _e('No Disclosure', 'jkl-reviews')?></span>
        </label>
        <label for="jkl-no-type" id="jkl-no-type" class="jkl-radio">
            <input type="radio" name="jkl_disclose" id="jkl-disclose-none" value="none" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'none' ); ?>>
            <span class="note"><?php _e('No Connection', 'jkl-reviews')?></span>
        </label>
        <label for="jkl-aff-type" id="jkl-aff-type" class="jkl-radio">
            <input type="radio" name="jkl_disclose" id="jkl-disclose-aff" value="affiliate" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'affiliate' ); ?>>
            <span class="note"><?php _e('Affiliate Link', 'jkl-reviews')?></span>
        </label>
        <label for="jkl-sample-type" id="jkl-sample-type" class="jkl-radio">
            <input type="radio" name="jkl_disclose" id="jkl-disclose-sample" value="sample" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'sample' ); ?>>
            <span class="note"><?php _e('Review or Sample', 'jkl-reviews')?></span>
        </label>
        <label for="jkl-sponsored-type" id="jkl-sponsored-type" class="jkl-radio">
            <input type="radio" name="jkl_disclose" id="jkl-disclose-sponsor" value="sponsored" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'sponsored' ); ?>>
            <span class="note"><?php _e('Sponsored Post', 'jkl-reviews')?></span>
        </label>
        <label for="jkl-shareholder-type" id="jkl-shareholder-type" class="jkl-radio">
            <input type="radio" name="jkl_disclose" id="jkl-disclose-shareholder" value="shareholder" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'shareholder' ); ?>>
            <span class="note"><?php _e('Employee/Shareholder', 'jkl-reviews')?></span>
        </label>
        
        <?php if (isset( $jklrv_stored_meta['jkl_disclose'][0] ) && !checked( $jklrv_stored_meta['jkl_disclose'][0], 'remove' ) ) { ?>
        <label for="jkl-disclosure-preview" class="jkl-label"><?php _e('Disclosure Preview: ', 'jkl-reviews')?></label>
            
        <small class="note"><?php echo wp_kses_post( jkl_get_material_disclosure( $jklrv_stored_meta['jkl_disclose'][0] ) ); ?></small>
        <?php 
        
            } // End Disclosure Type check
        //} // End Show Material Disclosure from WP Options page check 
            
        ?>
        
    </div><!-- #jkl-review-rating -->
    
</div><!-- .jkl-review-meta .tab-rating -->
