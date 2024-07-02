<?php
require_once __DIR__ . '/include/functions/functions.php';
require_once __DIR__ . '/include/ajax/products-loading.php';
require_once __DIR__ . '/include/ajax/vendors-loading.php';
require_once __DIR__ . '/include/ajax/dashboard/add-instruction.php';
require_once __DIR__ . '/include/ajax/admin/pdf_loading.php';
require_once __DIR__ . '/include/ajax/admin/pdf_delete_temp.php';
require_once __DIR__ . '/include/hooks.php';



//Child Theme Functions File
add_action( 'wp_enqueue_scripts', 'enqueue_wp_child_theme' );
function enqueue_wp_child_theme() {
	global $WCFM, $WCFMmp;

    if( ( esc_attr ( get_option( 'childthemewpdotcom_setting_x' ) ) != "Yes") ) {
		//This is your parent stylesheet you can choose to include or exclude this by going to your Child Theme Settings under the "Settings" in your WP Dashboard
		wp_enqueue_style('parent-css', get_template_directory_uri().'/style.css' );
    }

	//This is your child theme stylesheet = style.css
	wp_enqueue_style( 'child-css', get_stylesheet_uri() );
    wp_enqueue_style( 'stl-css', get_stylesheet_directory_uri().'/production/css/app.css' );

	//This is your child theme js file = js/script.js
	wp_enqueue_script( 'child-js', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'stl-js', get_stylesheet_directory_uri() . '/production/js/app.js');

	$four_persons_discount	= isset( $WCFMmp->wcfmmp_marketplace_options['store_four_persons_discount'] ) ? $WCFMmp->wcfmmp_marketplace_options['store_four_persons_discount'] : 10;

	wp_localize_script( 'child-js', 'child_vars', array(
			'four_persons_discount'          => $four_persons_discount
		)
	);

    wp_enqueue_editor();
}

require_once('include/widgets/products/products.php');
require_once('include/widgets/vendors/vendors.php');


function p($object){
    print("<pre>".print_r($object,true)."</pre>");
}

function w($object, $type){
    fwrite(fopen(__DIR__ . '/test.txt', $type), json_encode($object));
}

//function get_pdf_tempdir(){
//    return __DIR__ . '/libs/generate-pdf/temp/';
//}
//function get_pdf_tempdir_url(){
//    return get_stylesheet_directory_uri() . '/libs/generate-pdf/temp/';
//}


function get_pdf_tempdir(){
    return WP_CONTENT_DIR . '/uploads/';
}
function get_pdf_tempdir_url(){
    $upload_dir = wp_upload_dir();
    $tempdir_url = is_ssl() ? str_replace('http', 'https', $upload_dir['baseurl']) : $upload_dir['baseurl'];
    return $tempdir_url . '/';
}

function write_to_file($data, $file = 'test.txt'){
    @fwrite(fopen(get_pdf_tempdir() . $file, 'w'), $data);
}

function get_base64_img_by_src($src){

    $vendor_banner_base64 = '';
    if ( $src !== '' ) {
        $vendor_banner_type = wp_check_filetype($src);
        $vendor_banner_data = file_get_contents($src);
        $vendor_banner_base64 = 'data:image/' . $vendor_banner_type . ';base64,' . base64_encode($vendor_banner_data);
    }

    return $vendor_banner_base64;
}

function get_base64_img($id, $type = ''){

    $vendor_banner_base64 = '';
    if ( $id !== '' ) {
        $vendor_banner_path = $type !== 'thumb' ? get_attached_file($id) : wp_get_attachment_thumb_file($id);
        $vendor_banner_type = pathinfo($vendor_banner_path, PATHINFO_EXTENSION);
        $vendor_banner_data = file_get_contents($vendor_banner_path);
        $vendor_banner_base64 = 'data:image/' . $vendor_banner_type . ';base64,' . base64_encode($vendor_banner_data);
    }

    return $vendor_banner_base64;
}


function wcfm_allow_vendors_list( $allow_vendors_list, $is_marketplace ) {
    return [];
}
add_filter( 'wcfm_allow_vendors_list', 'wcfm_allow_vendors_list', 10, 2 );

function wpet_init(){
    register_setting( 'wpet_plugin_options', 'wpet_options', 'wpet_validate_options' );
}
add_action('admin_init', 'wpet_init' );


