<!-- this file is used to render individual campuses -->

<?php
get_header();

while (have_posts()) {
    the_post(); 
    pageBanner();
    
    ?>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>
        <div class="generic-content">
            <?php the_content() ?>
        </div>

        <div class="acf-map">
            <div class="marker"
                <?php $map_location = get_field('map_location'); ?>
                data-lng="<?php echo $map_location['lng']; ?>"
                data-lat="<?php echo $map_location['lat']; ?>"
            >
                <h3><?php the_title(); ?></h3>
                <?php echo $map_location['address'] ?>
            </div>
                
 
        </div>

        <?php }

        // Related programs:
        $relatedPrograms = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'program',
            'orderby' => 'title', //define orderby to the post 'title' (professor's name)
            'type' => 'DATE',
            'order' => 'ASC', //default is DEScending
            'meta_query' => array(
                array(
                    'key' => 'related_campus',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"' //concatenating (.) to get a string  
                ) //only shows professors that have a custom field 'related_campus' equal to the current campus that is being visited
            )
        ));

        if ($relatedPrograms->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Programs Available at this Campus</h2>';
            echo '<ul class="min-list link-list">';
            while ($relatedPrograms->have_posts()) {
                $relatedPrograms->the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

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
            'posts_per_page' => -1,
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
                    'key' => 'related_campus',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"' //concatenating (.) to get a string  
                ) //only shows events that have a custom field 'related_campus' equal to the current program that is being visited
            )
        ));

        if ($homepageEvents->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming Events in ' . get_the_title() . '</h2>';
            echo '<br>';
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