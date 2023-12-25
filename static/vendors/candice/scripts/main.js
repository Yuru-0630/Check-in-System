/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "../";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	__webpack_require__(1);
	__webpack_require__(5);
	__webpack_require__(6);
	__webpack_require__(7);
	__webpack_require__(8);
	__webpack_require__(9);
	module.exports = __webpack_require__(10);


/***/ },
/* 1 */
/***/ function(module, exports) {

	// removed by extract-text-webpack-plugin

/***/ },
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */
/***/ function(module, exports) {

	/**
	 * File navigation.js.
	 *
	 * Handles toggling the navigation menu for small screens and enables TAB key
	 * navigation support for dropdown menus.
	 */

	( function( $ ) {

		"use strict";

		/**
		 * Elements
		 */
		var $siteNavigation    = $( '#site-navigation' );
		var $socialMenuToggle  = $( '#social-menu-toggle' );
		var $socialMenuOverlay = $( '#social-menu-overlay' );
		var $siteSearchToggle  = $( '#site-search-toggle' );
		var $siteSearchOverlay = $( '#site-search-overlay' );
		var fadeSpeed          = 100;

		/**
		 * Functions
		 */
		function trapping_focus( element, event ) {
			// jQuery formatted selector to search for focusable items
	   		var focusableElementsString = "a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]),iframe, object, embed, *[tabindex], *[contenteditable]";
			
			var $this = element;

			if ( event.keyCode == 9 ) { // tab or maj+tab

				// get list of all children elements in given object
				var children = $this.find('*');

				// get list of focusable items
				var focusableItems = children.filter(focusableElementsString).filter(':visible');

				// get currently focused item
				var focusedItem = $( document.activeElement );

				// get the number of focusable items
				var numberOfFocusableItems = focusableItems.length;

				var focusedItemIndex = focusableItems.index(focusedItem);

				if ( !event.shiftKey && (focusedItemIndex == numberOfFocusableItems - 1) ){
					focusableItems.get(0).focus();
					event.preventDefault();
				}
				if ( event.shiftKey && focusedItemIndex === 0 ){
					focusableItems.get(numberOfFocusableItems - 1).focus();
					event.preventDefault();
				}
			}
		}

		/**
		 * Social navigation menu in modal
		 */
		// open modal
		$socialMenuToggle.click( function() { 
			$socialMenuToggle.attr( 'aria-expanded', 'true' );
			$socialMenuOverlay.attr( 'aria-hidden', 'false' ).fadeIn( fadeSpeed );
			$( '#close-social-menu' ).focus();
		} );
		// close modal
		$socialMenuOverlay.on( 'click keydown', function( event ) {
			if ( event.keyCode == 27 || event.type == 'click' ) { // esc
				$socialMenuOverlay.attr( 'aria-hidden', 'true' ).fadeOut( fadeSpeed );
				$socialMenuToggle.attr( 'aria-expanded', 'false' ).focus();
			} else {
				trapping_focus( $( this ), event );
			}
		} );

		/**
		 * Site search menu in modal
		 */
		// open modal
		$siteSearchToggle.click( function() {
			$siteSearchToggle.attr( 'aria-expanded', 'true' );
			$siteSearchOverlay.attr( 'aria-hidden', 'false' ).fadeIn( fadeSpeed ).find( '.search-field' ).focus();
		});
		// close modal
		$siteSearchOverlay.on( 'click keydown', function( event ) {
			if( event.keyCode == 27 || ( event.type == 'click' && ! $( event.target ).hasClass( 'search-field' ) ) ) {
				$siteSearchOverlay.attr( 'aria-hidden', 'true' ).fadeOut( fadeSpeed );
				$siteSearchToggle.attr( 'aria-expanded', 'false' ).focus();
			} else if ( event.type == 'keydown' ) {
				trapping_focus( $( this ), event );
			}
		} );

		$('.site-search-wrapper .search-form label').prepend('<span class="search-label">' + search.label + '</span>');

		/**
		 * Enables touch support.
		 */
		$siteNavigation.find( '.menu-item-has-children > a' ).on( 'touchstart', function( e ) {
			var el = $( this ).parent( 'li' );

			if ( ! el.hasClass( 'focus' ) ) {
				e.preventDefault();
				el.toggleClass( 'focus' );
				el.siblings( '.focus' ).removeClass( 'focus' );

			}
		} );

		// Hides dropdown menu.
		$( document.body ).on( 'touchstart', function( e ) {
			if ( ! $( e.target ).closest( '.primary-menu li' ).length ) {
				$( '.primary-menu li' ).removeClass( 'focus' );
			}
		} );

		/**
		 * Enables tab support for dropdown menus.
		 */
		$siteNavigation.find( 'a' ).on( 'focus blur', function() {
			$( this ).parents( '.menu-item' ).toggleClass( 'focus' );
		} );

	} )( jQuery );


/***/ },
/* 6 */
/***/ function(module, exports) {

	/**
	 * init.slick.js
	 *
	 * Initializes Slick
	 *
	 * Learn more: http://kenwheeler.github.io/slick/
	 */

	( function( $ ) {

		"use strict";

		if ( $.isFunction( $.fn.slick ) ) {

			var slick_args = {
				dots: true,
				pauseOnHover: true,
				pauseOnDotsHover: true,
				rtl: slider.rtl == 1 ? true : false,
			}

			if ( slick_args.rtl ) {
				slick_args.prevArrow = '<button type="button" class="slick-prev"><i class="fa fa-angle-right"></i></button>';
				slick_args.nextArrow = '<button type="button" class="slick-next"><i class="fa fa-angle-left"></i></button>';
			} else {
				slick_args.prevArrow = '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>';
				slick_args.nextArrow = '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>';
			}

		 	var $gallery_carousel = $( '.featured-gallery' );
			if ( false !== $gallery_carousel.length ) {
				slick_args.fade          = gallerySlider.fade == 1 ? true : false;
				slick_args.speed         = parseInt( gallerySlider.speed );
				slick_args.autoplay      = gallerySlider.autoplay == 1 ? true : false;
				slick_args.autoplaySpeed = parseInt( gallerySlider.autoplaySpeed );

				$gallery_carousel.slick( slick_args );
			}

			var $featured = $( '#featured-posts' );
			if ( false !== $featured.length ) {
				slick_args.fade          = homepageSlider.fade == 1 ? true : false;
				slick_args.speed         = parseInt( homepageSlider.speed );
				slick_args.autoplay      = homepageSlider.autoplay == 1 ? true : false;
				slick_args.autoplaySpeed = parseInt( homepageSlider.autoplaySpeed );

				if ( 'multiple' === homepageSlider.layout ) {
					slick_args.fade           = false;
					slick_args.slidesToShow   = 3;
					slick_args.slidesToScroll = 3;
					slick_args.arrows         = false;
					slick_args.responsive     = [{
							breakpoint: 1024,
							settings: {
								slidesToShow: 2,
								slidesToScroll: 2
							}
						},{
							breakpoint: 720,
							settings: {
								slidesToShow: 1,
								slidesToScroll: 1
							}
						}
					];
				}

				$featured.slick( slick_args );
			}
		}

	} )( jQuery );


/***/ },
/* 7 */
/***/ function(module, exports) {

	/**
	 * init.slicknav.js
	 *
	 * Initializes SlickNav
	 *
	 * Learn more: http://slicknav.com/
	 */

	( function( $ ) {

		"use strict";

		var $menuToggle   = $( '#menu-toggle' );
		var $combinedMenu = $( '#primary-menu' ).clone();
		var $secondMenu   = $( '#social-menu' ).clone();
		var $searchform   = $( '#site-search-overlay .search-form' ).clone();
		$secondMenu.appendTo( $combinedMenu );
		$searchform.appendTo( $combinedMenu );

		$( '#menu-toggle' ).click( function() { 
			$combinedMenu.slicknav( 'toggle' );
			if ( $menuToggle.attr( 'aria-expanded' ) == 'true' ) {
				$menuToggle.attr( 'aria-expanded', 'false' );
			} else {
				$menuToggle.attr( 'aria-expanded', 'true' );
			}
		} );

		$combinedMenu.slicknav( {
		    duplicate: false,
		    label: '',
			appendTo: '#mobile-menu',
			allowParentLinks: true,
			nestedParentLinks: false,
			duration: 300,
			closedSymbol: '<i class="fa fa-angle-right" aria-hidden="true"></i>',
			openedSymbol: '<i class="fa fa-angle-down" aria-hidden="true"></i>',
		} );

		$secondMenu.wrap( '<li>' );
		$searchform.wrap( '<li>' );

	} )( jQuery );


/***/ },
/* 8 */
/***/ function(module, exports) {

	/**
	 * init.fitvids.js
	 *
	 * Inializes FitVids
	 *
	 * Learn more: https://github.com/davatron5000/FitVids.js
	 */

	( function( $ ) {	

		"use strict";

		if ( $.isFunction( $.fn.fitVids ) ) {
			$( '.featured-video, .entry-content' ).fitVids();
		}

	} )( jQuery );


/***/ },
/* 9 */
/***/ function(module, exports) {

	/**
	 * init.magnific-popup.js
	 *
	 * Initializes Magnific Popup
	 *
	 * Learn more: http://dimsemenov.com/plugins/magnific-popup/documentation.html
	 */
	 
	( function( $ ) {

		"use strict";

		magnificPopup.enabled = magnificPopup.enabled == 1 ? true : false;

		if ( $.isFunction( $.fn.magnificPopup ) && magnificPopup.enabled ) {

			var magnificPopup_args = {
				type:         'image',
				mainClass: 	  'mfp-fade',
				closeMarkup:  '<button title="%title%" type="button" class="mfp-close"></button>',
				removalDelay: 300,
				image: {
					titleSrc: function( item ) {
						var caption = '';
						if ( ( caption = item.el.parents( 'figure' ).find( 'figcaption' ).html() ) ? true : false ) {
							return caption;
						}
						return '';
					}
				}
			};

			$( '.magnific-popup-gallery' ).each( function() {
				magnificPopup_args.gallery = { enabled: true };
				magnificPopup_args.delegate = 'figure:not(.slick-cloned) a';
				$( this ).magnificPopup( magnificPopup_args );
			} );

			$( 'a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"]' ).each( function() {
				if ( $( this ).parents( '.gallery' ).length === 0 && ! $( this ).hasClass( 'no-magnific-popup' ) ) {
					$( this ).magnificPopup( magnificPopup_args );
				}
			} );
		}

	} )( jQuery );


/***/ },
/* 10 */
/***/ function(module, exports) {

	/**
	 * File skip-link-focus-fix.js.
	 *
	 * Helps with accessibility for keyboard only users.
	 *
	 * Learn more: https://git.io/vWdr2
	 */
	( function() {

		"use strict";

		var isWebkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
		    isOpera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
		    isIe     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

		if ( ( isWebkit || isOpera || isIe ) && document.getElementById && window.addEventListener ) {
			window.addEventListener( 'hashchange', function() {
				var id = location.hash.substring( 1 ),
					element;

				if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
					return;
				}

				element = document.getElementById( id );

				if ( element ) {
					if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
						element.tabIndex = -1;
					}

					element.focus();
				}
			}, false );
		}
	} )();


/***/ }
/******/ ]);