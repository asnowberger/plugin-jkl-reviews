<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="inside hidden">
    
    <div class="jkl-reviews-types">
        <ul>
            <li>
                
            </li>
            <li>
                
            </li>
            <li>
                
            </li>
            <li>
                
            </li>
            <li>
                
            </li>
            <li>
                
            </li>
            <li>
                
            </li>
            <li>
                
            </li>
        </ul>
    </div>
    
    <!-- ##### PRODUCT LINKS TABLE -->
    <table class="jkl_review">
        <tr><th colspan="2"><?php _e( 'Product Links', 'jkl-reviews/languages' ) ?></th></tr>
        <tr class="divider"></tr>
        
        <!-- Affiliate Link -->
        <tr>
            <td class="left-label">
                <label for="jkl_affiliate_uri" class="jkl_label"><?php _e('Affiliate or Purchase Link: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_affiliate_uri" name="jkl_review_affiliate_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_affiliate_uri'] ) ) echo esc_url( $jklrv_stored_meta['jkl_review_affiliate_uri'][0] ); ?>" />
        </tr> <!-- TODO: Implement an Affiliate link Disclaimer message and checkbox option to turn it on/off. -->
        
        <!-- Product Homepage -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_product_uri" class="jkl_label"><?php _e('Link to Product Page: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_product_uri" name="jkl_review_product_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_product_uri'] ) ) echo esc_url( $jklrv_stored_meta['jkl_review_product_uri'][0] ); ?>" />
        </tr>
        
        <!-- Author Homepage -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_author_uri" class="jkl_label"><?php _e('Link to Author Homepage: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_author_uri" name="jkl_review_author_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_author_uri'] ) ) echo esc_url( $jklrv_stored_meta['jkl_review_author_uri'][0] ); ?>" />
            </td>
        </tr>       
        
        <!-- Resources Page -->
        <tr>
            <td class="left-label">
                <label for="jkl_review_resources_uri" class="jkl_label"><?php _e('Link to Resources Page: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <input type="url" id="jkl_review_resources_uri" name="jkl_review_resources_uri"
                        value="<?php if( isset( $jklrv_stored_meta['jkl_review_resources_uri'] ) ) echo esc_url( $jklrv_stored_meta['jkl_review_resources_uri'][0] ); ?>" />
            </td>
        </tr> 
        
        <?php if ( $jklrv_stored_options[ 'jklrv_display_disclosure' ] ) { // Only display the following IF Disclosure is enabled on WP Options page ?> 
        
        <tr><td colspan="2"><div class="divider-lite"></div></td></tr>
        
        <!-- Material Disclaimer Type. To comply with guidelines by the FTC (16 CFR, Part 255): http://www.access.gpo.gov/nara/cfr/waisidx_03/16cfr255_03.html -->
        <tr>
            <td class="left-label">
                <label for="jkl-disclosure-type" class="jkl_label"><?php _e('Material Disclosure: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <div class="radio">
                <label for="jkl-remove-type" id="jkl-remove-type">
                    <input type="radio" name="jkl_disclose" id="jkl-disclose-remove" value="remove" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'remove' ); ?>>
                    <span class="note"><?php _e('No Disclosure', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-no-type" id="jkl-no-type">
                    <input type="radio" name="jkl_disclose" id="jkl-disclose-none" value="none" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'none' ); ?>>
                    <span class="note"><?php _e('No Connection', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-aff-type" id="jkl-aff-type">
                    <input type="radio" name="jkl_disclose" id="jkl-disclose-aff" value="affiliate" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'affiliate' ); ?>>
                    <span class="note"><?php _e('Affiliate Link', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-sample-type" id="jkl-sample-type">
                    <input type="radio" name="jkl_disclose" id="jkl-disclose-sample" value="sample" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'sample' ); ?>>
                    <span class="note"><?php _e('Review or Sample', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-sponsored-type" id="jkl-sponsored-type">
                    <input type="radio" name="jkl_disclose" id="jkl-disclose-sponsor" value="sponsored" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'sponsored' ); ?>>
                    <span class="note"><?php _e('Sponsored Post', 'jkl-reviews/languages')?></span>
                </label>
                </div>
                <div class="radio">
                <label for="jkl-shareholder-type" id="jkl-shareholder-type">
                    <input type="radio" name="jkl_disclose" id="jkl-disclose-shareholder" value="shareholder" <?php if ( isset( $jklrv_stored_meta['jkl_disclose'] ) ) checked( $jklrv_stored_meta['jkl_disclose'][0], 'shareholder' ); ?>>
                    <span class="note"><?php _e('Employee/Shareholder', 'jkl-reviews/languages')?></span>
                </label>
                </div>
            </td>
        </tr>
        
        <?php if (isset( $jklrv_stored_meta['jkl_disclose'][0] ) && !checked( $jklrv_stored_meta['jkl_disclose'][0], 'remove' ) ) { ?>
        <tr><td colspan="2"><div class="divider-lite"></div></td></tr>
        
        <tr>
            <td class="left-label">
                <label for="jkl-disclosure-preview" class="jkl_label"><?php _e('Disclosure Preview: ', 'jkl-reviews/languages')?></label>
            </td>
            <td>
                <small class="note"><?php echo wp_kses_post( jkl_get_material_disclosure( $jklrv_stored_meta['jkl_disclose'][0] ) ); ?></small>
            </td>
        </tr>
        <?php 
        
            } // End Disclosure Type check
        } // End Show Material Disclosure from WP Options page check 
            
        ?>
        
    </table>
</div>