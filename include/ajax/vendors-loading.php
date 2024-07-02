<?php
add_action('wp_ajax_vendors_loading', 'vendors_loading');
add_action('wp_ajax_nopriv_vendors_loading', 'vendors_loading'); // For anonymous users

function vendors_loading()
{

    ob_start();

    $page = !empty($_POST['page']) ? sanitize_text_field($_POST['page']) : 0;
    $count_per_page = !empty($_POST['count']) ? sanitize_text_field($_POST['count']) : 3;

    $type = !empty($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
    $cat = !empty($_POST['cat']) ? sanitize_text_field($_POST['cat']) : '';
    $tag = !empty($_POST['tag']) ? sanitize_text_field($_POST['tag']) : '';
    $sort = !empty($_POST['sort']) ? sanitize_text_field($_POST['sort']) : '';
    $search = !empty($_POST['search']) ? sanitize_text_field($_POST['search']) : '';

    $exclude = !empty($_POST['exclude']) ? explode(',', $_POST['exclude']) : [];

    $offset = intval($page) * intval($count_per_page);

    $vendors = get_stores($type, $count_per_page, $cat, $tag, $search, $sort, $exclude, $offset);

    foreach ($vendors['stores'] as $store) : ?>
        <div class="col-md-6 col-lg-4 vendor-item">
            <?php include get_stylesheet_directory() . '/templates/vendors/vendors-item.php'; ?>
        </div>
    <?php endforeach;

    $result = ob_get_clean();

    $state = true;
    if (intval($vendors['count']) - $offset < $count_per_page) {
        $state = false;
    }

    $answer = [
        'state' => $state,
        'html' => $result,
        'vendors_count' => $vendors['count']
    ];

    echo json_encode($answer);


    die();
}
