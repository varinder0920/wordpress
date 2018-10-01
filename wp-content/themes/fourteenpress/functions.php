<?php
/**
 * Functions and definitions for the Fourteenpress theme.
 */
add_action( 'after_setup_theme', 'fourteenpress_theme_setup' );

function fourteenpress_theme_setup() {
    load_child_theme_textdomain( 'fourteenpress', get_stylesheet_directory() . '/languages' );
}

add_action('wp_enqueue_scripts', 'fourteenpress_enqueue_theme_style');

function fourteenpress_enqueue_theme_style() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

add_action('twentyfourteen_credits', 'fourteenpress_credits_handler');

function fourteenpress_credits_handler() {
    
    printf( __( '%s WordPress theme by <a href="%s">noorsplugin</a>', 'fourteenpress' ), 'Fourteenpress', 'https://noorsplugin.com/' ); ?> |
    <?php
}

add_action('widgets_init', 'fourteenpress_remove_left_sidebar', 11);

function fourteenpress_remove_left_sidebar() {
    unregister_sidebar('sidebar-1');
}

/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_posted_on() {
    if ( is_sticky() && is_home() && ! is_paged() ) {
            echo '<span class="featured-post">' . __( 'Sticky', 'twentyfourteen' ) . '</span>';
    }

    // Set up and print post meta information.
    printf(
            '<span class="entry-date"><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
            esc_url( get_permalink() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            get_the_author()
    );
}
