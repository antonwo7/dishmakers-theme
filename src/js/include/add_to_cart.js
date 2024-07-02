(function($) {
    jQuery(document).ready(function () {

        $(document).on( 'added_to_cart', function( e, fragments, cart_hash, this_button ) {
            $('.ajax_add_to_cart').each(function(){
                $(this).html(
                    $(this)
                        .html()
                        .replace(/(<([^>]+)>)/ig,"")
                )
            });
        } );

        $('.ajax_add_to_cart').click(function(){
            $(this).append('<div class="icon"><div></div><div></div><div></div><div></div></div>');
        });
    });

})(jQuery);

