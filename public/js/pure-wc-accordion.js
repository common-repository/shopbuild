(function ($) {
    "use strict";
    $('.sb-accordion-list').find('.sb-accordion-item.active').find('.sb-accordion-body').show();

    $('.sb-accordion-list').on('click', '.sb-accordion-header', function (e) {
      e.preventDefault();
  
      $(this).closest('.sb-accordion-item').siblings().removeClass('active').find('.sb-accordion-body').slideUp();
  
      $(this).closest('.sb-accordion-item').toggleClass('active').find('.sb-accordion-body').slideToggle();
  });
  
})(jQuery)  