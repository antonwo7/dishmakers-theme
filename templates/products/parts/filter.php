<?php
    $class = is_tax('product_tag') || is_tax('product_cat') || $settings['category'] === 'all' ? 'col-md-3' : 'col-md-3 col-25';
?>

<div class="list-filter">
    <div class="container">
        <form action="" method="get">
            <div class="row">
                <div class="<?php echo $class; ?>">
                    <input name="search" value="<?php echo !empty($search) ? $search : ''; ?>" type="text" placeholder="<?php echo $settings['search_input_placeholder']; ?>"/>
                </div>

                <?php if(!is_tax('product_cat')) : ?>
                <div class="<?php echo $class; ?>">
                    <div class="select-wrapper">
                        <select name="category">
                            <option value=""><?php echo __('All', 'hestia'); ?></option>
                            <?php foreach (get_terms(['taxonomy' => 'product_cat']) as $cat) :
                                if(!empty($settings['category']) && in_array($cat->term_id, $settings['cats_exclude'])) continue; ?>
                                <option value="<?php echo $cat->term_id; ?>" <?php check_field_selected($cat->term_id, $category); ?>><?php echo $cat->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(!is_tax('product_tag')) : ?>
                <div class="<?php echo $class; ?>">
                    <div class="select-wrapper">
                        <select name="tag">
                            <option value=""><?php echo $settings['search_all_label']; ?></option>
                            <?php foreach (get_terms(['taxonomy' => 'product_tag']) as $cat) : ?>
                                <option value="<?php echo $cat->term_id; ?>" <?php check_field_selected($cat->term_id, $tag); ?>><?php echo $cat->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($settings['category'] !== 'all') : ?>
                    <div class="<?php echo $class; ?>">
                        <div class="select-wrapper">
                            <select name="sort">
                                <option value="desc" <?php check_field_selected('desc', $sort); ?>><?php echo __('Descending', 'hestia'); ?></option>
                                <option value="asc" <?php check_field_selected('asc', $sort); ?>><?php echo __('Ascending', 'hestia'); ?></option>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="<?php echo $class; ?>">
                    <input type="submit" class="button-purple" value="<?php echo $settings['search_button_label']; ?>"/>
                </div>
            </div>
        </form>
    </div>
</div>
