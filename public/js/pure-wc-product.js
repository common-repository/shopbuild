(function ($) {
  "use strict";

  window.addEventListener("DOMContentLoaded", function (){

    function product_slider($block) {

      $($block).css("display", "block");
      var settings = $($block).data("settings");
      if(undefined != settings && settings.hasOwnProperty('pure_slider_gap')){
        var gap = settings['pure_slider_gap'];
  
        $($block).css({
          "margin-left": -gap + "px",
          "margin-right": -gap + "px",
        })
  

        $block.find('.pure-wc-slider-item, .sb-product-item.slick-slide').css({
          "margin-left": gap + "px",
          "margin-right": gap + "px",
        })
      }
  
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
        var pause_on_hover = settings["pure_slider_pause_on_hover"];
        var display_columns = parseInt(settings["pure_slider_slides_to_show"]) || 4;
        var scroll_columns = parseInt(settings["pure_slider_slides_to_scroll"]) || 4;
  
    
        // responsive controls
  
        // destop settings
        var desktop_width = parseInt(settings["desktop_width"]) || 1200;
        var desktop_display_columns = parseInt(settings["desktop_slides_to_show"]) || 4;
        var desktop_scroll_columns = parseInt(settings["desktop_slides_to_scroll"]) || 4;
  
  
        // tablet settings
        var tablet_width = parseInt(settings["tablet_width"]) || 992;
        var tablet_display_columns = parseInt(settings["tablet_slides_to_show"]) || 3;
        var tablet_scroll_columns = parseInt(settings["tablet_slides_to_scroll"]) || 3;
  
        // mobile settings
        var medium_width = parseInt(settings["medium_width"]) || 768;
        var medium_display_columns = parseInt(settings["medium_slides_to_show"]) || 2;
        var medium_scroll_columns = parseInt(settings["medium_slides_to_scroll"]) || 2;
  
        // smaill settings
        var small_width = parseInt(settings["small_width"]) || 576;
        var small_display_columns = parseInt(settings["small_slides_to_show"]) || 2;
        var small_scroll_columns = parseInt(settings["small_slides_to_scroll"]) || 2;
  
        // mobile settings
        var mobile_width = parseInt(settings["mobile_width"]) || 0;
        var mobile_display_columns = parseInt(settings["mobile_slides_to_show"]) || 1;
        var mobile_scroll_columns = parseInt(settings["mobile_slides_to_scroll"]) || 1;
  


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
            pauseOnHover: pause_on_hover,
            slidesToShow: display_columns,
            slidesToScroll: scroll_columns,
            centerMode: center_mode,
            centerPadding: center_padding,
            responsive: [
              {
                breakpoint: desktop_width,
                settings: {
                  slidesToShow: desktop_display_columns,
                  slidesToScroll: desktop_scroll_columns,
                },
              },
              {
                breakpoint: tablet_width,
                settings: {
                  slidesToShow: tablet_display_columns,
                  slidesToScroll: tablet_scroll_columns,
                },
              },
              {
                breakpoint: medium_width,
                settings: {
                  slidesToShow: medium_display_columns,
                  slidesToScroll: medium_scroll_columns,
                },
              },
              {
                breakpoint: small_width,
                settings: {
                  slidesToShow: small_display_columns,
                  slidesToScroll: small_scroll_columns,
                },
              },
              {
                breakpoint: mobile_width,
                settings: {
                  slidesToShow: mobile_display_columns,
                  slidesToScroll: mobile_scroll_columns,
                },
              },
            ],
          });
      }
    }
  
    function pure_wc_product(){
      $(".pure-product-slider-active, .sb-order-recommendation-slider-active").each(function () {
        product_slider($(this));
      });
    }
    
  
    function pure_wc_testimonial(){
      $(".sb-testimonial-slider-active").each(function () {
        product_slider($(this));
      });
    }
    

  
    function pure_wc_category(){
  
      $('.sb-grid-cols-gap').each(function(){
        var gap = $(this).data('gap');
  
        var horizontal = gap['pure_wc_category_gap_horizontal'];
        var vertical = gap['pure_wc_category_gap_vertical'];
  
        $(this).find('.sb-grid-row').css({
          'margin-left': -horizontal + 'px',
          'margin-right': -horizontal + 'px',
          'margin-top': -vertical + 'px',
          'margin-bottom': -vertical + 'px'
        });
  
        $(this).find('.sb-grid-row [class*="col-"]').css({
          'padding-left': horizontal + 'px',
          'padding-right': horizontal + 'px',
          'padding-top': vertical + 'px',
          'padding-bottom': vertical + 'px'
        })
      });
  
  
      $("[data-width").each(function () {
        var width = $(this).data("width");
        $(this).css("width", width + "px");
      });
      $("[data-height").each(function () {
        var height = $(this).data("height");
        $(this).css("height", height + "px");
      });
    }
   
  
  
    function pure_wc_brand(){
      $('.sb-grid-cols-gap').each(function(){
        var gap = $(this).data('gap');
  
       
        var horizontal = gap['pure_wc_brand_gap_horizontal'];
        var vertical = gap['pure_wc_brand_gap_vertical'];
        console.log(horizontal, vertical)
        $(this).find('.sb-grid-row').css({
          'margin-left': -horizontal + 'px',
          'margin-right': -horizontal + 'px',
          'margin-top': -vertical + 'px',
          'margin-bottom': -vertical + 'px'
        });
  
        $(this).find('.sb-grid-row [class*="col-"]').css({
          'padding-left': horizontal + 'px',
          'padding-right': horizontal + 'px',
          'padding-top': vertical + 'px',
          'padding-bottom': vertical + 'px'
        })
      });
  
      $(".sb-brand-slider-active").each(function () {
        product_slider($(this));
      });
  
    }
   
  
  
    function pure_wc_comparison(){
      $(".pure-wc-comparison-slider-active").each(function () {
        var settings = $(this).data("settings");
        var show_text = settings["pure_wc_comparison_show_text"] == false ? false : true;
          $(this).pureWcComparison({
                mode: "drag",
                showText: show_text,
                seperatorWidth: settings["pure_wc_comparison_separator_width"]+"px" || 4,
                seperatorOpacity: 1,
                autoSliding: settings["pure_wc_comparison_auto_sliding"] || false,
                autoSlidingStopOnHover: settings["pure_wc_comparison_auto_sliding_stop_on_hover"] || true,
                beforeText: settings["pure_wc_comparison_before_text"] || "Before",
                beforeTextPosition: settings["pure_wc_comparison_before_position"] || "top-left",
                afterText: settings["pure_wc_comparison_after_text"] || "After",
                afterTextPosition: settings["pure_wc_comparison_after_position"] || "bottom-right",
          });
      })
    }

  
  
    $(window).on("elementor/frontend/init", function () {
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/product-slider.default",pure_wc_product
      );
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/order-recommendation.default",pure_wc_product
      );
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/pure-testimonial.default",pure_wc_testimonial
      );
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/pure-categories.default",pure_wc_category
      );
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/pure-brand.default",pure_wc_brand
      );
      elementorFrontend.hooks.addAction(
        "frontend/element_ready/pure-comparsion-slider.default",pure_wc_comparison
      );
  
    });
  
  
    $('.sb-copy-btn span').on('click', function(){
      var buttonText = $(this).text();
      $(this).text("Copied!")
      navigator.clipboard.writeText(buttonText);
  
    })

    new PureCounter();
    new PureCounter({
      filesizing: true,
      selector: ".filesizecount",
      pulse: 2,
    });
    

  })

})(jQuery)