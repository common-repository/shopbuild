;(function($){
    "use strict";
    $(document).ready(function(){
        var data = $('#pure-wc-sale-notification').data('settings');
        var firstLoadingTime = data.firstLoadingTime * 1000;
        var notificationShowingTime = data.notificationShowingTime * 1000;
        var timeInterval = data.timeInterval * 1000;

        // Initial timeout for the first notification
        window.setTimeout(function(){
            var randNumber = getRandomNotificationIndex();
            showNotifications(randNumber);
            
            setTimeout(function () { 
                hideNotifications(randNumber);
            }, notificationShowingTime);

            loopNotifications();
        }, firstLoadingTime);

        // Loop to repeatedly show notifications
        function loopNotifications(){
            var interval = timeInterval + notificationShowingTime;
            setInterval(function () {
                var randNumber = getRandomNotificationIndex();
                showNotifications(randNumber);

                setTimeout(function () { 
                    hideNotifications(randNumber);
                }, notificationShowingTime);
            }, interval);
        }

        // Show notifications based on index
        function showNotifications(rand) {
            var notifications = $('.sb-notification-box');
            if (notifications.length > 0) {
                notifications.each(function(indx) {
                    if (indx === rand || notifications.length === 1) {
                        $(this).removeClass('sb-hide').addClass('sb-notification-active');
                    }
                });
            }
        }

        // Hide notifications based on index
        function hideNotifications(rand) {
            var notifications = $('.sb-notification-box');
            if (notifications.length > 0) {
                notifications.each(function(indx) {
                    if (indx === rand || notifications.length === 1) {
                        $(this).removeClass('sb-notification-active').addClass('sb-hide');
                    }
                });
            }
        }

        // Utility to get a random notification index
        function getRandomNotificationIndex() {
            var notifications = $('.sb-notification-box');
            return Math.floor(Math.random() * notifications.length);
        }

        // Handle manual close button click
        $('.sb-notification-close-btn').on('click', function(){
            $(this).closest('.sb-notification-box').removeClass('sb-notification-active').addClass('sb-hide');
        });
    });
})(jQuery);
