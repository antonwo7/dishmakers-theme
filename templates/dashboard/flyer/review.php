<div id="flyer-review" class="inner flyer active">
    <?php
    $product_id = isset($args['product_id']) ? $args['product_id'] : $product_id;

    $durations = [];
    $difficulties = [];
    $tags = [];
    $cats = [];
    $vendor = null;

    $product_name = '';
    $product_short_description = '';

    if(!empty($product_id) && $product_id !== 0){
        $current_product = wc_get_product($product_id);
        $vendor_id = get_post_meta($product_id, '_wcfm_product_author', true);
        $vendor = get_vendor_info_by_id($vendor_id);
        $durations = get_the_terms($product_id, 'dishduration');
        $difficulties = get_the_terms($product_id, 'dishdifficulty');
        $tags = get_the_terms($product_id, 'product_tag');
        $cats = get_the_terms($product_id, 'product_cat');

        $product_name = $current_product->get_name();
        $product_short_description = $current_product->get_short_description();
    }


    ?>
    <div class="flyer-review">
        <div class="flyer-description">
            <div class="product-name">
                <h3><?php echo $product_name; ?></h3>
                <span></span>
            </div>
            <?php if($vendor) : ?>
                <div class="vendor-info">
                    <?php if(!empty($vendor['banner'])) : ?>
                        <div class="vendor-icon">
                            <img src="<?php echo $vendor['banner']; ?>" alt="">
                        </div>
                    <?php endif; ?>
                    <div class="description">
                        <div class="name"><?php echo __('Store'); ?></div>
                        <div class="title"><?php echo $vendor['info']['store_name']; ?></div>
                        <div class="vendor-stars rating">
                            <span style="width:<?php echo get_vendor_rating($vendor_id); ?>;"></span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="product-terms">
                <div id="flyer-categories">
                    <b><?php echo __('Categories: '); ?></b>
                    <?php if($cats) : ?>
                        <?php foreach ($cats as $i => $d) : ?>
                            <span><a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a></span><?php echo count($cats) !== $i + 1 ? ', ' : ''; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="flyer-tags">
                    <b><?php echo __('Tags: '); ?></b>
                    <?php if($tags) : ?>
                        <?php foreach ($tags as $i => $d) : ?>
                            <span><a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a></span><?php echo count($tags) !== $i + 1 ? ', ' : ''; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="flyer-duration">
                    <b><?php echo __('Time: '); ?></b>
                    <?php if($durations) : ?>
                        <?php foreach ($durations as $i => $d) : ?>
                            <span><a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a></span><?php echo count($durations) !== $i + 1 ? ', ' : ''; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="flyer-difficulty">
                    <b><?php echo __('Difficulty: '); ?></b>
                    <?php if($difficulties) : ?>
                        <?php foreach ($difficulties as $i => $d) : ?>
                            <span><a href="<?php echo get_term_link($d->term_id); ?>"><?php echo $d->name; ?></a></span><?php echo count($difficulties) !== $i + 1 ? ', ' : ''; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-description">
                <?php echo $product_short_description; ?>
            </div>
        </div>
    </div>
    <div class="flyer-image">
        <img src="https://via.placeholder.com/600x600" alt=""/>
    </div>
    <div class="flyer-ingredients" id="flyer-ingredients">
        <div class="ingredients-title">Ingredients</div>
        <ul>
            <?php
            $ingredients = $ingredients_qty = [];
            if ( is_array( $wooco_components ) ) {
                $ingredients = array_column($wooco_components, 'products');
                $ingredients_qty = array_column($wooco_components, 'qty');
            }
            ?>
            <?php foreach ( $ingredients as $i => $ingredient_id ) : ?>
                <li>
                    <a href="<?php echo get_permalink($ingredient_id); ?>">
                        <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $ingredient_id ), 'thumbnail' )[0]; ?>" alt=""/>
                    </a>
                    <span><?php echo $ingredients_qty[$i]; ?></span>
                    <p><a href="<?php echo get_permalink($ingredient_id); ?>"><?php echo get_the_title($ingredient_id); ?></a></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<!--    <div class="flyer-footer">-->
<!--        <div class="logo">-->
<!--            <a href="">-->
<!--                <img src="https://works.seattleby.com/dishmakers/wp-content/uploads/2019/07/Dishmakers_Photoshop6_Plain_Paars-2.png" alt=""/>-->
<!--            </a>-->
<!--        </div>-->
<!--    </div>-->
    <div class="flyer-footer">
        <div class="logo">
            <a href="/">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/production/img/logo-footer.png" alt=""/>
            </a>
        </div>
<!--        <div class="text">-->
<!--            <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/production/img/mobil.png" alt=""/><div>Download our IOS or Android app, or log in to bluepron.com for how-to videos and supplier stories.</div>-->
<!--        </div>-->
    </div>
</div>
