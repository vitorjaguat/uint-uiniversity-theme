<!-- this file is used to render individual pages -->

<?php 

    get_header();

    while(have_posts()) {
        the_post(); ?>
        
        <h2><?php the_title() ?></h2>
        <?php the_content(); ?>
        <div>This is a page, not a post</div>
    <?php }

    get_footer();

?>