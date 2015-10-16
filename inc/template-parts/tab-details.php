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

/**
 * Store all Review Meta strings in an array of arrays to access more easily.
 * 
 * @since   2.0.1
 * 
 * @TODO:   Put inside the constructor for this class?
 */
$review_details = array(
    
    // 1) Book Type
    'book'      => array(
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'Ebook', 'jkl-reviews' ),            // jkl-review-details-label
        'details-1-label'   => __( '3 Best Points', 'jkl-reviews' ),    // jkl-review-details-1-label
        'details-2-label'   => __( 'Quotes', 'jkl-reviews' ),           // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'details-help'      => __( 'Add any additional details below. ', 'jkl-reviews' )
    ), 
    
    // 2) Audio Type
    'audio'     => array(
        'details-1-label'   => __( 'Track List', 'jkl-reviews' ),       // jkl-review-details-1-label
        'details-2-label'   => __( 'Track Length', 'jkl-reviews' ),     // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'Explicit', 'jkl-reviews' )          // jkl-review-details-label
    ), 
    
    // 3) Video Type
    'video'     => array(
        'details-1-label'   => __( 'Stars', 'jkl-reviews' ),            // jkl-review-details-1-label
        'details-2-label'   => __( 'Costars', 'jkl-reviews' ),          // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'CC', 'jkl-reviews' )                // jkl-review-details-label
    ), 
    
    // 4) Course Type
    'course'    => array(
        'description'       => __( 'Description', 'jkl-reviews' ),      // jkl-review-description
        'details-1-label'   => __( 'Prerequisites', 'jkl-reviews' ),    // jkl-review-details-1-label
        'details-2-label'   => __( 'Course covers', 'jkl-reviews' ),    // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'Beginner', 'jkl-reviews' )          // jkl-review-details-label
    ), 
    
    // 5) Product Type
    'product'   => array(
        'cover'             => __( 'Image', 'jkl-reviews' ),            // jkl-review-cover
        'id-num'            => __( 'ID Number', 'jkl-reviews' ),        // jkl-review-id-num
        'title'             => __( 'Product Name', 'jkl-reviews' ),     // jkl-review-title
        'author'            => __( 'Designer', 'jkl-reviews' ),         // jkl-review-author
        'publisher'         => __( 'Company', 'jkl-reviews' ),          // jkl-review-publisher
        'genre'             => __( 'Product Type', 'jkl-reviews' ),     // jkl-review-genre
        'series'            => __( 'Product Line', 'jkl-reviews' ),     // jkl-review-series
        'date'              => __( 'Manufacture Date', 'jkl-reviews' ), // jkl-review-date
        'length'            => __( 'Dimensions', 'jkl-reviews' ),       // jkl-review-length
        'format'            => __( 'Materials', 'jkl-reviews' ),        // jkl-review-format
        'description'       => __( 'Description', 'jkl-reviews' ),      // jkl-review-description
        'details-1-label'   => __( 'Positives', 'jkl-reviews' ),        // jkl-review-details-1-label
        'details-2-label'   => __( 'Negatives', 'jkl-reviews' ),        // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'Label', 'jkl-reviews' )             // jkl-review-details-label
    ), 
    
    // 6) Service Type
    'service'   => array(
        'cover'             => __( 'Image', 'jkl-reviews' ),            // jkl-review-cover
        'id-num'            => __( 'ID Number', 'jkl-reviews' ),        // jkl-review-id-num
        'title'             => __( 'Service Name', 'jkl-reviews' ),     // jkl-review-title
        'author'            => __( '***Provider', 'jkl-reviews' ),      // jkl-review-author
        'publisher'         => __( '***Company', 'jkl-reviews' ),       // jkl-review-publisher
        'genre'             => __( 'Service Type', 'jkl-reviews' ),     // jkl-review-genre
        'series'            => __( 'Series', 'jkl-reviews' ),           // jkl-review-series
        'date'              => __( 'Service Date', 'jkl-reviews' ),     // jkl-review-date
        'length'            => __( '***Length', 'jkl-reviews' ),        // jkl-review-length
        'format'            => __( '***Format', 'jkl-reviews' ),        // jkl-review-format
        'description'       => __( 'Description', 'jkl-reviews' ),      // jkl-review-description
        'details-1-label'   => __( 'Positives', 'jkl-reviews' ),        // jkl-review-details-1-label
        'details-2-label'   => __( 'Negatives', 'jkl-reviews' ),        // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'Superb', 'jkl-reviews' )            // jkl-review-details-label
    ), 
    
    // 7) Travel Type
    'travel'    => array(
        'cover'             => __( 'Image', 'jkl-reviews' ),            // jkl-review-cover
        'id-num'            => __( 'ID Number', 'jkl-reviews' ),        // jkl-review-id-num
        'title'             => __( 'Title', 'jkl-reviews' ),            // jkl-review-title
        'author'            => __( 'Destination', 'jkl-reviews' ),      // jkl-review-author
        'publisher'         => __( 'Provider', 'jkl-reviews' ),         // jkl-review-publisher
        'genre'             => __( 'Travel Type', 'jkl-reviews' ),      // jkl-review-genre
        'series'            => __( '***Series', 'jkl-reviews' ),        // jkl-review-series
        'date'              => __( 'Travel Date', 'jkl-reviews' ),      // jkl-review-date
        'length'            => __( 'Travel Period', 'jkl-reviews' ),    // jkl-review-length
        'format'            => __( '***Format', 'jkl-reviews' ),        // jkl-review-format
        'description'       => __( 'Description', 'jkl-reviews' ),      // jkl-review-description
        'details-1-label'   => __( 'Sightseeing', 'jkl-reviews' ),      // jkl-review-details-1-label
        'details-2-label'   => __( 'Experiences', 'jkl-reviews' ),      // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'Domestic', 'jkl-reviews' )          // jkl-review-details-label
    ),
    
    // 8) Other Type
    'other'     => array(
        'cover'             => __( 'Image', 'jkl-reviews' ),            // jkl-review-cover
        'id-num'            => __( 'ID Number', 'jkl-reviews' ),        // jkl-review-id-num
        'title'             => __( 'Title', 'jkl-reviews' ),            // jkl-review-title
        'author'            => __( 'Maker', 'jkl-reviews' ),            // jkl-review-author
        'publisher'         => __( 'Company', 'jkl-reviews' ),          // jkl-review-publisher
        'genre'             => __( 'Category', 'jkl-reviews' ),         // jkl-review-genre
        'series'            => __( 'Series', 'jkl-reviews' ),           // jkl-review-series
        'date'              => __( 'Date', 'jkl-reviews' ),             // jkl-review-date
        'length'            => __( 'Stats', 'jkl-reviews' ),            // jkl-review-length
        'format'            => __( 'Format', 'jkl-reviews' ),           // jkl-review-format
        'description'       => __( 'Description', 'jkl-reviews' ),      // jkl-review-description
        'details-1-label'   => __( 'Pros', 'jkl-reviews' ),             // jkl-review-details-1-label
        'details-2-label'   => __( 'Cons', 'jkl-reviews' ),             // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'Label', 'jkl-reviews' )             // jkl-review-details-label
    )
    
); // END $review_info array
?>

<div class="inside hidden">
            <!-- DIVIDER ----------------------------------------------------------->
        <div class="divider"></div>
        
        <p class="note"><?php _e( 'Add any additional details below.', 'jkl-reviews' ); ?></p>
        <p><input type="button" id="jkl-reviews-add-details" class="button" value="Add details" /></p>
        
        <!-- Details -->
        <div id="jkl-review-details" class="group hidden">
            
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
</div>