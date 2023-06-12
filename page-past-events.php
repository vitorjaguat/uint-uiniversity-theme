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
        $pastEvents->the_post();

        get_template_part('template-parts/content-event');

     } ?>

    <!-- pagination (must pass these options because using custom query): -->
    <?php
    echo paginate_links(array(
        'total' => $pastEvents->max_num_pages,

    )) ?>

</div>

<?php get_footer();

?>