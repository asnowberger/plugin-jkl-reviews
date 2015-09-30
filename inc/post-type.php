<?php

// Create a Custom Post Type for Reviews
add_action( 'init', 'jkl_reviews_register_cpt' );

/*
 * Custom Post Type for Reviews
 * Doc for Register_Post_Type: http://codex.wordpress.org/Function_Reference/register_post_type
 */

function jkl_reviews_register_cpt() {
    
    // Examples for translation-ready and Custom messages: http://codex.wordpress.org/Function_Reference/register_post_type#Example
    $args = array (
                'public'        => true,
                'has_archive'   => true,
                'can_export'    => true,
                'description'   => 'Add product reviews.',
                'menu_position' => 30,
                'menu_icon'     => 'dashicons-welcome-view-site',
                'supports'      => array( 
                    'title', 
                    'editor',
                    'excerpt',
                    'author', 
                    'comments', 
                    'thumbnail', 
                    'custom-fields' 
                ),
                'taxonomies'    => array( 
                    'category', 
                    'post_tag', 
                    'series', 
                    'genre' 
                ),
                'labels'        => array(
                    'name'                  => 'Reviews',
                    'singular_name'         => 'Review',
                    'add_new'               => 'Add New Review',
                    'add_new_item'          => 'Add New Review',
                    'edit'                  => 'Edit Review',
                    'edit_item'             => 'Edit Review',
                    'new_item'              => 'New Review',
                    'all_items'             => 'All Reviews',
                    'view'                  => 'View Review',
                    'view_item'             => 'View Review',
                    'search_items'          => 'Search Reviews',
                    'not_found'             => 'No Reviews found',
                    'not_found_in_trash'    => 'No Reviews found in Trash',
                    'menu_name'             => 'JKL Reviews'
                ),
                'rewrite'       => array(
                    'slug'  => 'review',
                ),
        
    );
    
    register_post_type( 'reviews', $args );
}

/*
 * Hierarchical Taxonomy for Review TYPES
 */
function jkl_reviews_define_type_taxonomy() {
    
    $labels = array(
        'name'              => 'Review Type',
        'singular_name'     => 'Review Types',
        'search_items'      => 'Search Review Types',
        'all_items'         => 'All Review Types',
        'parent_item'       => 'Parent Review Type',
        'parent_item_colon' => 'Parent Review Type:',
        'edit_item'         => 'Edit Review Type',
        'update_item'       => 'Update Review Type',
        'add_new_item'      => 'Add New Review Type',
        'new_item_name'     => 'New Type Review Name',
        'menu_name'         => 'Review Type',
        'view_item'         => 'View Review Types'
    );
    
    $args = array(
        'labels'        => $labels,
        'hierarchical'  => true,
        'query_var'     => true,
        'rewrite'       => true
    );  
    
    register_taxonomy( 'jkl-review-types', 'jkl-reviews', $args );
}

/*
 * Non-hierarchical taxonomy for Review topics or themes (tags)
 */
function jkl_reviews_define_tag_taxonomy() {
    
    $labels = array(
        'name'              => 'Review Tag',
        'singular_name'     => 'Review Tags',
        'search_items'      => 'Search Review Tags',
        'all_items'         => 'All Review Tags',
        'parent_item'       => 'Parent Review Tag',
        'parent_item_colon' => 'Parent Review Tag:',
        'edit_item'         => 'Edit Review Tag',
        'update_item'       => 'Update Review Tag',
        'add_new_item'      => 'Add New Review Tag',
        'new_item_name'     => 'New Tag Review Name',
        'menu_name'         => 'Review Tag',
        'view_item'         => 'View Review Tag'
    );
    
    $args = array(
        'labels'        => $labels,
        'hierarchical'  => false,
        'query_var'     => true,
        'rewrite'       => true
    );  
    
    register_taxonomy( 'jkl-review-tags', 'jkl-reviews', $args );
}

// Flushing Rewrite on Activation (Probably only necessary if actually DOING a rewrite in the Create Custom Post Type function declaration (above).
// Doc: http://codex.wordpress.org/Function_Reference/register_post_type#Flushing_Rewrite_on_Activation
function jkl_reviews_rewrite_flush() {
    
    // First, "add" the Custom Post Type (above)
    jkl_reviews_register_cpt();
    
    // *Only* rewrite on plugin activation
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'jklrv_rewrite_flush' );

?>
