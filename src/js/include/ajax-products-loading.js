(function($) {

    let end = false;
    let loading_in_process = false;

    function add_to_cart_init(){
        $('.ajax_add_to_cart').click(function(){
            $(this).append('<div class="icon"><div></div><div></div><div></div><div></div></div>');
        });
    }

    function getAjaxProducts(list, loading, page, count, vendorid, logged_user_id, type, cat, tag, dif, dur, sort, search, exclude, exclude_terms, include_terms) {

        loading_in_process = true;
        loading.addClass('loading');

        let form_data = [];

        form_data.push({name: 'page', value: page});
        form_data.push({name: 'count', value: count});
        form_data.push({name: 'vendorid', value: vendorid});
        form_data.push({name: 'logged_user_id', value: logged_user_id});
        form_data.push({name: 'type', value: type});
        form_data.push({name: 'cat', value: cat});
        form_data.push({name: 'tag', value: tag});
        form_data.push({name: 'dif', value: dif});
        form_data.push({name: 'dur', value: dur});
        form_data.push({name: 'sort', value: sort});
        form_data.push({name: 'search', value: search});
        form_data.push({name: 'exclude', value: exclude});
        form_data.push({name: 'exclude_terms', value: exclude_terms});
        form_data.push({name: 'include_terms', value: include_terms});
        form_data.push({name: 'action', value: 'products_loading'});

        $.ajax({
            type: 'post',
            url: sapc_CHECKER.ajaxurl,
            dataType: 'json',
            data: form_data,
            beforeSend: function () {
            },
            success: function (response) {
                $(list).append(response.html);
                add_to_cart_init();

                if (!response.state) {
                    loading.fadeOut();
                    end = true;
                }
            },
            error: function (response) {
                console.log(response);
            },
            complete: function () {
                loading_in_process = false;
                loading.removeClass('loading');
            }
        });
    }

    jQuery(document).ready(function () {

        $('#button-products-loading').click(function (e) {
            e.preventDefault();

            if (end) return;
            if (loading_in_process) return;

            const list = $('#ajax-content');
            if (!list.length) return;

            const loading = $(this);
            let number_per_page = 3;

            let items = list.find('.product-item').length;
            let current_page = items / number_per_page;
            current_page = current_page % 1 > 0 ? current_page + 1 : current_page;

            let exclude_ids = [];

            if(__type === 'all') {
                list.find('.product-item').each(function(){
                    exclude_ids.push( $(this).attr('data') );
                });

                current_page = 0;
            }

            let vendorid = (typeof __vendorid === 'undefined') ? 0 : __vendorid;
            let dif = (typeof __dif === 'undefined') ? '' : __dif;
            let dur = (typeof __dur === 'undefined') ? '' : __dur;
            let logged_user_id = (typeof __logged_user_id === 'undefined') ? 0 : __logged_user_id;

            let exclude_terms = $(this).attr('exclude_terms');
            let include_terms = (typeof __include_terms === 'undefined') ? '' : __include_terms;

            console.log(list, loading, current_page, number_per_page, vendorid, logged_user_id,  __type, __cat, __tag, dif, dur, __sort, __search, exclude_ids.join(), exclude_terms, include_terms);

            getAjaxProducts(list, loading, current_page, number_per_page, vendorid, logged_user_id, __type, __cat, __tag, dif, dur, __sort, __search, exclude_ids.join(), exclude_terms, include_terms);
        });
    });
})(jQuery);
