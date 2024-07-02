<?php

add_action('wp_ajax_pdf_delete_temp', 'pdf_delete_temp');
add_action('wp_ajax_nopriv_pdf_delete_temp', 'pdf_delete_temp');

function pdf_delete_temp()
{
    $files = !empty($_POST['files']) ? explode(',', $_POST['files']) : [];

    foreach($files as $file){
        unlink(get_pdf_tempdir() . basename($file));
    }

    echo admin_url('edit.php?post_type=product');

    die();
}
