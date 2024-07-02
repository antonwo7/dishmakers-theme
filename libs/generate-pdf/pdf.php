<?php

//require_once ( 'dompdf/autoload.inc.php' );

use Dompdf\Dompdf;

global $wp, $WCFM, $wc_product_attributes;

$ids = $args['ids'];


//$product = wc_get_product( $ids[0] );

ob_start();

get_template_part('/templates/dashboard/flyer/pdf', '', ['product_id' => $ids[0]]);

$html = ob_get_clean();
$dompdf = new DOMPDF();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();


