<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PlayQuizNow_Gutenberg_Block {

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_block' ) );
	}

	public static function register_block() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		wp_register_script(
			'playquiznow-block',
			PLAYQUIZNOW_PLUGIN_URL . 'assets/js/block.js',
			array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n' ),
			PLAYQUIZNOW_VERSION,
			false
		);

		wp_set_script_translations( 'playquiznow-block', 'playquiznow', PLAYQUIZNOW_PLUGIN_DIR . 'languages' );

		wp_register_style(
			'playquiznow-block-editor',
			PLAYQUIZNOW_PLUGIN_URL . 'assets/css/admin.css',
			array( 'wp-edit-blocks' ),
			PLAYQUIZNOW_VERSION
		);

		register_block_type( 'playquiznow/quiz', array(
			'editor_script'   => 'playquiznow-block',
			'editor_style'    => 'playquiznow-block-editor',
			'render_callback' => array( __CLASS__, 'render' ),
			'attributes'      => array(
				'quizId' => array(
					'type'    => 'string',
					'default' => '',
				),
				'width' => array(
					'type'    => 'string',
					'default' => '100%',
				),
				'height' => array(
					'type'    => 'number',
					'default' => 500,
				),
				'theme' => array(
					'type'    => 'string',
					'default' => 'light',
				),
			),
		) );
	}

	public static function render( $attributes ) {
		return PlayQuizNow::render_quiz( array(
			'id'     => isset( $attributes['quizId'] ) ? $attributes['quizId'] : '',
			'width'  => isset( $attributes['width'] ) ? $attributes['width'] : '100%',
			'height' => isset( $attributes['height'] ) ? $attributes['height'] : 500,
			'theme'  => isset( $attributes['theme'] ) ? $attributes['theme'] : 'light',
		) );
	}
}

PlayQuizNow_Gutenberg_Block::init();
