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
	var wc_checkout_coupons = {
		init: function() {
			// $( document.body ).on( 'click', 'a.showcoupon', this.show_coupon_form );
			$( document.body ).on( 'click', '.woocommerce-remove-coupon', this.remove_coupon );
			$( 'form.checkout_coupon' ).hide().on( 'submit', this.submit );
		},
		show_coupon_form: function() {
			$( '.checkout_coupon' ).slideToggle( 400, function() {
				$( '.checkout_coupon' ).find( ':input:eq(0)' ).trigger( 'focus' );
			});
			return false;
		},
		submit: function() {
			var $form = $( this );

			if ( $form.is( '.processing' ) ) {
				return false;
			}

			$form.addClass( 'processing' ).block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			var data = {
				security: wc_checkout_params.apply_coupon_nonce,
				coupon_code: $form.find('input[name="coupon_code"]').val(),
				billing_email: wc_checkout_form.$checkout_form.find('input[name="billing_email"]').val()
			};

			$.ajax({
				type:		'POST',
				url:		wc_checkout_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'apply_coupon' ),
				data:		data,
				success:	function( code ) {
					$( '.woocommerce-error, .woocommerce-message, .is-error, .is-success' ).remove();
					$form.removeClass( 'processing' ).unblock();

					if ( code ) {
						$form.before( code );
						$form.slideUp();

						$( document.body ).trigger( 'applied_coupon_in_checkout', [ data.coupon_code ] );
						$( document.body ).trigger( 'update_checkout', { update_shipping_method: false } );
					}
				},
				dataType: 'html'
			});

			return false;
		},
		remove_coupon: function( e ) {
			e.preventDefault();

			var container = $( this ).parents( '.woocommerce-checkout-review-order' ),
				coupon    = $( this ).data( 'coupon' );

			container.addClass( 'processing' ).block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});

			var data = {
				security: wc_checkout_params.remove_coupon_nonce,
				coupon:   coupon
			};

			$.ajax({
				type:    'POST',
				url:     wc_checkout_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'remove_coupon' ),
				data:    data,
				success: function( code ) {
					$( '.woocommerce-error, .woocommerce-message, .is-error, .is-success' ).remove();
					container.removeClass( 'processing' ).unblock();

					if ( code ) {
						$( 'form.woocommerce-checkout' ).before( code );

						$( document.body ).trigger( 'removed_coupon_in_checkout', [ data.coupon ] );
						$( document.body ).trigger( 'update_checkout', { update_shipping_method: false } );

						// Remove coupon code from coupon field
						$( 'form.checkout_coupon' ).find( 'input[name="coupon_code"]' ).val( '' );
					}
				},
				error: function ( jqXHR ) {
					if ( wc_checkout_params.debug_mode ) {
						/* jshint devel: true */
						console.log( jqXHR.responseText );
					}
				},
				dataType: 'html'
			});
		}
	};

	var wc_checkout_login_form = {
		init: function() {
			$( document.body ).on( 'click', 'a.showlogin', this.show_login_form );
		},
		show_login_form: function() {
			$( 'form.login, form.woocommerce-form--login' ).slideToggle();
			return false;
		}
	};

	if(!Boolean(pure_wc_shopbuild.is_checkout)){
		wc_checkout_coupons.init();
		wc_checkout_login_form.init();
	}

	// shop page sidebar price filter
	function products_price_filter(){
		// woocommerce_price_slider_params is required to continue, ensure the object exists
		if ( typeof woocommerce_price_slider_params === 'undefined' ) {
			return false;
		}

		$( document.body ).on( 'price_slider_create price_slider_slide', function( event, min, max ) {

			$( '.price_slider_amount span.from' ).html( accounting.formatMoney( min, {
				symbol:    woocommerce_price_slider_params.currency_format_symbol,
				decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
				thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
				precision: woocommerce_price_slider_params.currency_format_num_decimals,
				format:    woocommerce_price_slider_params.currency_format
			} ) );

			$( '.price_slider_amount span.to' ).html( accounting.formatMoney( max, {
				symbol:    woocommerce_price_slider_params.currency_format_symbol,
				decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
				thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
				precision: woocommerce_price_slider_params.currency_format_num_decimals,
				format:    woocommerce_price_slider_params.currency_format
			} ) );

			$( document.body ).trigger( 'price_slider_updated', [ min, max ] );
		});

		function init_price_filter() {
			$( 'input#min_price, input#max_price' ).hide();
			$( '.price_slider, .price_label' ).show();

			var min_price         = $( '.price_slider_amount #min_price' ).data( 'min' ),
				max_price         = $( '.price_slider_amount #max_price' ).data( 'max' ),
				step              = $( '.price_slider_amount' ).data( 'step' ) || 1,
				current_min_price = $( '.price_slider_amount #min_price' ).val(),
				current_max_price = $( '.price_slider_amount #max_price' ).val();

			$( '.price_slider:not(.ui-slider)' ).slider({
				range: true,
				animate: true,
				min: min_price,
				max: max_price,
				step: step,
				values: [ current_min_price, current_max_price ],
				create: function() {

					$( '.price_slider_amount #min_price' ).val( current_min_price );
					$( '.price_slider_amount #max_price' ).val( current_max_price );

					$( document.body ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
				},
				slide: function( event, ui ) {

					$( 'input#min_price' ).val( ui.values[0] );
					$( 'input#max_price' ).val( ui.values[1] );

					$( document.body ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
				},
				change: function( event, ui ) {

					$( document.body ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );
				}
			});
		}

		init_price_filter();
		$( document.body ).on( 'init_price_filter', init_price_filter );

		var hasSelectiveRefresh = (
			'undefined' !== typeof wp &&
			wp.customize &&
			wp.customize.selectiveRefresh &&
			wp.customize.widgetsPreview &&
			wp.customize.widgetsPreview.WidgetPartial
		);
		if ( hasSelectiveRefresh ) {
			wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function() {
				init_price_filter();
			} );
		}
	}

	// product details sale countdown
	function countdown(){
		$("[data-countdown]").countdown();
	}


	$("[data-countdown]").countdown();

	$(window).on("elementor/frontend/init", function () {
		elementorFrontend.hooks.addAction(
			"frontend/element_ready/sidebar-price-filter.default", products_price_filter
		);
		elementorFrontend.hooks.addAction(
			"frontend/element_ready/single-product-saletimer.default", countdown
		);
		
	});

	$(document).on( 'found_variation', 'form.cart', function( event, variation ) {
		event.preventDefault();          
	});

	
	function related_slider(){
		// product related slider active
		if($('.tp-woo-related-product-related-active').length > 0){
			$('.tp-woo-related-product-related-active').slick({
				dots: false,
				arrows: false,
				prevArrow: '<div class="prev"><i class="far fa-angle-left"></i></div>',
				nextArrow: '<div class="next"><i class="far fa-angle-right"></i></div>',
				autoplay: false,
				Speed: 2000,
				slidesToShow: 4,
				slidesToScroll: 1,
				focusOnSelect: true,
			});
		}
	}

	if($('#password-show-toggle').length > 0){
		var btn = document.getElementById('password-show-toggle');
		
		btn.addEventListener('click', function(e){

			
			
			var inputType = document.getElementById('password');
			var openEye = document.getElementById('open-eye');
			var closeEye = document.getElementById('close-eye');
	
			if (inputType.type === "password") {
				inputType.type = "text";
				openEye.style.display = 'block';
				closeEye.style.display = 'none';
				} else {
				inputType.type = "password";
				openEye.style.display = 'none';
				closeEye.style.display = 'block';
				}
		});
	}

	setTimeout(function(){

		$('img').imagesLoaded().done(function(instance) {
			$(".flex-control-thumbs").addClass("product-thumbnails");

			if ($(".woocommerce-product-gallery").hasClass("pure-single-product-gallery-vertical-sidebar") && $(window).width() > 992) {
				var verti = true;
			} else {
				var verti = false;
			}
	
			$('.product-thumbnails').slick({
				dots: false,
				arrows: false,
				prevArrow: '<div class="prev"><i class="far fa-angle-left"></i></div>',
				nextArrow: '<div class="next"><i class="far fa-angle-right"></i></div>',
				autoplay: false,
				Speed: 2000,
				slidesToShow: 4,
				slidesToScroll: 1,
				focusOnSelect: true,
				vertical: verti,
				responsive: [
					{
						breakpoint: 992,
						settings: {
						slidesToShow: 4,
						},
					},
					{
						breakpoint: 576,
						settings: {
						slidesToShow: 3,
						},
					},
					{
						breakpoint: 0,
						settings: {
						slidesToShow: 2,
						},
					},
				],
			});
		
		})
		.fail(function(instance) {
			console.log('all images loaded, at least one is broken');
		});
		

	}, 1000);
	

	
	// product related slider
	related_slider();


	var current_page = pure_wc_shopbuild.current_page;

	var is_blocked = function( $node ) {
		return $node.is( '.processing' ) || $node.parents( '.processing' ).length;
	};
	
	var block = function( $node ) {
		if ( ! is_blocked( $node ) ) {
			$node.addClass( 'processing' ).block( {
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
		}
	};
	
	var unblock = function( $node ) {
		$node.removeClass( 'processing' ).unblock();
	};

	$('#products-load-more').on('click', function(e){
		$(this).addClass('loading');
		current_page++;

		let first = ( pure_wc_shopbuild.per_page * current_page ) - pure_wc_shopbuild.per_page;
		let last = Math.min( pure_wc_shopbuild.total, pure_wc_shopbuild.per_page * current_page );
		
		$.ajax({
			type: 'POST',
			url: pure_wc_shopbuild.ajax_url,
			dataType: 'html',
			data: {
				action: 'products_load_more',
				security: pure_wc_shopbuild.shopbuild_nonce,
				per_page: pure_wc_shopbuild.per_page,
				paged: current_page
			},
			beforeSend: function() {
				block( $( 'div.elementor-container' ) );
			},
			complete: function() {
				unblock( $( 'div.elementor-container' ) );
				$(e.target).removeClass('loading');
			},
			success: function( response ){
				if(!response.match('No more products found!')){
					$('.products-grid-wrapper .sb-row').append(response);
					$('.woocommerce-result-count').text(`Showing ${first}-${last} of ${pure_wc_shopbuild.total} results`);
					$( document ).trigger('pure_wc_ajax_loaded');
				}else{
					$('.products-grid-wrapper .sb-row').append(response);
					$(e.target).prop('disabled', true);
				}
			},
			error: function( err ){
				console.error( err );
			}
		});
	});


	/**
	 * Woocomerce
	 */

	var get_url = function( endpoint ) {
		return wc_cart_params.wc_ajax_url.toString().replace(
			'%%endpoint%%',
			endpoint
		);
	};

	var show_notice = function( html_element, $target ) {
		if ( ! $target ) {
			$target = $( '.woocommerce-notices-wrapper:first' ) ||
				$( '.cart-empty' ).closest( '.woocommerce' ) ||
				$( '.woocommerce-cart-form' );
		}
		$target.prepend( html_element );
	};

	var cart_functions = function(){
		$(document).on('click', '#pure_coupon_submit', function(e){
			e.preventDefault();
			let $form = $('.woocommerce-cart-form');
			apply_coupon( $form );
		})

		$('.cart .qty').each(function(){
			$(this).on('change', function(){
				let $form = $('.woocommerce-cart-form');
				console.log($form);
				quantity_update( $form );
			})
		})
	}
	cart_functions();
	
	$(document).on('pure_wc_cart_update', function(){
		cart_functions();
	})

	/**
	 * Handle a cart Quantity Update
	 *
	 * @param {JQuery Object} $form The cart form.
	 */
	var quantity_update = function( $form ) {
		block( $form );
		block( $( 'div.cart_totals' ) );

		// Provide the submit button value because wc-form-handler expects it.
		$( '<input />' ).attr( 'type', 'hidden' )
						.attr( 'name', 'update_cart' )
						.attr( 'value', 'Update Cart' )
						.appendTo( $form );

		// Make call to actual form post URL.
		$.ajax( {
			type:     $form.attr( 'method' ),
			url:      $form.attr( 'action' ),
			data:     $form.serialize(),
			dataType: 'html',
			success:  function( response ) {
				updateWCdiv( response );
				$(document).trigger('pure_wc_cart_update')
			},
			complete: function() {
				unblock( $form );
				unblock( $( 'div.cart_totals' ) );
				$.scroll_to_notices( $( '[role="alert"]' ) );
			}
		});
	}

	
	var apply_coupon = function( $form ){
		block( $form );
		let $text_field = $( 'input[name="coupon_code"]' ).length > 0 ? $( 'input[name="coupon_code"]' ) : $('#coupon_code');
		let coupon_code = $text_field.val();

		let data = {
			security: wc_cart_params.apply_coupon_nonce,
			coupon_code: coupon_code
		};

		$.ajax({
			type:     'POST',
			url:      get_url( 'apply_coupon' ),
			data:     new URLSearchParams( data ).toString(),
			dataType: 'html',
			success: function( response ) {
				$( '.woocommerce-error, .woocommerce-message, .woocommerce-info' ).remove();
				show_notice( response );
				$( document.body ).trigger( 'applied_coupon', [ coupon_code ] );
			},
			complete: function() {
				unblock( $form );
				$text_field.val( '' );
				update_cart( true );
			}
		});
	}

	$(document).on('click', '#pure_checkout_coupon_submit', function(e){
		e.preventDefault();
		applyCheckoutCoupon();
	})

	var applyCheckoutCoupon = function(){
		var $form = $( '.sb-checkout-coupon' );

		if ( $form.is( '.processing' ) ) {
			return false;
		}

		$form.addClass( 'processing' ).block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		});

		var data = {
			security:		wc_checkout_params.apply_coupon_nonce,
			coupon_code:	$form.find( 'input[name="coupon_code"]' ).val()
		};

		$.ajax({
			type:		'POST',
			url:		wc_checkout_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'apply_coupon' ),
			data:		data,
			success:	function( code ) {
				$( '.woocommerce-error, .woocommerce-message, .is-error, .is-success' ).remove();
				$form.removeClass( 'processing' ).unblock();
				if ( code ) {
					$form.before( code );
					$( document.body ).trigger( 'applied_coupon_in_checkout', [ data.coupon_code ] );
					$( document.body ).trigger( 'update_checkout', { update_shipping_method: false } );
				}
			},
			dataType: 'html'
		});

		return false;
	}

	var update_cart = function( preserve_notices ) {
		let $form = $( '.woocommerce-cart-form' );

		block( $form );
		block( $( 'div.cart_totals' ) );

		// Make call to actual form post URL.
		$.ajax({
			type:     $form.attr( 'method' ),
			url:      $form.attr( 'action' ),
			data:     new URLSearchParams( new FormData( $form[0] ) ).toString(),
			dataType: 'html',
			success:  function( response ) {
				updateWCdiv( response, preserve_notices );
			},
			complete: function() {
				unblock( $form );
				unblock( $( 'div.cart_totals' ) );
				$.scroll_to_notices( $( '[role="alert"]' ) );
			}
		});
	}

	var removeDuplicateNotices = function( notices ) {
		let seen = [];
		let new_notices = notices;

		notices.each( function( index ) {
			let text = $( this ).text();

			if ( 'undefined' === typeof seen[ text ] ) {
				seen[ text ] = true;
			} else {
				new_notices.splice( index, 1 );
			}
		} );

		return new_notices;
	}

	var updateWCdiv = function( html_str, preserve_notices ) {
		let $html       = $.parseHTML( html_str );
		let $new_form   = $( '.woocommerce-cart-form', $html );
		let $new_totals = $( '.cart_totals', $html );
		let $notices    = removeDuplicateNotices( $( '.woocommerce-error, .woocommerce-message, .woocommerce-info', $html ) );

		// No form, cannot do this.
		if ( $( '.woocommerce-cart-form' ).length === 0 ) {
			// window.location.reload();
			return;
		}

		// Remove errors
		if ( ! preserve_notices ) {
			$( '.woocommerce-error, .woocommerce-message, .woocommerce-info' ).remove();
		}

		if ( $new_form.length === 0 ) {
			// If the checkout is also displayed on this page, trigger reload instead.
			if ( $( '.woocommerce-checkout' ).length ) {
				// window.location.reload();
				return;
			}

			// No items to display now! Replace all cart content.
			let $cart_html = $( '.cart-empty', $html ).closest( '.woocommerce' );
			$( '.woocommerce-cart-form__contents' ).closest( '.woocommerce' ).replaceWith( $cart_html );

			// Display errors
			if ( $notices.length > 0 ) {
				show_notice( $notices );
			}

			// Notify plugins that the cart was emptied.
			$( document.body ).trigger( 'wc_cart_emptied' );
		} else {
			// If the checkout is also displayed on this page, trigger update event.
			if ( $( '.woocommerce-checkout' ).length ) {
				$( document.body ).trigger( 'update_checkout' );
			}

			$( '.woocommerce-cart-form' ).replaceWith( $new_form );
			$( '.woocommerce-cart-form' ).find( ':input[name="update_cart"]' ).prop( 'disabled', true ).attr( 'aria-disabled', true );

			if ( $notices.length > 0 ) {
				show_notice( $notices );
			}

			updateCartTotalsDiv( $new_totals );
		}

		$( document.body ).trigger( 'updated_wc_div' );
	}

	var updateCartTotalsDiv = function( html_str ) {
		$( '.cart_totals' ).replaceWith( html_str );
		$( document.body ).trigger( 'updated_cart_totals' );
	};

	// add to cart
	$( document ).off('click', '.pure_single_add_to_cart_button').on('click', '.pure_single_add_to_cart_button', function ( e ) {
		e.preventDefault();
		pureSingleAddToCart( $( this ) );
	});
	// group add to cart
	$( document ).off('click', '.group-add-to-cart').on('click', '.group-add-to-cart', function ( e ) {
		e.preventDefault();
		pureGroupAddToCart( $(this) );
	});

	$( document ).on('click', '.group-add-to-cart.added', function ( e ) {
		e.preventDefault();
		window.location = $( this ).data('cart-url');
	});

	const pureSingleAddToCart = function( variant ) {
		if ( variant.is( '.wc-variation-selection-needed' ) ) {
			return window.alert( 'Please select a variation' );
		}

		const productId 	= variant.data( 'product_id' );
		const productQty 	= variant.data( 'quantity' );
		const variationId 	= (variant.attr( 'data-variation_id' ) != undefined)? variant.attr( 'data-variation_id' ) : 0;
		const variation 	= (variant.attr( 'data-selected_variant' ) != undefined)? JSON.parse(variant.attr( 'data-selected_variant' )) : { variation:''};
		const data = {
			action: 'woocommerce_ajax_add_to_cart',
			security: pure_wc_shopbuild.cart_nonce,
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
			url: pure_wc_shopbuild.ajax_url,
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
				variant.removeClass( 'loading' ).addClass( 'added' ).attr('data-cart-url', pure_wc_shopbuild.cart_url).text('View Cart');

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
		} );
	}
	const pureGroupAddToCart = function( $this ) {
		var quantities = {};

		// Select the input fields based on their name attribute
		$('input[name^="quantity["]').each(function() {
			var nameAttr = $(this).attr('name');
		
			// Ensure the name attribute is in the expected format
			if (nameAttr && nameAttr.match(/\d+/)) {
				var childID = nameAttr.match(/\d+/)[0];  // Extract the numeric part
				var quantity = $(this).val();
				
				// Ensure the quantity is a valid number
				if (!isNaN(quantity) && quantity > 0) {
					quantities[childID] = quantity;
				}
			}
		});

		if(_.isEmpty(quantities)){
			alert('Please select one of the items quantity!');
			return;
		}

		const data = {
			action: 'wc_group_ajax_add_to_cart',
			security: pure_wc_shopbuild.cart_nonce,
			quantities,
		};
		$( document.body ).trigger( 'adding_to_cart', [ $this, data ] );
		$this.removeClass( 'added' ).addClass( 'loading' );
		// Ajax add to cart request
		$.ajax( {
			type: 'POST',
			url: pure_wc_shopbuild.ajax_url,
			data,
			dataType: 'json',
			success( response ) {
				if(response.error){
					alert('Something went wrong please try again later!');
					return;
				}

				$this.removeClass( 'loading' ).addClass( 'added' ).attr('data-cart-url', pure_wc_shopbuild.cart_url).text('View Cart');

				// Trigger event so themes can refresh other areas.
				$( document.body ).trigger( 'added_to_cart', [
					response.fragments,
					response.cart_hash,
					$this,
				] );
				$( document.body ).trigger( 'update_checkout' );

			},
			error( errorThrown ) {
				$this.removeClass( 'loading' );
				console.log( errorThrown );
			},
		} );
	}
	

	function pureWcTab(){
		$(".pure-wc-product-tab").each(function () {
			$(this).jQueryTab({
				initialTab: 2,
				tabInTransition: 'fadeIn',
				tabOutTransition: 'fadeOut',
				cookieName: 'pure-wc-product-tab'
			});
		});
	}

	
	
	$(window).on("elementor/frontend/init", function () {
		elementorFrontend.hooks.addAction(
			"frontend/element_ready/product-tab.default",pureWcTab
		);

	});

	// Quantity buttons
	if ( ! String.prototype.getDecimals ) {
		String.prototype.getDecimals = function() {
			var num = this,
				match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
			if ( ! match ) {
				return 0;
			}
			return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
		}
	}
	// Quantity "plus" and "minus" buttons
	$( document.body ).on( 'click', '.plus, .minus', function() {
		var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
			currentVal  = parseFloat( $qty.val() ),
			max         = parseFloat( $qty.attr( 'max' ) ),
			min         = parseFloat( $qty.attr( 'min' ) ),
			step        = $qty.attr( 'step' );

		// Format values
		if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
		if ( max === '' || max === 'NaN' ) max = '';
		if ( min === '' || min === 'NaN' ) min = 0;
		if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

		// Change the value
		if ( $( this ).is( '.plus' ) ) {
			if ( max && ( currentVal >= max ) ) {
				$qty.val( max );
			} else {
				$qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
			}
		} else {
			if ( min && ( currentVal <= min ) ) {
				$qty.val( min );
			} else if ( currentVal > 0 ) {
				$qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
			}
		}

		// Trigger change event
		$qty.trigger( 'change' );
	});


	// existing login
	$(document).on('click', '.showlogin', function(e){
		$('.woocommerce-form-login.login').slideToggle()
	})

	$(document).on('click', '.woocommerce-form-login__submit', function(e){
		e.preventDefault();
		var $username = $('#username').val();
		var $password = $('#password').val();
		var $rememberme = $('#rememberme').val();
		var $nonce = $('#woocommerce-login-nonce').val();
		var $redirect = $('input[name="redirect"]').val();

		if( $username == '' || $password == '' ){
			$('.checkout.woocommerce-checkout').prepend(`
			<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout">
				<ul class="woocommerce-error" role="alert">
					<li data-id="billing_first_name">
						<strong>Username & Password</strong> are required fields.		
					</li>
				</ul>
			</div>
			`);
		}else{
			$.ajax({
				method:'POST',
				url: pure_wc_shopbuild.ajax_url,
				data:{
					action:'shopbuild_woo_ajax_login',
					username: $username,
					password: $password,
					rememberme: $rememberme,
					redirect: $redirect,
					nonce: $nonce,
				},
				success:function( res ){
					if( !res.success ){
						if($('.woocommerce-NoticeGroup-checkout').length){
							$('.woocommerce-NoticeGroup-checkout').html(`
							<ul class="woocommerce-error" role="alert">
								<li data-id="billing_first_name">
									${res.data}		
								</li>
							</ul>
							`);
						}else{

							$('.checkout.woocommerce-checkout').prepend(`
							<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout">
								<ul class="woocommerce-error" role="alert">
									<li data-id="billing_first_name">
										${res.data}		
									</li>
								</ul>
							</div>
							`);
						}
					}else{
						window.location.href = res.data;
					}
				}
			})
		}
	});



	$(document).on('click', '.pure-coupon-toggle-opener-btn', function(){
		$('.pure-coupon-toggle-content').slideToggle();
	})

	$("[data-text-color").each(function(){	
		$(this).css('color', $(this).data('text-color'));
	});
	$("[data-bg-color").each(function(){	
		$(this).css('background-color', $(this).data('text-color'));
	});


})( jQuery );
