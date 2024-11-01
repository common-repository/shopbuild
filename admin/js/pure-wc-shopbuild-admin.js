(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


	// term meta type

	let fileFrame;

	$( document ).ready( function () {
		$( '.tpwvs_upload_image_button' ).on( 'click', function ( event ) {
			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( fileFrame ) {
				// Open frame
				fileFrame.open();
				return;
			}

			// Create the media frame.
			fileFrame = wp.media.frames.fileFrame = wp.media( {
				title: tpwvs_swatches_term_meta.image_upload_text.title,
				button: {
					text:
						tpwvs_swatches_term_meta.image_upload_text.button_title,
				},
				multiple: false, // Set to true to allow multiple files to be selected
			} );

			// When an image is selected, run a callback.
			fileFrame.on( 'select', function () {
				// We set multiple to false so only get one image from the uploader
				const attachment = fileFrame
					.state()
					.get( 'selection' )
					.first()
					.toJSON();
				const attachmentUrl = attachment.url;
				$( '.tpwvs-image-preview' )
					.attr( 'src', attachmentUrl )
					.css( 'width', 'auto' )
					.show();
				$( '.tpwvs_remove_image_button' ).show();
				$( '.tpwvs_product_attribute_image' ).val( attachmentUrl );
			} );

			// Finally, open the modal
			fileFrame.open();
		} );

		$( '.tpwvs_remove_image_button' ).on( 'click', function () {
			$( '.tpwvs_product_attribute_image' ).val( '' );
			$( '.tpwvs-image-preview' ).attr( 'src', '' ).hide();
			$( '.tpwvs_remove_image_button' ).hide();
		} );

		$( '.tpwvs_color' ).wpColorPicker();
	} );

	$( document ).ajaxSuccess( function ( event, xhr, settings ) {
		//Check ajax action of request that succeeded
		if ( -1 === settings.data.indexOf( 'action=add-tag' ) ) {
			return;
		}
		const params = settings.data.split( '&' );
		const data = [];
		$.map( params, function ( val ) {
			const temp = val.split( '=' );
			data[ temp[ 0 ] ] = temp[ 1 ];
		} );
		if ( data.action === 'add-tag' ) {
			$( '.tpwvs_product_attribute_image' ).val( '' );
			$( '.tpwvs-image-preview' ).attr( 'src', '' ).hide();
			$( '.tpwvs_remove_image_button' ).hide();
			$( '.tpwvs_product_attribute_color .wp-picker-clear' ).trigger(
				'click'
			);
			$( '.tpwvs_product_attribute_color' ).trigger( 'click' );
		}

		if ( 'undefined' !== typeof data.tpwvs_image ) {
			$( '.wp-list-table #the-list' )
				.find( 'tr:first' )
				.find( 'th' )
				.after(
					'<td class="preview column-preview" data-colname="Preview"><img class="tpwvs-preview" src="' +
						decodeURIComponent( data.tpwvs_image ) +
						'" width="44px" height="44px"></td>'
				);
		}

		if ( 'undefined' !== typeof data.tpwvs_color ) {
			$( '.wp-list-table #the-list' )
				.find( 'tr:first' )
				.find( 'th' )
				.after(
					'<td class="preview column-preview" data-colname="Preview"><div class="tpwvs-preview" style="background-color:' +
						decodeURIComponent( data.tpwvs_color ) +
						';width:30px;height:30px;"></div></td>'
				);
		}
	} );


	var mediaUploader;
	$('#upload_coupon_image').on('click', function (e) {
		e.preventDefault();
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}
		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});
		mediaUploader.on('select', function () {
			var attachment = mediaUploader.state().get('selection').first().toJSON();
			$('#coupon_image_container').html('<img src="' + attachment.url + '" alt="Coupon Image" style="max-width: 100px; max-height: 100px;" />');
			$('#coupon_image_id').val(attachment.id);
		});
		mediaUploader.open();
	});

	$('#remove_coupon_image').on('click', function () {
		$('#coupon_image_container').html('');
		$('#coupon_image_id').val('');
	});

	$('#adminmenu #toplevel_page_shopbuild li a[href="admin.php?page=shopbuild_go_premium"]').attr('target', '_blank');
	

})( jQuery );

