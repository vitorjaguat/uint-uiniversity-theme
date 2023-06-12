<!-- This is the generic blog listing screen template. -->

<?php

get_header();
pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'A recap of our past events.'
));
// see functions.php to see the pageBanner function definition
?>

<div class="container container--narrow page-section">
    <?php

    // Custom query:
    $today = date('Ymd');
    $pastEvents = new WP_Query(array(
        'paged' => get_query_var('paged', 1), //see below, this is for pagination to work when using custom queries
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num', //define the 'meta_key' to the name of the custom-field, and define 'orderby' to 'meta_value_num' in order to display the events by their event_date date.
        'type' => 'DATE',
        'order' => 'DES', //default is DEScending, also 'ASC'
        'meta_query' => array(
            array(
                'key' => 'event_date',
                'compare' => '<',
                'value' => $today, //only show posts where event_date is >= today
                'type' => 'numeric'
            )
        )
    ));



    while ($pastEvents->have_posts()) {
        $pastEvents->the_post(); ?>

        <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php the_permalink() ?>">
                <span class="event-summary__month"><?php
                                                    $eventDate = new DateTime(get_field('event_date'));
                                                    echo $eventDate->format('M');
                                                    ?></span>
                <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
            </a>
            <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
                <p><?php echo wp_trim_words(get_the_content(), 36); ?> <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a></p>
            </div>
        </div>

    <?php } ?>

    <!-- pagination (must pass these options because using custom query): -->
    <?php
    echo paginate_links(array(
        'total' => $pastEvents->max_num_pages,

    )) ?>

</div>

<?php get_footer();

?>