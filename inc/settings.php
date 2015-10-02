<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Reviews_Settings' ) ) {
    
/** 
 * JKL Reviews Admin Settings Page
 * 
 * @author Aaron Snowberger
 * @project JKL-Reviews
 */
    
class JKL_Reviews_Settings {

    /*
     * Holds the values to be used in the fields callbacks
     * Doc: http://codex.wordpress.org/Creating_Options_Pages PERFECT Examples
     */ 
    private $options;

    /**
     * CONSTRUCTOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    public function __construct() {

        // Create the Settings Page
        $this->jkl_create_settings_page();  // ?Or add_action( 'admin_menu', array( $this, 'jkl_create_settings_page' ) );
        $this->jkl_register_settings();     // ?Or add_action( 'admin_init', array( $this, 'jkl_register_settings' ) );

        //add_action( 'admin_menu', array( &$this, 'jkl_add_menu' ) );
        //add_action( 'admin_init', array( &$this, 'jkl_register_settings' ) );
        
    }

    /**
     * METHODS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    
    /* 
    * Admin Settings Page Add a Menu 
    */
   public function jkl_add_menu() {

       // This page wil be under "Settings"
       add_options_page( 
               'JKL Reviews Settings', 
               __( 'JKL Reviews Settings', 'jkl-reviews' ), 
               'manage_options', 
               'jkl_reviews_settings', 
               array( $this, 'jkl_plugin_settings_page' ) 
       );

   } // END admin_menu

    /**
     * Settings Page Callback
     */
    public function jkl_create_settings_page() {

        // Get pre-existing settings
        $this->options = get_option( 'jkl_reviews_settings' );
        ?>

        <div class="wrap">

            <h2><?php _e( 'JKL Reviews Settings', 'jkl-reviews') ?></h2>
            <form method="post" action="options.php"> <!-- Add enctype="mutlipart/form-data" if allowing user to upload data -->
            <?php    
                // This prints out all hidden setting fields
                settings_fields( 'main-settings-group' ); // WP takes care of security and nonces with this function
                do_settings_sections( 'main-settings' );
                submit_button();
            ?>
            </form>
        </div>

        <?php
    }

    /**
     * Register and add settings
     */
    public function jkl_register_settings() {

        // Doc: http://codex.wordpress.org/Function_Reference/register_setting
        register_setting( 
                'main-settings-group',          // Option group name
                'jkl_reviews_settings',         // Option name
                array( $this, 'sanitize' )      // Sanitize callback
        );

        // Doc: http://codex.wordpress.org/Function_Reference/add_settings_section
        add_settings_section( 
                'main_section',                                     // ID
                __( 'Main Settings', 'jkl-reviews' ),               // Title
                array( $this, 'main_section_info' ),                // Callback
                'main-settings'                                     // Page
        ); 

                // add_settings_section( 'jklrv_cpt_section', __( 'Your Custom Content Types', 'jkl-reviews/languages'), array( $this, 'jklrv_cpt_section_cb' ), __FILE__ );

                add_settings_field( 
                        'show_disclosure',                                  // ID
                        __( 'Show Material Disclosure', 'jkl-reviews' ),    // Title
                        array( $this, 'disclosure_setting'),                // Callback
                        'main-settings',                                    // Page
                        'main_section'                                      // Section
                );

                add_settings_field( 
                        'box_style', 
                        __( 'Select Review Box Style', 'jkl-reviews' ), 
                        array( $this, 'box_style_setting' ), 
                        'main-settings', 
                        'main_section' 
                );

                add_settings_field( 
                        'color_scheme', 
                        __( 'Desired Color Scheme', 'jkl-reviews' ), 
                        array( $this, 'color_scheme_setting' ), 
                        'main-settings', 
                        'main_section' 
                );

                // add_settings_field( 'jklrv_cpt_option', __( 'Use JKL Reviews Post Type', 'jkl-reviews/languages' ), array( $this, 'jklrv_cpt_option_setting' ), __FILE__, 'jklrv_cpt_section' );

    }

    /**
     * Sanitize each setting field as needed
     * 
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ) {

        $new_input = array();
        if( isset( $input[ 'title' ] ) )
            $new_input[ 'title' ] = sanitize_text_field( $input[ 'title' ] );

        if( isset( $input[ 'author' ] ) )
            $new_input[ 'author' ] = sanitize_text_field( $input[ 'author' ] );

        if( isset( $input[ 'series' ] ) )
            $new_input[ 'series' ] = sanitize_text_field( $input[ 'series' ] );

        if( isset( $input[ 'category' ] ) )
            $new_input[ 'category' ] = sanitize_text_field( $input[ 'category' ] );

        return $new_input;
    }

    /**
     * Inputs !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */

    /**
     * Print Main Section Text
     */
    public function main_section_info() {
        printf( 'Enter your settings below:' );
    }

    /**
     * Display Disclosure Settings
     */
    public function disclosure_setting() {
        $options = get_option( 'jkl_reviews_settings' );
        ?>
        <input type='checkbox' id='jkl_reviews_settings[ disclosure ]' name='jkl_reviews_settings[ disclosure ]' value='1' <?php checked( $options[ 'disclosure' ], 1 ); ?> />
        <label for='jkl_reviews_settings[ disclosure ]' class='note'>
            <?php _e( 'For US users to comply with <a href="http://www.access.gpo.gov/nara/cfr/waisidx_03/16cfr255_03.html">FTC regulations</a> regarding "Endorsements and Testimonials in Advertising."', 'jkl-reviews') ?>
        </label>

        <?php
        if( isset( $options[ 'disclosure' ] ) ) {
            $output = "<br /></br>";
            $output .= "<div id='jkl-options-sample-disclosure' class=" . $options[ 'box_style' ] . ">";
            $output .= "<strong>Example Disclosure</strong>";
            $output .= "<p><small>" . get_material_disclosure( 'affiliate' ) . "</small></p>";
            $output .= "</div>";

            echo $output;
        }
    }

    /**
     * Display Box Style Settings
     */
    public function box_style_setting() {
        $items = array( 'Light', 'Dark' );
        echo "<select name='jkl_reviews_settings[ box_style ]'>";

        foreach( $items as $item ) {
            $selected = ( $this->options[ 'box_style' ] === $item ) ? 'selected="selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }

    /**
     * Display Color Scheme Settings
     */
    public function color_scheme_setting() {
        $items = array( 'Blue', 'Slate', 'Brown', 'Burgundy', 'Beige', 'Camel', 'Sand', 'Mud' );
        echo "<select name='jkl_reviews_settings[ color_scheme ]'>";

        foreach( $items as $item ) {
            $selected = ( $this->options[ 'color_scheme' ] === $item ) ? 'selected="selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }

    // Use Custom Post Type?
    public function jklrv_cpt_option_setting() {
        $options = get_option( 'jklrv_plugin_options' );
        ?>
        <input type='checkbox' id='jklrv_plugin_options[jklrv_cpt_option]' name='jklrv_plugin_options[jklrv_cpt_option]' value='1' <?php checked( $options['jklrv_cpt_option'], 1 ); ?> />
        <label for='jklrv_plugin_options[jklrv_cpt_option]' class='note'><?php _e('Enable JKL Reviews Custom Post Type for this site. <a href="#">Learn More</a>', 'jkl-reviews/languages') ?></label>
    <?php
    }
}
    
}