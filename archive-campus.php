<!-- This is the generic blog listing screen template. -->

<?php

get_header();
pageBanner(array(
    'title' => 'Our Campuses',
    'subtitle' => 'We have several conveniently located campuses.'
));
?> 
<!-- see functions.php for pageBanner function definition -->

<div class="container container--narrow page-section">

<div class="acf-map">
    <?php
        while(have_posts()) {
            the_post();
            $map_location = get_field('map_location');
    ?>
        <div class="marker"
            data-lng="<?php echo $map_location['lng']; ?>"
            data-lat="<?php echo $map_location['lat']; ?>"
        >
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php echo $map_location['address'] ?>
        </div>
    <?php } ?>
 
</div>



</div>

<?php get_footer();

?>