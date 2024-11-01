;(function($){
    "use strict";


    const pureUpdateSingleProductCartButtonData = function( variant, variation ) {
		const select = variant.find( '.variations select' );
		const data = {};
		const button = variant.find( '.single_add_to_cart_button' );
        const variantProductID = variant.data( 'product_id' );
		select.each( function () {
			const attributeName = $( this ).data( 'attribute_name' ) || $( this ).attr( 'name' );
			const value = $( this ).val() || '';
			data[ attributeName ] = value;
		});

        $(`.product-price-${variantProductID} > .price`).html(variation.price_html);
		if( button.length ){
			button.addClass( 'pure-wc-variation-found' ).removeClass('wc-variation-selection-needed');
			button.attr( 'data-variation_id', variation.variation_id );
			button.attr( 'data-selected_variant', JSON.stringify( data ) );
		}
		
	}

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
		} );
	}


    $(document).on('pure_wc_compare_loaded', function(){

        $(document).on('click', '.sb-cart-plus, .sb-cart-minus', function(e){
            e.preventDefault();
            var $this = $(this);
            var $closestForm = $this.closest('.cart');

            var $quantity = $closestForm.find('input[name="quantity"]').val();

            var $addToCartBtn =  $closestForm.find('.single_add_to_cart_button');

            $addToCartBtn.attr('data-quantity', $quantity);
        });

        $(document).on('keyup', 'input[name="quantity"]', function(e){
            e.preventDefault();
            var $this = $(this);
            var $closestForm = $this.closest('.cart');

            var $quantity = $this.val();

            var $addToCartBtn =  $closestForm.find('.single_add_to_cart_button');

            $addToCartBtn.attr('data-quantity', $quantity);

        });

		$(document).on('click', '.sb-cart-plus, .sb-cart-minus', function(e){
            e.preventDefault();
            var $this = $(this);
            var $closestForm = $this.closest('.cart');

            var $quantity = $closestForm.find('input[name="quantity"]').val();

            var $addToCartBtn =  $closestForm.find('.single_add_to_cart_button');

            $addToCartBtn.attr('data-quantity', $quantity);

        })

        $('.sb-ps-active').perfectScrollbar();

		$('.thumbnails').slick({
			dots:true,
			infinite:false,
            arrows: true,
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

        /**
         * Product Variation Function
         */

        $(document).on('click', '.reset_variations', function(e){
            e.preventDefault();
            var product_id = $( this ).closest('.variations_form').data('product_id');
      
            if( product_id != undefined ){
                var $thumbnails = $(`.thumbnails-${product_id}`);
                setTimeout(function() {
                    $thumbnails.slick('slickGoTo', 0);
                }, 100);
            }
        })

        $(document).on('click', '.tpwvs-swatches', function(e){
            e.preventDefault();
            var $el = $(this);
            var attributes = $el.data('attributes')
            var thisName = attributes.name
            var thisVal  = attributes.value

            $el.closest('td').find('select[name="'+thisName+'"]').val(thisVal).trigger('change');
        });

        var form_variation = $('.product-compare-wrapper').find('.variations_form');
        

		form_variation.each(function() {
			const thisForm = $( this );
          
			thisForm.wc_variation_form();
			thisForm.on( 'found_variation', function ( e, variation ) {
                
				pureUpdateSingleProductCartButtonData( thisForm, variation );
        
                if ( variation['image_id'] !== undefined ) {
                    var product_id = thisForm.data('product_id');
                    if( product_id != undefined ){
                        if ( $(`.thumbnails-${product_id} .thumbnail`).length > 1 ) {
                            var $thumb = $(`.thumbnails-${product_id} .thumbnail[data-id="${variation['image_id']}"]`);                   
                            if ($thumb.length) {
                              var pos = $(`.thumbnails-${product_id} .thumbnail`).index( $thumb );
                              var $thumbnails = $(`.thumbnails-${product_id}`);
                              
                              if ((pos >= 0) && $thumbnails.hasClass('slick-initialized')) {
                                setTimeout(function() {
                                  $thumbnails.slick('slickGoTo', pos);
                                }, 100);
                              }
                            }
                        }
                    }
                }
			})
		})

        $( document ).on('click', '.pure-wc-compare-remove-all', function(){
            $.ajax({
                type: 'GET',
                url: pure_wc_compare.ajax_url,
                data: {
                    action: 'pure_wc_compare',
                    remove: 2,
                    nonce: pure_wc_compare._nonce
                },
                beforeSend: function() {
					block( $( '#pure-wc-compare-popup' ) );
				},
				complete: function() {
					unblock( $( '#pure-wc-compare-popup' ) );
					$(this).removeClass('loading');
				},
                success:function(response){
                    $('.sb-product-compare-modal-content').html(response);
                    $(document).trigger('pure_wc_compare_loaded');
                }
            })
        });


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

        $('.remove-compare').on('click', function(e){
            e.preventDefault();

            var $this = $(this);
            var $id = $this.attr('data-product_id');
            $.ajax({
                type: 'GET',
                url: pure_wc_compare.ajax_url,
                data: {
                    action: 'pure_wc_compare',
                    product_id: $id,
                    remove: 1,
                    nonce: pure_wc_compare._nonce
                },
                beforeSend: function() {
					block( $( '#pure-wc-compare-popup' ) );
					
				},
				complete: function() {
					unblock( $( '#pure-wc-compare-popup' ) );
					$(e.target).removeClass('loading');
					
				},
                success:function(response){
                    $('.sb-product-compare-modal-content').html(response);
                    $(document).trigger('pure_wc_compare_loaded');
                }
            })
        });
	})


    $(document).on('pure_wc_ajax_loaded', function(){
        pureCompareFunction();
    });

    $(document).ready(function(){
        pureCompareFunction();
    });
    

    var pureCompareFunction = function(){
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

        $('.pure-wc-compare-btn').on('click', function(e){
            e.preventDefault();
            var $this = $(this);
            var id = $this.attr('data-id');
            $.ajax({
                type: 'GET',
                url: pure_wc_compare.ajax_url,
                data: {
                    action: 'pure_wc_compare',
                    product_id: id,
                    nonce: pure_wc_compare._nonce
                },
                beforeSend: function(){
                    $('.pure-wc-compare-loading').addClass('loading');
                    $.purewcPopup.open({
                        items: {
                            src: '#pure-wc-compare-popup', // can be a HTML string, jQuery object, or CSS selector
                            type: 'inline'
                        }
                    });
                },
                success:function(response){
                    $('.sb-product-compare-modal-content').html(response);
                    $(document).trigger('pure_wc_compare_loaded');
                },
                complete: function(){
                    $('.pure-wc-compare-loading').removeClass('loading');
                }
            })
        });

        var compBtn = document.getElementById('sbp_product_compare_btn');

        if(compBtn){
            compBtn.addEventListener('click', function() {
                if (this.className == 'on') this.classList.remove('on');
                else this.classList.add('on');
            });
        }
    }
})(jQuery)