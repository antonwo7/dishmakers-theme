<?php
/**
 * WCFM plugin view
 *
 * WCFM Products Manage view
 * This template can be overridden by copying it to yourtheme/wcfm/products-manager/
 *
 * @author      WC Lovers
 * @package     wcfm/views/products-manager
 * @version   1.0.0
 */

global $wp, $WCFM, $wc_product_attributes;

$placeholder_image = plugin_dir_url( __DIR__  ). 'images/Placeholder.png';
$video_placeholder_image = plugin_dir_url( __DIR__  ). 'images/video-placeholder.png';

if ( apply_filters( 'wcfm_is_pref_restriction_check', true ) ) {
	$wcfm_is_allow_manage_products = apply_filters( 'wcfm_is_allow_manage_products', true );
	if ( !$wcfm_is_allow_manage_products ) {
		wcfm_restriction_message_show( "Products" );
		return;
	} //!$wcfm_is_allow_manage_products
} //apply_filters( 'wcfm_is_pref_restriction_check', true )

if ( isset( $wp->query_vars[ 'wcfm-products-manage' ] ) && empty( $wp->query_vars[ 'wcfm-products-manage' ] ) ) {
	if ( !apply_filters( 'wcfm_is_allow_add_products', true ) ) {
		wcfm_restriction_message_show( "Add Product" );
		return;
	} //!apply_filters( 'wcfm_is_allow_add_products', true )
	if ( !apply_filters( 'wcfm_is_allow_pm_add_products', true ) ) {
		return;
	} //!apply_filters( 'wcfm_is_allow_pm_add_products', true )
	if ( !apply_filters( 'wcfm_is_allow_product_limit', true ) ) {
		if ( WCFM_Dependencies::wcfmvm_plugin_active_check() ) {
?>
<div class="wcfm-clearfix"></div>
<br />
<div class="collapse wcfm-collapse">
	<div class="wcfm-page-headig">
		<span class="wcfmfa fa-cube"></span>
		<span class="wcfm-page-heading-text">
			<?php
			_e( 'Add Product', 'wc-frontend-manager' );
?>
		</span>
		<?php
			do_action( 'wcfm_page_heading' );
?>
	</div>
	<div class="wcfm-collapse-content wcfm-nolimit-content">
		<div class="wcfm-container">
			<div class="wcfm-clearfix"></div>
			<br />
			<h2>
				<?php
			_e( 'You have reached your product limit!', 'wc-frontend-manager' );
?>
			</h2>
			<div class="wcfm-clearfix"></div>
			<br />
			<?php
			do_action( 'wcfm_product_limit_reached' );
?>
			<div class="wcfm-clearfix"></div>
			<br />
		</div>
	</div>
</div>
<?php
		} //WCFM_Dependencies::wcfmvm_plugin_active_check()
		else {
			wcfm_restriction_message_show( "Product Limit Reached" );
		}
		return;
	} //!apply_filters( 'wcfm_is_allow_product_limit', true )
	if ( !apply_filters( 'wcfm_is_allow_space_limit', true ) ) {
		wcfm_restriction_message_show( "Space Limit Reached" );
		return;
	} //!apply_filters( 'wcfm_is_allow_space_limit', true )
} //isset( $wp->query_vars[ 'wcfm-products-manage' ] ) && empty( $wp->query_vars[ 'wcfm-products-manage' ] )
elseif ( isset( $wp->query_vars[ 'wcfm-products-manage' ] ) && !empty( $wp->query_vars[ 'wcfm-products-manage' ] ) ) {
	$wcfm_products_single = get_post( $wp->query_vars[ 'wcfm-products-manage' ] );
	if ( $wcfm_products_single->post_status == 'publish' ) {
		if ( !apply_filters( 'wcfm_is_allow_edit_products', true ) ) {
			wcfm_restriction_message_show( "Edit Product" );
			return;
		} //!apply_filters( 'wcfm_is_allow_edit_products', true )
	} //$wcfm_products_single->post_status == 'publish'
	if ( !apply_filters( 'wcfm_is_allow_edit_specific_products', true, $wcfm_products_single->ID ) ) {
		wcfm_restriction_message_show( "Edit Product" );
		return;
	} //!apply_filters( 'wcfm_is_allow_edit_specific_products', true, $wcfm_products_single->ID )
	if ( wcfm_is_vendor() ) {
		$is_product_from_vendor = $WCFM->wcfm_vendor_support->wcfm_is_product_from_vendor( $wp->query_vars[ 'wcfm-products-manage' ] );
		if ( !$is_product_from_vendor ) {
			if ( apply_filters( 'wcfm_is_show_product_restrict_message', true, $wcfm_products_single->ID ) ) {
				wcfm_restriction_message_show( "Restricted Product" );
			} //apply_filters( 'wcfm_is_show_product_restrict_message', true, $wcfm_products_single->ID )
			else {
				echo apply_filters( 'wcfm_show_custom_product_restrict_message', '', $wcfm_products_single->ID );
			}
			return;
		} //!$is_product_from_vendor
	} //wcfm_is_vendor()
} //isset( $wp->query_vars[ 'wcfm-products-manage' ] ) && !empty( $wp->query_vars[ 'wcfm-products-manage' ] )

$product_id         = 0;
$product            = array();
$product_type       = apply_filters( 'wcfm_default_product_type', '' );
$is_virtual         = '';
$title              = '';
$sku                = '';
$visibility         = 'visible';
$excerpt            = '';
$description        = '';
$regular_price      = '';
$sale_price         = '';
$sale_date_from     = '';
$sale_date_upto     = '';
$product_url        = '';
$button_text        = '';
$is_downloadable    = '';
$downloadable_files = array();
$download_limit     = '';
$download_expiry    = '';
$children           = array();

$featured_img           = '';
$gallery_img_ids        = array();
$gallery_img_urls       = array();

$small_video            = '';
$full_video             = '';

$duration            = '';
$difficulty             = '';

$categories             = array();
$product_tags           = '';
$manage_stock           = '';
$stock_qty              = 0;
$backorders             = '';
$stock_status           = '';
$sold_individually      = '';
$weight                 = '';
$length                 = '';
$width                  = '';
$height                 = '';
$shipping_class         = '';
$tax_status             = '';
$tax_class              = '';
$attributes             = array();
$default_attributes     = '';
$attributes_select_type = array();
$variations             = array();

$upsell_ids    = array();
$crosssell_ids = array();

$product_durations		= get_terms( array(	'taxonomy' => 'dishduration', 'hide_empty' => false , 'hierarchical' => false ) );

$product_difficulties	= get_terms( array( 'taxonomy' => 'dishdifficulty', 'hide_empty' => false )  );

$product_durations		= get_terms( array(    'taxonomy' => 'dishduration', 'hide_empty' => false ) );
$product_difficulties	= get_terms( array( 'taxonomy' => 'dishdifficulty', 'hide_empty' => false )  );
$_categories	= get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false )  );
$_tags	= get_terms( array( 'taxonomy' => 'product_tag', 'hide_empty' => false )  );


if ( isset( $wp->query_vars[ 'wcfm-products-manage' ] ) && !empty( $wp->query_vars[ 'wcfm-products-manage' ] ) ) {
	
	$product = wc_get_product( $wp->query_vars[ 'wcfm-products-manage' ] );
	
	if ( !is_a( $product, 'WC_Product' ) ) {
		wcfm_restriction_message_show( "Invalid Product" );
		return;
	} //!is_a( $product, 'WC_Product' )
	
	// Fetching Product Data
	if ( $product && !empty( $product ) ) {
		$product_id           = $wp->query_vars[ 'wcfm-products-manage' ];
		$wcfm_products_single = get_post( $product_id );
		$product_type         = $product->get_type();
		$title                = $product->get_title( 'edit' );
		$sku                  = $product->get_sku( 'edit' );
		//$visibility = get_post_meta( $product_id, '_visibility', true);
		$excerpt              = wpautop( $product->get_short_description( 'edit' ) );
		$description          = wpautop( $product->get_description( 'edit' ) );
		$regular_price        = $product->get_regular_price( 'edit' );
		$sale_price           = $product->get_sale_price( 'edit' );
		
		$sale_date_from = $product->get_date_on_sale_from( 'edit' ) && ( $date = $product->get_date_on_sale_from( 'edit' )->getOffsetTimestamp() ) ? date_i18n( 'Y-m-d', $date ) : '';
		$sale_date_upto = $product->get_date_on_sale_to( 'edit' ) && ( $date = $product->get_date_on_sale_to( 'edit' )->getOffsetTimestamp() ) ? date_i18n( 'Y-m-d', $date ) : '';
		
		$rich_editor = apply_filters( 'wcfm_is_allow_rich_editor', 'rich_editor' );
		if ( !$rich_editor && apply_filters( 'wcfm_is_allow_editor_newline_replace', true ) ) {
			$breaks = apply_filters( 'wcfm_editor_newline_generators', array("<br />","<br>","<br/>") );
			
			$excerpt = str_ireplace( $breaks, "\r\n", $excerpt );
			$excerpt = strip_tags( $excerpt );
			
			$description = str_ireplace( $breaks, "\r\n", $description );
			$description = strip_tags( $description );
		} //!$rich_editor && apply_filters( 'wcfm_is_allow_editor_newline_replace', true )
		
		// External product option
		$product_url = get_post_meta( $product_id, '_product_url', true );
		$button_text = get_post_meta( $product_id, '_button_text', true );
		
		// Virtual
		$is_virtual = ( get_post_meta( $product_id, '_virtual', true ) == 'yes' ) ? 'enable' : '';
		
		// Download ptions
		$is_downloadable = ( get_post_meta( $product_id, '_downloadable', true ) == 'yes' ) ? 'enable' : '';
		if ( $product_type != 'simple' )
			$is_downloadable = '';
		if ( $is_downloadable == 'enable' ) {
			$downloadable_files = (array) get_post_meta( $product_id, '_downloadable_files', true );
			$download_limit     = ( -1 == get_post_meta( $product_id, '_download_limit', true ) ) ? '' : get_post_meta( $product_id, '_download_limit', true );
			$download_expiry    = ( -1 == get_post_meta( $product_id, '_download_expiry', true ) ) ? '' : get_post_meta( $product_id, '_download_expiry', true );
		} //$is_downloadable == 'enable'
		
		// Product Images
		$featured_img    = ( $product->get_image_id() ) ? $product->get_image_id() : '';
		//if($featured_img) $featured_img = wp_get_attachment_url($featured_img);
		//if(!$featured_img) $featured_img = '';
		$gallery_img_ids = $product->get_gallery_image_ids();
		if ( !empty( $gallery_img_ids ) ) {
			foreach ( $gallery_img_ids as $gallery_img_id ) {
				$gallery_img_urls[][ 'gimage' ] = $gallery_img_id; //wp_get_attachment_url($gallery_img_id);
				
			} //$gallery_img_ids as $gallery_img_id
		} //!empty( $gallery_img_ids )

		$small_video		= get_post_meta( $product_id, 'small_video', true );
		$full_video			= get_post_meta( $product_id, 'full_video', true );

		$duration_id    	= get_post_meta( $product_id, 'duration', true );

		if ( $duration_id ) {
			$term = get_term( $duration_id, "dishduration" );
			$duration 	= $term->term_name;
		}

		$difficulty_id	= get_post_meta( $product_id, 'difficulty', true );

		if ( $difficulty_id ) {
			$term = get_term( $difficulty_id, "dishdifficulty" );
			$difficulty	= $term->term_name;
		}



		// Product Categories
		$pcategories = get_the_terms( $product_id, 'product_cat' );
		if ( !empty( $pcategories ) ) {
			foreach ( $pcategories as $pkey => $pcategory ) {
				$categories[] = $pcategory->term_id;
			} //$pcategories as $pkey => $pcategory
		} //!empty( $pcategories )
		else {
			$categories = array();
		}
		
		// Product Tags
		if ( apply_filters( 'wcfm_is_tags_input', true ) ) {
			$product_tag_list = wp_get_post_terms( $product_id, 'product_tag', array(
				 "fields" => "names" 
			) );
			$product_tags     = apply_filters( 'wcfm_pm_product_tags_after_save', implode( ',', $product_tag_list ), $product_id );
		} //apply_filters( 'wcfm_is_tags_input', true )
		else {
			$product_tag_list = wp_get_post_terms( $product_id, 'product_tag', array(
				 "fields" => "ids" 
			) );
			$product_tags     = apply_filters( 'wcfm_pm_product_tags_after_save', $product_tag_list, $product_id );
		}
		
		// Product Stock options
		$manage_stock      = $product->managing_stock( 'edit' ) ? 'enable' : '';
		$stock_qty         = $product->get_stock_quantity( 'edit' );
		$backorders        = $product->get_backorders( 'edit' );
		$stock_status      = $product->get_stock_status( 'edit' );
		$sold_individually = $product->is_sold_individually( 'edit' ) ? 'enable' : '';
		
		// Product Shipping Data
		$weight         = $product->get_weight( 'edit' );
		$length         = $product->get_length( 'edit' );
		$width          = $product->get_width( 'edit' );
		$height         = $product->get_height( 'edit' );
		$shipping_class = $product->get_shipping_class_id( 'edit' );
		
		// Product Tax Data
		$tax_status = $product->get_tax_status( 'edit' );
		$tax_class  = $product->get_tax_class( 'edit' );
		
		// Product Attributes
		$wcfm_attributes = get_post_meta( $product_id, '_product_attributes', true );
		if ( !empty( $wcfm_attributes ) ) {
			$acnt = 0;
			foreach ( $wcfm_attributes as $wcfm_attribute ) {
				
				if ( $wcfm_attribute[ 'is_taxonomy' ] ) {
					$att_taxonomy = $wcfm_attribute[ 'name' ];
					
					if ( !taxonomy_exists( $att_taxonomy ) ) {
						continue;
					} //!taxonomy_exists( $att_taxonomy )
					
					$attribute_taxonomy = $wc_product_attributes[ $att_taxonomy ];
					
					$attributes[ $acnt ][ 'term_name' ]          = $att_taxonomy;
					$attributes[ $acnt ][ 'name' ]               = wc_attribute_label( $att_taxonomy );
					$attributes[ $acnt ][ 'attribute_taxonomy' ] = $attribute_taxonomy;
					$attributes[ $acnt ][ 'tax_name' ]           = $att_taxonomy;
					$attributes[ $acnt ][ 'is_taxonomy' ]        = 1;
					
					if ( 'text' !== $attribute_taxonomy->attribute_type ) {
						$attributes[ $acnt ][ 'attribute_type' ] = 'select';
					} //'text' !== $attribute_taxonomy->attribute_type
					else {
						$attributes[ $acnt ][ 'attribute_type' ] = 'text';
						$attributes[ $acnt ][ 'value' ]          = esc_attr( implode( ' ' . WC_DELIMITER . ' ', wp_get_post_terms( $product_id, $att_taxonomy, array(
							 'fields' => 'names' 
						) ) ) );
					}
				} //$wcfm_attribute[ 'is_taxonomy' ]
				else {
					$attributes[ $acnt ][ 'term_name' ]      = apply_filters( 'woocommerce_attribute_label', $wcfm_attribute[ 'name' ], $wcfm_attribute[ 'name' ], $product );
					$attributes[ $acnt ][ 'name' ]           = apply_filters( 'woocommerce_attribute_label', $wcfm_attribute[ 'name' ], $wcfm_attribute[ 'name' ], $product );
					$attributes[ $acnt ][ 'value' ]          = $wcfm_attribute[ 'value' ];
					$attributes[ $acnt ][ 'tax_name' ]       = '';
					$attributes[ $acnt ][ 'is_taxonomy' ]    = 0;
					$attributes[ $acnt ][ 'attribute_type' ] = 'text';
				}
				
				$attributes[ $acnt ][ 'is_active' ]    = 'enable';
				$attributes[ $acnt ][ 'is_visible' ]   = $wcfm_attribute[ 'is_visible' ] ? 'enable' : '';
				$attributes[ $acnt ][ 'is_variation' ] = $wcfm_attribute[ 'is_variation' ] ? 'enable' : '';
				
				if ( 'text' !== $attributes[ $acnt ][ 'attribute_type' ] ) {
					$attributes_select_type[ $acnt ] = $attributes[ $acnt ];
					unset( $attributes[ $acnt ] );
				} //'text' !== $attributes[ $acnt ][ 'attribute_type' ]
				$acnt++;
			} //$wcfm_attributes as $wcfm_attribute
		} //!empty( $wcfm_attributes )
		
		// Product Default Attributes
		$default_attributes = json_encode( (array) get_post_meta( $product_id, '_default_attributes', true ) );
		
		// Variable Product Variations
		$wcfm_variable_product_types = apply_filters( 'wcfm_variable_product_types', array(
			'variable',
			'variable-subscription',
			'pw-gift-card' 
		) );
		if ( in_array( $product_type, $wcfm_variable_product_types ) ) {
			$variation_ids = $product->get_children();
			if ( !empty( $variation_ids ) ) {
				foreach ( $variation_ids as $variation_id_key => $variation_id ) {
					$variation_data = new WC_Product_Variation( $variation_id );
					
					$variations[ $variation_id_key ][ 'id' ]     = $variation_id;
					$variations[ $variation_id_key ][ 'enable' ] = $variation_data->is_purchasable( 'edit' ) ? 'enable' : '';
					$variations[ $variation_id_key ][ 'sku' ]    = $variation_data->get_sku( 'edit' );
					
					// Variation Image
					$variation_img = $variation_data->get_image_id();
					if ( $variation_img )
						$variation_img = wp_get_attachment_url( $variation_img );
					else
						$variation_img = '';
					$variations[ $variation_id_key ][ 'image' ] = $variation_img;
					
					// Variation Price
					$variations[ $variation_id_key ][ 'regular_price' ] = $variation_data->get_regular_price( 'edit' );
					$variations[ $variation_id_key ][ 'sale_price' ]    = $variation_data->get_sale_price( 'edit' );
					
					// Variation Sales Schedule
					$variations[ $variation_id_key ][ 'sale_price_dates_from' ] = $variation_data->get_date_on_sale_from( 'edit' ) && ( $date = $variation_data->get_date_on_sale_from( 'edit' )->getOffsetTimestamp() ) ? date_i18n( 'Y-m-d', $date ) : '';
					$variations[ $variation_id_key ][ 'sale_price_dates_to' ]   = $variation_data->get_date_on_sale_to( 'edit' ) && ( $date = $variation_data->get_date_on_sale_to( 'edit' )->getOffsetTimestamp() ) ? date_i18n( 'Y-m-d', $date ) : '';
					
					// Variation Stock Data
					$variations[ $variation_id_key ][ 'manage_stock' ] = $variation_data->managing_stock( 'edit' ) ? 'enable' : '';
					$variations[ $variation_id_key ][ 'stock_status' ] = $variation_data->get_stock_status( 'edit' );
					$variations[ $variation_id_key ][ 'stock_qty' ]    = $variation_data->get_stock_quantity( 'edit' );
					$variations[ $variation_id_key ][ 'backorders' ]   = $variation_data->get_backorders( 'edit' );
					
					// Variation Virtual Data
					$variations[ $variation_id_key ][ 'is_virtual' ] = ( 'yes' == get_post_meta( $variation_id, '_virtual', true ) ) ? 'enable' : '';
					
					// Variation Downloadable Data
					$variations[ $variation_id_key ][ 'is_downloadable' ]    = ( 'yes' == get_post_meta( $variation_id, '_downloadable', true ) ) ? 'enable' : '';
					$variations[ $variation_id_key ][ 'downloadable_files' ] = get_post_meta( $variation_id, '_downloadable_files', true );
					$variations[ $variation_id_key ][ 'download_limit' ]     = ( -1 == get_post_meta( $variation_id, '_download_limit', true ) ) ? '' : get_post_meta( $variation_id, '_download_limit', true );
					$variations[ $variation_id_key ][ 'download_expiry' ]    = ( -1 == get_post_meta( $variation_id, '_download_expiry', true ) ) ? '' : get_post_meta( $variation_id, '_download_expiry', true );
					if ( !empty( $variations[ $variation_id_key ][ 'downloadable_files' ] ) ) {
						foreach ( $variations[ $variation_id_key ][ 'downloadable_files' ] as $variations_downloadable_files ) {
							$variations[ $variation_id_key ][ 'downloadable_file' ]      = $variations_downloadable_files[ 'file' ];
							$variations[ $variation_id_key ][ 'downloadable_file_name' ] = $variations_downloadable_files[ 'name' ];
						} //$variations[ $variation_id_key ][ 'downloadable_files' ] as $variations_downloadable_files
					} //!empty( $variations[ $variation_id_key ][ 'downloadable_files' ] )
					
					// Variation Shipping Data
					$variations[ $variation_id_key ][ 'weight' ]         = $variation_data->get_weight( 'edit' );
					$variations[ $variation_id_key ][ 'length' ]         = $variation_data->get_length( 'edit' );
					$variations[ $variation_id_key ][ 'width' ]          = $variation_data->get_width( 'edit' );
					$variations[ $variation_id_key ][ 'height' ]         = $variation_data->get_height( 'edit' );
					$variations[ $variation_id_key ][ 'shipping_class' ] = $variation_data->get_shipping_class_id( 'edit' );
					
					// Variation Tax
					$variations[ $variation_id_key ][ 'tax_class' ] = $variation_data->get_tax_class( 'edit' );
					
					// Variation Attributes
					$variations[ $variation_id_key ][ 'attributes' ] = json_encode( $variation_data->get_variation_attributes( 'edit' ) );
					
					// Description
					$variations[ $variation_id_key ][ 'description' ] = get_post_meta( $variation_id, '_variation_description', true );
					
					$variations = apply_filters( 'wcfm_variation_edit_data', $variations, $variation_id, $variation_id_key, $product_id );
				} //$variation_ids as $variation_id_key => $variation_id
			} //!empty( $variation_ids )
		} //in_array( $product_type, $wcfm_variable_product_types )
		
		$upsell_ids    = get_post_meta( $product_id, '_upsell_ids', true ) ? get_post_meta( $product_id, '_upsell_ids', true ) : array();
		$crosssell_ids = get_post_meta( $product_id, '_crosssell_ids', true ) ? get_post_meta( $product_id, '_crosssell_ids', true ) : array();
		$children      = get_post_meta( $product_id, '_children', true ) ? get_post_meta( $product_id, '_children', true ) : array();
	} //$product && !empty( $product )
} //isset( $wp->query_vars[ 'wcfm-products-manage' ] ) && !empty( $wp->query_vars[ 'wcfm-products-manage' ] )

$current_user_id = apply_filters( 'wcfm_current_vendor_id', get_current_user_id() );

// Shipping Class List
$product_shipping_class          = get_terms( 'product_shipping_class', array(
	 'hide_empty' => 0 
) );
$product_shipping_class          = apply_filters( 'wcfm_product_shipping_class', $product_shipping_class );
$variation_shipping_option_array = array(
	 '-1' => __( 'Same as parent', 'wc-frontend-manager' ) 
);
$shipping_option_array           = array(
	 '_no_shipping_class' => __( 'No shipping class', 'wc-frontend-manager' ) 
);
if ( $product_shipping_class && !empty( $product_shipping_class ) ) {
	foreach ( $product_shipping_class as $product_shipping ) {
		$variation_shipping_option_array[ $product_shipping->term_id ] = $product_shipping->name;
		$shipping_option_array[ $product_shipping->term_id ]           = $product_shipping->name;
	} //$product_shipping_class as $product_shipping
} //$product_shipping_class && !empty( $product_shipping_class )

// Tax Class List
$tax_classes                               = WC_Tax::get_tax_classes();
$classes_options                           = array();
$variation_tax_classes_options[ 'parent' ] = __( 'Same as parent', 'wc-frontend-manager' );
$variation_tax_classes_options[ '' ]       = __( 'Standard', 'wc-frontend-manager' );
$tax_classes_options[ '' ]                 = __( 'Standard', 'wc-frontend-manager' );

if ( !empty( $tax_classes ) ) {
	
	foreach ( $tax_classes as $class ) {
		$tax_classes_options[ sanitize_title( $class ) ]           = esc_html( $class );
		$variation_tax_classes_options[ sanitize_title( $class ) ] = esc_html( $class );
	} //$tax_classes as $class
} //!empty( $tax_classes )

$products_array = array();
if ( !empty( $upsell_ids ) ) {
	foreach ( $upsell_ids as $upsell_id ) {
		$products_array[ $upsell_id ] = get_post( absint( $upsell_id ) )->post_title;
	} //$upsell_ids as $upsell_id
} //!empty( $upsell_ids )
if ( !empty( $crosssell_ids ) ) {
	foreach ( $crosssell_ids as $crosssell_id ) {
		$products_array[ $crosssell_id ] = get_post( absint( $crosssell_id ) )->post_title;
	} //$crosssell_ids as $crosssell_id
} //!empty( $crosssell_ids )

if ( !empty( $children ) && is_array( $children ) ) {
	foreach ( $children as $group_children ) {
		$products_array[ $group_children ] = get_post( absint( $group_children ) )->post_title;
	} //$children as $group_children
} //!empty( $children ) && is_array( $children )

$product_types        = apply_filters( 'wcfm_product_types', array(
	 'simple' => __( 'Simple Product', 'wc-frontend-manager' ),
	'variable' => __( 'Variable Product', 'wc-frontend-manager' ),
	'grouped' => __( 'Grouped Product', 'wc-frontend-manager' ),
	'external' => __( 'External/Affiliate Product', 'wc-frontend-manager' ) 
) );
$product_categories = get_terms( 'product_cat', [
    'orderby' => 'name',
    'hide_empty' => 0,
    'parent' => 0,
    'meta_query' => [
        'relation'      => 'OR',
        [
            'key'       => 'hide_on_product_page',
            'compare'   => 'NOT EXISTS',
        ],
        [
            'key'       => 'hide_on_product_page',
            'value'     => '0',
            'compare'   => '=',
        ]
    ]]);


$product_defined_tags = get_terms( 'product_tag', 'orderby=name&hide_empty=0&parent=0' );
$catlimit             = apply_filters( 'wcfm_catlimit', -1 );

$product_type_class = '';
if ( count( $product_types ) == 0 ) {
	$product_types      = array(
		 'simple' => __( 'Simple Product', 'wc-frontend-manager' ) 
	);
	$product_type_class = 'wcfm_custom_hide';
} //count( $product_types ) == 0
elseif ( count( $product_types ) == 1 ) {
	$product_type_class = 'wcfm_custom_hide';
} //count( $product_types ) == 1

$wcfm_is_translated_product     = false;
$wcfm_wpml_edit_disable_element = '';
if ( $product_id && defined( 'ICL_SITEPRESS_VERSION' ) && !ICL_PLUGIN_INACTIVE && class_exists( 'SitePress' ) ) {
	global $sitepress, $wpml_post_translations;
	$default_language = $sitepress->get_default_language();
	$current_language = $sitepress->get_current_language();
	
	$source_language = $wpml_post_translations->get_source_lang_code( $product_id );
	
	//echo $source_language . "::" . $current_language . "::" . $default_language;
	if ( $source_language && ( $source_language != $current_language ) ) {
		$wcfm_is_translated_product     = true;
		$wcfm_wpml_edit_disable_element = 'wcfm_wpml_hide';
	} //$source_language && ( $source_language != $current_language )
} //$product_id && defined( 'ICL_SITEPRESS_VERSION' ) && !ICL_PLUGIN_INACTIVE && class_exists( 'SitePress' )
?>
<div class="collapse wcfm-collapse" id="wcfm_products_manage">
  <div class="wcfm-page-headig">
		<span class="wcfmfa fa-cube"></span>
		<span class="wcfm-page-heading-text"><?php _e( 'Manage Product', 'wc-frontend-manager' ); ?></span>
		<?php do_action( 'wcfm_page_heading' ); ?>
	</div>
	<div class="wcfm-collapse-content">
		<div id="wcfm_page_load"></div>

		<form id="wcfm_products_manage_form" class="wcfm">
		
		<?php do_action('begin_wcfm_products_manage_form'); ?>

		<?php

		$WCFM
			->wcfm_fields
			->wcfm_generate_form_field(apply_filters('wcfm_product_manage_fields_content', array(
			"pro_id" => array(
				'type' => 'hidden',
				'value' => $product_id
			)
		) , $product_id, $product_type));
		?>        

		<div class="wcfm-container wcfm-top-element-container step_1 step">
			<?php do_action( 'before_wcfm_products_manage_title' ); ?>
				<h2><?php if( $product_id ) { _e('Edit Product', 'wc-frontend-manager' ); } else { _e('Add Product', 'wc-frontend-manager' ); } ?></h2>
			<?php do_action( 'after_wcfm_products_manage_title' ); ?>
			<div class="wcfm-clearfix"></div>
		</div>

		<div class="wcfm-container wcfm-top-element-container step_1 step">
			<h2>1. <?php _e('Select dish type', 'wc-frontend-manager' ); ?></h2>
			<div class="inner" id="select_dish">
				 <select id="product_cats" name="product_cats[]" class="select2 short wcfm-select wcfm_ele simple variable external grouped booking"  data-maximum-selection-length="<?php echo $catlimit; ?>" data-placeholder="<?php _e('Select dish *', 'wc-frontend-manager'); ?>" style="width: 100%; margin-bottom: 10px;"> <?php if ( $product_categories ) { $WCFM->library->generateTaxonomyHTML( 'product_cat', $product_categories, $categories );} //$product_categories ?>
				</select>      
			</div>
			<div class="wcfm-clearfix"></div>
		</div>
            <?php
            $cats = [];
            foreach($_categories as $c){
                $cats[$c->term_id] = [$c->name, get_term_link($c->term_id)];
            }

            $tags = [];
            foreach($_tags as $c){
                $tags[$c->term_id] = [$c->name, get_term_link($c->term_id)];
            }
            ?>
            <script>
                var __categories = JSON.parse('<?php echo json_encode($cats); ?>');
                var __tags = JSON.parse('<?php echo json_encode($tags); ?>');
            </script>

		<div class="wcfm-container wcfm-top-element-container step_2 step">
			<h2>2. <?php _e('Choose tags', 'wc-frontend-manager' ); ?></h2>
			<div class="inner" id="dish_tags">
			<?php 
				$product_all_tags = array();
				foreach ( $product_defined_tags as $product_defined_tag ) {
					$product_all_tags[ $product_defined_tag->term_id ] = $product_defined_tag->name;
				} //$product_defined_tags as $product_defined_tag
				$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_simple_fields_tag', array(
					 "product_tags" => array(
						'type' => 'select',
						'class' => 'wcfm-select wcfm_ele product_tags_as_dropdown simple variable external grouped booking',
						'label_class' => 'wcfm_title',
						'value' => $product_tags,
						'options' => $product_all_tags,
						'attributes' => array(
							 'multiple' => true 
						),
					) 
				), $product_id, $product_type ) );
			?>            
			</div>
			<div class="wcfm-clearfix"></div>
		</div>

		<div class="wcfm-container wcfm-top-element-container step_4 step">
			<h2>3. <?php _e('Choose ingredients', 'wc-frontend-manager' ); ?></h2>
			<div class="inner" id="dish_ingredients">


			<select id="dropdown_ingredients" name="dropdown_ingredients[]" class="select short" multiple="multiple"  style="width: 150px;">
		   
			<?php

			$product = wc_get_product( $product_id );
			$wooco_components = get_post_meta( $product_id , 'wooco_components', true );
			$ingredients = $ingredients_qty = array();

			if ( is_array( $wooco_components ) ) {
				$ingredients = array_column($wooco_components, 'products');
				$ingredients_qty = array_column($wooco_components, 'qty');        

			}

			foreach ( $ingredients as $key => $ingredient_id ) {
				$ingredient = wc_get_product( $ingredient_id );
				$per_kilo = get_post_meta( $ingredient_id , 'dishmaker_per_kilo', true );
				$per_kilo_data_attr = '';

				if ( $per_kilo == 'yes' ) {
					$per_kilo_data_attr = 'data-perkilo="yes"';
				}

				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $ingredient_id ), 'thumbnail' );

				if ( ! $image ) {
					$image = array ( TAGS_PLACEHOLDER_IMAGE );
				}

				if ( $ingredient ) {
					?>
					<option  data-img="<?php echo $image[0] ?>" value="<?php echo $ingredient_id ?>" <?php echo $per_kilo_data_attr ?> selected="selected">
						<?php echo $ingredient->get_name(); ?>
					</option>
					<?php 
				}
			   
			}

			?>

			</select>

			<div id="ingredients_qty_wrapper" class="wcfm_product_manager_content_fields">
				<p class="excerpt wcfm_title wcfm_full_ele">
					<strong>Choose Ingredients Qty</strong>
				<?php
				if ( is_array( $ingredients ) && count( $ingredients ) > 0 ) {
					foreach ( $ingredients as $key => $ingredient_id ) {
						$ingredient = wc_get_product( $ingredient_id );

						if ( $ingredient ) {

							$ingredient_name = $ingredient->get_name();

							$per_kilo = get_post_meta( $ingredient_id , 'dishmaker_per_kilo', true );
							$per_kilo_data_attr = '';
							$placeholder = 100;
							if ( $per_kilo == 'yes' ) {
								$per_kilo_data_attr = 'data-perkilo="yes"';
								$ingredient_name .= ' (grammes)';
								$placeholder = 1;								
							}

							?>
							<div id="ingredients_qty_<?php echo $ingredient_id ?>">
								<p class="product_tags wcfm_title">
									<label><?php echo $ingredient_name; ?></label>
								</p>
								<input <?php echo $per_kilo_data_attr ?> class="wcfm-text" product_url="<?php echo get_permalink($ingredient_id); ?>" type="number" value="<?php echo $ingredients_qty[$key] ?>" name="ingredients_qty[<?php echo $ingredient_id ?>]" style="width: max-content;" data-ingredientId="<?php echo $ingredient_id ?>" placeholder="<?php echo $placeholder ?>" />
							</div>
							<?php                            
						}
							
					}  
				}

				?>
				</p>
			</div>
			<?php $nonce_field = wp_create_nonce("dishmaker_get_ingredients"); ?>
			<style type="text/css">
				#wp-description-editor-tools{
					display: none;
				}

				#wp-excerpt-editor-tools{
					display: none;
				}
			</style>
			<script type="text/javascript">
			jQuery(document).ready(function($) {     
				$('#dropdown_ingredients').select2({
					escapeMarkup: function(markup) {
					  return markup;
					},
					templateSelection: dropdown_ingredients_element_format,
					templateResult: dropdown_ingredients_element_format,                
					multiple: true ,
					closeOnSelect: false,
					sorter: function(results) {
						var query = $('#dish_ingredients .select2-search__field').val().toLowerCase();
						if ( query.length < 0 ) {
							return 0;
						}
						return results.sort(function(a, b) {
							return b.text.toLowerCase().indexOf(query) -
							a.text.toLowerCase().indexOf(query);
						});
					},

					ajax: {
						url: sapc_CHECKER.ajaxurl,
						dataType: 'json',
						delay: 250, // delay in ms while typing when to perform a AJAX search
						data: function (params) {
						  var query = {
							search: params.term,
							action: 'dishmaker_get_ingredients',
							dishmaker_get_ingredients_nonce: '<?php echo $nonce_field; ?>',
							product: '<?php echo $product_id; ?>',
							tags: $("#product_tags").val()
						  }

						  // Query parameters will be ?search=[term]&type=public
						  return query;
						},
						processResults: function( data ) {
							var options = [];

							if ( data.length > 0 ) {

								// data is the array of arrays, and each of them contains ID and the Label of the option
								$.each( data, function( index, text ) { 
									disabled = '';
									if ( text[6] !== null ) {
										disabled = text[6];
									}
									options.push( { 'disabled' : disabled, id: text[0], text: text[1], tags: text[2],  selected: text[3], img: text[4] } );
								});

							}
							return {
								results: options
							};
						},
					cache: true       
				  }
				});

				$('#dropdown_ingredients').on('change.select2', function (e) {
					var selected = $(this).select2('data');
					var $product_tag_select = $('#product_tags');

					var first_ingedient = false;

					$(selected).each(function(index,el) {

						if( $('option:selected' , $product_tag_select ).length == 0 ) {

							if (  el.tags  == null )  el.tags = '';

							tags = el.tags.split(",");

							tags.forEach(function(tag){
								first_ingedient = true;								
								tag = tag.trim();
								//$product_tag_select.find('option[text="'+tag+'"]').attr('selected','selected');
								$('option' , $product_tag_select ).filter( function () { return $(this).text() == tag; } ).attr('selected','selected');
							})
						}

						if( first_ingedient ) {
							$('#product_tags').trigger('change');
							$('#dropdown_ingredients').select2('close');			
						}


						if ( typeof(el.element) !== 'undefined' && typeof(el.element.dataset.perkilo) !== 'undefined' ) {
							el.perkilo = el.element.dataset.perkilo;
							el.text += ' (grammes)';
							el.value = 100;
						} else {
							el.perkilo = "no";
							el.value = 1;
						}

						if ( $("#ingredients_qty_" + el.id ).length == 0 ) {
							var template = '<div id="ingredients_qty_##ID##"><p class="product_tags wcfm_title"><label>##name##</label></p><input class="wcfm-text" type="number" value="##VALUE##" name="ingredients_qty[##ID##]" style="width: max-content;" data-ingredientId="##ID##" data-perkilo="##PERKILO##" ></div>';
							var html = template.replace( '##name##', el.text );
								html = html.replace( '##ID##', el.id );
								html = html.replace( '##ID##', el.id );
								html = html.replace( '##ID##', el.id );
								html = html.replace( '##PERKILO##', el.perkilo );
								html = html.replace( '##VALUE##', el.value );								

								$("#ingredients_qty_wrapper").append(html);
						}
					});
					
				}).on('select2:unselect' , function (e) {

					$("#ingredients_qty_" + e.params.data.id ).remove();

				});


				function dropdown_ingredients_element_format ( state ) {
					
					if ( typeof(state.element) !== 'undefined' && typeof(state.element.dataset.img) !== 'undefined' ) {
						state.img = state.element.dataset.img;
					}

					if (!state.img) { return state.text; }


					if ( state.tags !== '' && state.tags !== null ) {
						tags = ' ( ' + state.tags + ' ) ';
					} else {
						tags = '';
					}              

					var $state = $('<span><img height="50px" style="height: 50px;" src="' + state.img + '" /> ' 
						+ state.text 
						+ '<span class = dishmaker_dropdown_tags>' + tags + ' </span>'  
						+'</span>'
						);

					return $state;
				};

			});

			</script>   
			</div>
			<div class="wcfm-clearfix"></div>
		</div>        

		<div class="wcfm-container wcfm-top-element-container step_3 step">
			<h2>4. <?php _e('Add dish information', 'wc-frontend-manager' ); ?></h2>
			<div class="inner" id="information">
				<div class="left" style="width: 69%;">
					<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_manage_fields_general', array(
							 "product_type" => array(
								 'type' => 'select',
								'options' => $product_types,
								'class' => 'wcfm-select wcfm_ele wcfm_product_type wcfm_full_ele simple variable external grouped booking ' . $product_type_class . ' ' . $wcfm_wpml_edit_disable_element,
								'label_class' => 'wcfm_title wcfm_ele simple variable external grouped booking',
								'value' => $product_type 
							),
							"pro_title" => array(
								'placeholder' => __('Give your dish a name *','wc-frontend-manager'),
								'type' => 'text',
								'class' => 'wcfm-text wcfm_ele simple variable external grouped booking',
								'value' => $title 
							) 
							//"visibility"     => array('label' => __('Visibility', 'wc-frontend-manager'), 'type' => 'select', 'options' => array('visible' => __('Catalog/Search', 'wc-frontend-manager'), 'catalog' => __('Catalog', 'wc-frontend-manager'), 'search' => __('Search', 'wc-frontend-manager'), 'hidden' => __('Hidden', 'wc-frontend-manager')), 'class' => 'wcfm-select wcfm_ele wcfm_half_ele wcfm_half_ele_right simple variable external', 'label_class' => 'wcfm_ele wcfm_half_ele_title wcfm_title simple variable external', 'value' => $visibility, 'hints' => __('Choose where this product should be displayed in your catalog. The product will always be accessible directly.', 'wc-frontend-manager'))
							
						), $product_id, $product_type, $wcfm_is_translated_product, $wcfm_wpml_edit_disable_element ) );

					?>

					<?php
						$rich_editor = apply_filters( 'wcfm_is_allow_rich_editor', 'rich_editor' );
						$wpeditor    = apply_filters( 'wcfm_is_allow_product_wpeditor', 'wpeditor' );
						if ( $wpeditor && $rich_editor ) {
							$rich_editor = 'wcfm_wpeditor';
						} //$wpeditor && $rich_editor
						else {
							$wpeditor = 'textarea';
						}

						if ( trim( strip_tags( $description ) ) == '' ) {
							$description = "<strong>Cuisine:</strong>
							</hr>
							<strong>Descriptions:</strong>
							</hr>
							<strong>Instructions:</strong>
							</hr>
							Stap1:";
						}                            
						
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_manage_fields_content', array(
							 "excerpt" => array(
								'label' => __( 'Short Description (300 chars MAX)', 'wc-frontend-manager' ),
								'type' => $wpeditor,
								'class' => 'wcfm-textarea wcfm_ele wcfm_full_ele simple variable external grouped booking ' . $rich_editor,
								'label_class' => 'wcfm_title wcfm_full_ele ' . $rich_editor,
								'rows' => 5,
								'value' => $excerpt,
								'media_buttons' => false,
								'tinymce' => array(
									'toolbar1' => 'bold, italic, underline,|,bullist,numlist,|,formatselect',
									'toolbar2'=>false
								)	
							),
							"description" => array(
								 'label' => __( 'Description', 'wc-frontend-manager' ),
								'type' => $wpeditor,
								'class' => 'wcfm-textarea wcfm_ele wcfm_full_ele simple variable external grouped booking ' . $rich_editor,
								'label_class' => 'wcfm_title wcfm_full_ele ' . $rich_editor,
								'rows' => 10,
								'value' => $description,
								'media_buttons' => false ,
								'tinymce' => array(
									'toolbar1' => 'bold, italic, underline,|,bullist,numlist,|,formatselect',
									'toolbar2'=>false 
								)
							),
						), $product_id, $product_type ) );
					?>


					<div class="left" id="dish_duration">
						<strong><?php _e('Dish Duration','wc-frontend-manager'); ?></strong>                        
						<select name="dish_duration" data-placeholder="<?php _e('Duration *','wc-frontend-manager'); ?>" class="select_duration select2" required>
							<?php 


							$duration_options = array_column( $product_durations, 'name' , 'term_id' );

							foreach ( $duration_options as $duration_option_value => $duration_option_name ) {

								$selected = '';
								if ( $duration_option_value == $duration_id ) {
									$selected = 'selected';
								}
							?>
                                <option url="<?php echo get_term_link($duration_option_value); ?>" <?php echo $selected ?> value="<?php echo $duration_option_value ?>"><?php echo $duration_option_name ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="left" id="dish_difficulty">
						<strong><?php _e('Dish Difficulty','wc-frontend-manager'); ?></strong>                       
						<select name="dish_difficulty" data-placeholder="<?php _e('Difficulty *','wc-frontend-manager'); ?>" class="select_difficulty select2" required>

							<?php 

							$difficulty_options = array_column( $product_difficulties, 'name' , 'term_id' );

							foreach ( $difficulty_options as $difficulty_option_value => $difficulty_option_name ) {
								$selected = '';
								if ( $difficulty_option_value == $difficulty_id ) {
									$selected = 'selected';
								}
							?>
								<option url="<?php echo get_term_link($difficulty_option_value); ?>" <?php echo $selected ?> value="<?php echo $difficulty_option_value ?>"><?php echo $difficulty_option_name ?></option>
							<?php } ?>

						</select>
                        <script>
                            var difficulties_var = JSON.parse('<?php echo json_encode($difficulty_options); ?>');
                        </script>
					</div>
				</div>
				<?php  
				$featured_img_base64 = '';
				$placeholder_img_class = '';
				if ( $featured_img !== '' ) {
					$featured_img_url = wp_get_attachment_url( $featured_img );
					$featured_img_path = get_attached_file( $featured_img ); 
					$featured_img_type = pathinfo($featured_img_path, PATHINFO_EXTENSION);
					$featured_img_data = file_get_contents($featured_img_path);
					//$featured_img_base64 = 'data:image/' . $featured_img_type . ';base64,' . base64_encode($featured_img_data);
				} else {
					$featured_img_url = $placeholder_image;
					$placeholder_img_class = 'placeholder-img';
				}
						
				?>
				<div id="dish_upload_section" class="right" style="width: 29%; text-align: center;">
					<p class="featured_img wcfm_title"><strong><?php _e('Dish main image.','wc-frontend-manager'); ?></strong></p>                    
					<div class="dish_image_wrapper">
						<a href="#" id="dish_featured_image_holder" class="dish_image_holder">
							<img id="dish_featured_image" class="uploaded_image <?php echo $placeholder_img_class; ?>" data-placeholder="<?php echo $placeholder_image; ?>" src="<?php echo $featured_img_url; ?>"/>
							<input type="text" data-base64="<?php echo $featured_img_base64; ?>" name="featured_img" id="featured_img" style="display: none;" class="wcfm-product-feature-upload wcfm_ele simple variable external grouped booking wcfm_img_uploader form-control" readonly="" value="<?php echo $featured_img; ?>" data-mime="image">
						</a>
						<input type="button" class="remove_button button button-secondary" name="featured_img_remove_button" id="featured_img_remove_button" data-mime="image" value="x" <?php if( $featured_img == '' ) echo 'style="display: none;"' ?> > 
					</div>
				<?php do_action( 'wcfm_product_manager_right_panel_before', $product_id ); ?>
				<?php
					if ( $wcfm_is_allow_featured = apply_filters( 'wcfm_is_allow_featured', true ) ) {
						$gallerylimit = apply_filters( 'wcfm_gallerylimit', -1 );
						if ( !WCFM_Dependencies::wcfmu_plugin_active_check() ) {
							//$gallerylimit = apply_filters( 'wcfm_free_gallerylimit', 4 );
							
						} //!WCFM_Dependencies::wcfmu_plugin_active_check()
						$WCFM->wcfm_fields->wcfm_generate_form_field( apply_filters( 'wcfm_product_manage_fields_images', array(
							"gallery_img" => array(
								'label' => 'Gallery',            
								'type' => 'multiinput',
								'class' => 'wcfm-text wcfm-gallery_image_upload wcfm_ele simple variable external grouped booking',
								'label_class' => 'wcfm_title',
								'custom_attributes' => array(
								'limit' => $gallerylimit 
								),
								'value' => $gallery_img_urls,
								'options' => array(
									 "gimage" => array(
										 'type' => 'upload',
										'class' => 'wcfm_gallery_upload',
										'prwidth' => 75 
									) 
								) 
							) 
						), $gallery_img_urls ) );
						
						do_action( 'wcfm_product_manager_gallery_fields_end', $product_id );
						
						// Product Gallary missing message
						if ( !WCFM_Dependencies::wcfmu_plugin_active_check() ) {
							if ( apply_filters( 'is_wcfmu_inactive_notice_show', true ) ) {
								//wcfmu_feature_help_text_show( __( 'Unlimited Image Gallery', 'wc-frontend-manager' ), false, true );
								
							} //apply_filters( 'is_wcfmu_inactive_notice_show', true )
						} //!WCFM_Dependencies::wcfmu_plugin_active_check()
					} //$wcfm_is_allow_featured = apply_filters( 'wcfm_is_allow_featured', true )
					?>

					<p class="featured_img wcfm_title"><strong><?php _e('Small Video.','wc-frontend-manager'); ?></strong></p>                    

					<div class="dish_image_wrapper">
						<a href="#" id="dish_small_video_holder" class="dish_image_holder">
							<img id="dish_small_video_image" class="uploaded_image" data-placeholder="<?php echo $video_placeholder_image; ?>" src="<?php echo $video_placeholder_image; ?>" <?php if( $small_video !== '' ) echo 'style="display: none;"' ?> />
							<?php 
								$small_video_url = "";

								if ( $small_video != "" ) {
									$small_video_url = wp_get_attachment_url( $small_video );
								}
							?>

							<video <?php if( $small_video == '' ) echo 'style="display: none;"' ?> id="dish_small_video" src="<?php echo $small_video_url; ?>"></video>      

							<input type="text" name="small_video" id="small_video" style="display: none;" class="wcfm-product-small_video-upload wcfm_ele simple variable external grouped booking wcfm_img_uploader form-control" readonly="" value="<?php echo $small_video; ?>">
						</a>
						<input type="button" class="remove_button button button-secondary" name="small_video_remove_button" id="small_video_remove_button" data-mime="image" value="x" <?php if( $small_video == '' ) echo 'style="display: none;"' ?>  > 
					</div>

					<p class="featured_img wcfm_title"><strong><?php _e('Full Video.','wc-frontend-manager'); ?></strong></p>                    

					<div class="dish_image_wrapper">
						<a href="#" id="dish_full_video_holder" class="dish_image_holder">
							<img id="dish_full_video_image" class="uploaded_image" data-placeholder="<?php echo $video_placeholder_image; ?>" src="<?php echo $video_placeholder_image; ?>" <?php if( $full_video !== '' ) echo 'style="display: none;"' ?> />
							<?php 
								$full_video_url = "";

								if ( $full_video != "" ) {
									$full_video_url = wp_get_attachment_url( $full_video );
								}
							?>

							<video <?php if( $full_video_url == '' ) echo 'style="display: none;"' ?> id="dish_full_video" src="<?php echo $full_video_url; ?>"></video>      

							<input type="text" name="full_video" id="full_video" style="display: none;" class="wcfm-product-full_video-upload wcfm_ele simple variable external grouped booking wcfm_img_uploader form-control" readonly="" value="<?php echo $full_video; ?>">
						</a>
						<input type="button" class="remove_button button button-secondary" name="full_video_remove_button" id="full_video_remove_button" data-mime="image" value="x" <?php if( $full_video == '' ) echo 'style="display: none;"' ?> > 
					</div>


					<style type="text/css">
						.wcfm-product-small-video-upload .placeHoldermp4 {
							display: none !important;
						} 

						.wcfm-full_video_upload .placeHoldermp4 {
							display: none !important;
						}
					</style>

					<div class="wcfm-clearfix"></div>
				</div>
				</div>                
			<div class="wcfm-clearfix"></div>
		</div>
        <div class="wcfm-container wcfm-top-element-container step_5 step">
            <h2>5. <?php _e('Instruction ', 'wc-frontend-manager' ); ?></h2>

            <?php $instructions = json_decode(get_post_meta($product_id, '_instructions', true)); ?>

            <div class="inner instructions-steps" id="instruction-steps">

                <?php if(!empty($instructions)) : ?>
                    <?php foreach($instructions as $i => $instruction) : ?>
                        <?php include get_stylesheet_directory() . '/templates/dashboard/instruction-item.php'; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="instr-buttons">
                    <a href="#" class="button-purple add-instruction"><?php echo __('Add step'); ?><div class="icon"><div></div><div></div><div></div><div></div></div></a>
                </div>
            </div>
            <div class="wcfm-clearfix"></div>
        </div>

		<div class="wcfm-container wcfm-top-element-container step_5 step" style="display:none !important;">
			<h2>6. <?php _e('Overview recipe', 'wc-frontend-manager' ); ?></h2>

			<div class="inner">
				<div class="left" style="text-align: center; width: 49%;">
					<img class="uploaded_image" data-placeholder="<?php echo $placeholder_image; ?>" src="<?php echo $featured_img_base64; ?>" />
				</div>
				<div class="right" style="width: 49%;">
					<h4 class="dish_title"><?php echo $title ?></h4>
					<table>
						<?php
						if ( isset( $categories[0] ) ){
							$categorie_name = get_term_field( 'name', $categories[0] );
						}
						?>
						<tr><td width="70px"><strong><?php _e('Type:','wc-frontend-manager'); ?></strong></td><td class="push_dish"><?php echo $categorie_name ?></td></tr>
						<tr><td width="70px"><strong><?php _e('Duration:','wc-frontend-manager'); ?></strong></td><td class="push_duration"><?php echo $duration ?></td></tr>
						<tr><td width="70px"><strong><?php _e('Difficulty:','wc-frontend-manager'); ?></strong></td><td class="push_difficulty"><?php echo $difficulty ?></td></tr>
					</table>
					<p><strong><?php _e('Tags:','wc-frontend-manager'); ?></strong></p>
					<p class="push_tags">
						<?php foreach ($product_tags as $product_tag) { ?>
							<span class="tag"><?php echo get_term_field( 'name', $product_tag ) ?></span>
						<?php } ?>
					</p>
					<p><strong><?php _e('Ingredients:','wc-frontend-manager'); ?></strong></p>
					<p class="push_ingredients">
						<?php
						foreach ( $ingredients as $key => $ingredient_id ) {
							$ingredient = wc_get_product( $ingredient_id );
							if ( $ingredient ) {
							?>
								<span class="tag"><?php echo $ingredient->get_name() ?> x <?php echo $ingredients_qty[$key] ?></span>
							<?php
							}
						}
						?>
					</p>
					<br>
					<div class="push_description"><p><?php echo $description ?></p></div>
				</div>
			</div>
			<div class="wcfm-clearfix"></div>
		</div>

        <?php
//        if ( isset( $wp->query_vars[ 'wcfm-products-manage' ] ) && !empty( $wp->query_vars[ 'wcfm-products-manage' ] ) ) {
//            $product = wc_get_product( $wp->query_vars[ 'wcfm-products-manage' ] );
//            if ( !is_a( $product, 'WC_Product' ) ) {
        ?>
        <div class="wcfm-container wcfm-top-element-container step_5 step step-flyer" id="step-flyer">
            <h2>6. <?php _e('Overview recipe', 'wc-frontend-manager' ); ?></h2>
            <div class="flyers-select">
                <a href="#" class="active" data="#flyer-review">Front</a>
                <a href="#" data="#flyer-steps">Back</a>
            </div>
            <?php include get_stylesheet_directory() . '/templates/dashboard/flyer.php'; ?>

            <div class="wcfm-clearfix"></div>
        </div>
        <?php
//            }
//        }
        ?>


		<div id="wcfm_products_simple_submit" class="wcfm_form_simple_submit_wrapper">
			  <div class="wcfm-message" tabindex="-1"></div>

<!--				<input type="button" name="download-recipe" value="--><?php //_e( 'Download recipe card', 'wc-frontend-manager' ); ?><!--" id="wcfm_products_simple_download_button" class="wcfm_submit_button download-recipe" />-->

			  
				<?php if ($product_id && ($wcfm_products_single->post_status == 'publish'))
{ ?>
					<input type="submit" name="submit-data" value="<?php if (apply_filters('wcfm_is_allow_publish_live_products', true))
	{
		_e('Submit', 'wc-frontend-manager');
	}
	else
	{
		_e('Submit for Review', 'wc-frontend-manager');
	} ?>" id="wcfm_products_simple_submit_button" class="wcfm_submit_button" />
				<?php
}
else
{ ?>
					<?php if (apply_filters('wcfm_is_allow_product_limit', true) && apply_filters('wcfm_is_allow_space_limit', true))
	{ ?>
					  <input type="submit" name="submit-data" value="<?php if (apply_filters('wcfm_is_allow_publish_products', true))
		{
			_e('Submit', 'wc-frontend-manager');
		}
		else
		{
			_e('Submit for Review', 'wc-frontend-manager');
		} ?>" id="wcfm_products_simple_submit_button" class="wcfm_submit_button" />
					<?php
	} ?>
				<?php
} ?>
				<?php if (apply_filters('wcfm_is_allow_draft_published_products', true) && apply_filters('wcfm_is_allow_add_products', true))
{ ?>
					<input type="submit" name="draft-data" value="<?php _e('Draft', 'wc-frontend-manager'); ?>" id="wcfm_products_simple_draft_button" class="wcfm_submit_button" />
				<?php
} ?>
				
				<?php
if (apply_filters('wcfm_is_allow_product_preview', true))
{
	if ($product_id && ($wcfm_products_single->post_status != 'publish'))
	{
		echo '<a target="_blank" href="' . apply_filters('wcfm_product_preview_url', get_permalink($wcfm_products_single->ID)) . '">';
?>
						<input type="button" class="wcfm_submit_button" value="<?php _e('Preview', 'wc-frontend-manager'); ?>" />
						<?php
		echo '</a>';
	}
	elseif ($product_id && ($wcfm_products_single->post_status == 'publish'))
	{
		echo '<a target="_blank" href="' . apply_filters('wcfm_product_preview_url', get_permalink($wcfm_products_single->ID)) . '">';
?>
						<input type="button" class="wcfm_submit_button" value="<?php _e('View', 'wc-frontend-manager'); ?>" />
						<?php
		echo '</a>';
	}
}
?>
				<input type="hidden" name="wcfm_nonce" value="<?php echo wp_create_nonce('wcfm_products_manage'); ?>" />
			</div>

		</form>        

		<div class="wcfm-clearfix"></div><br />

	<script type="text/javascript">
			jQuery(document).ready(function($) {

				var media_uploader = null;
				var media_image_uploader = null;


				jQuery('#pro_title').on('input', function(){
					var data = jQuery(this).val();
					jQuery('.step_5 .dish_title').html(data);
				}).trigger('input');

				jQuery('#product_cats').select2().on('select2:select select2:unselect', function(e) {
					var data = $(this).select2('data');
					jQuery('.step_5 .push_dish').html(data[0].text);
				}).trigger( 'select2:select' );

				jQuery('#dish_duration').on('change', function(e) {
					var data = $( 'option:selected' , this ).text();
					jQuery('.step_5 .push_duration').html(data);
				}).trigger( 'change' );

				jQuery('#dish_difficulty').on('change', function(e) {
					var data = $( 'option:selected' , this ).text();
					jQuery('.step_5 .push_difficulty').html(data);
				}).trigger( 'change' );

				jQuery('#product_tags').select2().on('select2:select select2:unselect', function(e) {
					var data    = $(this).select2('data');
					var total   = data.length;
					jQuery('.step_5 .push_tags').html(''); 
					for(var x = 0; x < total;  x++){
						jQuery('.step_5 .push_tags').append(' <span class="tag">'+data[x].text+'</span>');
					}
				}).trigger( 'select2:select' );

				jQuery('#dropdown_ingredients').on('select2:select select2:unselect', function(e) {

					var data    = $(this).select2('data');
					var total   = data.length;
					jQuery('.step_5 .push_ingredients').html(''); 
					for(var x = 0; x < total;  x++){
						jQuery('.step_5 .push_ingredients').append(' <span id="push_ingredients_'+data[x].id+'" class="tag">'+data[x].text+'<span class="push_qty"></span></span>');
					}

				}).trigger( 'select2:select' );

				jQuery( "input[name^='ingredients_qty[']" ).on('input', function(){
					var id = jQuery(this).attr("data-ingredientId");
					var qty = jQuery(this).val();
					jQuery('.step_5 .push_ingredients #push_ingredients_'+id).find('.push_qty').text(" x " + qty);
				}).trigger('input');

				window.tinyMCE.on('addeditor', function( event ) {
					var editor = event.editor;
					editor.on('input init', function (e) {  
						var content = tinyMCE.activeEditor.getContent();
						jQuery('.step_5 .push_'+ tinyMCE.activeEditor.id  ).html(content);
					}); 
				}, true );

				jQuery('#dish_featured_image_holder').on('click', function(e){
					e.preventDefault();
					dishmaker_featured_img_open_media_uploader();
				});

				function dishmaker_featured_img_open_media_uploader() {
					media_uploader = wp.media({
						frame: 'select',
						multiple : false, // Allow the user to select multiple images
						library: {
							order: 'DESC',

							// [ 'name', 'author', 'date', 'title', 'modified', 'uploadedTo', 'id', 'post__in', 'menuOrder' ]
							orderby: 'date',

							// mime type. e.g. 'image', 'image/jpeg'
							type: 'image',

							// Searches the attachment title.
							search: null,

							// Includes media only uploaded to the specified post (ID)
							uploadedTo: null // wp.media.view.settings.post.id (for current post ID)
						},
					});
                    media_image_uploader = media_uploader;

					media_uploader.on("select", function(){
						var selected    = media_uploader.state().get('selection').first().toJSON();
						jQuery('#dish_featured_image ').attr('src', selected.sizes.full.url);
						jQuery('#featured_img').val(selected.id);
						jQuery('[name="featured_img_remove_button"]').show();
						jQuery('.step_5 .uploaded_image').attr('src', selected.sizes.full.url);

                        let flyer_review_container = $('#flyer-review');
                        flyer_review_container.find('.flyer-image img').attr('src', selected.sizes.full.url);

					});

					media_uploader.open();
				}

				jQuery('#dish_full_video_holder').on('click', function(e){
					e.preventDefault();
					dish_full_video_open_media_uploader();
				});

				function dish_full_video_open_media_uploader() {
					media_uploader = wp.media({
						frame: 'select',
						multiple : false, // Allow the user to select multiple images
						library: {
							order: 'DESC',

							// [ 'name', 'author', 'date', 'title', 'modified', 'uploadedTo', 'id', 'post__in', 'menuOrder' ]
							orderby: 'date',

							// mime type. e.g. 'image', 'image/jpeg'
							type: 'video',

							// Searches the attachment title.
							search: null,

							// Includes media only uploaded to the specified post (ID)
							uploadedTo: null // wp.media.view.settings.post.id (for current post ID)
						},
					});

					media_uploader.on("select", function(){
						var selected    = media_uploader.state().get('selection').first().toJSON();

						jQuery('#dish_full_video ').attr('src', selected.url).show();
						jQuery('#dish_full_video_image').hide();                        
						jQuery('#full_video').val(selected.id);
						jQuery('[name="full_video_remove_button"]').show();                   
						
					});

					media_uploader.open();
				}

				jQuery('#dish_small_video_holder').on('click', function(e){
					e.preventDefault();
					dish_small_video_open_media_uploader();
				});

				function dish_small_video_open_media_uploader() {
					media_uploader = wp.media({
						frame: 'select',
						multiple : false, // Allow the user to select multiple images
						library: {
							order: 'DESC',

							// [ 'name', 'author', 'date', 'title', 'modified', 'uploadedTo', 'id', 'post__in', 'menuOrder' ]
							orderby: 'date',

							// mime type. e.g. 'image', 'image/jpeg'
							type: 'video',

							// Searches the attachment title.
							search: null,

							// Includes media only uploaded to the specified post (ID)
							uploadedTo: null // wp.media.view.settings.post.id (for current post ID)
						},
					});

					media_uploader.on("select", function(){
						var selected    = media_uploader.state().get('selection').first().toJSON();

						jQuery('#dish_small_video ').attr('src', selected.url).show();
						jQuery('#dish_small_video_image').hide();                        
						jQuery('#small_video').val(selected.id);
						jQuery('[name="small_video_remove_button"]').show();                   
						
					});

					media_uploader.open();
				}                

				jQuery('#dish_upload_section .remove_button').on('click', function(e) { 
					var button = $(this);
					var wrapper = button.parents('.dish_image_wrapper');
					var img = jQuery('.uploaded_image',wrapper);
					jQuery('.uploaded_image',wrapper).attr('src',img.attr('data-placeholder')).show();
					jQuery('video',wrapper).attr('src','').hide();
					jQuery('.wcfm_img_uploader',wrapper).attr('value','');
					button.hide();
				});

				var $form = $('#wcfm_products_manage_form'),
				origForm = $form.serialize();

				$(':input' , $form).on('change input', function() {
				    console.log( $form.serialize() , $form.serialize() !== origForm );
				});

				jQuery('#wcfm_products_simple_download_button').on('click', function(e) { 
					e.preventDefault();

					window.location.href = window.location.href + " ?pdf";

					/*fetch('http://woocommerce.local/store-manager/products-manage/3858/?pdf')
							.then(resp => resp.blob())
							.then(blob => {
							const url = window.URL.createObjectURL(blob);
							const a = document.createElement('a');
							a.style.display = 'none';
							a.href = url;
							a.setAttribute('target', '_blank');
							//a.download = 'todo-1.json';
							document.body.appendChild(a);
							a.click();
							window.URL.revokeObjectURL(url);
						})*/			
				});

				// setTimeout(function () {
				//     for (var i = 0; i < tinymce.editors.length; i++) {
				// 		tinymce.get("excerpt").on('KeyUp Change', function (e) {
                //
				// 			content = this.getContent().replace(/(<([^>]+)>)/ig,"");
				// 			limitNum = 300;
                //
				// 			if (content.length > limitNum) {
                //
				// 				this.setContent( content.substring(0, limitNum) );
				// 				this.focus();
				// 				this.selection.select(this.getBody(), true);
				// 				this.selection.collapse(false);
                //
				// 			}
				// 		});
				// 		tinyMCE.triggerSave();
				//        }
				// }, 2000);
			
			});
		</script>

		<?php
			do_action( 'after_wcfm_products_manage' );
		?>
	</div>
</div>

<style type="text/css">

.wcfm-collapse .wcfm-top-element-container{ padding: 15px 20px 15px 20px !important; }
.wcfm_submit_button.download-recipe{ background: #5e1691 !important; color: #ffffff!important; }
#wcfm-main-contentainer .inner table tbody td{ padding: 0px !important; }

.step{ display: table !important; text-align: left !important; }
.step h2{ display: block !important; width: 100% !important; }
.step .inner{ text-align: center; }
.step .inner select{ width: 50%; }
.step .inner input{ width: 100% !important; }
.step .inner .left,
.step .inner .right{ float: left; width: 49%; margin-left: 1%; text-align: right; }
.step .inner .left{ margin-left: 0%; margin-right: 1%; text-align: left; }
.step .inner .wp-editor-tabs{ display: none !important; }
.step .inner p,
.step .inner h1,
.step .inner h2,
.step .inner h3,
.step .inner h4,
.step .inner h5,
.step .inner table,
.step .inner ul,
.step .inner ul li,
.step .inner ol,
.step .inner ol li{ text-align: left !important; }
.step .inner .left select,
.step .inner .right select{ width: 95% !important; }
.step .inner span.tag{ border: 1px solid #ccc; border-radius: 3px; cursor: pointer; padding: 5px; text-align: left; }
.step .inner img{ border: 1px solid #ccc; }
.step .inner img.uploaded_image{ width: 100%; height: auto; }

.dish_image_wrapper {
	display: block;
	position: relative;
}

.dish_image_wrapper input.remove_button {
	width: 30px  !important;
	height: 30px;
	display: block;
	text-align: center;
	margin: 0 auto;
	position: absolute;
	top: 5px;
	right: 5px;
}

.step .inner input.remove_button{
	width: 30px  !important;
	height: 30px;    
}

p.wcfm_title, span.wcfm_title {
	display: block;
}

.select2-container--default .select2-results__option[aria-disabled=true] {
	display: block !important;
}
</style>
