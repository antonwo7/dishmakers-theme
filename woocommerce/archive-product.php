<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$settings = [
    'count' => 3,
    'category' => '',
    'sorting' => 'desc',
    'view' => 'list',
    'search_input_placeholder' => __('Search'),
    'search_all_label' => __('All'),
    'search_button_label' => __('Search'),
    'show_more_label' => __('Load more'),
];
?>

<?php get_header( 'shop' ); ?>

<?php if(is_tax('dishdifficulty')) : ?>
    <script>let __dif = <?php echo $wp_query->get_queried_object()->term_id; ?>;</script>
<?php endif; ?>

<?php if(is_tax('dishduration')) : ?>
    <script>let __dur = <?php echo $wp_query->get_queried_object()->term_id; ?>;</script>
<?php endif; ?>

<?php do_action( 'woocommerce_before_main_content' ); ?>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php do_action( 'woocommerce_archive_description' ); ?>
</header>
<?php
if ( woocommerce_product_loop() ) {

	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) : ?>

        <div class="product-term-list" id="products">
            <div class="product_area">
                <div id="products-wrapper" class="products-wrapper">

                    <?php include get_stylesheet_directory() . '/include/widgets/products/include/products-list.php'; ?>

                </div><!-- .products-wrapper -->
            </div><!-- #products -->
        </div><!-- .product_area -->
<?php
//		while ( have_posts() ) {
//			the_post();
//			$product = wc_get_product( get_the_ID() );
//
//			if ( $product && !$product->is_type( 'composite' ) ) {
//				continue;
//			}
//			/**
//			 * Hook: woocommerce_shop_loop.
//			 */
//			do_action( 'woocommerce_shop_loop' );
//
//			wc_get_template_part( 'content', 'product' );
//		}
?>
    <?php endif;

	woocommerce_product_loop_end();

	do_action( 'woocommerce_after_shop_loop' );
}

do_action( 'woocommerce_after_main_content' );

do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
