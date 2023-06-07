<?php 
require get_template_directory() . '/inc/comments-helper.php';
function gamesonline_adv_theme_support(){
register_nav_menus(array('primary' =>  __('Primary Menu','games-online'), 'footer' => __('Footer Menu','games-online')));
add_image_size( 'post', 530, 353, true );
add_theme_support( 'starter-content');
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( "wp-block-styles" );
add_theme_support( "responsive-embeds" );
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
add_theme_support( "custom-header" );
add_theme_support( "custom-background");
add_theme_support( "align-wide" );
}

add_action('after_setup_theme','gamesonline_adv_theme_support');

function gamesonline_set_excerpt_length($length){
    if ( is_admin() ) return $length;
    return 10;
}

function gamesonline_the_category_list( $categories, $post_id ) {
    return array_slice( $categories, 0, 2, true );
}
add_filter( 'the_category_list', 'gamesonline_the_category_list', 10, 2 );
add_filter('excerpt_length','gamesonline_set_excerpt_length');


function gamesonline_LoadScripts(){
    wp_enqueue_style("tailwindcss",get_template_directory_uri()."/style.css");
    wp_enqueue_script('gamesOnline_hamburger',get_template_directory_uri().'/src/scripts/script.js',array(),'1.0.0',true);
}

add_action('wp_enqueue_scripts','gamesonline_LoadScripts');



function gamesonline_setTimeFrame(){
    echo  ('  <div class="w-full text-center hover:underline focus:underline"><p class="mx-auto mt-8  mb-2">'. esc_html__("Copyright © 2021","games-online") . " " .  bloginfo("title"). " " . esc_html__("All rights reserved.","games-online") .'</p><p >'. esc_html__("Theme By:","games-online").' <a href="https://jrpg.com/games-online-theme" class="hover:text-white focus:underline hover:underline">'.esc_html__("JRPG.com.","games-online").'</a></p></div>');
}

function gamesonline_enqueue_comments_reply() {
	if( get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
	}
	}
	add_action( 'comment_form_before', 'gamesonline_enqueue_comments_reply' );

	