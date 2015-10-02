<?php
/**
 * JKL Reviews Uninstall
 */

// If uninstall not called from WordPress exit 
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit ();

// Delete option from options table 
delete_option( 'jkl_reviews_settings' );

//remove additional options and custom tables