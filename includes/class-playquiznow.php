<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PlayQuizNow {

	/**
	 * Validate a CSS width value against allowed patterns.
	 *
	 * @param string $width The width value to validate.
	 * @return string Sanitized width or '100%' as fallback.
	 */
	private static function sanitize_css_width( $width ) {
		$width = trim( $width );
		if ( preg_match( '/^\d+(\.\d+)?(px|%|em|rem|vw|vh)$/', $width ) ) {
			return $width;
		}
		return '100%';
	}

	/**
	 * Validate a quiz ID against allowed characters.
	 *
	 * @param string $id Raw quiz ID.
	 * @return string Sanitized quiz ID or empty string.
	 */
	private static function sanitize_quiz_id( $id ) {
		$id = sanitize_text_field( $id );
		if ( preg_match( '/^[a-zA-Z0-9_-]+$/', $id ) ) {
			return $id;
		}
		return '';
	}

	/**
	 * Render a quiz embed iframe.
	 *
	 * @param array $atts Shortcode/block attributes.
	 * @return string HTML output.
	 */
	public static function render_quiz( $atts ) {
		$defaults = array(
			'id'     => '',
			'width'  => get_option( 'playquiznow_default_width', '100%' ),
			'height' => get_option( 'playquiznow_default_height', 500 ),
			'theme'  => 'light',
		);

		$atts = shortcode_atts( $defaults, $atts, 'playquiznow' );

		$quiz_id = self::sanitize_quiz_id( $atts['id'] );

		if ( empty( $quiz_id ) ) {
			if ( current_user_can( 'edit_posts' ) ) {
				return '<p style="color:#dc2626;font-weight:600;">'
					. esc_html__( 'PlayQuizNow: Please provide a valid quiz ID (letters, numbers, hyphens, underscores).', 'playquiznow' )
					. '</p>';
			}
			return '';
		}

		$width  = self::sanitize_css_width( $atts['width'] );
		$height = max( 100, intval( $atts['height'] ) );
		$theme  = in_array( $atts['theme'], array( 'light', 'dark' ), true ) ? $atts['theme'] : 'light';

		$embed_url = esc_url( PLAYQUIZNOW_EMBED_BASE . $quiz_id . '?theme=' . $theme . '&source=wordpress' );

		$loading_attr = get_option( 'playquiznow_lazy_load', '1' ) === '1' ? ' loading="lazy"' : '';

		self::enqueue_frontend_assets();

		$iframe_title = esc_attr(
			/* translators: %s: quiz ID */
			sprintf( __( 'PlayQuizNow Quiz: %s', 'playquiznow' ), $quiz_id )
		);

		$html  = '<div class="playquiznow-container" style="width:' . esc_attr( $width ) . ';max-width:100%;">';
		$html .= '<iframe';
		$html .= ' src="' . $embed_url . '"';
		$html .= ' title="' . $iframe_title . '"';
		$html .= ' width="100%"';
		$html .= ' height="' . esc_attr( $height ) . '"';
		$html .= ' frameborder="0"';
		$html .= ' scrolling="no"';
		$html .= ' allow="clipboard-write"';
		$html .= ' sandbox="allow-scripts allow-same-origin allow-popups allow-forms"';
		$html .= $loading_attr;
		$html .= ' class="playquiznow-iframe"';
		$html .= ' data-quiz-id="' . esc_attr( $quiz_id ) . '"';
		$html .= '></iframe>';

		$html .= '</div>';

		return $html;
	}

	/**
	 * Enqueue frontend CSS and JS only when a quiz is rendered.
	 */
	private static function enqueue_frontend_assets() {
		if ( ! wp_script_is( 'playquiznow-frontend', 'enqueued' ) ) {
			wp_enqueue_style(
				'playquiznow-frontend',
				PLAYQUIZNOW_PLUGIN_URL . 'assets/css/frontend.css',
				array(),
				PLAYQUIZNOW_VERSION
			);
			wp_enqueue_script(
				'playquiznow-frontend',
				PLAYQUIZNOW_PLUGIN_URL . 'assets/js/frontend.js',
				array(),
				PLAYQUIZNOW_VERSION,
				true
			);
		}
	}
}
