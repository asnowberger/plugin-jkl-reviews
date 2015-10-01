<?php

// Create a Custom Post Type for Reviews
add_action( 'init', 'jkl_reviews_register_cpt' );

/*
 * Custom Post Type for Reviews
 * Doc for Register_Post_Type: http://codex.wordpress.org/Function_Reference/register_post_type
 */

if ( !class_exists( 'JKL_Reviews_Post_Type' ) ) {
    
    /**
     * The JKL Reviews Custom Post Type
     */
    class JKL_Reviews_Post_Type {
        
        const POST_TYPE = "review";
        private $_meta = array(
            'meta_a',
            'meta_b',
            'meta_c',
        );
        
        /**
         * CONSTRUCTOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         */
        public function __construct() {
            
            // register actions
            add_action( 'init', array( &$this, 'jkl_cpt_init' ) );
            add_action( 'admin_init', array( &$this, 'jkl_cpt_admin_init' ) );
            
        } // END __construct()
    
        
        /**
         * SETUP !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         */
        public function jkl_cpt_init() {
            
            // Initialize Post Type
            $this->jkl_register_post_type();
            add_action( 'save_post', array( &$this, 'jkl_save_post' ) );
            
        } // END jkl_cpt_init()
        
        /** 
         * Hook into WP's admin_init action hook
         */
        public function jkl_cpt_admin_init() {
            
            // Add metaboxes
            add_action( 'add_meta_boxes', array( &$this, 'jkl_add_meta_boxes' ) );
        
        } // END jkl_cpt_admin_init()
        
        /**
         * Create the Post Type
         */
        public function jkl_register_post_type() {

            // Examples for translation-ready and Custom messages: http://codex.wordpress.org/Function_Reference/register_post_type#Example
            
            $labels = array(
                        'name'                  => __( sprintf( '%ss', ucwords( str_replace( "_", " ", self::POST_TYPE ) ) ), 'jkl-reviews' ),
                        'singular_name'         => __( ucwords( str_replace( "_", " ", self::POST_TYPE ) ), 'jkl-reviews' ),
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
            );
            $args = array (
                        'public'        => true,
                        'has_archive'   => true,
                        'can_export'    => true,
                        'description'   => __( 'Add product reviews.', 'jkl-reviews' ),
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
                        'labels'        => $labels,
                        'rewrite'       => array(
                            'slug'  => 'review',
                        ),
            );

            register_post_type( self::POST_TYPE, $args );
        }
        
        /**
         * METABOXES !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         */
        
        /** 
         * Hook into WP's add_meta_boxes action hook
         */
        public function jkl_add_meta_boxes() {
            
            // Add this metabox to every selected post
            // Doc http://codex.wordpress.org/Function_Reference/add_meta_box/
            add_meta_box(
                    sprintf( 'jkl_%s_section', self::POST_TYPE ),   // Unique ID
                    sprintf( '%s Information', ucwords( str_replace ( "_", " ", self::POST_TYPE ) ) ), // Title
                    array( &$this, 'jkl_add_inner_meta_boxes' ),    // Callback function
                    self::POST_TYPE                                 // Post type to display on
                                                                    // Context
                                                                    // Priority
                                                                    // Callback_args
            );
        
        } // END jkl_add_meta_boxes()
        
        /**
         * Called off of the jkl_add_meta_boxes
         */
        public function jkl_add_inner_meta_boxes( $post ) {
            
            // Render the job order metabox
            include ( sprintf ( "%s/../inc/metaboxes.php", dirname( __FILE__ ), self::POST_TYPE ) );
            
        } // END jkl_add_inner_meta_boxes( $post )
        
        /**
         * Save the metaboxes for this custom Post Type
         */
        public function jkl_save_post( $post_id ) {
            
            // verify if this is an auto save routine
            // If it is, our form has not been submitted, so we don't want to do anything
            if ( defined ( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }
            
            if ( isset ( $_POST[ 'post_type' ] ) && $_POST['post_type'] == self::POST_TYPE && current_user_can( 'edit_post', $post_id ) ) {
                
                foreach( $this->_meta as $field_name ) {
                    // Update the post's meta field
                    update_post_meta( $post_id, $field_name, $_POST[ $field_name ] );
                }
                
            } else {
                return;
            } // END if ( isset )
        } // END save_post( $post_id )

        
        /**
         * TAXONOMIES !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         */
        
        /*
         * Hierarchical Taxonomy for Review TYPES
         */
        public function jkl_define_type_taxonomy() {

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
        public function jkl_define_tag_taxonomy() {

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
        public function jkl_reviews_rewrite_flush() {

            // First, "add" the Custom Post Type (above)
            jkl_reviews_register_cpt();

            // *Only* rewrite on plugin activation
            flush_rewrite_rules();
        }
        
    } // END class JKL_Reviews_Post_Type
} // END if ( !class_exists( 'JKL_Reviews_Post_Type' ) )

register_activation_hook( __FILE__, 'jkl_reviews_rewrite_flush' );
?>
