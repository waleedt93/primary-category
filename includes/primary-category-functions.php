<?php

if ( ! defined( 'ABSPATH' ) ) { //if file called directly
	exit;
}

if ( ! function_exists( 'the_primary_category' ) ) { //if function isn't alreay declared
	function the_primary_category( $taxonomy, $post_id = null, $output = 'link', $echo = true ) {
		$taxonomy = sanitize_key( $taxonomy );

		if ( ! $post_id || empty( $taxonomy ) ) {
			return false;
		}

		$primary = get_post_meta( $post_id, '_primary_category_' . $taxonomy, true ); //get post meta for that post

		if ( ! $primary ) {
			return false;
		}

		$term_id = get_term( $primary, $taxonomy, OBJECT ); // get term object from post meta id

		$html    = '';

		if ( 'link' === $output ) { /*if output type is link*/
			$html = sprintf( '<a href="%s" title="%s">%s</a>', get_term_link( $term_id ), $term_id->name, $term_id->name );
		} else { // if output type is name or something else
			$html = $term_id->name;
		}
		// filter primary_category_html created to modify generated html
		$html = apply_filters( 'primary_category_html', $html, $taxonomy, $post_id, $output );

		if ( $echo ) {
			echo wp_kses_post( $html );
		} else {
			return wp_kses_post( $html );
		}
	}
}