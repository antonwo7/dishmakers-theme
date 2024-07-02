<?php

function get_vendors_list_type_title($type){
    $type_title = '';

    switch ($type) {
        case 'popular':
            $type_title = __('Popular vendors', 'hestia');
            break;
        case 'trending':
            $type_title = __('Trending vendors', 'hestia');
            break;
        case 'toprated':
            $type_title = __('Top rated vendors', 'hestia');
            break;
        default:
            $type_title = __('All vendors', 'hestia');
    }

    return $type_title;
}


function get_vendor_info_by_id($vendor_id){

    if( !$vendor_id ) return false;
    if( !wcfm_is_vendor( $vendor_id ) ) return false;

    if( !apply_filters( 'wcfmmp_store_list_card_valid', $vendor_id ) ) return false;

    $is_store_offline = get_user_meta( $vendor_id, '_wcfm_store_offline', true );
    if ( $is_store_offline ) return false;

    $is_disable_vendor = get_user_meta( $vendor_id, '_disable_vendor', true );
    if ( $is_disable_vendor ) return false;

    $vendor = [];

    $vendor_user = wcfmmp_get_store($vendor_id);

    $vendor['id'] = $vendor_id;

    $vendor['rating'] = get_vendor_rating($vendor_id);

    $vendor['info'] = $vendor_user->get_shop_info();
    $vendor['gravatar'] = $vendor_user->get_avatar();
    $vendor['gravatar_id'] = get_user_meta( $vendor_id, 'wp_user_avatar', true );

    $banner_type = $vendor_user->get_list_banner_type();
    $banner_video = '';
    $banner = '';

    if( $banner_type == 'video' ) {
        $banner_video = $vendor_user->get_list_banner_video();
    } else {
        $banner          = $vendor_user->get_list_banner();
        if( !$banner ) {
            $banner = !empty( $WCFMmp->wcfmmp_marketplace_options['store_list_default_banner'] ) ? wcfm_get_attachment_url($WCFMmp->wcfmmp_marketplace_options['store_list_default_banner']) : $WCFMmp->plugin_url . 'assets/images/default_banner.jpg';
            $banner = apply_filters( 'wcfmmp_list_store_default_bannar', $banner );
        }
    }


    $vendor['banner_video'] = $banner_video;
    $vendor['banner'] = $banner;

    $vendor['name'] = isset( $vendor['info']['name'] ) ? esc_html( $vendor['info']['name'] ) : __( 'N/A', 'wc-multivendor-marketplace' );
    $vendor['name'] = apply_filters( 'wcfmmp_store_title', $vendor['name'] , $vendor_id );

    $vendor['url'] = wcfmmp_get_store_url( $vendor_id );
    $vendor['address'] = $vendor_user->get_address_string();
    $vendor['description'] = $vendor_user->get_shop_description();

    return $vendor;
}

function get_vendor_rating($id){
    global $WCFMmp;

    if ( !apply_filters( 'wcfm_is_pref_vendor_reviews', true ) || !apply_filters( 'wcfm_is_allow_review_rating', true ) )
        return 0;

    if( !$id )
        return 0;

    $vendor_rating = $WCFMmp->wcfmmp_reviews->get_vendor_review_rating( $id );

    return $vendor_rating ? ( ( $vendor_rating / 5 ) * 100 - 1 ) : 0;
}

function get_stores_ids($type, $count, $category, $tag, $search, $sort, $exclude, $offset = 0){

    $count = (empty($count) || ($count == 1)) ? 5 : intval($count);

    switch ($type) {
        case 'popular':
            return get_stories_global($count, $search, $category, $tag, "popularity_{$sort}", $exclude, $offset);

        case 'trending':
            return get_stories_global($count, $search, $category, $tag, "trending_{$sort}", $exclude, $offset);

        case 'toprated':
            return get_stories_global($count, $search, $category, $tag, "rating_{$sort}", $exclude, $offset);

        case 'all':
            return get_stories_global($count, $search, $category, $tag, 'rand', $exclude, $offset);

        default:
            return get_stories_global($count, $search, $category, $tag, "newness_{$sort}", $exclude, $offset);
    }

}

function get_stores_by_ids($stores_ids){

    $stores = [];

    foreach($stores_ids['ids'] as $store_id){
        if( !$store_id ) continue;
        if( !wcfm_is_vendor( $store_id ) ) continue;

        if( !apply_filters( 'wcfmmp_store_list_card_valid', $store_id ) ) continue;

        $is_store_offline = get_user_meta( $store_id, '_wcfm_store_offline', true );
        if ( $is_store_offline ) break;

        $is_disable_vendor = get_user_meta( $store_id, '_disable_vendor', true );
        if ( $is_disable_vendor ) break;

        $store_item = [];

        $store_user = wcfmmp_get_store($store_id);

        $store_item['store_id'] = $store_id;

        $store_item['store_rating'] = get_vendor_rating($store_id);

        $store_item['store_info'] = $store_user->get_shop_info();
        $store_item['gravatar'] = $store_user->get_avatar();

        $banner_type = $store_user->get_list_banner_type();
        $banner_video = '';
        $banner = '';

        if( $banner_type == 'video' ) {
            $banner_video = $store_user->get_list_banner_video();
        } else {
            $banner          = $store_user->get_list_banner();
            if( !$banner ) {
                $banner = !empty( $WCFMmp->wcfmmp_marketplace_options['store_list_default_banner'] ) ? wcfm_get_attachment_url($WCFMmp->wcfmmp_marketplace_options['store_list_default_banner']) : $WCFMmp->plugin_url . 'assets/images/default_banner.jpg';
                $banner = apply_filters( 'wcfmmp_list_store_default_bannar', $banner );
            }
        }

        $store_item['banner_video'] = $banner_video;
        $store_item['banner'] = $banner;

        $store_item['store_name'] = isset( $store_item['store_info']['store_name'] ) ? esc_html( $store_item['store_info']['store_name'] ) : __( 'N/A', 'wc-multivendor-marketplace' );
        $store_item['store_name'] = apply_filters( 'wcfmmp_store_title', $store_item['store_name'] , $store_id );

        $store_item['store_url'] = wcfmmp_get_store_url( $store_id );
        $store_item['store_address'] = $store_user->get_address_string();
        $store_item['store_description'] = $store_user->get_shop_description();

        $stores[] = $store_item;
    }

    return [ 'stores' => $stores, 'count' => $stores_ids['count'] ];
}

function get_stores($type, $count, $category, $tag, $search, $sort, $exclude, $offset = 0){
    $stores_ids = get_stores_ids($type, $count, $category, $tag, $search, $sort, $exclude, $offset);
    $stores = get_stores_by_ids($stores_ids);

    return $stores;
}

function get_stories_global($count, $search, $category, $tag, $sort, $exclude = [], $offset = 0){

    global $wpdb;

    $category = empty($category) ? '%' : $category;
    $tag = empty($tag) ? '%' : $tag;

    $sort = $sort == 'rand' ? 'RAND()_' : $sort;

    $sort = empty($sort) ? 'newness_asc' : $sort;
    $order_by = explode('_', $sort)[0];
    $order = explode('_', $sort)[1];

    $exclude = !empty($exclude) ? implode(',', $exclude) : 0;

    $query = "
            SELECT 
                SQL_CALC_FOUND_ROWS
                u.ID as vendor_id, 
                ifnull(umr.meta_value, '0') as vendor_rating, 
                ifnull(ums.meta_value, '0') as vendor_name, 
                views.count as vendor_views,
                orders.orders_count as vendor_orders
            FROM wp_users u 

            LEFT JOIN wp_wcfm_marketplace_store_taxonomies as st ON st.vendor_id = u.ID
            
            LEFT JOIN wp_term_relationships as cat ON (st.product_id = cat.object_id) 
            LEFT JOIN wp_term_relationships as tag ON (st.product_id = tag.object_id)
            
            LEFT JOIN wp_usermeta as um 
                ON um.user_id = u.ID
            LEFT JOIN wp_usermeta as umr 
                ON umr.user_id = u.ID AND (umr.meta_key = '_wcfmmp_avg_review_rating' OR umr.meta_value is null)
            LEFT JOIN wp_usermeta as ums 
                ON ums.user_id = u.ID AND (ums.meta_key = 'wcfmmp_store_name' OR ums.meta_value is null)
                    
            LEFT JOIN (
                SELECT SUM(pmv.meta_value) as count, st.vendor_id as vendor_id FROM wp_wcfm_marketplace_store_taxonomies st
                LEFT JOIN wp_postmeta pmv ON pmv.post_id = st.product_id AND pmv.meta_key = '_wcfm_product_views'
                WHERE pmv.meta_value is not null
                AND st.vendor_id IN 
                    (SELECT u.ID FROM wp_users u)
                GROUP BY st.vendor_id
            ) as views ON views.vendor_id = u.ID
            
            LEFT JOIN (
                SELECT o.vendor_id as vendor_id, count(o.order_id) as orders_count
                FROM wp_wcfm_marketplace_orders o
                GROUP BY vendor_id
            ) as orders ON orders.vendor_id = u.ID
                
            WHERE um.meta_key = '_wcfmmp_profile_id' 
            AND ums.meta_value LIKE '%{$search}%'
            AND cat.term_taxonomy_id LIKE '{$category}'
            AND tag.term_taxonomy_id LIKE '{$tag}'
            
            AND u.ID NOT IN ({$exclude}) 
            
            GROUP BY u.ID
            ORDER BY 
                " . ($order_by == 'newness' ? "vendor_id {$order}" : "") . "
                " . ($order_by == 'trending' ? "vendor_views {$order}" : "") . "
                " . ($order_by == 'rating' ? "vendor_rating {$order}" : "") . "
                " . ($order_by == 'popularity' ? "vendor_orders {$order}" : "") . "
                " . ($order_by == 'RAND()' ? "RAND()" : "") . "
            LIMIT {$count}
            OFFSET {$offset}";

    $count_query = "select FOUND_ROWS();";

    $results = $wpdb->get_results($query, ARRAY_N);

    $count = $wpdb->get_results($count_query, ARRAY_A)[0]["FOUND_ROWS()"];

    $ids = [];

    foreach ($results as $item){
        $ids[] = $item[0];
    }

    return [ 'ids' => $ids, 'count' => $count ];
}


function get_vendor_avatar($id){
    $vendor = wcfmmp_get_store($id);

    $avatar_id = (int) $vendor->get_info_part( 'list_banner' );

    if ( ! $avatar_id ) {
        $avatar_id = (int) $vendor->get_info_part( 'banner' );
        if ( ! $avatar_id ) {
            $avatar_id = get_user_meta( $id, 'wp_user_avatar', true );
        }
    }

    return $avatar_id;
}
