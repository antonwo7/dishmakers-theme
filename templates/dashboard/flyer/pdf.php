<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

<link rel='stylesheet' id='yith-wcwl-font-awesome-css'  href='<?php echo site_url(); ?>/wp-content/plugins/yith-woocommerce-wishlist/assets/css/font-awesome.css?ver=4.7.0' type='text/css' media='all' />
<link rel='stylesheet' id='wcfm_fa_icon_css-css'  href='<?php echo site_url(); ?>/wp-content/plugins/wc-frontend-manager/assets/fonts/font-awesome/css/wcfmicon.min.css?ver=6.5.4' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-shared-0-css'  href='<?php echo site_url(); ?>/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css?ver=5.12.0' type='text/css' media='all' />
<link rel='stylesheet' id='elementor-icons-fa-brands-css'  href='<?php echo site_url(); ?>/wp-content/plugins/elementor/assets/lib/font-awesome/css/brands.min.css?ver=5.12.0' type='text/css' media='all' />

<div id="flyer-review" class="inner flyer active">
    <?php

    $product_id = isset($args['product_id']) ? $args['product_id'] : $product_id;

    $current_product = wc_get_product($product_id);
    $vendor_id = get_post_meta($product_id, '_wcfm_product_author', true);
    $vendor = get_vendor_info_by_id($vendor_id);
    $vendor_avatar = get_vendor_avatar($vendor_id);
    $durations = get_the_terms($product_id, 'dishduration');
    $difficulties = get_the_terms($product_id, 'dishdifficulty');
    $tags = get_the_terms($product_id, 'product_tag');
    $cats = get_the_terms($product_id, 'product_cat');

    ?>
    <div class="flyer-container">
        <div class="flyer-review">
            <div class="flyer-description">
                <div class="product-name">
                    <h3><?php echo $current_product->get_name(); ?></h3>
                    <span></span>
                </div>
                <div class="clear"></div>

                <?php if($vendor) : ?>
                    <div class="vendor-info">
                        <?php if(!empty($vendor_avatar)) : ?>
                            <div class="vendor-icon">
                                <img src="<?php echo get_base64_img_by_src(wp_get_attachment_image_src($vendor_avatar, [150, 150])[0]); ?>" alt="">
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

                <div class="clear"></div>
                <div class="product-terms">
                    <div id="flyer-categories">
                        <?php if($cats) : ?>
                            <b><?php echo __('Categories: '); ?></b>
                            <?php foreach ($cats as $i => $d) : ?>
                                <?php echo $d->name; ?><?php echo count($cats) !== $i + 1 ? ', ' : ''; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div id="flyer-tags">
                        <?php if($tags) : ?>
                            <b><?php echo __('Tags: '); ?></b>
                            <?php foreach ($tags as $i => $d) : ?>
                                <?php echo $d->name; ?><?php echo count($tags) !== $i + 1 ? ', ' : ''; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div id="flyer-duration">
                        <?php if($durations) : ?>
                            <b><?php echo __('Time: '); ?></b>
                            <?php foreach ($durations as $i => $d) : ?>
                                <?php echo $d->name; ?><?php echo count($durations) !== $i + 1 ? ', ' : ''; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div id="flyer-difficulty">
                        <?php if($difficulties) : ?>
                            <b><?php echo __('Difficulty: '); ?></b>
                            <?php foreach ($difficulties as $i => $d) : ?>
                                <?php echo $d->name; ?><?php echo count($difficulties) !== $i + 1 ? ', ' : ''; ?>
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
            <?php foreach ( $ingredients as $i => $ingredient_id ) : ?>
                <?php if($ingredient_id) : ?>
                    <?php $ingredient = wc_get_product($ingredient_id); ?>
                    <?php if($ingredient) : ?>
                        <div class="li">
                            <img src="<?php echo get_base64_img( $ingredient->get_image_id() ); ?>" alt=""/>
                            <div class="link"><?php echo get_the_title($ingredient_id); ?> (<?php echo $ingredients_qty[$i]; ?>)</div>
                        </div>
                    <?php endif; ?>
                    <?php if(($i+1) % 4 == 0) : ?>
                        <div class="clear"></div>
                    <?php endif;?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="clear"></div>
    <div class="flyer-footer">
        <div class="logo">
            <img src="<?php echo get_base64_img_by_src(get_stylesheet_directory_uri() . '/production/img/logo-footer.png'); ?>" alt=""/>
        </div>

    </div>
</div>
<?php $instructions = json_decode(get_post_meta($product_id, '_instructions', true)); ?>
<div id="flyer-steps" class="inner flyer steps">
    <div class="steps-wrapper">
        <div class="ingredients-title">Instructions</div>
        <ul>
            <?php if(!empty($instructions)) : ?>
                <?php foreach($instructions as $i => $instruction) : ?>
                    <li>
                        <b><?php echo $instruction[0]; ?></b>
                        <div class="clear"></div>
                        <p><?php echo strip_tags($instruction[1]); ?></p>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <div class="clear"></div>
    <div class="flyer-footer second-footer">
        <div class="logo">
            <img src="<?php echo get_base64_img_by_src(get_stylesheet_directory_uri() . '/production/img/logo-footer.png'); ?>" alt=""/>
        </div>
    </div>
</div>

<style>
    html{
        padding:0;
        margin:0;
        font-family: 'Roboto', sans-serif;
    }
    html a{
        color:#5e1691 !important;
    }
    .table{
        width:100%;
        td{
        }
    }
    .clear{
        display: block;
        width:100%;
        clear:both;
        float:none;
    }
    .inner.flyer {
        padding-top: 0;
        display: block;
        width: 100%;
        height:1060px;
    }

    .border4{
        border-bottom: 4px solid #5e1691;
    }
    .flyer-container{
        width:100%;
    }
    .inner.flyer .flyer-review {
        /*padding-right: 30px;*/
        width: 50%;
        float:left;
        margin:0 0;
    }
    .inner.flyer .flyer-review .flyer-description{
        /*margin-bottom:40px;*/
        margin:0 30px 10px 0 !important;
        padding:0 0 10px 0;
    }
    .inner.flyer .flyer-review .flyer-description .product-name {
        background: #5e1691;
        color: #fff;
        padding: 10px 20px;
        text-align: left;
        margin-bottom: 25px;
        margin-top:0;
        float:left;
        width:100%;
    }
    .inner.flyer .flyer-review .flyer-description .product-name h3 {
        font-size: 28px;
        margin-bottom: 10px;
        margin-top:0;
        line-height: 1;
    }
    .inner.flyer .flyer-review .flyer-description .product-name span {
        font-style: italic;
        font-size: 17px;
        line-height: 1.2;
    }
    .inner.flyer .flyer-review .flyer-description .product-terms {
        margin-top: 20px;
        font-size: 14px;
        margin-left:20px;
        color:#5e1691;
    }
    .inner.flyer .flyer-review .flyer-description .product-terms a{
        text-decoration:none;
        font-weight: 400;
        color:#5e1691;
    }
    .inner.flyer .flyer-review .flyer-description .product-terms div {
        text-align: left;
    }
    .inner.flyer .flyer-review .flyer-description .product-terms p {
        line-height: 1.2;
    }
    .inner.flyer .flyer-review .flyer-description .product-terms b {
        color: #5e1691;
        font-size: 13px;
        text-transform: uppercase;
    }
    .inner.flyer .flyer-review .flyer-description .product-description {
        margin-top: 20px;
        text-align: left;
        font-size: 13px;
        margin-left:20px;
    }
    .inner.flyer .flyer-image {
        width: 50%;
        float:right;
        margin:0 0 0 20px;
        padding:0 0 0 0;
        display:inline-block;
    }
    .inner.flyer .flyer-image img{
        max-width: 100%;
    }
    .inner.flyer .flyer-ingredients {
        margin-top: 40px;
        width: 100%;
        text-align: left;
    }
    .ingredients-title {
        color: #5e1691;
        font-size: 20px;
        font-weight: bold;
        margin:20px 20px 20px 20px;
    }
    .inner.flyer .flyer-ingredients .ul {
        display: block;
        width:100%;
        padding: 0;
        list-style: none;
        margin: 40px 0px 30px 0px;

    }
    .inner.flyer .flyer-ingredients .ul .li .img_link{
        display: inline-block;
    }
    .inner.flyer .flyer-ingredients .ul .li {
        width: 160px;
        float:left;
        display:inline-block;
        box-sizing: border-box;
        text-align: left !important;
        font-size:14px;
        margin-bottom:50px;
        padding:0 20px;
    }
    .inner.flyer .flyer-ingredients .ul .li .quantity{
        width:100%;
        text-align: center !important;
        display:block;
        color:#5e1691;
    }
    .inner.flyer .flyer-ingredients .ul .li .link{
        color:#5e1691;
    }
    .inner.flyer .flyer-ingredients .ul .li a{
        text-decoration: none;
        font-size: 14px;
        line-height:1;
    }
    .inner.flyer .flyer-ingredients .ul .li span {
        line-height:1;

    }
    .inner.flyer .flyer-ingredients .ul .li div{
        margin-bottom: 10px;
    }
    .inner.flyer .flyer-ingredients .ul .li p {
        text-align: center !important;
        font-weight: bold;
        text-transform: uppercase;
    }
    .inner.flyer .flyer-ingredients .ul .li img {
        max-width: 110px;
        margin:0;
        display:block;
    }
    .inner.flyer .flyer-footer {
        margin-top: 30px;
        width: 100%;
        height:65px;
        padding:10px;
    }
    .inner.flyer .flyer-footer .logo {
        max-width: 200px;
        padding:5px;
        margin: 0 auto;
    }
    .inner.flyer .flyer-footer .text {
        float:right;
        color:#fff;
        font-size:12px;
        width:360px;
        line-height: 1.2;
        padding-left: 40px;

    }
    .inner.flyer .flyer-footer .text div{
        padding-left:30px;
        margin-top:15px;
    }
    .inner.flyer .flyer-footer .text img{
        margin-right:10px;
        float:left;
        width:20px;
        margin-top:17px;
    }

    .item-vendor, .vendor-info {
        margin-top: 55px;
        background: #fff;
        width:100%;
        height:76px;
        display:inline-block;
        margin-bottom: 20px;
        margin-left:20px;
    }
    .item-vendor .description, .vendor-info .description {
        padding-left: 95px;
        text-align: left;
        font-size: 14px;
        margin:12px 0 0 0;
        float:left;
        display: inline-block;
    }
    .item-vendor .description, .vendor-info .description .name{
        color:#999;
    }
    .item-vendor .vendor-icon, .vendor-info .vendor-icon {
        width: 75px;
        height: 75px;
        padding: 4px;
        background: #fff;
        float:left;
        overflow: hidden;
        border: 1px solid #efefef;
        border-radius:37px;
    }
    .item-vendor .vendor-icon img, .vendor-info .vendor-icon img {
        max-width: 100%;
        border-radius:37px;
    }
    .item-vendor .vendor-stars, .vendor-info .vendor-stars {
        position: relative;
        font-size: 10px;
    }

    .flyer-footer{
        margin:30px 0 0 0;
        background: #5e1691;
        position:absolute;
        bottom:0;
        left:0;
    }
    .flyer-footer.second-footer{
        bottom:0;
    }
    .flyer-footer .logo{
        width:200px;
    }
    .flyer-footer .logo img{
        width:100%;
    }

    .rating {
        height: 1.618em;
        line-height: 1.618;
        font-family: 'Font Awesome 5 Free' !important;
        font-weight: 900;
        width: 6em;
        display: inline-block;
    }

    .rating:before {
         color: #47525d;
         content: "" "" "" "" "";
         opacity: .25;
         float: left;
         top: 0;
         left: 0;
         position: absolute;
     }

    .rating span {
        overflow: hidden;
        float: left;
        top: 0;
        left: 0;
        position: absolute;
        padding-top: 1.5em;
    }

    .rating span:before {
         content: "" "" "" "" "";
         top: 0;
         position: absolute;
         left: 0;
         color: #FF912C;
     }

    .inner.steps {
        padding-top: 20px;

    }

    .inner.flyer.steps ul {
        list-style: none;
        padding: 0;
        margin:0;
    }
    .inner.flyer.steps ul li {
        padding-left: 30px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .inner.flyer.steps ul li:before {
        content: '1';
        color: #fff;
        text-align: center;
        border-radius: 10px;
        width: 20px;
        height: 20px;
        display:block;
        float:left;
        background: #5e1691;
        font-size: 12px;
        line-height: 1.2;
        margin-right:10px;
    }
    .inner.flyer.steps ul li b {
        color: #5e1691;
        line-height: 1.1;
        float:left;
    }
    .inner.flyer.steps ul li p{
        margin-left:30px;
    }
    .inner.flyer.steps ul li:nth-child(1):before {
        content: "1";
    }
    .inner.flyer.steps ul li:nth-child(2):before {
        content: "2";
    }
    .inner.flyer.steps ul li:nth-child(3):before {
        content: "3";
    }
    .inner.flyer.steps ul li:nth-child(4):before {
        content: "4";
    }
    .inner.flyer.steps ul li:nth-child(5):before {
        content: "5";
    }
    .inner.flyer.steps ul li:nth-child(6):before {
        content: "6";
    }
    .inner.flyer.steps ul li:nth-child(7):before {
        content: "7";
    }
    .inner.flyer.steps ul li:nth-child(8):before {
        content: "8";
    }
    .inner.flyer.steps ul li:nth-child(9):before {
        content: "9";
    }
    .inner.flyer.steps ul li:nth-child(10):before {
        content: "10";
    }
    .inner.flyer.steps ul li:nth-child(11):before {
        content: "11";
    }
    .inner.flyer.steps ul li:nth-child(12):before {
        content: "12";
    }
    .inner.flyer.steps ul li:nth-child(13):before {
        content: "13";
    }
    .inner.flyer.steps ul li:nth-child(14):before {
        content: "14";
    }
    .inner.flyer.steps ul li:nth-child(15):before {
        content: "15";
    }
    .inner.flyer.steps ul li:nth-child(16):before {
        content: "16";
    }
    .inner.flyer.steps ul li:nth-child(17):before {
        content: "17";
    }
    .inner.flyer.steps ul li:nth-child(18):before {
        content: "18";
    }
    .inner.flyer.steps ul li:nth-child(19):before {
        content: "19";
    }
    .inner.flyer.steps ul li:nth-child(20):before {
        content: "20";
    }


</style>
