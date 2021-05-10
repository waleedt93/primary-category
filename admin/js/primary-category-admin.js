(function( $ ) {
	'use strict';

	/**
	 * All of the code for admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready.
	 *
	 */

	$(document).ready(function () {

		var label = PRIMARY_CAT.label; //get label from localize_script

		//for each taxonomies of a post type
		$( PRIMARY_CAT.taxonomies ).each( function( key, taxonomy) {
			var inputs = $( '#taxonomy-' + taxonomy ).find( '.categorychecklist :checked' ); //target input fields of a taxanomy

			if ( inputs.length ) {
				inputs.each( function() {

					var checkbox = $( this );
					var wrap     = checkbox.closest( '.selectit' );
					var current  = $( '#primary-input-' + taxonomy ).val();

					if ( current === checkbox.val() ) {
						wrap.addClass( 'cat-selected' ); // if currently that term is selected as primary add class
					}
					//append set as primary button to already selected primary term
					wrap.append('<a href="#" class="cat-link cat-'+ taxonomy +'-'+checkbox.val()+'" data-taxonomy="'+ taxonomy +'" data-taxonomy-id="'+checkbox.val()+'">'+label+'</a>');
				} );
			}
			//append set as primary to selected term
			$( document ).on( 'click', '#taxonomy-' + taxonomy + ' [type="checkbox"]', function() {
				var self = $( this );
				var id   = self.val();
				var wrap = self.closest( '.selectit' );

				if ( ! self.prop( 'checked' ) ) {
					$( '.cat-' + taxonomy + '-' + id ).remove();
					if ( wrap.hasClass( 'cat-selected' ) ) {
						wrap.removeClass( 'cat-selected' );
						$( '#primary-input-' + taxonomy ).val( '' );
					}
				} else {
					$( '#taxonomy-' + taxonomy )
						.find( 'input[value="' + self.val() + '"]' )
						.closest( '.selectit' )
						.append('<a href="#" class="cat-link cat-'+taxonomy+'-'+id+'" data-taxonomy="'+taxonomy+'" data-taxonomy-id="'+id+'">'+label+'</a>');

				}
			} );

			$( '#' + taxonomy + 'checklist' ).on( 'wpListAddEnd', function( data ) {

				var list  = $( data.target );
				var item  = list.find( '.selectit:first' );
				var input = item.find( '[type="checkbox"]' );

				item.append('<a href="#" class="cat-link cat-' + taxonomy + '-' +input.val()+'" data-taxonomy="' + taxonomy + '" data-taxonomy-id="'+input.val()+'">'+label+'</a>');
			} );
		} );
		//add or remove cat-selected class
		$( document ).on( 'click', '.cat-link', function( e ) {
			e.preventDefault();

			var self        = $( this );
			var taxonomy    = self.data( 'taxonomy' );
			var taxonomy_id = self.data( 'taxonomy-id' );
			var links       = $( '.cat-' + taxonomy + '-' + taxonomy_id );
			var wrap        = links.closest( '.selectit' );
			var input       = $( '#primary-input-' + taxonomy );
			var selected    = wrap.hasClass( 'cat-selected' );

			$( '#taxonomy-' + taxonomy )
				.find( '.cat-selected' )
				.removeClass( 'cat-selected' );

			if ( ! selected ) {
				input.val( taxonomy_id );
				wrap.addClass( 'cat-selected' );
			} else {
				input.val( '' );
				wrap.removeClass( 'cat-selected' );
			}
		} );

	});
})( jQuery );