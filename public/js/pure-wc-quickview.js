(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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
	// console.log(wc_single_product_params);

	$(document).on('pure_wc_ajax_loaded', function(){
		quick_view();
		pureSingleVariationFunctionality();
		$('.sb-ps-active').perfectScrollbar({
			suppressScrollX : true,
		});
	})

	const pureSingleVariationFunctionality = function() {
		$( '.variations_form.cart' ).each(
			function () {
				const thisForm = $( this );
				thisForm.wc_variation_form();
				thisForm.on( 'found_variation', function ( e, variation ) {
					pureUpdateSingleProductCartButtonData( thisForm, variation );
				});
			}
		);
	}

	const pureUpdateSingleProductCartButtonData = function( variant, variation ) {
		const select = variant.find( '.variations select' );
		const data = {};
		const button = variant.find( '.single_add_to_cart_button' );
		select.each( function () {
			const attributeName = $( this ).data( 'attribute_name' ) || $( this ).attr( 'name' );
			const value = $( this ).val() || '';
			data[ attributeName ] = value;
		});

		if( button.length ){
			button.addClass( 'tpwvs-variation-found' );
			button.attr( 'data-variation_id', variation.variation_id );
			button.attr( 'data-selected_variant', JSON.stringify( data ) );
		}
		
	}

	const pureSingleAddToCart = function( variant ) {
		if ( variant.is( '.wc-variation-selection-needed' ) ) {
			return window.alert( 'Please select a variation' );
		}
		const productId 	= variant.data( 'product_id' ) || variant.val() || variant.closest( '.variations_button' ).find( 'input[name="add-to-cart"]' ).val();
		const productQty 	= variant.data( 'quantity' ) || variant.closest( '.quantity' ).find( 'input[name="quantity"]' ).val() || 1;
		const variationId 	= (variant.attr( 'data-variation_id' ) != undefined)? variant.attr( 'data-variation_id' ) : 0;
		const variation 	= (variant.attr( 'data-selected_variant' ) != undefined)? JSON.parse(variant.attr( 'data-selected_variant' )) : { variation:''};
		const data = {
			action: 'woocommerce_ajax_add_to_cart',
			security: pure_wc_quickview.ajax_add_to_cart_nonce,
			product_id: productId,
			quantity: productQty,
			variation_id: variationId,
			variation,
		};
		$( document.body ).trigger( 'adding_to_cart', [ variant, data ] );
		variant.removeClass( 'added' ).addClass( 'loading' );
		// Ajax add to cart request
		$.ajax( {
			type: 'POST',
			url: pure_wc_quickview.ajax_url,
			data,
			dataType: 'json',
			success( response ) {
				if ( ! response ) {
					return;
				}

				if ( response.error && response.product_url ) {
					window.location = response.product_url;
					return;
				}

				// Trigger event so themes can refresh other areas.
				$( document.body ).trigger( 'added_to_cart', [
					response.fragments,
					response.cart_hash,
					variant,
				] );
				$( document.body ).trigger( 'update_checkout' );

				variant.removeClass( 'loading' ).addClass( 'added' );
			},
			error( errorThrown ) {
				variant.removeClass( 'loading' );
				console.log( errorThrown );
			},
		});
	}


	$(document).on('pure_wc_quickview_loaded', function(){
		pureSingleVariationFunctionality();
		$('.sb-ps-active').perfectScrollbar({
			suppressScrollX : true,
		});

		$('.sb-product-quickview-main-thumb-slider').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			fade: true,
			dots: true,
			asNavFor: '.sb-product-quickview-nav-slider',
			prevArrow: `<button type="button" class="sb-product-quickview-button-prev sb-product-quickview-main-thumb-slider-btn">
							<svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1.00073 6.99989L15 6.99989" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M6.64648 1.5L1.00011 6.99954L6.64648 12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</button>`,
			nextArrow: `<button type="button" class="sb-product-quickview-button-next sb-product-quickview-main-thumb-slider-btn">
							<svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14.9993 6.99989L1 6.99989" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M9.35352 1.5L14.9999 6.99954L9.35352 12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</button>`,
		});

		// console.log($('.sb-product-quickview-nav-slider').data('vertical'));
		$('.sb-product-quickview-nav-slider').slick({
			slidesToShow: 3,
			slidesToScroll: 1,
			asNavFor: '.sb-product-quickview-main-thumb-slider',
			dots: false,
			arrows: false,
			centerMode: true,
  			centerPadding: '0',
			focusOnSelect: true,
			vertical: Boolean($('.sb-product-quickview-nav-slider').data('vertical')) || false
		})

		$( document ).on('click', '.single_add_to_cart_button', function ( e ) {
			e.preventDefault();
			pureSingleAddToCart( $( this ) );
		})

		$(document).on('click', '.sb-cart-plus, .sb-cart-minus', function(e){
            e.preventDefault();
            var $this = $(this);
            var $closestForm = $this.closest('.cart');

            var $quantity = $closestForm.find('input[name="quantity"]').val();

            var $addToCartBtn =  $closestForm.find('.single_add_to_cart_button');

            $addToCartBtn.attr('data-quantity', $quantity);

        })
	})

	$(document).on('hide_variation', function(){
		$('.reset_variations').on('click', function(e){
			e.preventDefault();
			var $thumbnails = $('.pure-quickview-thumbnails');
			setTimeout(function() {
				$thumbnails.slick('slickGoTo', 0);
			}, 100);
		})
	})

	$(document).on('found_variation', function(e, variation){
		console.log(variation);
		
		if ( variation['image_id'] !== undefined ) {
			
			if ( $('.pure-quickview-thumbnails .sb-thumbnail').length > 1 ) {
			  var $thumb = $('.pure-quickview-thumbnails .sb-thumbnail[data-id="' + variation['image_id'] + '"]');
			  
			  if ($thumb.length) {
				var pos = $('.pure-quickview-thumbnails .sb-thumbnail').index( $thumb );
				console.log(pos);
				var $thumbnails = $('.pure-quickview-thumbnails');
				
				if ((pos >= 0) && $thumbnails.hasClass('slick-initialized')) {
				  setTimeout(function() {
					$thumbnails.slick('slickGoTo', pos);
				  }, 100);
				}
			  }
			}
		}
	})

	$(function(){
		quick_view();
	})

	var quick_view = function(){
		/**
		 * Woocommerce quickview 
		 */
		var products_ids = [], _products = [];

		$(function() {
			$('.pure-wc-quickview-btn').each(function() {
				var id = $(this).attr('data-id');
		
				if (-1 === $.inArray(id, products_ids)) {
					products_ids.push(id);
					_products.push({src: pure_wc_quickview.ajax_url + '?product_id=' + id});
				}
			});
		});

		$('.pure-wc-quickview-btn').on('click', function(e){
			e.preventDefault();
			var $this = $(this);
    		var id = $this.attr('data-id');
			pure_wc_quickview_click( id );
		});

		var pure_get_index_key = function(array, key, value) {
			for (var i = 0; i < array.length; i++) {
			  if (array[i][key] === value) {
				return i;
			  }
			}
		  
			return -1;
		}

		var pure_wc_quickview_click = function( id ){
			var index = pure_get_index_key( _products, 'src', pure_wc_quickview.ajax_url + '?product_id=' + id );
			var main_class = 'mfp-fade';

			$.purewcPopup.open({
				items: _products,
				type: 'ajax',
				mainClass: main_class,
				removalDelay: 160,
				overflowY: 'scroll',
				fixedContentPos: true,
				tClose: 'Close (Esc)',
				gallery: {
					tPrev: 'Previous (Left arrow key)', // title for left button
					tNext: 'Next (Right arrow key)', // title for right button
				  	enabled: true,
				},
				ajax: {
				  settings: {
					type: 'GET', 
					data: {
					  action: 'pure_quickview',
					  nonce:pure_wc_quickview._nonce
					},
				  },
				},
				callbacks: {
				  open: function() {
					// console.log('Open');
				  }, 
				  ajaxContentAdded: function() {
					$(document.body).trigger('pure_wc_quickview_loaded', [id]);
					// console.log(this.content)
				  }, 
				  close: function() {
					// console.log('Close');
				  }, 
				  afterClose: function() {
					// console.log('After Close');
				  }
				},
			}, index);
		}
	}
	

})( jQuery );
