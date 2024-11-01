/*!
 * Cndk.BeforeAfter.js v 0.0.2 (https://github.com/ilkerccom/pure-wc-comparison)
 * Ilker Cindik
 * Licensed under the MIT license
 */
(function ($) {
    "use strict";
  
    $.fn.pureWcComparison = function(options) {

        // Default settings
        var settings = $.extend({
            mode: "hover", /* hover,drag */
            showText: true,
            beforeText: "Before",
            beforeTextPosition: "bottom-left", /* top-left, top-right, bottom-left, bottom-right */
            afterText: "After",
            afterTextPosition: "bottom-right", /* top-left, top-right, bottom-left, bottom-right */
            seperatorWidth: "4px",
            seperatorOpacity: "0.8",
            theme: "light", /* light,dark  */
            autoSliding: false,
            autoSlidingStopOnHover: true,
            hoverEffect: true,
            enterAnimation: false,
            dragIcon: `<svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 17V1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M13 17V1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M7 17V1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>`,
        }, options);

        // This
        var element = this;

        // Wait for image(s) loading
        var img = new Image();
        img.src = $(this).find(">div").eq(0).find('div[data-type="before"] img').attr("src"); 
        img.onload = function() {
            runCndkBeforeAfter(element);
        };

        // Run Plugin
        function runCndkBeforeAfter(element)
        {
            element.each(function() { 

                // Get contents
                var count = $(this).find(">div>div").length;
                if(count <= 1)
                {
                    // No images
                    console.log("(cndk.beforeafter.js) Error -> No before-after images found.");
                }

                // Add theme class
                element.addClass("pure-wc-comparison-theme-"+settings.theme);

                // Continue
                var root = $(this);
                root.addClass("pure-wc-comparison pure-wc-comparison-root");
                root.append("<div class='pure-wc-comparison-seperator' style='width:"+settings.seperatorWidth+";opacity:"+settings.seperatorOpacity+"'></div>");

                // Container
                root.append("<div class='pure-wc-comparison-container'></div>");

                // Hover Effect
                if(settings.hoverEffect == true)
                {
                    root.addClass("pure-wc-comparison-hover");
                }

                // Before-After text
                if(settings.showText == true)
                {
                    var dataBeforeTitle = $(this).find(">div").eq(0).find('div[data-type="before"]').attr("data-title") == undefined ? settings.beforeText : $(this).find(">div").eq(0).find('div[data-type="before"]').attr("data-title");
                    var dataAfterTitle = $(this).find(">div").eq(0).find('div[data-type="after"]').attr("data-title") == undefined ? settings.afterText : $(this).find(">div").eq(0).find('div[data-type="after"]').attr("data-title");
                    root.append("<div class='pure-wc-comparison-item-before-text pure-wc-comparison-"+settings.beforeTextPosition+"'>"+dataBeforeTitle+"</div>");
                    root.append("<div class='pure-wc-comparison-item-after-text pure-wc-comparison-"+settings.afterTextPosition+"'>"+dataAfterTitle+"</div>");
                }

                for(var i=0; i<count; i++)
                {
                    // Before
                    var div1 = $(this).find(">div").eq(i).find('div[data-type="before"]');
                    var img1 = $(this).find(">div").eq(i).find('div[data-type="before"] img');
                    img1.addClass("pure-wc-comparison-item-before");
                    div1.addClass("pure-wc-comparison-item-before-c");
                    div1.css("overflow","hidden");
                    div1.css("z-index","2");

                    // After
                    var div2 = $(this).find(">div").eq(i).find('div[data-type="after"]');
                    var img2 = $(this).find(">div").eq(i).find('div[data-type="after"] img');
                    img2.addClass("pure-wc-comparison-item-after");
                    div2.addClass("pure-wc-comparison-item-after-c");
                    div2.css("z-index","1");

                    // Image-Item width/height
                    var itemwidth = img1.width();
                    var itemheight = img1.height();

                    // Screen width
                    var screenWidth = $(this).parent().width();
                    if(screenWidth < itemwidth)
                    {
                        itemheight = itemheight/(itemwidth/screenWidth);
                        itemwidth = screenWidth;
                        img1.css("width", itemwidth + "px");
                        img2.css("width", itemwidth + "px");
                    }

                    // Item
                    $(this).find(">div").eq(0).addClass("pure-wc-comparison-item");
                    $(this).find(">div").eq(0).css("height",itemheight + "px");

                    // Small Before-After text
                    if(itemwidth < 200)
                    {
                        $(this).find(".pure-wc-comparison-item-after-text").addClass("pure-wc-comparison-extra-small-text pure-wc-comparison-extra-small-text-after");
                        $(this).find(".pure-wc-comparison-item-before-text").addClass("pure-wc-comparison-extra-small-text pure-wc-comparison-extra-small-text-before");
                    }

                    // Start position
                    div1.css("width","50%");
                    div2.css("width","50%");
                    $(".pure-wc-comparison-seperator").css("left","50%");

                    // Root inline
                    root.css("width",itemwidth + "px");
                    root.css("height",itemheight + "px");
                }

                // Modes
                if(settings.mode == "hover")
                {
                    // Hover mode
                    $(root).find(".pure-wc-comparison-seperator, .pure-wc-comparison-item > div").addClass("pure-wc-comparison-hover-transition");
                    $(root).on('mousemove', function(e){
                        var parentOffset = $(this).offset();
                        var mouseX = parseInt((e.pageX - parentOffset.left));
                        var mousePercent = (mouseX*100)/parseInt(root.width());
                        $(this).find(".pure-wc-comparison-item-before-c").css("width",mousePercent+"%");
                        $(this).find(".pure-wc-comparison-item-after-c").css("width",(100-mousePercent)+"%");
                        $(this).find(".pure-wc-comparison-seperator").css("left",mousePercent+"%");
                    }).on("mouseleave",function(){
                        $(this).find(".pure-wc-comparison-item-after-c").css("width","50%");
                        $(this).find(".pure-wc-comparison-item-before-c").css("width","50%");
                        $(this).find(".pure-wc-comparison-seperator").css("left","50%");
                    });
                }
                else if(settings.mode == "drag")
                {
                    // Drag mode
                    $(root).find(".pure-wc-comparison-seperator, .pure-wc-comparison-item > div").addClass("pure-wc-comparison-drag-transition");
                    $(root).on("click", function(e){
                        var parentOffset = $(this).offset();
                        var mouseX = parseInt((e.pageX - parentOffset.left));
                        var mousePercent = (mouseX*100)/parseInt(root.width());
                        $(this).find(".pure-wc-comparison-item-before-c").css("width",mousePercent+"%");
                        $(this).find(".pure-wc-comparison-item-after-c").css("width",(100-mousePercent)+"%");
                        $(this).find(".pure-wc-comparison-seperator").css("left",mousePercent+"%");
                    });

                    // Draggable seperator
                    var isSliding = false;
                    var currentElement = (root);
                    currentElement.find(".pure-wc-comparison-seperator").on("mousedown",function(e){
                        isSliding = true;
                        currentElement.find(".pure-wc-comparison-seperator, .pure-wc-comparison-item > div").removeClass("pure-wc-comparison-drag-transition");
                        currentElement.on("mousemove", function(e){
                            if(isSliding) {
                                var parentOffset = currentElement.offset();
                                var mouseX = parseInt((e.pageX - parentOffset.left));
                                var mousePercent = (mouseX*100)/parseInt(root.width());
                                currentElement.find(".pure-wc-comparison-item-before-c").css("width",mousePercent+"%");
                                currentElement.find(".pure-wc-comparison-item-after-c").css("width",(100-mousePercent)+"%");
                                currentElement.find(".pure-wc-comparison-seperator").css("left",mousePercent+"%");
                            }
                        });
                    });

                    // Release
                    currentElement.find(".pure-wc-comparison-seperator").on("mouseup",function(e){
                        isSliding = false;
                        currentElement.find(".pure-wc-comparison-seperator, .pure-wc-comparison-item > div").addClass("pure-wc-comparison-drag-transition");
                    });

                    // Mobile touch-support
                    currentElement.find(".pure-wc-comparison-seperator").on("touchstart",function(e){
                        isSliding = true;
                        currentElement.find(".pure-wc-comparison-seperator, .pure-wc-comparison-item > div").removeClass("pure-wc-comparison-drag-transition");
                        currentElement.on("touchmove",function(e){
                            var parentOffset = currentElement.offset();
                            var mouseX = parseInt((e.originalEvent.touches[0].pageX - parentOffset.left));
                            var mousePercent = (mouseX*100)/parseInt(root.width());
                            currentElement.find(".pure-wc-comparison-item-before-c").css("width",mousePercent+"%");
                            currentElement.find(".pure-wc-comparison-item-after-c").css("width",(100-mousePercent)+"%");
                            currentElement.find(".pure-wc-comparison-seperator").css("left",mousePercent+"%");
                        });
                    });

                    // Add visual to seperator
                    currentElement.find(".pure-wc-comparison-seperator").append(`<div><span><i class="drag-icon">${settings.dragIcon}</i></span></div>`);
                }

                // Start Animation
                if(settings.enterAnimation)
                {
                    $(this).addClass("pure-wc-comparison-animation");
                }

                // Auto-Sliding
                if(settings.autoSliding)
                {
                    $(this).attr("auto-sliding","true");
                    $(this).find(".pure-wc-comparison-item-before-c").addClass("pure-wc-comparison-animation-item-1");
                    $(this).find(".pure-wc-comparison-item-after-c").addClass("pure-wc-comparison-animation-item-2");
                    $(this).find(".pure-wc-comparison-seperator").addClass("pure-wc-comparison-animation-seperator");

                    if(settings.autoSlidingStopOnHover)
                    {
                        // Stop On Enter
                        $(this).on("mouseenter", function(){
                            $(this).find(".pure-wc-comparison-item-before-c").removeClass("pure-wc-comparison-animation-item-1");
                            $(this).find(".pure-wc-comparison-item-after-c").removeClass("pure-wc-comparison-animation-item-2");
                            $(this).find(".pure-wc-comparison-seperator").removeClass("pure-wc-comparison-animation-seperator");
                        })

                        // Start On Exit
                        $(this).on("mouseleave", function(){
                            $(this).find(".pure-wc-comparison-item-before-c").addClass("pure-wc-comparison-animation-item-1");
                            $(this).find(".pure-wc-comparison-item-after-c").addClass("pure-wc-comparison-animation-item-2");
                            $(this).find(".pure-wc-comparison-seperator").addClass("pure-wc-comparison-animation-seperator");
                        })
                    }
                }
            });
        }
    };
})(jQuery)