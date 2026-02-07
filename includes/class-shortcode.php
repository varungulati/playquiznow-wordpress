<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PlayQuizNow_Shortcode {

	public static function init() {
		add_shortcode( 'playquiznow', array( __CLASS__, 'handle' ) );
	}

	public static function handle( $atts ) {
		return PlayQuizNow::render_quiz( $atts );
	}
}

PlayQuizNow_Shortcode::init();
