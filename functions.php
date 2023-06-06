<?php

// function university_files() {
//     wp_enqueue_style('university_main_styles', get_stylesheet_uri()); // adding styles from style.css

function university_files() {
    wp_enqueue_script('main-university-js', get_theme_file_uri('build/index.js'), array('jquery'), 1.0, true); // adding the main js file; it takes 3 more arguments besides the file uri: dependecies, theme version, and a booloan which stands for if we want to load the file right after loading the head of the page.
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i'); // adding styles from google fonts CDN link (without the https: part)
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); // adding styles from fontawesome CDN link (without the https: part)
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css')); // adding styles from /build/style-index.css
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css')); // adding styles from /build/style-index.css
    

    

}

add_action('wp_enqueue_scripts', 'university_files'); // run university_files function before loading the head in html