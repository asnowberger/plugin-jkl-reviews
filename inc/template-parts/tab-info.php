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

/**
 * Store all Review Meta strings in an array of arrays to access more easily.
 * 
 * @since   2.0.1
 * 
 * @TODO:   Put inside the constructor for this class?
 */
$review_info = array(
    
    // 1) Book Type
    'book'      => array(
        'cover'             => __( 'Cover', 'jkl-reviews' ),            // jkl-review-cover
        'id-num'            => __( 'ISBN', 'jkl-reviews' ),             // jkl-review-id-num
        'title'             => __( 'Title', 'jkl-reviews' ),            // jkl-review-title
        'author'            => __( 'Author', 'jkl-reviews' ),           // jkl-review-author
        'publisher'         => __( 'Publisher', 'jkl-reviews' ),        // jkl-review-publisher
        'genre'             => __( 'Genre', 'jkl-reviews' ),            // jkl-review-genre
        'series'            => __( 'Series', 'jkl-reviews' ),           // jkl-review-series
        'date'              => __( 'Publication Date', 'jkl-reviews' ), // jkl-review-date
        'length'            => __( 'Length', 'jkl-reviews' ),           // jkl-review-length
        'format'            => __( 'Format', 'jkl-reviews' ),           // jkl-review-format
        'description'       => __( 'Description', 'jkl-reviews' ),      // jkl-review-description
        'details-1-label'   => __( '3 Best Points', 'jkl-reviews' ),    // jkl-review-details-1-label
        'details-2-label'   => __( 'Quotes', 'jkl-reviews' ),           // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'Ebook', 'jkl-reviews' )             // jkl-review-details-label
    ), 
    
    // 2) Audio Type
    'audio'     => array(
        'cover'             => __( 'Cover', 'jkl-reviews' ),            // jkl-review-cover
        'id-num'            => __( 'ASIN', 'jkl-reviews' ),             // jkl-review-id-num
        'title'             => __( 'Title', 'jkl-reviews' ),            // jkl-review-title
        'author'            => __( 'Artist', 'jkl-reviews' ),           // jkl-review-author
        'publisher'         => __( 'Label', 'jkl-reviews' ),            // jkl-review-publisher
        'genre'             => __( 'Genre', 'jkl-reviews' ),            // jkl-review-genre
        'series'            => __( 'Series', 'jkl-reviews' ),           // jkl-review-series
        'date'              => __( 'Release Date', 'jkl-reviews' ),     // jkl-review-date
        'length'            => __( 'Length', 'jkl-reviews' ),           // jkl-review-length
        'format'            => __( 'Format', 'jkl-reviews' ),           // jkl-review-format
        'description'       => __( 'Description', 'jkl-reviews' ),      // jkl-review-description
        'details-1-label'   => __( 'Track List', 'jkl-reviews' ),       // jkl-review-details-1-label
        'details-2-label'   => __( 'Track Length', 'jkl-reviews' ),     // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'Explicit', 'jkl-reviews' )          // jkl-review-details-label
    ), 
    
    // 3) Video Type
    'video'     => array(
        'cover'             => __( 'Cover', 'jkl-reviews' ),            // jkl-review-cover
        'id-num'            => __( 'ID Number', 'jkl-reviews' ),        // jkl-review-id-num // Y + num = YouTube, V + num = Vimeo
        'title'             => __( 'Title', 'jkl-reviews' ),            // jkl-review-title
        'author'            => __( 'Director', 'jkl-reviews' ),         // jkl-review-author
        'publisher'         => __( 'Studio', 'jkl-reviews' ),           // jkl-review-publisher
        'genre'             => __( 'Genre', 'jkl-reviews' ),            // jkl-review-genre
        'series'            => __( 'MPAA Rating', 'jkl-reviews' ),      // jkl-review-series
        'date'              => __( 'Release Date', 'jkl-reviews' ),     // jkl-review-date
        'length'            => __( 'Runtime', 'jkl-reviews' ),          // jkl-review-length
        'format'            => __( 'Format', 'jkl-reviews' ),           // jkl-review-format
        'description'       => __( 'Synopsis', 'jkl-reviews' ),         // jkl-review-description
        'details-1-label'   => __( 'Stars', 'jkl-reviews' ),            // jkl-review-details-1-label
        'details-2-label'   => __( 'Costars', 'jkl-reviews' ),          // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'CC', 'jkl-reviews' )                // jkl-review-details-label
    ), 
    
    // 4) Course Type
    'course'    => array(
        'cover'             => __( 'Cover', 'jkl-reviews' ),            // jkl-review-cover
        'id-num'            => __( 'ID Number', 'jkl-reviews' ),        // jkl-review-id-num
        'title'             => __( 'Title', 'jkl-reviews' ),            // jkl-review-title
        'author'            => __( 'Author', 'jkl-reviews' ),           // jkl-review-author
        'publisher'         => __( 'Producer', 'jkl-reviews' ),         // jkl-review-publisher
        'genre'             => __( 'Genre', 'jkl-reviews' ),            // jkl-review-genre
        'series'            => __( 'Series', 'jkl-reviews' ),           // jkl-review-series
        'date'              => __( 'Publication Date', 'jkl-reviews' ), // jkl-review-date
        'length'            => __( 'Length', 'jkl-reviews' ),           // jkl-review-length
        'format'            => __( 'Format', 'jkl-reviews' ),           // jkl-review-format
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

/**
 * Takes a string that represents the 'slug' of the Review Type and returns a string
 * with the appropriate FontAwesome string for that Review Type
 * 
 * @since   2.0.1
 * 
 * @param   string  $string Takes a string that represents the 'slug' of the Review Type
 * @return  string
 * 
 * @TODO:   Put inside the constructor for this class?
 */
function get_fa_icon( $string ) {
    
    switch( $string ) {
        case 'book' :
            return 'book';
            break;
        case 'audio' :
            return 'headphones';
            break;
        case 'video' :
            return 'youtube-play';
            break;
        case 'course' :
            return 'pencil-square-o';
            break;
        case 'product' :
            return 'archive';
            break;
        case 'service' :
            return 'gift';
            break;
        case 'travel' : 
            return 'plane';
            break;
        default: 
            return 'star';
    }
    
} // END get_fa_icon( $string )

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

<!-- REVIEW META BOX -->
<div id="jkl-review-info" class="inside">
    
    <!-- Review Types Icon menu -->
    <div id="jkl-reviews-types">
        <?php 
        /**
         * Loop through our $review_info array and retrieve just the key value ($review_type) 
         * that represents the 'slug' for each type to use when creating our classes, ids, etc
         * 
         * @link http://stackoverflow.com/questions/8440352/retrieve-key-value-of-multidimensional-array-in-php
         */
        foreach( $review_info as $review_type => $data ) { 
            
                echo "<a id='$review_type-type' class='$review_type-type'>";
                echo "<i class='fa fa-" . get_fa_icon( $review_type ) . " fa-2x'></i>";
                echo "<span>" . ucwords( $review_type ) . "</span>";
                echo "</a>";
                
        } 
        ?>
    </div><!-- #jkl-reviews-types Icons Menu -->
    
    <!-- REVIEW INFORMATION TABLE -->
    <!-- Default helper text -->
    <div class="jkl-review"> 
        <p class="note"><?php _e( 'Select your Review Type from the menu above.', 'jkl-reviews' ); ?></p>
    </div>
    
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
    
</div><!-- #jkl-review-info -->
        
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

        <p class="note"><?php echo sprintf( 'Enter %s information below:', ucwords( $str_type ) ); ?></p>

        <!-- Cover image preview. This should only display the cover image IF THERE IS ONE. -->
        <?php //if ( $jklrv_stored_meta['jkl-review-cover'][0] != '' ) { ?>
            <label for="jkl-review-cover-preview" class="jkl-label"><?php echo __( sprintf( '%s Preview ', $array['cover'] ), 'jkl-reviews' ); ?></label>
            <div id="jkl-cover-preview">
                <img src="<?php echo esc_url( $jklrv_stored_meta['jkl-review-cover'][0] ); ?>" />
            </div>
        <?php //} ?>

        <!-- Cover image. This should accept and display an image (like a Featured Image) using WP's image Uploader/chooser. -->
        <label for="jkl-review-cover" class="jkl-label"><?php echo __( sprintf( 'Set %s ', $array['cover'] ), 'jkl-reviews' ); ?></label>
        <input type="url" id="jkl-review-cover" name="jkl-review-cover" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-cover'] ) ) echo esc_url( $jklrv_stored_meta['jkl-review-cover'][0] ); ?>" />
        <input type="button" id="jkl-review-cover-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'jkl-review' )?>" />

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
        <input type="text" class="input-text" id="jkl-review-date" name="jkl-review-date" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-date'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-date'][0] ); ?>" />

        <!-- Length -->
        <label for="jkl-review-length" class="jkl-label"><?php echo $array['length']; ?></label>
        <input type="text" class="input-text" id="jkl-review-length" name="jkl-review-length" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-length'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-length'][0] ); ?>" />

        <!-- Format -->
        <label for="jkl-review-format" class="jkl-label"><?php echo $array['format']; ?></label>
        <input type="text" class="input-text" id="jkl-review-format" name="jkl-review-format" 
               value="<?php if( isset( $jklrv_stored_meta['jkl-review-format'] ) ) echo esc_attr( $jklrv_stored_meta['jkl-review-format'][0] ); ?>" />

        <!-- Description -->
        <label for=jkl-review-description" class="jkl-label"><?php echo $array['description']; ?></label>
        <textarea id="jkl-review-description" name="jkl-review-description"><?php if( isset( $jklrv_stored_meta['jkl-review-description'] ) ) echo wp_kses_post( $jklrv_stored_meta['jkl-description'][0] ); ?></textarea>
        <p><span class="note"><?php _e( 'Enter any valid HTML in the Summary field.<br /><strong>Note:</strong> Any text entered will be in italics.', 'jkl-reviews' ) ?></span></p>

        <!-- Details -->
        <div class="divider-lite"></div>
        <p><?php _e( 'Add any additional details below.', 'jkl-reviews' ); ?></p>
        <div id="jkl-review-details">
            
            <div class="jkl-review-details-left">
                <p><input type="button" id="jkl-reviews-add-detail-1" value="+" /></p>
            </div>
            <div class="jkl-review-details-right">
                <p><input type="button" id="jkl-reviews-add-detail-2" value="+" /></p>
            </div>
            
            <div class="jkl-label">
                <input type='checkbox' id='jkl-review-labeled' name='jkl-review-labeled' value='1' <?php //checked( $options['use_shortcode'], 1 ); ?> />
                <label for="jkl-review-labeled" name="jkl-review-labeled"><?php echo $array['labeled']; ?></label>
            </div>
            <input type="text" class="input-text" id="jkl-review-details-label" name="jkl-review-details-label" 
               value="<?php isset( $jklrv_stored_meta['jkl-review-details-label'] ) ? esc_attr( $jklrv_stored_meta['jkl-review-details-label'][0] ) : $array['label']; ?>" />

        </div><!-- #jkl-review-details -->    

    <?php
}