<?php

$category = !empty($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$tag = !empty($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';
$search = !empty($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
$sort = !empty($_GET['sort'])
    ? sanitize_text_field($_GET['sort'])
    : (!empty($settings['sorting']) ? $settings['sorting'] : 'desc');

$count = !empty($settings['count']) ? $settings['count'] : 3;

$stores = get_stores($settings['category'], $count, $category, $tag, $search, $sort, [])['stores'];

$view = $settings['view'];
?>

<?php include get_stylesheet_directory() . '/templates/vendors/vendors-' . $view . '.php'; ?>
