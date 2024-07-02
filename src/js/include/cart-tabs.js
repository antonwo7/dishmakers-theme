(function($){
    $(document).ready(function(){
        $('.cart-tabs .tabs-headers .tabs-header').click(function(){
            let data = $(this).attr('data');

            $(this).closest('.tabs').find('.tabs-header').removeClass('active')
            $(this).addClass('active')

            let tabs = $(this).closest('.tabs');

            let tabs_blocks = tabs.find('.tabs-blocks');
            tabs_blocks.find('.tabs-block').removeClass('active');
            console.log(data)
            tabs_blocks.find('.tabs-block[data="' + data + '"]').addClass('active')
        })
    })
})(jQuery)
