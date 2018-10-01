<?php
/**
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage biker
 * @since biker 1.0
*/

/**
 * biker setup.
 *
 * @since biker 1.0
 */
function biker_setup() {
	remove_action('jolene_empty_sidebar_6', 'jolene_empty_sidebar_6');
	remove_action('jolene_empty_sidebar_8', 'jolene_empty_sidebar_8');
	remove_action('jolene_header_image', 'jolene_header_image');
	load_child_theme_textdomain( 'biker', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'biker_setup' );
/**
 * New Jolene setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * @since biker 1.0
 */

function jolene_setup() {

	$defaults = jolene_get_defaults();

	if ( get_theme_mod( 'is_show_top_menu', $defaults ['is_show_top_menu']) == '1' )
		register_nav_menu( 'top1', __( 'First Top Menu', 'jolene' ));
	if ( get_theme_mod( 'is_show_secont_top_menu', $defaults ['is_show_secont_top_menu']) == '1' )
		register_nav_menu( 'top2', __( 'Second Top Menu', 'jolene' ));
	if ( get_theme_mod( 'is_show_footer_menu', $defaults ['is_show_footer_menu']) == '1' )
		register_nav_menu( 'footer', __( 'Footer Menu', 'jolene' ));

	load_theme_textdomain( 'jolene', get_template_directory() . '/languages' );
	
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'custom-background', array(
		'default-color' => 'cccccc',
	) );

	add_theme_support( 'post-thumbnails' );
	
	set_post_thumbnail_size( 300, 9999 ); 
	
	add_image_size( 'jolene-full-width', jolene_big_thumbnail_size());//big thumbnail
	add_image_size( 'jolene-full-screen', 1309);//large thumbnail
	
	
	$args = array(
		'default-image'          => get_stylesheet_directory_uri() . '/img/biker.jpg',
		'default-text-color'     => 'ffffff',
		'width'                  => 1309,
		'height'                 => 390,
		'flex-height'            => true,
		'flex-width'             => false,
		'wp-head-callback'       => 'jolene_header_style',
		'admin-head-callback'    => 'jolene_admin_header_style',
		'admin-preview-callback' => 'jolene_admin_header_image',
	);
	add_theme_support( 'custom-header', $args );
		
	/*
	 * Enable support for Post Formats.
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );
	
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'caption'
	) );
	
	add_theme_support( 'title-tag' );
	
	/*
	 * Enable support for WooCommerce plugin.
	 */
	 
	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'jolene_setup' );


/**
 * Return the Google font stylesheet URL if available.
 *
 * @since biker 1.0
 */
function biker_get_font_url() {
	$font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans fonts, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'biker' ) ) {
		$subsets = 'latin,latin-ext';
		$family = 'Open+Sans:400italic,400,300';

		/* translators: To add an additional Open Sans character subset specific to your language,	
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Font: add new subset (greek, cyrillic, vietnamese)', 'biker' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		}
		if ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$query_args = array(
			'family' => $family,
			'subset' => $subsets,
		);
		$font_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
		
	}

	return $font_url;
}

/**
 * Enqueue parent and child scripts
 *
 * @package WordPress
 * @subpackage biker
 * @since biker 1.0
*/

function biker_enqueue_styles() {
    wp_enqueue_style( 'biker-parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'biker-style', get_stylesheet_uri(), array( 'biker-parent-style' ) );
    wp_enqueue_script( 'biker-nav', get_stylesheet_directory_uri() . '/js/navigation.js', array( ),'20151402', true );
	
	$font_url = biker_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'biker-fonts', esc_url_raw( $font_url ), array(), null );
	
}
add_action( 'wp_enqueue_scripts', 'biker_enqueue_styles' );

/**
 * Unregister fonts
 *
 * @since biker 1.0
 */
function biker_dequeue_styles() {
	
	wp_dequeue_style('jolene-fonts');
	
}
add_action( 'wp_print_styles', 'biker_dequeue_styles' );

/**
 * Print Demo Widget into the empty sidebar-6.
 *
 * @since biker 1.0
 */
function biker_empty_sidebar_6() {
	the_widget( 'WP_Widget_Calendar', 'title='.__('Calendar', 'biker'), 'before_widget=<div class="widget-wrap"><aside class="widget">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
	the_widget( 'WP_Widget_Recent_Posts', 'title='.__('Recent Posts', 'biker').'&sortby=post_modified', 'before_widget=<div class="widget-wrap"><aside class="widget">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
	the_widget( 'WP_Widget_Search', 'title='.__('Search', 'biker'), 'before_widget=<div class="widget-wrap"><aside class="widget widget_search">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
}
add_action('jolene_empty_sidebar_6', 'biker_empty_sidebar_6');

/**
 * Print Demo Widget into the empty sidebar-8.
 *
 * @since biker 1.0
 */
function biker_empty_sidebar_8() {
	the_widget( 'WP_Widget_Search', '', 'before_widget=<div class="widget-wrap"><aside class="widget widget_search">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
}
add_action('jolene_empty_sidebar_8', 'biker_empty_sidebar_8');

/**
 * biker setup.
 *
 * Filter for theme defaults.
 *
 * @since biker 1.0
 */
function biker_option_defaults($defaults){
	$defaults['color_scheme'] = 'biker';
	$defaults['is_second_menu_on_front_page_only'] = '0';
	$defaults['is_has_shop_sidebar'] = '';
	$defaults['is_has_mobile_sidebar'] = '';
	$defaults['is_text_on_front_page_only'] = '';
	$defaults['is_empty_6_on'] = 1;
	$defaults['is_empty_8_on'] = 1;
	$defaults['opacity'] = 0.3;
	$defaults['top'] = 'top';

	return $defaults;
}
add_filter('jolene_option_defaults', 'biker_option_defaults');

/**
 * Print the Header Image or large post image.
 *
 * @since Jolene 1.0.1
 */
function biker_header_image() {

	$defaults = jolene_get_defaults();
	
	if (  'large' == get_theme_mod( 'post_thumbnail', $defaults['post_thumbnail'] ) && !(function_exists('is_woocommerce') && is_woocommerce()) && ! is_front_page() && ! is_archive() && ! is_home() && ! is_search() ) {

		if( ! is_page() ) : ?>
			<div class="img-container">
				<div class="header-wrapper">
					<div class="image-and-cats-large">
						<div class="category-list">	
						<!-- Category-->
							<div class="site-cat">
								<h1 class="site-title"><?php echo get_the_category_list(', '); ?></h1>
							</div>
						</div>
						<?php if ( ! post_password_required() && ! is_attachment() ) :
									the_post_thumbnail('jolene-full-screen');
						endif; ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		<?php else :
				if ( has_post_thumbnail() ) : ?>
				<div class="img-container">
					<div class="header-wrapper">
						<div class="image-and-cats-large">
							<?php the_post_thumbnail('jolene-full-screen'); ?>
						</div><!-- .image-and-cats-big -->
					</div>
				</div>
			<?php endif; 
		endif; 	
		
		
	} else {
	
		if ( get_header_image() 
				&& ( get_theme_mod( 'is_header_on_front_page_only', $defaults['is_header_on_front_page_only'] ) != '1' || is_front_page())) : ?>		

			<div class="img-container">
				<?php if ( display_header_text() ) : ?>
				<?php endif; ?>
				
				<!-- Banner -->
				<div class="header-wrapper">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php header_image(); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
					</a>
				</div>

			</div>
		<?php endif;
	}
}
add_action( 'jolene_header_image', 'biker_header_image' );

// Add customize options.
require get_stylesheet_directory() . '/inc/customize.php';