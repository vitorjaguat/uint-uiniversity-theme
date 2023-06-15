<!-- the search results will be displayed here in this page -->

<?php

get_header();
pageBanner(array(
    'title' => 'Search Results',
    'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query(false)) . '&rdquo;'
));
// see functions.php to see the pageBanner function definition
?>

<div class="container container--narrow page-section">
    <?php

    while (have_posts()) {
        the_post(); 
        
        get_template_part('template-parts/content', get_post_type()); // will output template-parts/content-event if get_post_type is 'event', will output template-parts/content-program if get_post_type is program, etc etc
        
        ?>
        
    <?php } ?>

    <!-- pagination: -->
    <?php
    echo paginate_links() ?>

</div>

<?php get_footer();

?>