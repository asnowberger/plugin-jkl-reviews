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
        //$this->jkl_create_settings_page();  // ?Or add_action( 'admin_menu', array( $this, 'jkl_create_settings_page' ) );
        //$this->jkl_register_settings();     // ?Or add_action( 'admin_init', array( $this, 'jkl_register_settings' ) );

        add_action( 'admin_menu', array( &$this, 'jkl_add_menu' ) );
        add_action( 'admin_init', array( &$this, 'jkl_register_settings' ) );
        
    } // END __construct()

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
               array( $this, 'jkl_create_settings_page' ) 
       );

   } // END jkl_add_menu()

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
    } // END jkl_create_settings_page()

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
        
        /**
         * Main Section
         */
        add_settings_section( 
                'main_section',                                     // ID
                __( 'Main Settings', 'jkl-reviews' ),               // Title
                array( $this, 'main_section_info' ),                // Callback
                'main-settings'                                     // Page
        ); 
        
        /**
         * Components Section
         * Doc: http://codex.wordpress.org/Function_Reference/add_settings_section
         */
        add_settings_section(
                'components_section',                               // ID
                __( 'Components', 'jkl-reviews' ),                  // Title
                array( $this, 'component_section_info' ),           // Callback
                'main-settings'                                     // Page
        );
        
                add_settings_field(
                        'add_shortcode',                            // ID
                        __( 'Enable Shortcode', 'jkl-reviews' ),    // Title
                        array( $this, 'enable_shortcode' ),         // Callback
                        'main-settings',                            // Page
                        'components_section'                        // Section
                );
        
                add_settings_field( 
                        'add_cpt', 
                        __( 'Enable Reviews Post Type', 'jkl-reviews' ), 
                        array( $this, 'enable_cpt' ), 
                        'main-settings', 
                        'components_section' 
                );
                
                add_settings_field(
                        'add_widget',
                        __( 'Enable Dynamic Widget', 'jkl-reviews' ),
                        array( $this, 'enable_widget' ),
                        'main-settings',
                        'components_section'
                );
                
                add_settings_field(
                        'add_giveaways',
                        __( 'Enable Giveaways', 'jkl-reviews' ),
                        array( $this, 'enable_giveaways' ),
                        'main-settings',
                        'components_section'
                );
        
        /**
         * Color and Style Settings
         */
        add_settings_section(
                'style_section',
                __( 'Plugin Style', 'jkl-reviews' ),
                array( $this, 'style_section_info' ),
                'main-settings'
        );
 
                add_settings_field( 
                        'box_style',                                    
                        __( 'Select Review Box Style', 'jkl-reviews' ), 
                        array( $this, 'box_style_setting' ), 
                        'main-settings', 
                        'style_section' 
                );

                add_settings_field( 
                        'color_scheme', 
                        __( 'Desired Color Scheme', 'jkl-reviews' ), 
                        array( $this, 'color_scheme_setting' ), 
                        'main-settings', 
                        'style_section' 
                );
                
                add_settings_field(
                        'custom_css',
                        __( 'Custom CSS Rules', 'jkl-reviews' ),
                        array( $this, 'custom_css_setting' ),
                        'main-settings',
                        'style_section'
                );
                
        /**
         * Other Settings
         */
        add_settings_section(
                'other_section',
                __( 'Other Settings', 'jkl-reviews' ),
                array( $this, 'other_section_info' ),
                'main-settings'
        );
                
                add_settings_field( 
                        'show_disclosure',                                  // ID
                        __( 'Show Material Disclosure', 'jkl-reviews' ),    // Title
                        array( $this, 'disclosure_setting'),                // Callback
                        'main-settings',                                    // Page
                        'other_section'                                     // Section
                );

                add_settings_field( 
                        'attribution', 
                        __( 'Show Attribution Link', 'jkl-reviews' ), 
                        array( $this, 'attribution_setting' ), 
                        'main-settings', 
                        'other_section' 
                );     
        
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
     * MAIN SECTION !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    
    // Print Main Section Text
    public function main_section_info() {
        echo '<p>Enter your settings below:</p>';
    }
    
    /**
     * COMPONENTS SECTION !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    
    // Print Components Section Text
    public function component_section_info() {
        echo '<p>Which plugin components would you like to enable?</p>';
    }
    
    /**
     * Enable Shortcode
     */
    public function enable_shortcode() {
        
        $options = get_option( 'jkl_reviews_settings' );
        ?>
        <input type='checkbox' id='jkl_reviews_settings[use_shortcode]' name='jkl_reviews_settings[use_shortcode]' value='1' <?php checked( $options['use_shortcode'], 1 ); ?> />
        <label for='jkl_reviews_settings[use_shortcode]' class='note'><?php _e('Enable Shortcode to place a Reviews box anywhere within your Post content.'
                . '<br><a href="#">Learn More</a>', 'jkl-reviews') ?></label>
    
    <?php
    }
    
    /**
     * Enable Reviews Post Type
     */
    public function enable_cpt() {
        
        $options = get_option( 'jkl_reviews_settings' );
        ?>
        <input type='checkbox' id='jkl_reviews_settings[use_cpt]' name='jkl_reviews_settings[use_cpt]' value='1' <?php checked( $options['use_cpt'], 1 ); ?> />
        <label for='jkl_reviews_settings[use_cpt]' class='note'><?php _e('Enable JKL Reviews Custom Post Type for this site.'
                . '<br><a href="#">Learn More</a>', 'jkl-reviews') ?></label>
    
    <?php
    }
    
    /**
     * Enable Dynamic Sidebar Widget
     */
    public function enable_widget() {
        
        $options = get_option( 'jkl_reviews_settings' );
        ?>
        <input type='checkbox' id='jkl_reviews_settings[use_widget]' name='jkl_reviews_settings[use_widget]' value='1' <?php checked( $options['use_widget'], 1 ); ?> />
        <label for='jkl_reviews_settings[use_widget]' class='note'><?php _e('Enable Dynamic Sidebar to load review data when you click a Cover Image.'
                . '<br><a href="#">Learn More</a>', 'jkl-reviews') ?></label>
    
    <?php
    }
    
    /**
     * Enable Giveaways
     */
    public function enable_giveaways() {
        
        $options = get_option( 'jkl_reviews_settings' );
        ?>
        <input type='checkbox' id='jkl_reviews_settings[use_giveaways]' name='jkl_reviews_settings[use_giveaways]' value='1' <?php checked( $options['use_giveaways'], 1 ); ?> />
        <label for='jkl_reviews_settings[use_giveaways]' class='note'><?php _e('Enable Product Giveaways for this site.'
                . '<br><a href="#">Learn More</a>', 'jkl-reviews') ?></label>
    
    <?php
    }
    
    /**
     * STYLE SECTION !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    
    // Print Style Section Text
    public function style_section_info() {
        echo '<p>Style your plugin below:</p>';
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
    
    /**
     * Custom CSS Rules Textarea
     */
    public function custom_css_setting() {
        $options = get_option( 'jkl_reviews_settings' );
        ?>
        <textarea id='jkl_reviews_settings[ custom_css ]' name='jkl_reviews_settings[ custom_css ]' value="jkl_reviews_settings[ custom_css ]">
            
        </textarea>
    <?php
    }
    
    /**
     * OTHER SECTION !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    
    // Print Other Section Text
    public function other_section_info() {
        echo '<p>The following section deals with attribution and disclosure of materials.</p>';
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
     * Show Attribution Link?
     */
    public function attribution_setting() {
        $options = get_option( 'jkl_review_settings' );
        if( ! isset( $options[ 'attribution' ] ) )
            $options[ 'attribution' ] = 1;

        ?>
        <input type='checkbox' id='jkl_review_settings[ attribution ]' name='jkl_review_settings[ attribution ]' value='1' <?php checked( $options[ 'attribution' ], 1 ); ?> />
        <label for='jkl_review_settings[ attribution ]' class='note'>
            <?php _e( 'Allow Plugin to link to the <a href="http://www.jekkilekki.com">developer\'s website?</a>'
                    . '<br>Consider <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=567MWDR76KHLU">donating before disabling.</a>', 'jkl-reviews') ?>
        </label>

        <?php
    }
    
} // END class JKL_Reviews_Settings   
} // END if ( ! class_exists( 'JKL_Reviews_Settings' ) )