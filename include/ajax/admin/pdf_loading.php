<?php

add_action('wp_ajax_pdf_loading', 'pdf_generate');
add_action('wp_ajax_nopriv_pdf_loading', 'pdf_generate'); // For anonymous users

//require_once ( get_stylesheet_directory() . '/libs/generate-pdf/dompdf/autoload.inc.php' );

use Dompdf\Dompdf;

function generate_filename(){
    return rand() . '-' . time();
}

function pdf_generate()
{

//    ob_start();

    $id = !empty($_POST['id']) ? sanitize_text_field($_POST['id']) : '';


    global $wp, $WCFM, $wc_product_attributes;

    ob_start();

    get_template_part('/templates/dashboard/flyer/pdf', '', ['product_id' => $id]);

    $html = ob_get_clean();

    $dompdf = new DOMPDF();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $filename = generate_filename();
    write_to_file($dompdf->output(), $filename);

    echo get_pdf_tempdir_url() . $filename;

    die();
}
