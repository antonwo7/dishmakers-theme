<?php

global $wp_query;

$category = is_tax('product_cat') ? $wp_query->get_queried_object()->term_id : (!empty($_GET['category']) ? sanitize_text_field($_GET['category']) : '');
$tag = is_tax('product_tag') ? $wp_query->get_queried_object()->term_id : (!empty($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '');
$difficulty = is_tax('dishdifficulty') ? $wp_query->get_queried_object()->term_id : '';
$duration = is_tax('dishduration') ? $wp_query->get_queried_object()->term_id : '';

$search = !empty($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
$sort = !empty($_GET['sort'])
    ? sanitize_text_field($_GET['sort'])
    : (!empty($settings['sorting']) ? $settings['sorting'] : 'desc');

$exclude_terms = !empty($settings['cats_exclude']) ? $settings['cats_exclude'] : 0;

$include_terms = [];
if(!empty($settings['cats_include']))
    $include_terms = array_merge($include_terms, $settings['cats_include']);

if(!empty($settings['tags_include']))
    $include_terms = array_merge($include_terms, $settings['tags_include']);

$category_setting = empty($settings['category']) ? 'new' : $settings['category'];

$only_simple_products = !empty($settings['only_simple_product']);

$count = !empty($settings['count']) ? $settings['count'] : 6;
$vendor_id = !empty($settings['vendor_id']) ? $settings['vendor_id'] : 0;
$logged_user_id = isset($logged_user_id) ? $logged_user_id : 0;

global $logged_user_id;
$logged_user_id = (isset($logged_user_id) || $logged_user_id != 0) ? $logged_user_id : 0;

$data = get_products($logged_user_id, $vendor_id, $category_setting, $count, $search, $category, $tag, $difficulty, $duration, $sort, [], $exclude_terms, $include_terms, $only_simple_products);
$products = $data['products'];
$found = $data['count'];
$view = $settings['view'];

?>

<?php include get_stylesheet_directory() . '/templates/products/products-' . $view . '.php'; ?>
