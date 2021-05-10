<?php

if ( ! defined( 'ABSPATH' ) ) { //if file called directly
	exit;
}

if ( ! class_exists( 'Primary_Category_Shortcode' ) ) { //if class already not existed then create
	class Primary_Category_Shortcode {
		public static function init() {
			add_shortcode( 'primary_category', array( __CLASS__, 'shortcode' ) ); // created shortcode primary_category
		}

		public static function shortcode( $atts ) {
			$atts = shortcode_atts( array(
				'taxonomy' => '',
				'post-id'     => '',
				'output'   => 'link',
			), $atts, 'primary_category' );
			//grab the paramaters and output
			return the_primary_category( $atts['taxonomy'], $atts['post-id'], $atts['output'], false );
		}
	}
}
