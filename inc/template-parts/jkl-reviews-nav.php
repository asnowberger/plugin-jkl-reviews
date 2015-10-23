<?php

/**
 * 
 * @since   2.0.0
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
        'labeled'           => __( 'Add Label?', 'jkl-reviews' ),       // jkl-review-details-labeled
        'label'             => __( 'Ebook', 'jkl-reviews' ),            // jkl-review-details-label
        'detailed'          => __( 'Add Details?', 'jkl-reviews' ),
        'details-1-label'   => __( '3 Best Points', 'jkl-reviews' ),    // jkl-review-details-1-label
        'details-2-label'   => __( 'Quotes', 'jkl-reviews' ),           // jkl-review-details-2-label
        'details-1'         => array(),                                 // jkl-review-details-1[]
        'details-2'         => array(),                                 // jkl-review-details-2[]
        'details-help'      => __( 'Add any additional details below. ', 'jkl-reviews' )
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
        'detailed'          => __( 'Add Track List?', 'jkl-reviews' ),
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
        'detailed'          => __( 'Add Details?', 'jkl-reviews' ),
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
        'detailed'          => __( 'Add Details?', 'jkl-reviews' ),
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
        'detailed'          => __( 'Add Features?', 'jkl-reviews' ),
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
        'detailed'          => __( 'Add Features?', 'jkl-reviews' ),
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
        'detailed'          => __( 'Add Details?', 'jkl-reviews' ),
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
        'detailed'          => __( 'Add Details?', 'jkl-reviews' ),
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
    #jkl-rating-add-alert {
        // background-color: <?php // echo $colors[4]; ?>;
    }
</style>

<div id="jkl-reviews-meta-nav">
    <h2 class="nav-tab-wrapper current">
        <a class="nav-tab nav-tab-active" href="javascript:;">Product Info</a>
        <a class="nav-tab" href="javascript:;">Details</a>
        <a class="nav-tab" href="javascript:;">Rating</a>
        <a class="nav-tab hidden" href="javascript:;">Giveaway</a>
    </h2>

    <!-- REVIEW META BOX -->
    <div id="jkl-review-info" class="inside">

        <!-- Review Types Icon menu -->
        <section id="jkl-reviews-types" class="group">
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
        </section><!-- #jkl-reviews-types Icons Menu -->
        
        <!-- Default helper text -->
        <p class="jkl-review-helper note"><?php _e( 'Select your Review Type from the menu above.', 'jkl-reviews' ); ?></p>

        <?php
            // Include the template parts for rendering the tabbed content
            include_once( 'tab-info.php' );
            include_once( 'tab-details.php' );
            include_once( 'tab-rating.php' );
            include_once( 'tab-giveaway.php' );

            // Add a nonce field for security
            wp_nonce_field( 'jkl-reviews-save', 'jkl_reviews_nonce' );
        ?>
        
    </div><!-- END REVIEW META BOX #jkl-review-info -->
</div>