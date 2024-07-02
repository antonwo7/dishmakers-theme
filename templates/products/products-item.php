<?php
    global $product;
    $product = wc_get_product($product_id);

    $image = get_the_post_thumbnail_url($product_id, 'thumb');
    $image = empty($image) ? 'https://via.placeholder.com/290x200' : $image;

    $vendor = get_vendor_info_by_id($vendor_id);

    $difficulties = get_the_terms($product_id, 'dishdifficulty');
    $durations = get_the_terms($product_id, 'dishduration');
    $tags = get_the_terms($product_id, 'product_tag');
    $cats = get_the_terms($product_id, 'product_cat');

    global $logged_user_id;
    $full_video = (isset($logged_user_id) && $logged_user_id != 0) ? get_post_meta( $product_id, 'full_video', true ) : '';

    $url = !empty($full_video) ? wp_get_attachment_url( $full_video ) : get_permalink( $product_id );
?>
<div class="item">
    <div class="item-image">
        <a class="<?php echo !empty($full_video) ? 'popup-trigger' : ''?>" <?php echo !empty($full_video) ? "data='#video-popup'" : ""; ?> href="<?php echo $url; ?>">
            <img src="<?php echo $image; ?>" alt=""/>
            <?php if(!empty($full_video)) : ?>
                <div class="video_back"><div></div></div>
            <?php endif; ?>
        </a>
    </div>
    <div class="item-footer">
        <div class="item-icon">

        </div>
        <div class="item-title">
            <a href="<?php echo get_permalink( $product_id ); ?>"><?php echo $product->get_name(); ?></a>
        </div>
        <div class="item-stars rating">
            <span style="width:<?php echo get_product_rating($product_id); ?>%;"></span>
        </div>
        <span class="item-price"><?php echo $product->get_price_html();?></span>
        <div>
            <?php echo woocommerce_template_loop_add_to_cart(); ?>
        </div>
        <div class="params">
            <?php if(!empty($difficulties)) : ?>
                <div>
                    <?php echo __('Difficulties: '); ?>
                    <?php foreach ($difficulties as $d) : ?>
                        <span><a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($durations)) : ?>
                <div>
                    <?php echo __('Duration: '); ?>
                    <?php foreach ($durations as $d) : ?>
                        <span><a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($tags)) : ?>
                <div>
                    <?php echo __('Tags: '); ?>
                    <?php foreach ($tags as $d) : ?>
                        <span><a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($cats)) : ?>
                <div>
                    <?php echo __('Categories: '); ?>
                    <?php foreach ($cats as $d) : ?>
                        <?php //if($d->slug !== 'all') : ?>
                            <span><a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a></span>
                        <?php //endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="order_info">
                <?php if(!empty($order_id)) : ?>
                    <div><?php echo 'Bestelnummer: '; ?><a href="<?php echo get_order_url($order_id); ?>"><span><?php echo $order_id; ?></span></a></div>
                <?php endif; ?>
                <?php if(!empty($order_date)) : ?>
                    <div><?php echo 'Besteldatum: '; ?><span><?php echo (new DateTime($order_date))->format("F j, Y"); ?></span></div>
                <?php endif; ?>
            </div>
        </div>
        <?php if($vendor_id) : ?>
            <div class="item-vendor">
                <div class="vendor-icon">
                    <a href="<?php echo wcfmmp_get_store_url($vendor_id); ?>">
                        <img src="<?php echo $vendor['banner']; ?>" alt=""/>
                    </a>
                </div>
                <div class="description">
                    <div class="name"><?php echo __('Store'); ?></div>
                    <div class="title"><a href="<?php echo wcfmmp_get_store_url($vendor_id); ?>"><?php echo $vendor['info']['store_name']; ?></a></div>
                    <div class="vendor-stars rating">
                        <span style="width:<?php echo get_vendor_rating($vendor_id); ?>%;"></span>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="item-vendor empty"></div>
        <?php endif; ?>
    </div>
</div>
