/* Javascript */

$wooco_wrap = jQuery( '.product.product-type-composite' );

function wooco_calc_price() {
    var $wooco_components = $wooco_wrap.find('.wooco-components');
    var $wooco_total = $wooco_wrap.find('.wooco-total');
    var total = 0;

    if ((
        $wooco_components.attr('data-pricing') === 'only'
    ) && (
        $wooco_components.attr('data-price') !== ''
    )) {
        total = Number($wooco_components.attr('data-price'));
    } else {
        // calc price
        $wooco_components.find('.wooco_component_product').each(function () {
            var _this = jQuery(this);

            if ((
                _this.attr('data-price') > 0
            ) && (
                _this.attr('data-qty') > 0
            )) {
                total += Number(_this.attr('data-price')) * Number(_this.attr('data-qty'));
            }
        });

        // discount
        if ((
            $wooco_components.attr('data-percent') > 0
        ) && (
            $wooco_components.attr('data-percent') < 100
        )) {
            total = total * (
                100 - Number($wooco_components.attr('data-percent'))
            ) / 100;
        }

        if ($wooco_components.attr('data-pricing') === 'include') {
            total += Number($wooco_components.attr('data-price'));
        }
    }

    var total_html = '<span class="woocommerce-Price-amount amount">';
    var total_formatted = wooco_format_money(total, wooco_vars.price_decimals, '', wooco_vars.price_thousand_separator, wooco_vars.price_decimal_separator);

    switch (wooco_vars.price_format) {
        case '%1$s%2$s':
            //left
            total_html += '<span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span>' + total_formatted;
            break;
        case '%1$s %2$s':
            //left with space
            total_html += '<span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span> ' + total_formatted;
            break;
        case '%2$s%1$s':
            //right
            total_html += total_formatted + '<span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span>';
            break;
        case '%2$s %1$s':
            //right with space
            total_html += total_formatted + ' <span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span>';
            break;
        default:
            //default
            total_html += '<span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span> ' + total_formatted;
    }

    total_html += '</span>';

    if ((
        $wooco_components.attr('data-pricing') !== 'only'
    ) && (
        parseFloat($wooco_components.attr('data-percent')) > 0
    ) && (
        parseFloat($wooco_components.attr('data-percent')) < 100
    )) {
        total_html += ' <small class="woocommerce-price-suffix">' + wooco_vars.saved_text.replace('[d]', wooco_round(parseFloat($wooco_components.attr('data-percent'))) + '%') + '</small>';
    }

    if ( jQuery( 'select.qty' , $wooco_wrap ).val() > 1 ) {

    	total_html = '<span class="woocommerce-Price-amount amount">';
    	total_unformatted = total * jQuery( 'select.qty' , $wooco_wrap ).val();
    	total_formatted = wooco_format_money( total_unformatted , wooco_vars.price_decimals, '', wooco_vars.price_thousand_separator, wooco_vars.price_decimal_separator);

	    switch (wooco_vars.price_format) {
	        case '%1$s%2$s':
	            //left
	            total_html += '<span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span>' + total_formatted;
	            break;
	        case '%1$s %2$s':
	            //left with space
	            total_html += '<span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span> ' + total_formatted;
	            break;
	        case '%2$s%1$s':
	            //right
	            total_html += total_formatted + '<span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span>';
	            break;
	        case '%2$s %1$s':
	            //right with space
	            total_html += total_formatted + ' <span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span>';
	            break;
	        default:
	            //default
	            total_html += '<span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span> ' + total_formatted;
	    }


    	total_html = '<del>' + total_html + '</del>';
    	total_discounted = ( total_unformatted - ( child_vars.four_persons_discount * total_unformatted ) / 100 );

   	 	total_discounted = wooco_format_money(total_discounted, wooco_vars.price_decimals, '', wooco_vars.price_thousand_separator, wooco_vars.price_decimal_separator);

		total_html += '  <span class="woocommerce-Price-currencySymbol">' + wooco_vars.currency_symbol + '</span>' + total_discounted;

		//child_vars
    }

    $wooco_total.html(wooco_vars.total_text + ' ' + total_html).slideDown();

    if (wooco_vars.change_price !== 'no') {
        // change the main price
        var price_selector = '.summary > .price';

        if ((wooco_vars.price_selector !== null) &&
            (wooco_vars.price_selector !== '')) {
            price_selector = wooco_vars.price_selector;
        }

        $wooco_wrap.find(price_selector).html(total_html);
    }

    jQuery(document).trigger('wooco_calc_price', [total, total_formatted, total_html]);
}

jQuery( 'select.qty' , $wooco_wrap ).on('input' , function(e) {
	wooco_calc_price();
})