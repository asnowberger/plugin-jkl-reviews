<?php

// Add a custom Post Type for Reviews
add_action( 'init', 'jkl_create_review' );

/*
 * Custom Post Type for Reviews
 * Doc for Register_Post_Type: http://codex.wordpress.org/Function_Reference/register_post_type
 */

function jkl_create_review() {
    
    // Examples for translation-ready and Custom messages: http://codex.wordpress.org/Function_Reference/register_post_type#Example
    register_post_type( 'reviews', array (
        'public'    => true,
        'labels' => array(
            'name' => 'Reviews',
            'singular_name' => 'Review',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Review',
            'edit' => 'Edit',
            'edit_item' => 'Edit Review',
            'view' => 'View',
            'view_item' => 'View Review',
            'search_items' => 'Search Reviews',
            'not_found' => 'No Reviews found',
            'not_found_in_trash' => 'No Reviews found in Trash',
        ),
        
        'description' => 'Add book reviews, movie reviews, product reviews, or service reivews.',
        'public' => true,
        'menu_position' => 30,
        'supports' => array( 'title', 'editor', 'author', 'comments', 'thumbnail', 'custom-fields' ),
        'taxonomies' => array( 'category', 'post_tag', 'series', 'genre' ),
        'menu_icon' => 'dashicons-welcome-view-site',
        'has_archive' => true,
    ));
}

// Flushing Rewrite on Activation (Probably only necessary if actually DOING a rewrite in the Create Custom Post Type function declaration (above).
// Doc: http://codex.wordpress.org/Function_Reference/register_post_type#Flushing_Rewrite_on_Activation
function jklrv_rewrite_flush() {
    
    // First, "add" the Custom Post Type (above)
    jkl_create_review();
    
    // *Only* rewrite on plugin activation
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'jklrv_rewrite_flush' );

?>
