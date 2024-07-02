<?php /* Template Name: Biblotheek Page */ ?>

<?php $logged_user_id = get_current_user_id(); ?>

<?php get_header(); ?>

<?php do_action( 'hestia_page_builder_full_before_content' ); ?>
    <script>
        var __logged_user_id = <?php echo $logged_user_id; ?>
    </script>
    <div class="<?php echo hestia_layout(); ?>">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/content', 'pagebuilder' );
            endwhile;
        endif;
        ?>
    </div>

<?php do_action( 'hestia_page_builder_full_after_content' ); ?>

<?php get_footer();
