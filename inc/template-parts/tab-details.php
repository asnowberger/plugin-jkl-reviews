<?php

/**
 * Provides the "Details" view for the corresponding tab in the Post Meta Box.
 * 
 * @since       2.0.1
 * 
 * @package     JKL_Reviews
 * @subpackage  JKL_Reviews/inc/template-parts
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 */

?>

<div class="jkl-review-meta">

    <?php
    /**
     * Dynamically loop through our Review Types (array) and create each info box fields
     */
    foreach( $review_info as $review_type => $data ) {
        
        echo "<div id='$review_type-details' class='jkl-review $review_type-info hidden'>";
        
            /**
             * Call function to load each Review Type's labels in meta boxes
             */
            jkl_reviews_load_detail_part( $review_type, $data );
            
        echo "</div><!-- #$review_type-details -->";
    }
    ?>
    
</div><!-- #jkl-review-meta -->

<?php
/**
 * Accepts the Review Type 'slug' and an array of its data, then outputs the HTML 
 * for that Review Type's details meta box
 * 
 * @since   2.0.1
 * 
 * @param   string  $str_type
 * @param   array   $array
 */
function jkl_reviews_load_detail_part( $str_type, $array ) {
    ?>

        <!-- Label option - to display near title - gives details about the product -->
        <div class="jkl-labeler group">
            <input type='checkbox' id='jkl-review-labeled' name='jkl-review-labeled' value='1' <?php //checked( $options['use_shortcode'], 1 ); ?> />
            <label for="jkl-review-labeled" name="jkl-review-labeled"><?php echo $array['labeled']; ?></label>
            <input type="text" class="" id="jkl-review-details-label" name="jkl-review-details-label" 
                   value="<?php echo ( isset( $jklrv_stored_meta['jkl-review-details-label'] ) ? esc_attr( $jklrv_stored_meta['jkl-review-details-label'][0] ) : $array['label'] ); ?>" />
            <span class="jkl-label-preview-container">Preview: 
                <span class="jkl-label-preview"><?php echo $array['label']; ?></span>
            </span>
        </div>        

        <p class="note"><?php _e( 'Add any additional details below.', 'jkl-reviews' ); ?></p>
        <p><input type="button" id="jkl-reviews-add-details" class="button" value="Add details" /></p>
        
        <!-- Details -->
        <div id="jkl-review-details" class="group hidden">
                
            <div class="divider"></div>
            
            <div class="jkl-review-details group">
                <div class="jkl-review-details-left">
                    <label for=jkl-review-detail-label-1" class="jkl-label"><?php _e( 'List 1:', 'jkl-reviews' ); ?></label>
                    <input type="text" class="jkl-review-detail-label" id="jkl-review-detail-label-1" name="jkl-review-detail-label-1" 
                           value="<?php echo ( isset( $jklrv_stored_meta['jkl-review-detail-label-1'] ) ? esc_attr( $jklrv_stored_meta['jkl-review-detail-label-1'][0] ) : $array['details-1-label'] ); ?>" />

                    <div class="jkl-review-detail-info"></div>

                    <input type="button" class="jkl-reviews-add-item button" value="+" />
                    <input type="button" class="jkl-reviews-remove-item button hidden" value="-" />
                </div>
                <div class="jkl-review-details-right">
                    <label for=jkl-review-detail-label-2" class="jkl-label"><?php _e( 'List 2:', 'jkl-reviews' ); ?></label>
                    <input type="text" class="jkl-review-detail-label" id="jkl-review-detail-label-2" name="jkl-review-detail-label-2" 
                           value="<?php echo ( isset( $jklrv_stored_meta['jkl-review-detail-label-2'] ) ? esc_attr( $jklrv_stored_meta['jkl-review-detail-label-2'][0] ) : $array['details-2-label'] ); ?>" />

                    <div class="jkl-review-detail-info"></div>

                    <input type="button" class="jkl-reviews-add-item button" value="+" />
                    <input type="button" class="jkl-reviews-remove-item button hidden" value="-" />
                </div>
            </div>
            
        </div><!-- #jkl-review-details -->    
    <p>Add any additional links below.</p>
    <div id="jkl-reviews-links"></div><!-- #jkl-reviews-links -->
    <p><input type="submit" id="jkl-reviews-add-link" value="Add Link" /></p>

<?php
}