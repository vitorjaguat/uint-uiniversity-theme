<?php

// function university_files() {
//     wp_enqueue_style('university_main_styles', get_stylesheet_uri()); // adding styles from style.css

function university_files()
{
    wp_enqueue_script('main-university-js', get_theme_file_uri('build/index.js'), array('jquery'), 1.0, true); // adding the main js file; it takes 3 more arguments besides the file uri: dependecies, theme version, and a booloan which stands for if we want to load the file right after loading the head of the page.
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i'); // adding styles from google fonts CDN link (without the https: part)
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); // adding styles from fontawesome CDN link (without the https: part)
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css')); // adding styles from /build/style-index.css
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css')); // adding styles from /build/style-index.css

}

add_action('wp_enqueue_scripts', 'university_files'); // run university_files function before loading the head in html

function university_features()
{
    register_nav_menu('headerMenuLocation', 'Header Menu Location'); // register menu location so that in the CMS the user can create and edit menus (see index.php, the exact location is set there)
    register_nav_menu('footerLocationOne', 'Footer Location 1');
    register_nav_menu('footerLocationTwo', 'Footer Location 2');
    add_theme_support('title-tag'); //enables dynamic titles on the page's tab
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{
    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }
}

add_action('pre_get_posts', 'university_adjust_queries'); //sort events in ascending order of their event_date field + not show past events

//see uint-university-theme/mu-plugins for other functions, eg university-post-types.php that defines custom post types (they are there so that the user can change the theme and keep having access to them in the CMS)
