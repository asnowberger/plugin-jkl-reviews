<?php

/* 
 * ##### 7 #####
 * Add the WP Options Page here.
 */
class JKL_Review_Options {
    
    // TODO: Read this: http://codex.wordpress.org/Creating_Options_Pages PERFECT Examples
    
    protected $options;
    
    public function __construct() {
        $this->options = get_option( 'jklrv_plugin_options' );
        $this->jkl_register_settings_and_fields();
    }
    
    static public function add_menu_page() {
        // Params (name, menu name, user with access, page_id, callback function to display page contents)
        // The PHP call __FILE__ points to THIS specific file and will be sure our page_id is unique
        add_options_page( 'JKL Reviews Options', __( 'JKL Reviews Options', 'jkl-reviews/languages' ), 'administrator', __FILE__, array('JKL_Review_Options', 'jkl_display_options_page'));
    }
    
    static public function jkl_display_options_page() {
        ?>
        <div class="wrap">
            <?php // screen_icon(); // Deprecated function? No icons in any of the menus I can see ?>
            <h2><?php _e( 'JKL Reviews Options', 'jkl-reviews/languages') ?></h2>
            <?php // print_r(get_option('jklrv_plugin_options')); ?>
            <form method="post" action="options.php"> <!-- Add enctype="mutlipart/form-data" if allowing user to upload data -->
                <!-- To add inputs, use the WP Settings API: http://codex.wordpress.org/Settings_API -->
                <?php settings_fields( 'jklrv_plugin_options' ); // WP takes care of security and nonces with this function ?>
                <?php do_settings_sections( __FILE__ ); ?>
                
                <p class="submit">
                    <input name="submit" type="submit" class="button-primary" value="Save Changes" />
                </p>
            </form>
        </div>

        <?php
    }
    
    public function jkl_register_settings_and_fields() {
        
        // Note: WITHIN this function, we don't really have to prefix everything because everything is confined to THIS function and THIS class (one nice benefit of classes right?)
        
        // Doc: http://codex.wordpress.org/Function_Reference/register_setting
        register_setting( 'jklrv_plugin_options', 'jklrv_plugin_options' ); // Params (group name, name, optional callback)
    
        // Doc: http://codex.wordpress.org/Function_Reference/add_settings_section
        add_settings_section( 'jklrv_main_section', __( 'Main Settings', 'jkl-reviews/languages' ), array( $this, 'jklrv_main_section_cb' ), __FILE__ ); // Params (id, title, callback, page)
        add_settings_section( 'jklrv_cpt_section', __( 'Your Custom Content Types', 'jkl-reviews/languages'), array( $this, 'jklrv_cpt_section_cb' ), __FILE__ );
        
        // Note: You can't access methods within a class without passing an array
        add_settings_field( 'jklrv_display_disclosure', __( 'Show Material Disclosure', 'jkl-reviews/languages' ) , array( $this, 'jklrv_display_disclosure_setting'), __FILE__, 'jklrv_main_section' ); // Params (id, title, callback, page, section)
        add_settings_field( 'jklrv_display_style', __( 'Select Review Box Style', 'jkl-reviews/languages' ), array( $this, 'jklrv_display_style_setting' ), __FILE__, 'jklrv_main_section' );
        add_settings_field( 'jklrv_color_scheme', __( 'Desired Color Scheme', 'jkl-reviews/languages' ), array( $this, 'jklrv_color_scheme_setting' ), __FILE__, 'jklrv_main_section' );
        add_settings_field( 'jklrv_attribution_link', __( 'Show Attribution Link', 'jkl-reviews/languages' ), array( $this, 'jklrv_attribution_setting' ), __FILE__, 'jklrv_main_section' );
        add_settings_field( 'jklrv_cpt_option', __( 'Use JKL Reviews Post Type', 'jkl-reviews/languages' ), array( $this, 'jklrv_cpt_option_setting' ), __FILE__, 'jklrv_cpt_section' );
        
    }
    
    public function jklrv_main_section_cb() {
        // optional
    }
    public function jklrv_cpt_section_cb() {
        // optional
    }
    
    /*
     * 
     * Inputs
     * 
     */
    
    // Display Material Disclosures?
    public function jklrv_display_disclosure_setting() {
        $options = get_option( 'jklrv_plugin_options' );
        if( ! isset( $options[ 'jklrv_display_disclosure' ] ) )
            $options[ 'jklrv_display_disclosure' ] = 0;
        
        ?>
        <input type='checkbox' id='jklrv_plugin_options[jklrv_display_disclosure]' name='jklrv_plugin_options[jklrv_display_disclosure]' value='1' <?php checked( $options['jklrv_display_disclosure'], 1 ); ?> />
        <label for='jklrv_plugin_options[jklrv_display_disclosure]' class='note'>
            <?php _e( 'For US users to comply with <a href="http://www.access.gpo.gov/nara/cfr/waisidx_03/16cfr255_03.html">FTC regulations</a> regarding "Endorsements and Testimonials in Advertising."', 'jkl-reviews/languages') ?>
        </label>
       
        <?php
        if( $options[ 'jklrv_display_disclosure' ] !== 0 )
            echo "<br /><br /><div id='jkl-options-sample-disclosure' class=" . $options['jklrv_display_style'] . "><strong>Example Disclosure</strong><p><small>" . jkl_get_material_disclosure( 'affiliate' ) . "</small></p></div>";
    }
    
    // Dark or Light Scheme
    public function jklrv_display_style_setting() {
        $items = array( 'Light', 'Dark' );
        echo "<select name='jklrv_plugin_options[jklrv_display_style]'>";
        
        foreach( $items as $item ) {
            $selected = ( $this->options['jklrv_display_style'] === $item ) ? 'selected="selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }
    
    // Color Scheme
    public function jklrv_color_scheme_setting() {
        $items = array( 'Blue', 'Slate', 'Brown', 'Burgundy', 'Beige', 'Camel', 'Sand', 'Mud' );
        echo "<select name='jklrv_plugin_options[jklrv_color_scheme]'>";
        
        foreach( $items as $item ) {
            $selected = ( $this->options['jklrv_color_scheme'] === $item ) ? 'selected="selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }
    
    // Display Material Disclosures?
    public function jklrv_attribution_setting() {
        $options = get_option( 'jklrv_plugin_options' );
        if( ! isset( $options[ 'jklrv_attribution_link' ] ) )
            $options[ 'jklrv_attribution_link' ] = 1;
        
        ?>
        <input type='checkbox' id='jklrv_plugin_options[jklrv_attribution_link]' name='jklrv_plugin_options[jklrv_attribution_link]' value='1' <?php checked( $options['jklrv_attribution_link'], 1 ); ?> />
        <label for='jklrv_plugin_options[jklrv_attribution_link]' class='note'>
            <?php _e( 'Can I show a link back to the Plugin Developer\'s <a href="http://www.jekkilekki.com">website?</a> Consider <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=567MWDR76KHLU">donating before disabling.</a>', 'jkl-reviews/languages') ?>
        </label>
       
        <?php
    }
    
    // Use Custom Post Type?
    public function jklrv_cpt_option_setting() {
        $options = get_option( 'jklrv_plugin_options' );
        if( ! isset( $options[ 'jklrv_cpt_option' ] ) )
            $options[ 'jklrv_cpt_option' ] = 0;
        ?>
        <input type='checkbox' id='jklrv_plugin_options[jklrv_cpt_option]' name='jklrv_plugin_options[jklrv_cpt_option]' value='1' <?php checked( $options['jklrv_cpt_option'], 1 ); ?> />
        <label for='jklrv_plugin_options[jklrv_cpt_option]' class='note'><?php _e('Enable JKL Reviews Custom Post Type for this site. <a href="#">Learn More</a>', 'jkl-reviews/languages') ?></label>
    <?php
    
        if( isset( $options['jklrv_cpt_option'] ) )
            jklrv_enable_cpt();
    }
}

