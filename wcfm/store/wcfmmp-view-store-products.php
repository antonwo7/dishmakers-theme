<?php
/**
 * The Template for displaying all store products.
 *
 * @package WCfM Markeplace Views Store/products
 *
 * For edit coping this to yourtheme/wcfm/store 
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $WCFM, $WCFMmp, $avia_config;

$counter = 0;

wc_set_loop_prop( 'is_filtered', true );

// Enfold Theme Compatibility
if( $avia_config && is_array( $avia_config ) ) {
	$avia_config['overview'] = true;
}

$settings = [
    'count' => 3,
    'category' => '',
    'sorting' => 'desc',
    'view' => 'list',
    'search_input_placeholder' => __('Search'),
    'search_all_label' => __('All'),
    'search_button_label' => __('Search'),
    'vendor_id' => $store_user->get_id(),
    'show_more_label' => __('Load more'),
];
?>

<?php do_action( 'wcfmmp_store_before_products', $store_user->get_id() ); ?>

<div class="" id="products">
	<div class="product_area">
	    <div id="products-wrapper" class="products-wrapper">
            <script>let __vendorid = <?php echo $store_user->get_id(); ?>;</script>

            <?php include get_stylesheet_directory() . '/include/widgets/products/include/products-list.php'; ?>
			
        </div><!-- .products-wrapper -->
	</div><!-- #products -->
</div><!-- .product_area -->

<?php do_action( 'wcfmmp_store_after_products', $store_user->get_id() ); ?>
