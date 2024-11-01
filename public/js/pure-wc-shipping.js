;(function($){
    "use strict";
    $(document).ready(function(){
        function pure_wc_free_shipping_calculator(){
            $('.shipping_method').each(function(indx, el){
                $(el).on('change', function(e){
                    pure_wc_calculate_shipping(this);
                })

                if($(el).prop('checked') && $(el).val().includes('free_shipping')){
                    pure_wc_calculate_shipping(el);
                }
            })
        }

        function pure_wc_calculate_shipping( el ){
            
            if($(el).val().includes('free_shipping')){
                var getFreeShippingID = $(el).val().split(':')[1];
                
                $.ajax({
                    url: pure_wc_shipping.ajax_url,
                    method:'GET',
                    data:{
                        action:'pure_wc_free_shipping',
                        security: pure_wc_shipping.nonce,
                        free_shipping_id: getFreeShippingID
                    },
                    beforeSend: function(){
                        block($('#pure_wc_free_shipping_progress'));
                    },
                    success:function(res){
                        $('#pure_wc_free_shipping_progress').html(res);
                        console.log(res);
                    },
                    complete:function(){
                        unblock($('#pure_wc_free_shipping_progress'));
                    }
                })
            }
        }
        $(document).on('updated_shipping_method', function(){
            pure_wc_free_shipping_calculator();
        });
        $(document).on('updated_wc_div', function(){
            $.ajax({
                url: pure_wc_shipping.ajax_url,
                method:'GET',
                data:{
                    action:'pure_wc_free_shipping',
                    security: pure_wc_shipping.nonce,
                },
                beforeSend: function(){
                    block($('#pure_wc_free_shipping_progress'));
                },
                success:function(res){
                    $('#pure_wc_free_shipping_progress').html(res);
                    console.log(res);
                },
                complete:function(){
                    unblock($('#pure_wc_free_shipping_progress'));
                }
            })
        })
        
        pure_wc_free_shipping_calculator();
        /**
         * Check if a node is blocked for processing.
         *
         * @param {JQuery Object} $node
         * @return {bool} True if the DOM Element is UI Blocked, false if not.
         */
        var is_blocked = function( $node ) {
            return $node.is( '.processing' ) || $node.parents( '.processing' ).length;
        };

        /**
         * Block a node visually for processing.
         *
         * @param {JQuery Object} $node
         */
        var block = function( $node ) {
            if ( ! is_blocked( $node ) ) {
                $node.addClass( 'processing' ).block( {
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                } );
            }
        };

        /**
         * Unblock a node after processing is complete.
         *
         * @param {JQuery Object} $node
         */
        var unblock = function( $node ) {
            $node.removeClass( 'processing' ).unblock();
        };
    });
})(jQuery);