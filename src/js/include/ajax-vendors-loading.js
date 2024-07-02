(function() {

    let end = false;
    let loading_in_process = false;

    function getAjaxVendors(list, loading, page, count, type, cat, tag, sort, search, exclude) {

        loading_in_process = true;
        loading.addClass('loading');

        let form_data = [];
        let vendors_html = '';

        form_data.push({name: 'page', value: page});
        form_data.push({name: 'count', value: count});
        form_data.push({name: 'type', value: type});
        form_data.push({name: 'cat', value: cat});
        form_data.push({name: 'tag', value: tag});
        form_data.push({name: 'sort', value: sort});
        form_data.push({name: 'search', value: search});
        form_data.push({name: 'exclude', value: exclude});
        form_data.push({name: 'action', value: 'vendors_loading'});

        $.ajax({
            type: 'post',
            url: sapc_CHECKER.ajaxurl,
            dataType: 'json',
            data: form_data,
            beforeSend: function () {
            },
            success: function (response) {
                $(list).append(response.html);
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

    jQuery(document).ready(function ($) {

        $('#button-vendors-loading').click(function (e) {
            e.preventDefault();

            if (end) return;
            if (loading_in_process) return;

            const list = $('#ajax-content');
            if (!list.length) return;

            const loading = $(this);
            let number_per_page = 3;

            let items = list.find('.vendor-item').length;

            let current_page = items / number_per_page;
            current_page = current_page % 1 > 0 ? current_page + 1 : current_page;

            let exclude_ids = [];

            if(__type === 'all') {
                list.find('.vendor-item').each(function(){
                    exclude_ids.push( $(this).attr('data') );
                });

                current_page = 0;
            }

            getAjaxVendors(list, loading, current_page, number_per_page, __type, __cat, __tag, __sort, __search, exclude_ids.join());
        });
    });
})();
