<!-- this file is used to render individual posts (not pages) -->

<?php
get_header();

while (have_posts()) {
    the_post(); 
    pageBanner();
    
    ?>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content() ?>
        </div>

        <?php }

        // Related professors:
        $relatedProfessors = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby' => 'title', //define orderby to the post 'title' (professor's name)
            'type' => 'DATE',
            'order' => 'ASC', //default is DEScending
            'meta_query' => array(
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"' //concatenating (.) to get a string  
                ) //only shows professors that have a custom field 'related_programs' equal to the current program that is being visited
            )
        ));

        if ($relatedProfessors->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors</h2>';
            echo '<ul class="professor-cards">';
            while ($relatedProfessors->have_posts()) {
                $relatedProfessors->the_post(); ?>
                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink(); ?>">
                <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape') ?>" alt="<?php the_title(); ?>">
                <span class="professor-card__name"><?php the_title(); ?></span>
                </a>

                </li>
        <?php }
            echo '</ul>';
            
        }
        wp_reset_postdata();
        ?>

<?php 

        // Related events:
        $today = date('Ymd');
        $homepageEvents = new WP_Query(array(
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num', //define the 'meta_key' to the name of the custom-field, and define 'orderby' to 'meta_value_num' in order to display the events by their event_date date.
            'type' => 'DATE',
            'order' => 'ASC', //default is DEScending
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today, //only show events where event_date is >= today
                    'type' => 'numeric'
                ),
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"' //concatenating (.) to get a string  
                ) //only shows events that have a custom field 'related_programs' equal to the current program that is being visited
            )
        ));

        if ($homepageEvents->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
            while ($homepageEvents->have_posts()) {
                $homepageEvents->the_post(); 
                get_template_part('template-parts/content-event');
         }

            wp_reset_postdata();
        }
        ?>

    </div>






    </div>


<?php 

get_footer();
?>