<?php /* Template Name: Vendors List Page */ ?>

<?php get_header(); ?>

<?php
    $type = !empty($_GET['type']) ? $_GET['type'] : '';
    $page_title = get_vendors_list_type_title($type);
    $sort = !empty($_GET['sort']) ? $_GET['sort'] : 'desc';
    $count = 12;

    $stores = get_stores($type, $sort, $count);

    if(!empty($stores))
        include get_stylesheet_directory() . '/templates/vendors/vendors-list.php';
?>

<?php get_footer();
