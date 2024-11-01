;(function($){
    "use strict";
    $(document.body).on('added_to_cart', function(event, fragments, cart_hash, button){
        var $notice;
        if('div.pure_wc_cart_notification_cross_sell' in fragments){
            $notice = $('<div class="pure-wc-cart-notification-popup">'+fragments['div.pure_wc_cart_notification_cross_sell']+'</div>');
            $('.pure-wc-cart-crosssell-notification-box-wrapper').append($notice);
            setTimeout(function(){
                $notice.fadeOut(200, function(){
                    $(this).remove();
                });
            }, 600000);
        }
        if('div.pure_wc_cart_notification' in fragments){
            $notice = $('<div class="pure-wc-cart-notification-box">'+fragments['div.pure_wc_cart_notification']+'</div>');
            $('.pure-wc-cart-notification-box-wrapper').append($notice);
            setTimeout(function(){
                $notice.fadeOut(200, function(){
                    $(this).remove();
                });
            }, 4000);
        }
        $('.wc-notice').remove();
        $( document ).trigger('pure_wc_ajax_cart_notification_loaded');

        $(document).on('click', '.pure-add-to-cart-notification-cross-sell', function(event) {
            event.stopPropagation(); // Prevents the event from propagating to parent elements
        });

        $(document).on('click', '.sb-close-crosssell-popup, .pure-wc-cart-notification-popup', function(event){
            $('.pure-wc-cart-notification-popup').fadeOut(200, function(){
                $(this).remove();
            });
        });
    });

    $(document).on('pure_wc_ajax_cart_notification_loaded', function() {
        var notifications = document.querySelectorAll('.pure-wc-cart-notification-box');
        var baseBottom = 40;
        notifications.forEach(function(notification, index) {
            let bottomPosition = baseBottom;

            if(notifications.length > 1){
                bottomPosition = baseBottom + (((notifications.length - 1) - index) * 110); 
            }

            notification.style.bottom = bottomPosition + 'px';
        });
    });

})(jQuery);