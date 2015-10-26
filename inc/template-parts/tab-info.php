<?php

/**
 * Provides the "Product Info" view for the corresponding tab in the Post Meta Box.
 * 
 * @since       2.0.1
 * 
 * @package     JKL_Reviews
 * @subpackage  JKL_Reviews/inc/template-parts
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 */

?>
<div class="jkl-review-meta tab-info">   
    <!-- REVIEW INFORMATION TAB -->
    
    <?php 
    /**
     * Dynamically loop through our Review Types (array) and create each info box
     * using the same type of foreach loop as above
     */
    foreach( $review_info as $review_type => $data ) {
        
        echo "<div id='$review_type-info' class='jkl-review $review_type-info hidden'>";

            /**
             * Call function to load each Review Type's labels in meta boxes
             */
            jkl_reviews_load_info_part( $review_type, $data );

        echo "</div><!-- #$review_type-info -->";
            
    } 
    ?>
    
</div><!-- #jkl-review-meta -->
     

<?php
/**
 * Accepts the Review Type 'slug' and an array of its data, then outputs the HTML 
 * for that Review Type
 * 
 * @since   2.0.1
 * 
 * @param   string  $str_type
 * @param   array   $array
 */
function jkl_reviews_load_info_part( $str_type, $array ) {
    ?>

        <p class="note"><?php _e( sprintf( 'Enter %s information below:', ucwords( $str_type ) ), 'jkl-reviews' ); ?></p>

        <!-- Cover image. This should accept and display an image (like a Featured Image) using WP's image Uploader/chooser. -->
        <label for="jkl-review-cover" class="jkl-label"><?php echo __( sprintf( 'Set %s ', $array['cover'] ), 'jkl-reviews' ); ?></label>
        <input type="url" id="jkl-review-cover" name="jkl-review-cover" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-cover'] ) ) echo esc_url( $jklrv_stored_meta['jkl-review-cover'][0] ); ?>" />
        <button type="submit" id="jkl-review-cover-button" class="button">
            <?php _e( 'Choose Image', 'jkl-review' ); ?>
        </button>
        <button type="submit" id="jkl-review-remove-cover-button" class="button hidden">
            <?php _e( 'Remove', 'jkl-review' )?>
        </button>

        <!-- Cover image preview. This should only display the cover image IF THERE IS ONE. -->
        <?php //if ( $jklrv_stored_meta['jkl-review-cover'][0] != '' ) { ?>
            <div id="jkl-cover-preview" class="hidden">    
                <label for="jkl-review-cover-preview" class="jkl-label"><?php echo __( sprintf( '%s Preview ', $array['cover'] ), 'jkl-reviews' ); ?></label>
            
                <a href="#">
                    <img id="jkl-cover-img" src="<?php echo esc_url( $jklrv_stored_meta['jkl-review-cover'][0] ); ?>" />
                </a>
            </div>
        <?php //} ?>
        
        <!-- DIVIDER ----------------------------------------------------------->
        <div class="divider"></div>

        <!-- ID Number -->
        <label for="jkl-review-id-num" class="jkl-label"><?php echo $array['id-num']; ?></label>
        <input type="text" class="input-text" id="jkl-review-id-num" name="jkl-review-id-num" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-id-num'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-id-num'][0] ); ?>" />

        <!-- Title -->
        <label for="jkl-review-title" class="jkl-label"><?php echo $array['title']; ?></label>
        <input type="text" class="input-text" id="jkl-review-title" name="jkl-review-title" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-title'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-title'][0] ); ?>" />

        <!-- Author -->
        <label for="jkl-review-author" class="jkl-label"><?php echo $array['author']; ?></label>
        <input type="text" class="input-text" id="jkl-review-author" name="jkl-review-author" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-author'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-author'][0] ); ?>" />

        <!-- Publisher -->
        <label for="jkl-review-publisher" class="jkl-label"><?php echo $array['publisher']; ?></label>
        <input type="text" class="input-text" id="jkl-review-publisher" name="jkl-review-publisher" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-publisher'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-publisher'][0] ); ?>" />

        <!-- Genre. Should (eventually) act as WP Tags, separate-able by commas, including the list + X marks to remove categories -->
        <label for="jkl-review-genre" class="jkl-label"><?php echo $array['genre']; ?></label>
        <input type="text" class="input-text" id="jkl-review-genre" name="jkl-review-genre" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-genre'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-genre'][0] ); ?>" />
        <p><span class="note"><?php _e( 'Separate multiple values with commas.', 'jkl-reviews' ) ?></span></p>

        <!-- Series -->
        <label for="jkl-review-series" class="jkl-label"><?php echo $array['series']; ?></label>
        <input type="text" class="input-text" id="jkl-review-series" name="jkl-review-series" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-series'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-series'][0] ); ?>" />

        <!-- Release Date -->
        <label for="jkl-review-date" class="jkl-label"><?php echo $array['date']; ?></label>
        <input type="text" class="input-date" id="jkl-review-date" name="jkl-review-date" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-date'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-date'][0] ); ?>" />
        <br>
        
        <!-- Length -->
        <label for="jkl-review-length" class="jkl-label"><?php echo $array['length']; ?></label>
        <input type="text" class="input-text" id="jkl-review-length" name="jkl-review-length" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-length'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-length'][0] ); ?>" />

        <!-- Format -->
        <label for="jkl-review-format" class="jkl-label"><?php echo $array['format']; ?></label>
        <input type="text" class="input-text" id="jkl-review-format" name="jkl-review-format" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-format'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-format'][0] ); ?>" />

        <!-- Description -->
        <label for=jkl-review-description" class="jkl-label jkl-label-float"><?php echo $array['description']; ?></label>
        <?php
            /**
             * Add WYSIWYG Editor for the description rather than a vanilla <textarea>
             * 
             * @since   2.0.1
             */
             $content = '';
             $editor_id = "jkl-review-$str_type-description";
             wp_editor( $content, $editor_id );

}