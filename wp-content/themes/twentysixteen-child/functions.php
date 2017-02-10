<?php

function my_theme_enqueue_styles() {
  $parent_style = 'twentysixteen-style';
  wp_enqueue_style( $parent_style, get_stylesheet_uri() );
  wp_enqueue_style( 'child-style',
                    get_stylesheet_directory_uri() . '/style.css',
                    array( $parent_style ),
                    wp_get_theme()->get('Version')
  );
  echo(get_stylesheet_uri());/* DEBUGGING */
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

?>
