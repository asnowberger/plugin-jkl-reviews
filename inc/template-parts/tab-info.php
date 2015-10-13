<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="inside">
    <div id="jkl-reviews-types">
        <a id="book-type" class="book-type">
            <i class="fa fa-book fa-2x fa-inverse"></i>
            <span>Book</span>
        </a>
        <a id="audio-type">
            <i class="fa fa-headphones fa-2x fa-inverse"></i>
            <span>Audio</span>
        </a>
        <a id="video-type">
            <i class="fa fa-youtube-play fa-2x fa-inverse"></i>
            <span>Video</span>
        </a>
        <a id="course-type">
            <i class="fa fa-pencil-square-o fa-2x fa-inverse"></i>
            <span>Course</span>
        </a>
        <a id="product-type">
            <i class="fa fa-archive fa-2x fa-inverse"></i>
            <span>Product</span>
        </a>
        <a id="service-type">
            <i class="fa fa-gift fa-2x fa-inverse"></i>
            <span>Service</span>
        </a>
        <a id="travel-type">
            <i class="fa fa-plane fa-2x fa-inverse"></i>
            <span>Travel</span>
        </a>
        <a id="other-type">
            <i class="fa fa-star fa-2x fa-inverse"></i>
            <span>Other</span>
        </a>
    </div>
    
    
    <!-- REVIEW INFORMATION TABLE -->
    <table class="jkl-review"> 
        
    </table>
    
    <div id="book-info" class="jkl-review hidden">
        <p>This is book info.</p>
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
    </div>
    <div id="audio-info" class="jkl-review hidden">
        <p>This is audio info.</p>
    </div>
    <div id="video-info" class="jkl-review hidden">
        <p>This is video info.</p>
    </div>
    <div id="course-info" class="jkl-review hidden">
        <p>This is course info.</p>
    </div>
    <div id="product-info" class="jkl-review hidden">
        <p>This is product info.</p>
    </div>
    <div id="service-info" class="jkl-review hidden">
        <p>This is service info.</p>
    </div>
    <div id="travel-info" class="jkl-review hidden">
        <p>This is travel info.</p>
    </div>
    <div id="other-info" class="jkl-review hidden">
        <p>This is other info.</p>
    </div>
    
</div>
        
        