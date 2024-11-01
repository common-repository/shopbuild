(function ($) {
    "use strict";

    function pure_hero_slider($block) {
        $($block).css("display", "block");
        var settings = $($block).data("settings");
    
        if (settings) {
          var arrows = settings["pure_slider_arrow"] || false;
          var prevArrowIcon = settings["pure_slider_arrow_prev_icon"] || `<svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M1.00073 6.99989L15 6.99989" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M6.64648 1.5L1.00011 6.99954L6.64648 12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
          var nextArrowIcon = settings["pure_slider_arrow_next_icon"] || `<svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.9993 6.99989L1 6.99989" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9.35352 1.5L14.9999 6.99954L9.35352 12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>`;
          var dots = settings["pure_slider_dots"] || false;
          var rtl = settings["pure_slider_rtl"] || false;
          var infinite = settings["pure_slider_infinite"] || false;
          var center_mode = settings["pure_slider_center_mode"] || false;
          var center_padding = settings["pure_slider_center_padding"] || "0px";
          var autoplay = settings["pure_slider_autoplay"] || false;
          var autoplay_speed = parseInt(settings["pure_slider_autoplay_speed"]) || 3000;
          var animation_speed = parseInt(settings["pure_slider_speed"]) || 300;
          var fade = settings["pure_slider_fade"] || false;

          $($block)
            .not(".slick-initialized")
            .slick({
              arrows: arrows,
              prevArrow: `<button type="button" class="slick-prev">${prevArrowIcon}</button>`,
              nextArrow: `<button type="button" class="slick-next">${nextArrowIcon}</button>`,
              dots: dots,
              infinite: infinite,
              rtl: rtl,
              autoplay: autoplay,
              autoplaySpeed: autoplay_speed,
              speed: animation_speed,
              fade: fade,
              slidesToShow: 1,
              slidesToScroll: 1,
              centerMode: center_mode,
              centerPadding: center_padding,
            });
        }
    }

    function pure_wc_slider(){
        $(".sb-slider-active").each(function () {
            pure_hero_slider($(this));
        });
      }

  $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction(
            "frontend/element_ready/pure-hero-slider.default",pure_wc_slider
        );
    });

})(jQuery)