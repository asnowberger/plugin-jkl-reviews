<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'JKL_Reviews_Settings' ) ) {
    
/** 
 * JKL Reviews Admin Settings Page
 * 
 * @author Aaron Snowberger
 * @project JKL-Reviews
 * @link http://code.tutsplus.com/tutorials/the-complete-guide-to-the-wordpress-settings-api-part-1--wp-24060
 * @link http://theme.fm/2011/10/how-to-create-tabs-with-the-settings-api-in-wordpress-2590/
 * @link TABS http://digitalraindrops.net/2011/02/tabbed-options-page/
 * 
 * @TODO currently 'General' tab doesn't show up at all
 */
    
class JKL_Reviews_Settings {

    private $version;
    
    /*
     * Holds the values to be used in the fields callbacks
     * Doc: http://codex.wordpress.org/Creating_Options_Pages PERFECT Examples
     */ 
    private $options        = array();
    
    
    private $general_settings_key = 'jkl_reviews_general_settings';
    private $style_settings_key = 'jkl_reviews_style_settings';
    private $plugin_options_key = 'jkl_reviews_plugin_options';
    private $plugins_settings_tabs = array();

    /**
     * CONSTRUCTOR !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    public function __construct() {

        // Create the Settings Page
        //$this->jkl_create_settings_page();  // ?Or add_action( 'admin_menu', array( $this, 'jkl_create_settings_page' ) );
        //$this->jkl_register_settings();     // ?Or add_action( 'admin_init', array( $this, 'jkl_register_settings' ) );

        add_action( 'init', array( &$this, 'jkl_load_settings' ) );
        add_action( 'admin_init', array( &$this, 'jkl_register_general_settings' ) );
        add_action( 'admin_init', array( &$this, 'jkl_register_style_settings' ) );
        add_action( 'admin_menu', array( &$this, 'jkl_add_menus' ) );
        
    } // END __construct()

    /**
     * METHODS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
     */
    
    /**
     * Load Settings
     */
    public function jkl_load_settings() {
        
        $this->general_settings = (array) get_option( $this->general_settings_key );
        $this->style_settings = (array) get_option( $this->style_settings_key );
        
        // Merge with defaults
        $this->general_settings = array_merge( array (
            'general_option' => 'General value'
        ), $this->general_settings );
        
        $this->style_settings = array_merge( array( 
            'style_option' => 'Style value'
        ), $this->style_settings );
        
    }
    
    /**
     * Register and add settings
     */
    public function jkl_register_general_settings() {

        $this->plugin_settings_tabs[ $this->general_settings_key ] = 'General';
        
        // Doc: http://codex.wordpress.org/Function_Reference/register_setting
        register_setting( 
                $this->general_settings_key,            // Option group name
                $this->general_settings_key,            // Option name
                array( $this, 'sanitize' )              // Sanitize callback
        );
        
        /**
         * Main Section
         */
        add_settings_section( 
                'main_section',                                     // ID
                __( 'Main Settings', 'jkl-reviews' ),               // Title
                array( $this, 'main_section_info' ),                // Callback
                $this->general_settings_key                                     // Page
        ); 
        
        /**
         * Components Section
         * Doc: http://codex.wordpress.org/Function_Reference/add_settings_section
         */
        add_settings_section(
                'components_section',                               // ID
                __( 'Components', 'jkl-reviews' ),                  // Title
                array( $this, 'component_section_info' ),           // Callback
                $this->general_settings_key                                     // Page
        );
        
                add_settings_field(
                        'add_shortcode',                            // ID
                        __( 'Enable Shortcode', 'jkl-reviews' ),    // Title
                        array( $this, 'enable_shortcode' ),         // Callback
                        $this->general_settings_key,                            // Page
                        'components_section'                        // Section
                );
        
                add_settings_field( 
                        'add_cpt', 
                        __( 'Enable Reviews Post Type', 'jkl-reviews' ), 
                        array( $this, 'enable_cpt' ), 
                        $this->general_settings_key, 
                        'components_section' 
                );
                
                add_settings_field(
                        'add_widget',
                        __( 'Enable Dynamic Widget', 'jkl-reviews' ),
                        array( $this, 'enable_widget' ),
                        $this->general_settings_key,
                        'components_section'
                );
                
                add_settings_field(
                        'add_giveaways',
                        __( 'Enable Giveaways', 'jkl-reviews' ),
                        array( $this, 'enable_giveaways' ),
                        $this->general_settings_key,
                        'components_section'
                );
                   
    }
    
    public function jkl_register_style_settings() {
        
        $this->plugins_settings_tabs[ $this->style_settings_key ] = 'Style';
        
        // Doc: http://codex.wordpress.org/Function_Reference/register_setting
        register_setting( 
                $this->style_settings_key,            // Option group name
                $this->style_settings_key,            // Option name
                array( $this, 'sanitize' )              // Sanitize callback
        );
        
        /**
         * Color and Style Settings
         */
        add_settings_section(
                'style_section',
                __( 'Plugin Style', 'jkl-reviews' ),
                array( $this, 'style_section_info' ),
                $this->style_settings_key
        );
 
                add_settings_field( 
                        'box_style',                                    
                        __( 'Select Review Box Style', 'jkl-reviews' ), 
                        array( $this, 'box_style_setting' ), 
                        $this->style_settings_key, 
                        'style_section' 
                );

                add_settings_field( 
                        'color_scheme', 
                        __( 'Desired Color Scheme', 'jkl-reviews' ), 
                        array( $this, 'color_scheme_setting' ), 
                        $this->style_settings_key, 
                        'style_section' 
                );
                
                add_settings_field(
                        'custom_css',
                        __( 'Custom CSS Rules', 'jkl-reviews' ),
                        array( $this, 'custom_css_setting' ),
                        $this->style_settings_key,
                        'style_section'
                );
                
        /**
         * Other Settings
         */
        add_settings_section(
                'other_section',
                __( 'Other Settings', 'jkl-reviews' ),
                array( $this, 'other_section_info' ),
                $this->style_settings_key
        );
                
                add_settings_field( 
                        'show_disclosure',                                  // ID
                        __( 'Show Material Disclosure', 'jkl-reviews' ),    // Title
                        array( $this, 'disclosure_setting'),                // Callback
                        $this->style_settings_key,                                    // Page
                        'other_section'                                     // Section
                );

                add_settings_field( 
                        'attribution', 
                        __( 'Show Attribution Link', 'jkl-reviews' ), 
                        array( $this, 'attribution_setting' ), 
                        $this->style_settings_key, 
                        'other_section' 
                );     
        
    }
    
        /* 
     * Admin Settings Page Add a Menu 
     */
    public function jkl_add_menus() {
       
        /**
         * Create a submenu page for THIS plugin
         */
        add_submenu_page(
                'jkl-plugins-main-menu',
                __( 'JKL Reviews Plugin Settings', 'jkl-reviews' ),
                __( 'JKL Reviews', 'jkl-reviews' ),
                'manage_options',
                $this->plugin_options_key,
                array( $this, 'jkl_create_settings_page' )
        );
       
        /**
         * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         * !!!! IMPORTANT: Only allows one instance of the JKL Plugins Menu  !!!!
         * !!!! Add AFTER add_submenu_page() to not duplicate the name       !!!!
         * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         */
        if ( empty ( $GLOBALS[ 'admin_page_hooks' ][ 'jkl-plugins-main-menu' ] ) ) {
            add_menu_page(
                    __( 'JKL Plugins', 'jkl-level-test' ),
                    __( 'JKL Plugins', 'jkl-level-test' ),
                    'manage_options',
                    'jkl-plugins-main-menu',
                    'jkl_plugins_main_page',
                    'dashicons-admin-plugins'
            );
       }

    } // END jkl_add_menu()

    /**
     * Settings Page Callback
     */
    public function jkl_create_settings_page() {

        // Get pre-existing settings
        $this->options = get_option( 'jkl_reviews_settings' );
        
        $tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $this->general_settings_key;
        ?>

        <div class="wrap">
            <?php $this->jkl_create_settings_tabs(); ?>

            <form method="post" action="options.php"> <!-- Add enctype="mutlipart/form-data" if allowing user to upload data -->
            <?php
                wp_nonce_field( 'update-options' );
                // This prints out all hidden setting fields
                settings_fields( $tab ); // WP takes care of security and nonces with this function
                do_settings_sections( $tab );
                submit_button();
            ?>
            </form>
        </div>

        <?php
    } // END jkl_create_settings_page()

    /**
     * Tabs
     */
    public function jkl_create_settings_tabs() {

        $current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : $this->general_settings_key;
        
        echo '<h2 class="nav-tab-wrapper">';
        foreach ( $this->plugins_settings_tabs as $tab_key => $tab_caption ) {
            $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
            echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
        }
        echo '</h2>';
        
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