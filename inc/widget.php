<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Reviews_Widget' ) ) {

/**
 * JKL Reviews Widget
 * Doc: https://codex.wordpress.org/Widgets_API
 * 
 * @author Aaron Snowberger
 * @project JKL-Reviews
 */
    
class JKL_Reviews_Widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct(
                'jkl-reviews-widget',                   // ID
                __( 'JKL Review Box', 'jkl-reviews' ),  // Name
                array(                                  // Args
                    'description'   => __( 'A widget to load review data quickly in the sidebar.', 'jkl-reviews' ),
                )
        );
        
        add_action( 'widgets_init', array( &$this, 'jkl_register_widget' ) );
        
    } // END __construct()
    
    /**
     * Registers the widget in WP
     */
    public function jkl_register_widget() {
        register_widget( 'JKL_Reviews_Widget' );
    }
    
    /**
     * Outputs the content (front-end) of the widget
     * 
     * @see WP_Widget::widget()
     * 
     * @param array $args       Widget arguments
     * @param array $instance   Saved values from database
     */
    public function widget( $args, $instance ) {
        echo $args[ 'before_widget' ];
        if ( ! empty( $instance[ 'title' ] ) ) {
            echo $args[ 'before_title' ] . apply_filters( 'widget_title', $instance[ 'title' ] ) . $args[ 'after_title' ];
        }
        echo __( 'JKL Reviews Widget! ', 'jkl-reviews' );
        echo $args[ 'after_widget' ];
    } // END widget()
    
    /**
     * Outputs the options form on admin (back-end)
     * 
     * @see WP_Widget::form()
     * 
     * @param array $instance The widget options (previously saved values from database)
     */
    public function form( $instance ) {
        $title = ! empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Widget Title', 'jkl-reviews' );
        ?>
        
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title: ' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        
        <?php
    } // END form()
    
    /**
     * Processing widget options on save (sanitization)
     * 
     * @see WP_Widget::update()
     * 
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     * 
     * @return array Updated safe values to be saved
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance[ 'title' ] = ( ! empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
        
        return $instance;
    } // END update()
    
} // END class JKL_Reviews_Widget
} // END if ( ! class_exists( 'JKL_Reviews_Widget' )