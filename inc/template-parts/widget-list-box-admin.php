<?php

?> 

<!-- Widget title -->
<p>
    <label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php _e( 'Widget Title:', 'jkl-reviews' ); ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'widget_title' ); ?>"
           name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php echo $instance[ 'widget_title' ]; ?>" />
</p>

<!-- Number of items to display -->
<p>
    <label for="<?php echo $this->get_field_id( 'review_num' ); ?>"><?php _e( 'Number of reviews to display:', 'jkl-reviews' ); ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'review_num' ); ?>"
           name="<?php echo $this->get_field_name( 'review_num' ); ?>" value="<?php echo $instance[ 'review_num' ]; ?>" />
</p>

<!-- Review Type selector -->
<p>
    <label for="<?php echo $this->get_field_id( 'review_type' ); ?>"><?php _e( 'Review Type:', 'jkl-reviews' ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'review_type' ); ?>" name="<?php echo $this->get_field_id( 'review_type' ); ?>">
        <option <?php selected( $instance[ 'review_type' ], 'all' ); ?> value="all">All Review Types</option>
        <?php foreach( get_terms( 'review_type', 'parent=0&hide_empty=0' ) as $term ) { // TODO CATEGORY or TAXONOMY name in there?> 
            <option <?php selected( $instance[ 'review_type' ], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
        <?php } ?>
    </select>
</p>

<!-- List Box Type selector -->
<p>
    <!-- <input type='checkbox' id='jklrv_plugin_options[jklrv_display_disclosure]' name='jklrv_plugin_options[jklrv_display_disclosure]' value='1' <?php checked( $options['jklrv_display_disclosure'], 1 ); ?> /> -->
    <input type="checkbox" id="<?php echo $this->get_field_id( 'latest' ); ?>" name="<?php echo $this->get_field_id( 'latest' ); ?>" value="<?php echo $instance[ 'latest' ]; ?>" <?php checked( $instance[ 'latest' ], 0 ); ?> />
    <label for="<?php echo $this->get_field_id( 'latest' ); ?>"><?php _e( 'Latest Reviews', 'jkl-reviews' ); ?></label>
    <input type="checkbox" id="<?php echo $this->get_field_id( 'top' ); ?>" name="<?php echo $this->get_field_id( 'top' ); ?>" value="<?php echo $instance[ 'top' ]; ?>" <?php checked( $instance[ 'top' ], 0 ); ?> />
    <label for="<?php echo $this->get_field_id( 'top' ); ?>"><?php _e( 'Top Reviews', 'jkl-reviews' ); ?></label>
</p>

<?php