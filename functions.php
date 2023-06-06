<?php

function university_files() {
    wp_enqueue_style('university_main_styles', get_stylesheet_uri()); // adding styles from style.css

}

add_action('wp_enqueue_scripts', 'university_files'); // run university_files function before loading the head in html