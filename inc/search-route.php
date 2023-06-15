<?php 

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch() {
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE, //the safest way to define a 'GET' request here
        'callback' => 'universitySearchResults'
    ));
}

function universitySearchResults($data) {
    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
        's' => sanitize_text_field($data['term']) //'s' property will filter posts; $data['term'] will get the search query; sanitize_text_field will prevent XSS attacks
    ));
    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
        'campuses' => array()

    ); // constructing the array of results only with the content that we want, separated by post-type

    while($mainQuery->have_posts()) {
        $mainQuery->the_post();
        if (get_post_type() == 'post' OR get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'postType' => get_post_type(),
                'authorName' => get_the_author()
            )); //array_push is a PHP method (same as .push() in JS). the 1st arg is the target array, the 2nd arg is the values to be pushed
        }
        if (get_post_type() == 'professor') {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
            ));
        }
        if (get_post_type() == 'program') {
            $relatedCampuses = get_field('related_campus');
            if ($relatedCampuses) {
                foreach($relatedCampuses as $campus) {
                    array_push($results['campuses'], array(
                        'title' => get_the_title($campus),
                        'permalink' => get_the_permalink($campus)
                    ));
                }
            }
            

            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'id' => get_the_ID()
            ));
        }
        if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
            if (has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 18);
            }

            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $description
            ));
        }
        if (get_post_type() == 'campus') {
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
            ));
        }
        
    }

    //Relationship query (for ex., if a professor post has a relationship with a program post, also return that professor when searching for the program)
    if ($results['programs']) {
        $programsMetaQuery = array('relation' => 'OR'); //constructing the mataquery to return all programs that match the serach term, then will use this metaquery to search for professors that have a relationship with that program

    foreach($results['programs'] as $item) {
        array_push($programsMetaQuery, array(
            'key' => 'related_programs',
            'compare' => 'LIKE',
            'value' => '"' . $item['id'] . '"'
        ));
    }

    $programRelationshipQuery = new WP_Query(array(
        'post_type' => array('professor', 'event'),
        'meta_query' => $programsMetaQuery
            ));
    
    while($programRelationshipQuery->have_posts()) {
        $programRelationshipQuery->the_post();

        if (get_post_type() == 'professor') {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
            ));
        }
        if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
            if (has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 18);
            }

            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $description
            ));
        }
    }

    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR)); //array_unique removes duplicates when an item is found in more than one query; array_values removes the "1", "2" from the results of array_unique
    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    }

    

    return $results; //dont't need to stress about JSON syntax, WP will automatically convert this array to readable JSON
}

?>