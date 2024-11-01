;(function($){
    $(document).ready(function(){

        $(document).on('change', '.currency-switcher__dropdown__list', function(){
            var currency = $(this).val();
            window.location.href = '?currency=' + currency + '&_wpnonce=' + currency_switcher.currency_switcher_nonce;
        });
    })
})(jQuery);