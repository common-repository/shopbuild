;(function($){
    "use strict";

    // Intercept click event on locked widgets
    console.log('Pure WC ShopBuild Elementor Admin JS loaded');

    $(document).on('click', '.elementor-widget-locked', function(e) {
        e.preventDefault();

        // Check if inside the Elementor editor
        if (window.elementor && window.elementor.editor) {
            // Create the modal popup content
            var modalContent = '<div class="elementor-pro-modal">' +
                '<h3>' + elementor.translate( 'This is a Pro Widget' ) + '</h3>' +
                '<p>' + elementor.translate( 'Upgrade to Elementor Pro to unlock this widget.' ) + '</p>' +
                '<a href="https://your-upgrade-link.com" target="_blank" class="elementor-button elementor-button-success">' + 
                    elementor.translate( 'Upgrade Now' ) + 
                '</a>' +
            '</div>';

            // Show modal popup using Elementor's modal API
            elementor.dialogsManager.createWidgetModal({
                message: modalContent,
                type: 'info',
                title: elementor.translate( 'Pro Widget' )
            }).show();
        }
    });

    // Ensure Elementor has fully loaded
    elementor.on('panel:init', function() {
        // Add 'locked' visual indicator and prevent dragging for the locked widget
        elementor.hooks.addAction('panel/open_editor/widget', function(panel, model, view) {
            console.log(view);
            var isLocked = view.$el.hasClass('elementor-widget-locked');

            if (isLocked) {
                // Disable dragging
                view.$el.draggable('disable');
                view.$el.addClass('no-drag');
            }
        });

        // Block widget from being inserted into the canvas
        $(document).on('mousedown', '.elementor-widget-locked', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            alert('This widget is only available in the Pro version.');
            return false; // Prevent the widget from being dragged
        });
    });
})( jQuery )