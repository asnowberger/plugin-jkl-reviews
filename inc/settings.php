<?php

/* 
 * Settings
 */
?>

<div class="wrap">
    <h2>JKL Reviews Settings</h2>
    <form method="post" action="settings.php">
        <?php @settings_fields( 'jkl_reviews_settings' ); ?>
        <?php @do_settings_fields( 'jkl_reviews_settings' ); ?>
        
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="jkl_reviews_setting_a">Setting A</label>
                </th>
                <td>
                    <input type="text" name="jkl_setting_a" id="jkl_setting_a" value="<?php echo get_option( 'jkl_setting_a' ); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="jkl_reviews_setting_b">Setting B</label>
                </th>
                <td>
                    <input type="text" name="jkl_setting_b" id="jkl_setting_b" value="<?php echo get_option( 'jkl_setting_b' ); ?>" />
                </td>
            </tr>
        </table>
        
        <?php @submit_button(); ?>
    </form>
</div>

