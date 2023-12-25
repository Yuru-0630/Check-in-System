/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	"use strict";

	//--------------------------------------------------------------
	// Site Identity
	//--------------------------------------------------------------
	// Site title
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Show/Hide Site Title
	wp.customize( 'show_site_title', function( value ) {
		value.bind( function( to ) {
			to = ( to ) ? 'inline-block' : 'none';
			$( '.site-title' ).css( {'display': to} );
		} );
	} );
	
	// Tagline
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Show/Hide Tagline
	wp.customize( 'show_tagline', function( value ) {
		value.bind( function( to ) {
			to = ( to ) ? 'block' : 'none';
			$( '.site-description' ).css( {'display': to} );
		} );
	} );

	//--------------------------------------------------------------
	// Labels
	//--------------------------------------------------------------
	// Related Posts Label
	wp.customize( 'related_posts_label', function( value ) {
		value.bind( function( to ) {
			$( '.related-posts-label' ).text( to );
		} );
	} );

	// Read More Label
	wp.customize( 'read_more_label', function( value ) {
		value.bind( function( to ) {
			$( '.read-more-label' ).text( to );
		} );
	} );

	// Search Label
	wp.customize( 'search_label', function( value ) {
		value.bind( function( to ) {
			$( '.search-label' ).text( to );
			$( '.search-form .search-field' ).attr( 'placeholder', to );
		} );
	} );

	// Footer Copyright
	wp.customize( 'footer_copyright', function( value ) {
		value.bind( function( to ) {
			$( '.site-info p' ).html( to );
		} );
	} );

	//--------------------------------------------------------------
	// Font Smoothing
	//--------------------------------------------------------------
	wp.customize( 'font_smoothing', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( 'html' ).css( { '-moz-osx-font-smoothing': 'grayscale', '-webkit-font-smoothing': 'antialiased' } );
			} else {
				$( 'html' ).css( { '-moz-osx-font-smoothing': 'auto', '-webkit-font-smoothing': 'subpixel-antialiased' } );
			}
		} );
	} );

	//--------------------------------------------------------------
	// Header Layout
	//--------------------------------------------------------------
	// Main Navigation Align
	wp.customize( 'primary_menu_alignment', function( value ) {
		value.bind( function( to ) {
			$( '.primary-menu' ).css( {'justify-content': to} );
		} );
	} );

} )( jQuery );
