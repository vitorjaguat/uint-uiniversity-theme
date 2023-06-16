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

    if (have_posts()) {
        while (have_posts()) {
            the_post(); 
            
            get_template_part('template-parts/content', get_post_type()); // will output template-parts/content-event if get_post_type is 'event', will output template-parts/content-program if get_post_type is program, etc etc
            
             } 
        // pagination:
        
        echo paginate_links();
    } else {
        echo '<h2 class="headline headline--small-plus">No results match that search.</h2>';
    }

    get_search_form(); //outputs the code from searchform.php, which is a search form equal to what exists in page-search.php

    ?>

</div>

<?php get_footer();

?>