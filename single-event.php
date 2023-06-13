<!-- this file is used to render individual posts (not pages) -->

<?php
get_header();

while (have_posts()) {
    the_post();
    pageBanner();
    //see functions.php for pageBanner function definition
    ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home</a> <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content() ?>
        </div>

        <?php

        //Related programs:
        $relatedPrograms = get_field('related_programs');

        if ($relatedPrograms) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Related Program(s)</h2>';
            echo '<ul class="link-list min-list">';
            foreach ($relatedPrograms as $program) { ?>
                <li><a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program); ?></a></li>
        <?php }
            echo '</ul>';

            wp_reset_postdata();
        }

        //Related campus:
        $relatedCampus = get_field('related_campus');

        if ($relatedCampus) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Campus</h2>';
            echo '<ul class="link-list min-list">';
            foreach ($relatedCampus as $campus) { ?>
                <li><a href="<?php echo get_the_permalink($campus) ?>"><?php echo get_the_title($campus); ?></a></li>
        <?php }
            echo '</ul>';
        }
        wp_reset_postdata();


        ?>

    </div>


<?php }

get_footer();
?>