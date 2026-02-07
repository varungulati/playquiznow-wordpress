<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PlayQuizNow_Settings {

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'add_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	public static function add_menu() {
		add_options_page(
			__( 'PlayQuizNow Settings', 'playquiznow' ),
			__( 'PlayQuizNow', 'playquiznow' ),
			'manage_options',
			'playquiznow',
			array( __CLASS__, 'render_page' )
		);
	}

	public static function register_settings() {
		register_setting( 'playquiznow_settings', 'playquiznow_default_width', array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '100%',
		) );
		register_setting( 'playquiznow_settings', 'playquiznow_default_height', array(
			'type'              => 'integer',
			'sanitize_callback' => array( __CLASS__, 'sanitize_height' ),
			'default'           => 500,
		) );
		register_setting( 'playquiznow_settings', 'playquiznow_show_branding', array(
			'type'              => 'string',
			'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
			'default'           => '1',
		) );
		register_setting( 'playquiznow_settings', 'playquiznow_lazy_load', array(
			'type'              => 'string',
			'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
			'default'           => '1',
		) );

		add_settings_section(
			'playquiznow_defaults',
			__( 'Default Embed Settings', 'playquiznow' ),
			null,
			'playquiznow'
		);

		add_settings_field( 'playquiznow_default_width', __( 'Default Width', 'playquiznow' ), array( __CLASS__, 'field_width' ), 'playquiznow', 'playquiznow_defaults' );
		add_settings_field( 'playquiznow_default_height', __( 'Default Height (px)', 'playquiznow' ), array( __CLASS__, 'field_height' ), 'playquiznow', 'playquiznow_defaults' );
		add_settings_field( 'playquiznow_show_branding', __( 'Show Branding', 'playquiznow' ), array( __CLASS__, 'field_branding' ), 'playquiznow', 'playquiznow_defaults' );
		add_settings_field( 'playquiznow_lazy_load', __( 'Lazy Load', 'playquiznow' ), array( __CLASS__, 'field_lazy_load' ), 'playquiznow', 'playquiznow_defaults' );
	}

	public static function sanitize_checkbox( $value ) {
		return $value ? '1' : '';
	}

	public static function sanitize_height( $value ) {
		return max( 100, intval( $value ) );
	}

	public static function field_width() {
		$value = get_option( 'playquiznow_default_width', '100%' );
		echo '<input type="text" name="playquiznow_default_width" value="' . esc_attr( $value ) . '" class="regular-text" />';
		echo '<p class="description">' . esc_html__( 'CSS value, e.g. "100%", "600px", "80vw".', 'playquiznow' ) . '</p>';
	}

	public static function field_height() {
		$value = get_option( 'playquiznow_default_height', 500 );
		echo '<input type="number" name="playquiznow_default_height" value="' . esc_attr( $value ) . '" min="100" step="1" class="small-text" /> px';
	}

	public static function field_branding() {
		$checked = get_option( 'playquiznow_show_branding', '1' );
		echo '<label><input type="checkbox" name="playquiznow_show_branding" value="1" ' . checked( $checked, '1', false ) . ' /> ';
		echo esc_html__( 'Display "Powered by PlayQuizNow" link below the quiz.', 'playquiznow' ) . '</label>';
	}

	public static function field_lazy_load() {
		$checked = get_option( 'playquiznow_lazy_load', '1' );
		echo '<label><input type="checkbox" name="playquiznow_lazy_load" value="1" ' . checked( $checked, '1', false ) . ' /> ';
		echo esc_html__( 'Load iframes lazily for better page performance.', 'playquiznow' ) . '</label>';
	}

	public static function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		wp_enqueue_style( 'playquiznow-admin', PLAYQUIZNOW_PLUGIN_URL . 'assets/css/admin.css', array(), PLAYQUIZNOW_VERSION );
		?>
		<div class="wrap playquiznow-settings">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

			<div class="playquiznow-quickstart">
				<h2><?php esc_html_e( 'Quick Start', 'playquiznow' ); ?></h2>
				<p><?php esc_html_e( 'Use the shortcode below to embed a quiz on any page or post:', 'playquiznow' ); ?></p>
				<code>[playquiznow id="your-quiz-id"]</code>
				<p><?php esc_html_e( 'Or use the PlayQuizNow block in the Gutenberg editor.', 'playquiznow' ); ?></p>
			</div>

			<form action="options.php" method="post">
				<?php
				settings_fields( 'playquiznow_settings' );
				do_settings_sections( 'playquiznow' );
				submit_button();
				?>
			</form>

			<div class="playquiznow-reference">
				<h2><?php esc_html_e( 'Shortcode Parameters', 'playquiznow' ); ?></h2>
				<table class="widefat fixed striped">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Parameter', 'playquiznow' ); ?></th>
							<th><?php esc_html_e( 'Default', 'playquiznow' ); ?></th>
							<th><?php esc_html_e( 'Description', 'playquiznow' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><code>id</code></td>
							<td>&mdash;</td>
							<td><?php esc_html_e( 'Required. The quiz ID from your PlayQuizNow dashboard.', 'playquiznow' ); ?></td>
						</tr>
						<tr>
							<td><code>width</code></td>
							<td><code>100%</code></td>
							<td><?php esc_html_e( 'Width of the embed container (any CSS value).', 'playquiznow' ); ?></td>
						</tr>
						<tr>
							<td><code>height</code></td>
							<td><code>500</code></td>
							<td><?php esc_html_e( 'Initial height in pixels. Auto-resizes via postMessage.', 'playquiznow' ); ?></td>
						</tr>
						<tr>
							<td><code>theme</code></td>
							<td><code>light</code></td>
							<td><?php esc_html_e( 'Theme: "light" or "dark".', 'playquiznow' ); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	}
}

PlayQuizNow_Settings::init();
