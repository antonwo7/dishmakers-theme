<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

<link rel='stylesheet' id='yith-wcwl-font-awesome-css'  href='http://dishmakers.loc/wp-content/plugins/yith-woocommerce-wishlist/assets/css/font-awesome.css?ver=4.7.0' type='text/css' media='all' />
<link rel='stylesheet' id='wcfm_fa_icon_css-css'  href='http://dishmakers.loc/wp-content/plugins/wc-frontend-manager/assets/fonts/font-awesome/css/wcfmicon.min.css?ver=6.5.4' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-shared-0-css'  href='http://dishmakers.loc/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css?ver=5.12.0' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-fa-brands-css'  href='http://dishmakers.loc/wp-content/plugins/elementor/assets/lib/font-awesome/css/brands.min.css?ver=5.12.0' type='text/css' media='all' />

<div id="flyer-review" class="inner flyer active">
<?php

    $product_id = isset($args['product_id']) ? $args['product_id'] : 0;

    $current_product = wc_get_product($product_id);
    $vendor_id = get_post_meta($product_id, '_wcfm_product_author', true);
    $vendor = get_vendor_info_by_id($vendor_id);
    $durations = get_the_terms($product_id, 'dishduration');
    $difficulties = get_the_terms($product_id, 'dishdifficulty');
    $tags = get_the_terms($product_id, 'product_tag');
    $cats = get_the_terms($product_id, 'product_cat');

    $vendor_banner = $vendor['banner'];
?>

<div class="flyer-container">
    <div class="flyer-review">
        <div class="flyer-description">
            <div class="product-name">
                <h3><?php echo $current_product->get_name(); ?></h3>
                <span></span>
            </div>
            <div class="clear"></div>
            <div class="vendor-info">
                <div class="vendor-icon">
                    <img src="<?php echo get_base64_img_by_src(wp_get_attachment_image_url($vendor['gravatar_id'])); ?>" alt="">
                </div>
                <div class="description">
                    <div class="name"><?php echo __('Store'); ?></div>
                    <div class="title"><?php echo $vendor['info']['store_name']; ?></div>
                    <div class="vendor-stars rating">
                        <span style="width:<?php echo get_vendor_rating($vendor_id); ?>;"></span>
                    </div>
                </div>

            </div>
            <div class="clear"></div>
            <div class="product-terms">
                <div id="flyer-categories">
                    <?php if($cats) : ?>
                        <b><?php echo __('Categories: '); ?></b>
                        <?php foreach ($cats as $i => $d) : ?>
                            <a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a><?php echo count($cats) !== $i + 1 ? ', ' : ''; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="flyer-tags">
                    <?php if($tags) : ?>
                        <b><?php echo __('Tags: '); ?></b>
                        <?php foreach ($tags as $i => $d) : ?>
                            <a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a><?php echo count($tags) !== $i + 1 ? ', ' : ''; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="flyer-duration">
                    <?php if($durations) : ?>
                        <b><?php echo __('Time: '); ?></b>
                        <?php foreach ($durations as $i => $d) : ?>
                            <a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a><?php echo count($durations) !== $i + 1 ? ', ' : ''; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="flyer-difficulty">
                    <?php if($difficulties) : ?>
                        <b><?php echo __('Difficulty: '); ?></b>
                        <?php foreach ($difficulties as $i => $d) : ?>
                            <a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a><?php echo count($difficulties) !== $i + 1 ? ', ' : ''; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-description">
                <?php echo $current_product->get_short_description(); ?>
            </div>
        </div>
    </div>
    <div class="flyer-image">
        <img src="<?php echo get_base64_img($current_product->get_image_id()); ?>" alt=""/>
    </div>
</div>
<div class="clear border4"></div>
<div class="flyer-ingredients" id="flyer-ingredients">
    <div class="ingredients-title">Ingredients</div>
    <div class="ul">
        <?php
        $ingredients = $ingredients_qty = [];
        $wooco_components = get_post_meta( $product_id , 'wooco_components', true );
        if ( is_array( $wooco_components ) ) {
            $ingredients = array_column($wooco_components, 'products');
            $ingredients_qty = array_column($wooco_components, 'qty');
        }
        ?>
        <?php foreach ( $ingredients as $i => $ingredient_id ) : $ingredient = wc_get_product($ingredient_id); ?>
            <div class="li">
                <img src="<?php echo get_base64_img( $ingredient->get_image_id() ); ?>" alt=""/>
                <div class="link"><a href="<?php echo get_permalink($ingredient_id); ?>"><?php echo get_the_title($ingredient_id); ?></a> (<?php echo $ingredients_qty[$i]; ?>)</div>
            </div>
            <?php if(($i+1) % 4 == 0) : ?>
                <div class="clear"></div>
            <?php endif;?>
        <?php endforeach; ?>
    </div>
</div>
<div class="clear"></div>
<div class="flyer-footer">
    <div class="logo">
        <a href="/">
            <img src="<?php echo get_base64_img_by_src(get_stylesheet_directory_uri() . '/production/img/logo-footer.png'); ?>" alt=""/>
        </a>
    </div>
    <div class="text">
        <img src="<?php echo get_base64_img_by_src(get_stylesheet_directory_uri() . '/production/img/mobil.png'); ?>" alt=""/><div>Download our IOS or Android app, or log in to bluepron.com for how-to videos and supplier stories.</div>
    </div>
</div>
