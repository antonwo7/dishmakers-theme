<?php

add_action( 'after_wcfm_products_manage_meta_save', 'test', 10, 2);
function test($new_product_id, $wcfm_products_manage_form_data){
    $data = [];
    $instructions = $wcfm_products_manage_form_data['instructions'];

    foreach ($instructions['title'] as $i => $title){
        $description = $instructions['description'][$i];
        $data[] = [$title, $description];
    }

    update_post_meta( $new_product_id, '_instructions', json_encode($data));
}



add_filter('bulk_actions-edit-product', function ($actions)
{
    $actions['download_recipe_card'] = __('Download recipe card');
    return $actions;
});

add_filter( 'handle_bulk_actions-edit-product', 'download_recipe_card_handler', 10, 3 );
function download_recipe_card_handler( $redirect, $action, $ids ) {
    if ( $action == 'download_recipe_card' ) {
        //get_template_part('/libs/generate-pdf/pdf', '', ['ids' => $ids]);
        $redirect = add_query_arg([
                'pdf_loading' => 1,
                'pdf_ids' => implode(',', $ids)
        ], $redirect);
    }

    return $redirect;
}

add_action('admin_footer', 'pdf_loading');
function pdf_loading()
{
    if (empty($_GET['pdf_loading']))
        return;


    $ids = empty($_GET['pdf_ids']) ? [] : $_GET['pdf_ids'];
    $ids = explode(',', $ids);
    ?>

    <style>
        .pdf_loading_message {
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            position: fixed;
            top: 0;
            left: 0;
        }
        .pdf_loading_message .message_wrapper {
            width: 100%;
            max-width: 300px;
            padding: 40px;
            border-radius: 4px;
            background: #fff;
            position:absolute;
            top:50%;
            left:50%;
            transform: translate(-50%, -50%);
        }
        .pdf_loading_message .message_wrapper h3{
            padding:0;
            margin:0 0 15px 0;
            font-size:25px;
        }
        .pdf_loading_message .message_wrapper p{
            margin:15px 0 0 0;
        }
    </style>

    <script>
        function pdf_delete_temp(files){
            let form_data = [];
            form_data.push({name: 'files', value: files});
            form_data.push({name: 'action', value: 'pdf_delete_temp'});

            jQuery.ajax({
                type: 'post',
                url: ajaxurl,
                data: form_data,
                success: function (response) {
                    window.location.href = response;
                },
                error: function (response) {
                    console.log('error');
                }
            });
        }

        function download(url, filename) {
            let link = document.createElement('a');
            link.href = url;
            link.download = filename;
            link.dispatchEvent(new MouseEvent('click'));
        }

        function pdf_loading(ids){
            let promises = [];
            let files = [];

            for(const id of ids){
                let form_data = [];

                form_data.push({name: 'id', value: id});
                form_data.push({name: 'action', value: 'pdf_loading'});

                let request = jQuery.ajax({
                    type: 'post',
                    url: ajaxurl,
                    data: form_data,
                    success: function (response) {
                        files.push(response);
                        download(response, 'pdf.pdf');
                    },
                    error: function (response) {
                        console.log('error');
                    }
                });

                promises.push(request);
            }

            jQuery.when.apply(null, promises).done(function() {
                console.log(files);
                pdf_delete_temp(files);
            })
        }

        jQuery(document).ready(function ($) {
            pdf_loading(JSON.parse('<?php echo json_encode($ids); ?>'));
        });
    </script>

    <?php
    get_template_part('/templates/admin/pdf_loading_message', '', ['ids' => $ids]);
}


add_action( 'after_wcfm_products_manage_meta_save', 'check_excerpt_before_save', 10, 2 );
function check_excerpt_before_save( $product_id, $form_data ) {
    if ( array_key_exists( 'excerpt', $form_data ) && strlen(strip_tags($form_data['excerpt'])) > 300 ) {
        dishmaker_send_errors( 'Please insert correct recipe excerpt (<300 chars) before submit', $product_id );

    }


}

add_filter( 'wcfm_form_custom_validation', 'check_vendor_data_before_save', 51, 2 );
function check_vendor_data_before_save($wcfm_vendor_manage_profile_form_data, $form_manager){
    if(empty($wcfm_vendor_manage_profile_form_data['vendor_id'])) return $wcfm_vendor_manage_profile_form_data;

    if(empty($wcfm_vendor_manage_profile_form_data['gravatar']) || $wcfm_vendor_manage_profile_form_data['gravatar'] == '0'){
        return [
            'has_error' => true,
            'message' => __('Error! Store logo is required!')
        ];
    }

    return $wcfm_vendor_manage_profile_form_data;
}

add_filter( 'wcfm_form_custom_validation', 'check_vendor_data_before_save1', 52, 2 );
function check_vendor_data_before_save1($wcfm_vendor_manage_profile_form_data, $form_manager){
    if(empty($wcfm_vendor_manage_profile_form_data['vendor_id'])) return $wcfm_vendor_manage_profile_form_data;

    if(empty($wcfm_vendor_manage_profile_form_data['banner']) || $wcfm_vendor_manage_profile_form_data['banner'] == '0'){
        return [
            'has_error' => true,
            'message' => __('Error! Store banner is required!')
        ];
    }

    return $wcfm_vendor_manage_profile_form_data;
}

function get_elementor_template($id){

    if (class_exists("\\Elementor\\Plugin")) {;
        $pluginElementor = \Elementor\Plugin::instance();
        return $pluginElementor->frontend->get_builder_content($id);
    }

    return '';
}

add_action('woocommerce_after_cart', function(){
    require(__DIR__ . '/../templates/cart/tabs.php');
});
