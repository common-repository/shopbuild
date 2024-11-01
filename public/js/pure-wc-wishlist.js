(function($){
    "use strict";


    $(document).on('pure_wc_wishlist_loaded', function(){
        pure_wc_add_wishlist();
        pure_wc_remove_wishlist();
        pure_wc_remove_wishlist_modal();
        $('.pure_wc_cart_btn').on('click', function(e){
            e.preventDefault();
        });

        $('.pure-wc-wishlist-modal-close').on('click', function(e){
            $('.pure-wc-wishlist-modal').removeClass('opened');
            $('.sb-product-wishlist-modal-bg').removeClass('opened');
        });

    })

    $(document).on('pure_wc_ajax_loaded', function(){
        pure_wc_add_wishlist();
        pure_wc_remove_wishlist();
        $('.pure_wc_cart_btn').on('click', function(e){
            e.preventDefault();
        });

        $('.pure-wc-wishlist-modal-close').on('click', function(e){
            $('.pure-wc-wishlist-modal').removeClass('opened');
            $('.sb-product-wishlist-modal-bg').removeClass('opened');
        });

    })


    $(document).ready(function(){
        pure_wc_add_wishlist();
        pure_wc_remove_wishlist();
        $('.pure_wc_cart_btn').on('click', function(e){
            e.preventDefault();
        });

    });

    $(document).on('pure_wc_wishlist_modal_loaded', function(){
        pure_wc_remove_wishlist_modal();

        $('.pure-wc-wishlist-modal-close').on('click', function(e){
            $('.pure-wc-wishlist-modal').removeClass('opened');
            $('.sb-product-wishlist-modal-bg').removeClass('opened');
        });

        $('.sb-ps-active').perfectScrollbar();
    });


    var pure_wc_add_wishlist = function(){
        $('.pure-wc-wishlist-btn').on('click', function(e){
            e.preventDefault();
            if( !$(this).hasClass('added') ){
                
                var $product_id = $(this).data('id');
                var $this = $(this);
                $.ajax({
                    type:'GET',
                    url: pure_wc_wishlist.ajax_url,
                    data:{
                        action: pure_wc_wishlist.action,
                        product_id: $product_id,
                        nonce: pure_wc_wishlist._nonce
                    },
                    beforeSend: function(){
                        $this.addClass('loading');
                        $('.sb-product-wishlist-modal-bg').addClass('opened');
                        $('.pure-wc-wishlist-modal').addClass('loading');
                        $('.pure-wc-wishlist-modal').addClass('opened');
                    },
                    success:function(response){
                        var res = JSON.parse(response);
                        if( "exists"  in res ){
                            $('#pure-wc-wishlist-modal .pure-wc-wishlist-modal-content').html(res.body);
                        }else{
                            $('#pure-wc-wishlist-modal .pure-wc-wishlist-modal-content').html(res.body);
                            $this.addClass('added');
                            $this.html(pure_wc_wishlist.wishlist_added);
                        }
                    },
                    complete: function(){
                        $this.removeClass('loading');
                        $(document).trigger('pure_wc_wishlist_modal_loaded');
                        $('.pure-wc-wishlist-modal').removeClass('loading');
                    },
                })
                
            }
        });
    }

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

    var pure_wc_remove_wishlist = function(){
        $('.remove-wishlist-btn').on('click', function(e){
            e.preventDefault();
            var $product_id = $(this).data('id');
            $.ajax({
                type:'GET',
                url: pure_wc_wishlist.ajax_url,
                data:{
                    action: 'pure_wc_remove_wishlist',
                    product_id: $product_id,
                    nonce: pure_wc_wishlist._nonce
                },
                beforeSend: function() {
					block( $( '.pure-wc-wishlist-table' ) );
				},
				complete: function() {
					unblock( $( '.pure-wc-wishlist-table' ) );
				},
                success:function(response){
                    $('.pure-wc-wishlist-table').html(response);
                    $(document).trigger('pure_wc_wishlist_loaded');
                }
            })
        });
    }

    var pure_wc_remove_wishlist_modal = function(){
        $('.remove-wishlist-btn-modal').on('click', function(e){
            e.preventDefault();
            var $product_id = $(this).data('id');
            $.ajax({
                type:'GET',
                url: pure_wc_wishlist.ajax_url,
                data:{
                    action: pure_wc_wishlist.action,
                    remove: 1,
                    product_id: $product_id,
                    nonce: pure_wc_wishlist._nonce
                },
                beforeSend: function() {
					block( $( '.pure-wc-wishlist-table' ) );
				},
				complete: function() {
					unblock( $( '.pure-wc-wishlist-table' ) );
				},
                success:function(response){
                    var res = JSON.parse(response);
                    $('.pure-wc-wishlist-modal-content').html(res.body);
                    $(document).trigger('pure_wc_wishlist_modal_loaded');
                    $(`.pure-wc-wishlist-btn[data-id="${$product_id}"]` ).removeClass('added');
                }
            })
        });
    }

})(jQuery)