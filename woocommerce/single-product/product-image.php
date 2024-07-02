<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<figure class="woocommerce-product-gallery__wrapper">
		<?php
		/*if ( $product->get_image_id() ) {
			$small_video    = get_post_meta( $product->get_id(), 'small_video', true );


			if ( $small_video != "" ) {
				$small_video_url = wp_get_attachment_url( $small_video );
				$small_video_thumbnail_url = wp_get_attachment_url( $product->get_image_id() );

				$gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
				$thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
				$full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
				$thumbnail_src     = wp_get_attachment_image_src( $product->get_image_id(), $thumbnail_size );
				$full_src          = wp_get_attachment_image_src( $product->get_image_id(), $full_size );
				$alt_text          = trim( wp_strip_all_tags( get_post_meta( $product->get_image_id(), '_wp_attachment_image_alt', true ) ) );


				$html = '<div data-thumb="'. $thumbnail_src[0]  .'" data-thumb-alt="'. $alt_text .'" class="woocommerce-product-gallery__image">' . do_shortcode( '[video mp4="'. $small_video_url .'"]', false ) . '</div>';

			} else {
				$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
			}
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}
		*/

		//echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
		?>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/3.0.5/shaka-player.ui.min.js"></script>
	    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/3.0.5/controls.min.css">
	    <script defer src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js"></script>
	    <script type="text/javascript">const manifestUri="<?php echo content_url(); ?>/shaka-player/1/video2.mpd";async function init(){const e=document.getElementById("video").ui;e.configure({overflowMenuButtons:["quality", "picture_in_picture", "cast", "playback_rate"]});const o=e.getControls(),r=o.getPlayer();window.player=r,window.ui=e,r.addEventListener("error",onPlayerErrorEvent),o.addEventListener("error",onUIErrorEvent);try{await r.load(manifestUri),console.log("The video has now been loaded!")}catch(e){onPlayerError(e)}}function onPlayerErrorEvent(e){onPlayerError(event.detail)}function onPlayerError(e){console.error("Error code",e.code,"object",e)}function onUIErrorEvent(e){onPlayerError(event.detail)}function initFailed(e){console.error("Unable to load the UI library!")}document.addEventListener("shaka-ui-loaded",init),document.addEventListener("shaka-ui-load-failed",initFailed); </script>

			<div data-shaka-player-container style="max-width:40em" data-shaka-player-cast-receiver-id="7B25EC44">
				<video autoplay data-shaka-player id="video" style="width:100%;height:100%"></video>
			</div>


		<?php		
		do_action( 'woocommerce_product_thumbnails' );
		?>
	</figure>
</div>
