<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Get the global admin color scheme so we can use it in our meta box.
 * @link https://kolakube.com/admin-color-scheme/
 */
global $_wp_admin_css_colors;

$admin_color = get_user_option( 'admin_color' );
$colors      = $_wp_admin_css_colors[$admin_color]->colors;

$book_info = array(
    'Book',
    'Cover',
    'ISBN',
    'Title',
    'Author',
    'Publisher',
    'Genre',
    'Series',
    'Publication Date',
    'Length',
    'Format',
    'Description'
);
$audio_info = array(
    'Audio'
);
$video_info = array(
    'Video'
);
$course_info = array(
    'Course'
);
$product_info = array(
    'Product'
);
$service_info = array(
    'Service'
);
$travel_info = array(
    'Travel'
);
$other_info = array(
    'Other'
);

?>

<style>
    /**
     * @TODO: Later, put this in a 'head' call as a function?
     */
    #jkl-reviews-types a {
        background-color: <?php echo $colors[1]; ?>;
    }
    #jkl-reviews-types a:hover {
        background-color: <?php echo $colors[2]; ?>;
    }
    #jkl-reviews-types a.active {
        background-color: <?php echo $colors[2]; ?>;
    }
</style>


<div id="jkl-review-info" class="inside">
    <div id="jkl-reviews-types">
        <a id="book-type" class="book-type">
            <i class="fa fa-book fa-2x"></i>
            <span>Book</span>
        </a>
        <a id="audio-type">
            <i class="fa fa-headphones fa-2x"></i>
            <span>Audio</span>
        </a>
        <a id="video-type">
            <i class="fa fa-youtube-play fa-2x"></i>
            <span>Video</span>
        </a>
        <a id="course-type">
            <i class="fa fa-pencil-square-o fa-2x"></i>
            <span>Course</span>
        </a>
        <a id="product-type">
            <i class="fa fa-archive fa-2x"></i>
            <span>Product</span>
        </a>
        <a id="service-type">
            <i class="fa fa-gift fa-2x"></i>
            <span>Service</span>
        </a>
        <a id="travel-type">
            <i class="fa fa-plane fa-2x"></i>
            <span>Travel</span>
        </a>
        <a id="other-type">
            <i class="fa fa-star fa-2x"></i>
            <span>Other</span>
        </a>
    </div>
    
    
    <!-- REVIEW INFORMATION TABLE -->
    <div class="jkl-review"> 
        <p class="note">Select your Review Type from the menu above.</p>
    </div>
    
    <div id="book-info" class="jkl-review hidden">
        <?php jkl_reviews_load_info_part( $book_info ); ?>
    </div> 
    
    <div id="audio-info" class="jkl-review hidden">
        <?php jkl_reviews_load_info_part( $audio_info ); ?>
    </div>
    
    <div id="video-info" class="jkl-review hidden">
        <?php jkl_reviews_load_info_part( $video_info ); ?>
    </div>
    
    <div id="course-info" class="jkl-review hidden">
        <?php jkl_reviews_load_info_part( $course_info ); ?>
    </div>
    
    <div id="product-info" class="jkl-review hidden">
        <?php jkl_reviews_load_info_part( $product_info ); ?>
    </div>
    
    <div id="service-info" class="jkl-review hidden">
        <?php jkl_reviews_load_info_part( $service_info ); ?>
    </div>
    
    <div id="travel-info" class="jkl-review hidden">
        <?php jkl_reviews_load_info_part( $travel_info ); ?>
    </div>
    
    <div id="other-info" class="jkl-review hidden">
        <?php jkl_reviews_load_info_part( $other_info ); ?>
    </div>
    
</div>
        
<?php

function jkl_reviews_load_info_part( $array ) {
    ?>

        <p class="note">Enter <?php echo $array[0]; ?> information below:</p>

        <!-- Cover image preview. This should only display the cover image IF THERE IS ONE. -->
        <?php //if ( $jklrv_stored_meta['jkl-review-cover'][0] != '' ) { ?>
            <label for="jkl-review-cover-preview" class="jkl-label"><?php _e('Cover Preview: ', 'jkl-reviews')?></label>
            <div id="jkl-cover-preview">
                <img src="<?php echo esc_url( $jklrv_stored_meta['jkl-review-cover'][0] ); ?>" />
            </div>
        <?php //} ?>

        <!-- Cover image. This should accept and display an image (like a Featured Image) using WP's image Uploader/chooser. -->
        <label for="jkl-review-cover" class="jkl-label"><?php _e('Cover: ', 'jkl-reviews')?></label>
        <input type="url" id="jkl-review-cover" name="jkl-review-cover" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-cover'] ) ) echo esc_url( $jklrv_stored_meta['jkl-review-cover'][0] ); ?>" />
        <input type="button" id="jkl-review-cover-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'jkl-review' )?>" />

        <div class="divider"></div>

        <!-- ID Number -->
        <label for="jkl-review-id-num" class="jkl-label"><?php _e('ISBN: ', 'jkl-reviews')?></label>
        <input type="text" class="input-text" id="jkl-review-id-num" name="jkl-review-id-num" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-id-num'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-id-num'][0] ); ?>" />

        <!-- Title -->
        <label for="jkl-review-title" class="jkl-label"><?php _e('Title: ', 'jkl-reviews')?></label>
        <input type="text" class="input-text" id="jkl-review-title" name="jkl-review-title" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-title'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-title'][0] ); ?>" />

        <!-- Author -->
        <label for="jkl-review-author" class="jkl-label"><?php _e('Author: ', 'jkl-reviews')?></label>
        <input type="text" class="input-text" id="jkl-review-author" name="jkl-review-author" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-author'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-author'][0] ); ?>" />

        <!-- Publisher -->
        <label for="jkl-review-publisher" class="jkl-label"><?php _e('Publisher: ', 'jkl-reviews')?></label>
        <input type="text" class="input-text" id="jkl-review-publisher" name="jkl-review-publisher" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-publisher'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-publisher'][0] ); ?>" />

        <!-- Genre. Should (eventually) act as WP Tags, separate-able by commas, including the list + X marks to remove categories -->
        <label for="jkl-review-genre" class="jkl-label"><?php _e('Genre: ', 'jkl-reviews')?></label>
        <input type="text" class="input-text" id="jkl-review-genre" name="jkl-review-genre" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-genre'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-genre'][0] ); ?>" />
        <p><span class="note"><?php _e( 'Separate multiple values with commas.', 'jkl-reviews' ) ?></span></p>

        <!-- Series -->
        <label for="jkl-review-series" class="jkl-label"><?php _e('Series: ', 'jkl-reviews')?></label>
        <input type="text" class="input-text" id="jkl-review-series" name="jkl-review-series" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-series'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-series'][0] ); ?>" />

        <!-- Release Date -->
        <label for="jkl-review-date" class="jkl-label"><?php _e('Publication Date: ', 'jkl-reviews')?></label>
        <input type="text" class="input-text" id="jkl-review-date" name="jkl-review-date" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-date'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-date'][0] ); ?>" />

        <!-- Length -->
        <label for="jkl-review-length" class="jkl-label"><?php _e('Length: ', 'jkl-reviews')?></label>
        <input type="text" class="input-text" id="jkl-review-length" name="jkl-review-length" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-length'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-length'][0] ); ?>" />

        <!-- Format -->
        <label for="jkl-review-format" class="jkl-label"><?php _e('Format: ', 'jkl-reviews')?></label>
        <input type="text" class="input-text" id="jkl-review-format" name="jkl-review-format" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-format'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-format'][0] ); ?>" />

        <!-- Description -->
        <label for=jkl-review-description" class="jkl-label"><?php _e('Description: ', 'jkl-reviews')?></label>
        <textarea id="jkl-review-description" name="jkl-review-description"><?php if( isset( $jklrv_stored_meta['jkl-review-description'] ) ) echo wp_kses_post( $jklrv_stored_meta['jkl-description'][0] ); ?></textarea>
        <p><span class="note"><?php _e( 'Enter any valid HTML in the Summary field.<br /><strong>Note:</strong> Any text entered will be in italics.', 'jkl-reviews' ) ?></span></p>

        <!-- Details -->
        <div class="divider-lite"></div>
        <p>Add any additional details below.</p>
        <div id="jkl-review-details"></div><!-- #jkl-review-details -->
        <p><input type="submit" id="jkl-reviews-add-detail" value="Add Detail" /></p>

    <?php
}