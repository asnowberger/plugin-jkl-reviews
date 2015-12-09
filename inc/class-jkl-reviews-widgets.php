<?php
/**
 * JKL Reviews Info box sidebar widget
 * 
 * If enabled, this widget replaces the info box in the Post or Custom Post Type content.
 * 
 * @since       2.0.1
 * 
 * @package     JKL_Reviews
 * @subpackage  JKL_Reviews/inc/widgets
 * @author      Aaron Snowberger <jekkilekki@gmail.com>
 */

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
    exit;
}

//==============================================================================
// 
// JKL REVIEWS WIDGET Info Box class
// 
//==============================================================================
class JKL_Reviews_Widget_Info_Box extends WP_Widget {
    
    /**
     * Widget identifier
     * 
     * @since   2.0.1
     * 
     * @var     string
     */
    protected $widget_slug = 'jkl-reviews-widget-info';
    
    /*--------------------------------------------------------------------------
     * CONSTRUCTOR
     *-------------------------------------------------------------------------*/
    
    /**
     * Specifies the classname and description, instantiates the widget, 
     * includes any necessary stylesheets and JavaScript.
     */
    public function __construct() {
        
        // build
        parent::construct(
                $this->get_widget_slug(),
                __( 'JKL Reviews - Info Box', $this->get_widget_slug() ),
                array(
                        'classname'     => $this->get_widget_slug().'-class',
                        'description'   => __( 'This widget can be used to replace all or some of the Review box content in Posts.', $this->get_widget_slug() )
                )
        );
        
        // Register ADMIN styles and scripts (backend)
        add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
        
        // Register SITE styles and scripts (frontend)
        add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'regsiter_widget_scripts' ) );
        
        // Refresh the widget's cached output with each new post
        add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
        add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
        add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
        
    } // END __construct()
    
    /**
     * GETTER Method: Return the widget slug.
     * 
     * @since   2.0.1
     * 
     * @return  Plugin slug string
     */
    public function get_widget_slug() {
        return $this->widget_slug;
    }
    
    /*--------------------------------------------------------------------------
     * Widget API Functions
     *-------------------------------------------------------------------------*/
    
    /**
     * Outputs the content of the widget
     * 
     * @param   array args      The array of form elements
     * @param   array instance  The current instance of the widget
     */
    public function widget( $args, $instance ) {
        
        // Check if there is cached output
        $cache = wp_cache_get( $this->get_widget_slug(), 'widget' );
        
        if ( !is_array( $cache ) )
                $cache = array();
        
        if ( !isset ( $args[ 'widget_id' ] ) )
                $args[ 'widget_id' ] = $this->id;
        
        if ( isset ( $cache[ $args[ 'widget_id' ] ] ) )
                return print $cache[ $args[ 'widget_id' ] ];
        
        // continue widget logic, put everything into a string and ...
        
        extract( $args, EXTR_SKIP );
        
        $widget_string = $before_widget;
        
        // Change widget values based on input fields
        ob_start();
        include( plugin_dir_path( __FILE__ ) . 'template-parts/widget-info-box.php' );
        $widget_string .= ob_get_clean();
        $widget_string .= $after_widget;
        
        $cache[ $args[ 'widget_id' ] ] = $widget_string;
        
        wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );
        
        print $widget_string;
        
    } // END widget()
    
    public function flush_widget_cache() {
        wp_cache_delete( $this->get_widget_slug(), 'widget' );
    }
    
    /**
     * Processes the widgets options to be saved.
     * 
     * @param   array new_instance  The new instance of values to be generated via the update.
     * @param   array old_instance  The previous instance of values before the update.
     */
    public function update( $new_instance, $old_instance ) {
        
        $instance = $old_instance;
        
        $instance[ 'widget_title' ] = strip_tags( stripslashes( $new_instance[ 'widget_title' ] ) );
        $instance[ 'display_info' ] = strip_tags( stripslashes( $new_instance[ 'display_info' ] ) );
        
        return $instance;
        
    } // END update()
    
    /**
     * Generates the administartion form for the widget
     * 
     * @param   array instance  The array of keys and values for the widget
     */
    public function form( $instance ) {
        
        // TODO: Define default values for your variables
        $instance = wp_parse_args( 
                (array) $instance,
                array(
                    'widget_title'  => '',
                    'display_info'  => ''
                )
        );
        
        $widget_title = strip_tags( stripslashes( $new_instance[ 'widget_title' ] ) );
        $display_info = strip_tags( stripslashes( $new_instance[ 'display_info' ] ) );
        
         // Display the admin form
        include( plugin_dir_path( __FILE__ ) . 'template-parts/widget-info-box-admin.php' );
        
    } // END form()
} // END JKL_REVIEWS_WIDGET_INFO_BOX

return new JKL_Reviews_Widget_Info_Box;


//==============================================================================
// 
// JKL REVIEWS WIDGET List Box class
// 
//==============================================================================
class JKL_Reviews_Widget_List_Box extends WP_Widget {
    
    /**
     * Widget identifier
     * 
     * @since   2.0.1
     * 
     * @var     string
     */
    protected $widget_slug = 'jkl-reviews-widget-list';
    
    /*--------------------------------------------------------------------------
     * CONSTRUCTOR
     *-------------------------------------------------------------------------*/
    
    /**
     * Specifies the classname and description, instantiates the widget, 
     * includes any necessary stylesheets and JavaScript.
     */
    public function __construct() {
        
        // build
        parent::construct(
                $this->get_widget_slug(),
                __( 'JKL Reviews - List Reviews', $this->get_widget_slug() ),
                array(
                        'classname'     => $this->get_widget_slug().'-class',
                        'description'   => __( 'This widget can display a list of either Latest Reviews or Top Rated Reviews.', $this->get_widget_slug() )
                )
        );
        
        // Register ADMIN styles and scripts (backend)
        add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
        
        // Register SITE styles and scripts (frontend)
        add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'regsiter_widget_scripts' ) );
        
        // Refresh the widget's cached output with each new post
        add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
        add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
        add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
        
    } // END __construct()
    
    /**
     * GETTER Method: Return the widget slug.
     * 
     * @since   2.0.1
     * 
     * @return  Plugin slug string
     */
    public function get_widget_slug() {
        return $this->widget_slug;
    }
    
    /*--------------------------------------------------------------------------
     * Widget API Functions
     *-------------------------------------------------------------------------*/
    
    /**
     * Outputs the content of the widget
     * 
     * @param   array args      The array of form elements
     * @param   array instance  The current instance of the widget
     */
    public function widget( $args, $instance ) {
        
        // Check if there is cached output
        $cache = wp_cache_get( $this->get_widget_slug(), 'widget' );
        
        if ( !is_array( $cache ) )
                $cache = array();
        
        if ( !isset ( $args[ 'widget_id' ] ) )
                $args[ 'widget_id' ] = $this->id;
        
        if ( isset ( $cache[ $args[ 'widget_id' ] ] ) )
                return print $cache[ $args[ 'widget_id' ] ];
        
        // continue widget logic, put everything into a string and ...
        
        extract( $args, EXTR_SKIP );
        
        $widget_string = $before_widget;
        
        // Change widget values based on input fields
        ob_start();
        include( plugin_dir_path( __FILE__ ) . 'views/widget-list-box.php' );
        $widget_string .= ob_get_clean();
        $widget_string .= $after_widget;
        
        $cache[ $args[ 'widget_id' ] ] = $widget_string;
        
        wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );
        
        print $widget_string;
        
    } // END widget()
    
    public function flush_widget_cache() {
        wp_cache_delete( $this->get_widget_slug(), 'widget' );
    }
    
    /**
     * Processes the widgets options to be saved.
     * 
     * @param   array new_instance  The new instance of values to be generated via the update.
     * @param   array old_instance  The previous instance of values before the update.
     */
    public function update( $new_instance, $old_instance ) {
        
        $instance = $old_instance;
        
        $instance[ 'widget_title' ] = strip_tags( stripslashes( $new_instance[ 'widget_title' ] ) );
        $instance[ 'review_num' ] = strip_tags( stripslashes( $new_instance[ 'review_num' ] ) );
        $instance[ 'review_type' ] = strip_tags( stripslashes( $new_instance[ 'review_type' ] ) );
        $instance[ 'latest' ] = strip_tags( stripslashes( $new_instance[ 'latest' ] ) );
        $instance[ 'top' ] = strip_tags( stripslashes( $new_instance[ 'top' ] ) );
        
        return $instance;
        
    } // END update()
    
    /**
     * Generates the administartion form for the widget
     * 
     * @param   array instance  The array of keys and values for the widget
     */
    public function form( $instance ) {
        
        // TODO: Define default values for your variables
        $instance = wp_parse_args( 
                (array) $instance,
                array(
                    'widget_title'  => '',
                    'review_num'    => '',
                    'review_type'   => '',
                    'latest'        => '',
                    'top'           => ''
                )
        );
        
        $widget_title = strip_tags( stripslashes( $new_instance[ 'widget_title' ] ) );
        $review_num = strip_tags( stripslashes( $new_instance[ 'review_num' ] ) );
        $review_type = strip_tags( stripslashes( $new_instance[ 'review_type' ] ) );
        $latest = strip_tags( stripslashes( $new_instance[ 'latest' ] ) );
        $top = strip_tags( stripslashes( $new_instance[ 'top' ] ) );
        
         // Display the admin form
        include( plugin_dir_path( __FILE__ ) . 'views/admin.php' );
        
    } // END form()
}

return new JKL_Reviews_Widget_List_Box;