<section class="vendors-list">
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

        <div class="list-filter">
            <div class="container">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-3 <?php echo $settings['category'] !== 'all' ? 'col-25' : ''; ?>">
                            <input name="search" value="<?php echo !empty($search) ? $search : ''; ?>" type="text" placeholder="<?php echo $settings['search_input_placeholder']; ?>"/>
                        </div>
                        <div class="col-md-3 <?php echo $settings['category'] !== 'all' ? 'col-25' : ''; ?>">
                            <div class="select-wrapper">
                                <select name="category">
                                    <?php foreach (get_terms(['taxonomy' => 'product_cat']) as $cat) : ?>
                                        <option value="<?php echo $cat->term_id; ?>" <?php check_field_selected($cat->term_id, $category); ?>><?php echo $cat->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 <?php echo $settings['category'] !== 'all' ? 'col-25' : ''; ?>">
                            <div class="select-wrapper">
                                <select name="tag">
                                    <option value=""><?php echo $settings['search_all_label']; ?></option>
                                    <?php foreach (get_terms(['taxonomy' => 'product_tag']) as $cat) : ?>
                                        <option value="<?php echo $cat->term_id; ?>" <?php check_field_selected($cat->term_id, $tag); ?>><?php echo $cat->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php if($settings['category'] !== 'all') : ?>
                            <div class="col-md-3 col-25">
                                <div class="select-wrapper">
                                    <select name="sort">
                                        <option value="desc" <?php check_field_selected('desc', $sort); ?>><?php echo __('Descending', 'hestia'); ?></option>
                                        <option value="asc" <?php check_field_selected('asc', $sort); ?>><?php echo __('Ascending', 'hestia'); ?></option>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="col-md-3 <?php echo $settings['category'] !== 'all' ? 'col-25' : ''; ?>">
                            <input type="submit" class="button-purple" value="<?php echo $settings['search_button_label']; ?>"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="list-content">
            <div class="row">
                <div id="ajax-content">
                    <?php foreach ($stores as $store) : ?>
                        <div class="col-md-6 col-lg-4 vendor-item" data="<?php echo $store['store_id']; ?>">
                            <?php include get_stylesheet_directory() . '/templates/vendors/vendors-item.php'; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="load-more">
                    <a href="#" class="button-purple" id="button-vendors-loading"><?php echo $settings['show_more_label']; ?>
                        <div class="icon"><div></div><div></div><div></div><div></div></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
