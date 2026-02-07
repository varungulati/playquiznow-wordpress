<?php
/**
 * Plugin Name: PlayQuizNow
 * Plugin URI:  https://playquiznow.com/wordpress-plugin
 * Description: Embed interactive quizzes from PlayQuizNow into your WordPress site with a shortcode or Gutenberg block.
 * Version:     1.0.0
 * Author:      PlayQuizNow
 * Author URI:  https://playquiznow.com
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: playquiznow
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'PLAYQUIZNOW_VERSION' ) ) {
	return;
}

define( 'PLAYQUIZNOW_VERSION', '1.0.0' );
define( 'PLAYQUIZNOW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLAYQUIZNOW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PLAYQUIZNOW_EMBED_BASE', 'https://playquiznow.com/embed/' );

require_once PLAYQUIZNOW_PLUGIN_DIR . 'includes/class-playquiznow.php';
require_once PLAYQUIZNOW_PLUGIN_DIR . 'includes/class-shortcode.php';
require_once PLAYQUIZNOW_PLUGIN_DIR . 'includes/class-gutenberg-block.php';
require_once PLAYQUIZNOW_PLUGIN_DIR . 'includes/class-settings.php';

add_action( 'init', 'playquiznow_load_textdomain' );

function playquiznow_load_textdomain() {
	load_plugin_textdomain( 'playquiznow', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

register_activation_hook( __FILE__, 'playquiznow_activate' );

function playquiznow_activate() {
	add_option( 'playquiznow_default_width', '100%' );
	add_option( 'playquiznow_default_height', '500' );
	add_option( 'playquiznow_show_branding', '1' );
	add_option( 'playquiznow_lazy_load', '1' );
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'playquiznow_settings_link' );

function playquiznow_settings_link( $links ) {
	$settings_link = '<a href="' . esc_url( admin_url( 'options-general.php?page=playquiznow' ) ) . '">'
		. esc_html__( 'Settings', 'playquiznow' ) . '</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
