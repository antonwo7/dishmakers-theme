<?php
add_action('wp_ajax_products_loading', 'products_loading');
add_action('wp_ajax_nopriv_products_loading', 'products_loading'); // For anonymous users

function products_loading()
{

    ob_start();

    $page = !empty($_POST['page']) ? sanitize_text_field($_POST['page']) : 0;
    $count_per_page = !empty($_POST['count']) ? sanitize_text_field($_POST['count']) : 1;

    $type = !empty($_POST['type']) ? sanitize_text_field($_POST['type']) : '';
    $cat = !empty($_POST['cat']) ? sanitize_text_field($_POST['cat']) : '';
    $tag = !empty($_POST['tag']) ? sanitize_text_field($_POST['tag']) : '';
    $difficulty = !empty($_POST['dif']) ? sanitize_text_field($_POST['dif']) : '';
    $duration = !empty($_POST['dur']) ? sanitize_text_field($_POST['dur']) : '';
    $sort = !empty($_POST['sort']) ? sanitize_text_field($_POST['sort']) : '';
    $search = !empty($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $vendor_id = !empty($_POST['vendorid']) ? sanitize_text_field($_POST['vendorid']) : 0;
    $logged_user_id = !empty($_POST['logged_user_id']) ? sanitize_text_field($_POST['logged_user_id']) : 0;

    $exclude = !empty($_POST['exclude']) ? explode(',', $_POST['exclude']) : [];

    $exclude_terms = !empty($_POST['exclude_terms']) ? explode(',', $_POST['exclude_terms']) : [];
    $include_terms = !empty($_POST['exclude']) ? explode(',', $_POST['exclude']) : [];

    $offset = intval($page) * intval($count_per_page);

    $products = get_products($logged_user_id, $vendor_id, $type, $count_per_page, $search, $cat, $tag, $difficulty, $duration, $sort, $exclude, $exclude_terms, $include_terms, false, $offset);

    foreach ($products['products'] as $item) :
        $product_id = $item['product_id'];
        $vendor_id = $item['vendor_id'];
        ?>
        <div class="col-md-6 col-lg-4 product-item" data="<?php echo $product_id; ?>">
            <?php include get_stylesheet_directory() . '/templates/products/products-item.php'; ?>
        </div>
    <?php endforeach;

    $result = ob_get_clean();

    $state = true;
    if (intval($products['count']) - $offset < $count_per_page) {
        $state = false;
    }

    $answer = [
        'state' => $state,
        'html' => $result,
        'products_count' => $products['count']
    ];

    echo json_encode($answer);

    die();
}
