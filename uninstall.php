<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'playquiznow_default_width' );
delete_option( 'playquiznow_default_height' );
delete_option( 'playquiznow_show_branding' );
delete_option( 'playquiznow_lazy_load' );
