<?php if(is_admin()) : ?>
    <script src="<?php echo get_stylesheet_directory_uri() . '/production/js/app.js'?>"></script>
<?php endif; ?>

<div class="vendors-carousel">
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


        <div class="owl-carousel owl-theme vendors-slider">
            <?php foreach ($stores as $store) : ?>
            <div class="vendor-item">
                <?php include 'vendors-item.php'; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
