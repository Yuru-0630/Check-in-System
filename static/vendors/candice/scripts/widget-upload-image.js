/**
 * widget-upload-image.js
 */

( function( $ ) {
 
	"use strict";
 
	// ADD IMAGE LINK
	$( 'body' ).on( 'click', '.upload_image_button', function( event ) {

		event.preventDefault();
		var frame,
			field_id = $( this ).data( 'field-id' ),
			imgContainer = $( '#' + field_id + 'img' ),
			imgIdInput = $( '#' + field_id + 'attachment_id' ),
			delImgLink = $( '#' + field_id + 'delete' );

		// If the media frame already exists, reopen it.
		if ( frame ) {
			frame.open();
			return;
		}

		// Create a new media frame
		frame = wp.media( {
			title: widgetUploadImage.frameTitle,
			multiple: false  // Set to true to allow multiple files to be selected
		} );

		// When an image is selected in the media frame...
		frame.on( 'select', function() {

			// Get media attachment details from the frame state
			var attachment = frame.state().get('selection').first().toJSON();

			// Send the attachment URL to our custom image input field.
			imgContainer.html( '<img src="' + attachment.url + '" class="upload_image_button" data-field-id="' + field_id + '">' );

			// Send the attachment id to our hidden input
			imgIdInput.val( attachment.id ).trigger( 'change' );

			// Unhide the remove image link
			delImgLink.removeClass( 'hidden' );
		});

		// Finally, open the modal on click
		frame.open();
	});

	// DELETE IMAGE LINK
	$( 'body' ).on( 'click', '.upload_image_delete', function( event ){

		event.preventDefault();
		var field_id = $( this ).data( 'field-id' ),
			imgContainer = $( '#' + field_id + 'img' ),
			imgIdInput = $( '#' + field_id + 'attachment_id' );

		// Clear out the preview image
		imgContainer.html( '' );

		// Hide the delete image link
		$( this ).addClass( 'hidden' );

		// Delete the image id from the hidden input
		imgIdInput.val( '' ).trigger( 'change' );
	});

} )( jQuery );
