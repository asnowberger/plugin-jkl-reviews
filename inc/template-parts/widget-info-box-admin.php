<?php

?>

<!-- Widget title -->
<p>
    <label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php _e( 'Widget Title:', 'jkl-reviews' ); ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'widget_title' ); ?>"
           name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php echo $instance[ 'widget_title' ]; ?>" />
</p>

<!-- Display type selector -->
<p>
    <label for="<?php echo $this->get_field_id( 'display_info' ); ?>"><?php _e( 'Display:', 'jkl-reviews' ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'display_info' ); ?>" name="<?php echo $this->get_field_id( 'display_info' ); ?>">
        <option <?php selected( $instance[ 'display_info' ], 'all' ); ?> value="all">All Review Info</option>
        <option <?php selected( $instance[ 'display_info' ], 'info' ); ?> value="info">Product Info Only</option>
        <option <?php selected( $instance[ 'display_info' ], 'details' ); ?> value="details">Details Only</option>
    </select>
</p>

<?php