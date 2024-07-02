<?php if(is_admin()) : ?>
    <script src="<?php echo get_stylesheet_directory_uri() . '/production/js/app.js'?>"></script>
<?php endif; ?>

<div class="products-carousel">
    <div class="container-fluid">
        <div class="list-header">
            <div class="row">
                <div class="col-12">
                    <div class="header-wrapper">
                        <div class="title">
                            <h2><?php echo $settings['title']; ?></h2>
                        </div>
                        <div class="all-link">
                            <a class="button-purple small" href="<?php echo $settings['link_url']['url']; ?>"><?php echo $settings['link_text']; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="owl-carousel owl-theme products-slider">
            <?php foreach ($products as $item) :
                $product_id = $item['product_id'];
                $vendor_id = $item['vendor_id'];
                ?>
            <div class="product-item">
                <?php include 'products-item.php'; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
