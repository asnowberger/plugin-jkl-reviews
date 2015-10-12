<?php

/**
 * 
 * @since   2.0.0
 */
?>

<div id="jkl-reviews-navigation">
    <h2 class="nav-tab-wrapper current">
        <a class="nav-tab nav-tab-active" href="javascript:;">Product Info</a>
        <a class="nav-tab" href="javascript:;">Links</a>
        <a class="nav-tab" href="javascript:;">Run Giveaway</a>
    </h2>

    <?php
        // Include the template parts for rendering the tabbed content
        include_once( 'tab-info.php' );
        include_once( 'tab-links.php' );
        include_once( 'tab-giveaway.php' );

        // Add a nonce field for security
        wp_nonce_field( 'jkl-reviews-save', 'jkl_reviews_nonce' );
    ?>

</div>