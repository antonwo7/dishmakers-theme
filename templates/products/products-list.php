<section class="products-list">
    <div class="container">
        <div class="list-header">
            <div class="row">
                <div class="col-6">
                    <div class="title">
                        <h1><?php echo $settings['title']; ?></h1>
                    </div>
                </div>
                <div class="col-6 text-right">
                    <div class="all-link"><a href="<?php echo $settings['link_url']['url']; ?>"><?php echo $settings['link_text']; ?></a></div>
                </div>
            </div>
        </div>

        <script>
            var __type = '<?php echo $settings['category']; ?>';
            var __cat = '<?php echo $category; ?>';
            var __tag = '<?php echo $tag; ?>';
            var __sort = '<?php echo $sort; ?>';
            var __search = '<?php echo $search; ?>';
        </script>


        <?php include get_stylesheet_directory() . '/templates/products/parts/filter.php'; ?>


        <div class="list-content">
            <div class="row">
                <div id="ajax-content">
                    <?php if(!empty($products)) :?>
                        <?php foreach ($products as $item) :
                            $product_id = $item['product_id'];
                            $vendor_id = $item['vendor_id'];
                            $order_id = !empty($item['order']['order_id']) ? $item['order']['order_id'] : '';
                            $order_date = !empty($item['order']['order_date']) ? $item['order']['order_date'] : '';
                            $found = empty($found) ? 0 : $found;
                        ?>
                        <div class="col-md-6 col-lg-4 product-item" data="<?php echo $product_id; ?>">
                            <?php include get_stylesheet_directory() . '/templates/products/products-item.php'; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php if($logged_user_id != 0) : ?>
                            <div class="nothing_found">hier komen uw bereidingsvideo's</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if(!empty($products) && count($products) < $found) : ?>
                    <div class="load-more">
                        <a href="#" exclude_terms="<?php echo !empty($settings['cats_exclude']) ? implode($settings['cats_exclude']) : ''; ?>" class="button-purple" id="button-products-loading"><?php echo $settings['show_more_label']; ?>
                            <div class="icon"><div></div><div></div><div></div><div></div></div>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php include get_stylesheet_directory() . '/templates/products/parts/video_popup.php'; ?>
        </div>
    </div>
</section>
