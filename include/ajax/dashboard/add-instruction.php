<?php
add_action('wp_ajax_add_instruction', 'add_instruction');
add_action('wp_ajax_nopriv_add_instruction', 'add_instruction');

function add_instruction()
{
    ob_start();

    $i = !empty($_POST['id']) ? sanitize_text_field($_POST['id']) : 0;

    include get_stylesheet_directory() . '/templates/dashboard/instruction-item.php';

    $result = ob_get_clean();
    echo json_encode($result);

    die();
}
