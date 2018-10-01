<?php
/**
 * Remove fields from customizer and remove postMessage support for some fields.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since biker 1.0
 */

function biker_customize_register( $wp_customize ) {

	$defaults = jolene_get_defaults();
	
	$wp_customize->remove_section('jolene_color_scheme');
	$wp_customize->remove_control('shadow_color');
	
	$wp_customize->add_setting( 'opacity', array(
		'default'        => $defaults['opacity'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'biker_sanitize_opacity'
	) );
	$wp_customize->add_control( 'opacity', array(
		'label'      => __('Opacity for menus and other elements', 'biker'),
		'section'    => 'colors',
		'settings'   => 'opacity',
		'type'       => 'select',
		'priority'   => 1,
		'choices'	 => array ('0.1' => '0.1', 
							   '0.2' => '0.2', 
							   '0.3' => '0.3', 
							   '0.4' => '0.4', 
							   '0.5' => '0.5',
							   '0.6' => '0.6', 
							   '0.7' => '0.7',
							   '0.8' => '0.8',
							   '0.9' =>  '0.9',
							   '1' => '1')
	) );
	
//column widget background

	$wp_customize->add_setting( 'top', array(
		'default'        => $defaults['top'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'biker_sanitize_background_position'
	) );
	$wp_customize->add_control( 'top', array(
		'label'   => __( 'Vertical position', 'biker' ),
		'section' => 'background_image',
		'settings'   => 'top',
		'type'       => 'select',
		'priority'   => 2,
		'choices'	 => array ('top' => __('Top', 'biker'),
								'center' => __('Center', 'biker'), 
								'bottom' => __('Bottom', 'biker'))
	) );
	
	$wp_customize->get_setting( 'menu1_color' )->transport = 'refresh';
	$wp_customize->get_setting( 'menu2_color' )->transport = 'refresh';
	$wp_customize->get_setting( 'menu3_color' )->transport = 'refresh';
	$wp_customize->get_setting( 'sidebar1_color' )->transport = 'refresh';
	$wp_customize->get_setting( 'sidebar2_color' )->transport = 'refresh';
}
add_action( 'customize_register', 'biker_customize_register', 21 );

/**
 * Sanitize opacity.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since biker 1.0
 */
function biker_sanitize_opacity( $value ) {
	$possible_values = array ('0.1', 
							   '0.2', 
							   '0.3', 
							   '0.4', 
							   '0.5',
							   '0.6', 
							   '0.7',
							   '0.8',
							   '0.9',
							   '1');
	return ( in_array( $value, $possible_values ) ? $value : '0.3' );
}

/**
 * Return string Sanitized backgroind position
 *
 * @since biker 1.0
 */
function biker_sanitize_background_position( $value ) {
	$possible_values = array( 'top', 'center', 'bottom');
	return ( in_array( $value, $possible_values ) ? $value : 'top' );
}

/**
 * Add custom styles to the header.
 *
 * @since biker 1.0
*/
function biker_hook_css() {
	$defaults = jolene_get_defaults();
	$def_colors = jolene_get_colors(get_theme_mod('color_scheme', $defaults['color_scheme']));
	
	$top = get_theme_mod('top', $defaults['top']);
	$opacity = get_theme_mod('opacity', $defaults['opacity']);
	
	$opacity = get_theme_mod('opacity', $defaults['opacity']);
	$min_opacity = ( floatval($opacity) < 0.5 ? 0.5 : floatval($opacity) );
	
?>

	<style type="text/css"> 
		/* Top Menu */
		
		.site {
			background: #000 url(<?php echo esc_url(get_theme_mod('column_background_url', jolene_get_column_background())); ?>) repeat  <?php echo esc_attr($top); ?> center fixed;		
		}
		
		.site-info-text-top  .site-title a {
			color: #<?php echo esc_attr( get_header_textcolor() ); ?>;

		}
		
		.column .widget {
			background: <?php echo esc_attr(biker_hex_to_rgba(get_theme_mod('widget_back', $def_colors['widget_back']), $opacity )); ?>;
		}
		
		.sidebar-top-full,
		.sidebar-before-footer {
			background-color:<?php echo esc_attr(biker_hex_to_rgba(get_theme_mod('sidebar1_color', $def_colors['sidebar1_color']), $opacity )); ?>;
		}	
		
		.sidebar-before-footer .widget {
			color: <?php echo esc_attr(get_theme_mod('sidebar1_text', $def_colors['sidebar1_text'])); ?>;
		}
		
		.sidebar-before-footer a {
			color: <?php echo esc_attr(get_theme_mod('sidebar1_link', $def_colors['sidebar1_link'])); ?>;
		}
		
		.sidebar-before-footer a:hover {
			color: <?php echo esc_attr(get_theme_mod('sidebar1_hover', $def_colors['sidebar1_hover'])); ?>;
		}
		
		.image-and-cats-big a,
		.image-and-cats a,
		.site-cat a {
			color: <?php echo esc_attr(get_theme_mod('link_color', $def_colors['link_color'])); ?>;
		}
	
		#top-1-navigation {
			background-color:<?php echo esc_attr(biker_hex_to_rgba(get_theme_mod('menu1_color', $def_colors['menu1_color']), $opacity )); ?>;
		}
	
		#top-1-navigation .horisontal-navigation li ul {
			background-color: <?php echo esc_attr(biker_hex_to_rgba(get_theme_mod('menu1_hover_back', $def_colors['menu1_hover_back']), $min_opacity )); ?>;
		}
	
		/* Second Top Menu */
		
		#top-navigation {
			background-color:<?php echo esc_attr(biker_hex_to_rgba(get_theme_mod('menu2_color', $def_colors['menu2_color']), $opacity )); ?>;
		}
	
		#top-navigation .horisontal-navigation li ul {
			background-color: <?php echo esc_attr(biker_hex_to_rgba(get_theme_mod('menu2_hover_back', $def_colors['menu2_hover_back']), $min_opacity )); ?>;
		}

		/* Footer Menu */
		
		.site-info,
		#footer-navigation {
			background-color:<?php echo esc_attr(biker_hex_to_rgba(get_theme_mod('menu3_color', $def_colors['menu3_color']), $opacity )); ?>;
		}
		
		#footer-navigation .horisontal-navigation li ul {
			background-color: <?php echo esc_attr(biker_hex_to_rgba(get_theme_mod('menu3_hover_back', $def_colors['menu3_hover_back']), $min_opacity )); ?>;
		}

		/* Footer Sidebar */
		
		.sidebar-footer {
			background-color:<?php echo esc_attr(biker_hex_to_rgba(get_theme_mod('sidebar2_color', $def_colors['sidebar2_color']), $opacity )); ?>;
		}	

		/* Top Sidebar */
		.sidebar-top-full,
		.sidebar-top {
			background-color:<?php echo esc_attr(biker_hex_to_rgba(get_theme_mod('sidebar1_color', $def_colors['sidebar1_color']), $opacity )); ?>;
		}	
		
		@media screen and (min-width: 1280px) {
			.page.two-sidebars .site-content,
			.two-sidebars .site-content {
				max-width: <?php echo esc_attr(get_theme_mod('content_width', $defaults['content_width'])); ?>px;
			}
		}	

	</style>
	<?php
}
add_action('wp_head', 'biker_hook_css', 21);
/**
 * biker Color scheme.
 *
 * Default Colors for the child theme biker.
 *
 * @since biker  1.0
 */
function biker_def_colors($def_colors) {
	$def_colors['widget_back'] = '#123456';
	$def_colors['site_name_back'] = '#fff';

	$def_colors['link_color'] = '#822f2c';
	$def_colors['heading_color'] = '#000';
	
	$def_colors['menu1_color'] = '#3f3f3f';
	$def_colors['menu1_link'] = '#fff';
	$def_colors['menu1_hover'] = '#eee';
	$def_colors['menu1_hover_back'] = '#111';
	
	$def_colors['menu2_color'] = '#ff5e58';
	$def_colors['menu2_link'] = '#fff';
	$def_colors['menu2_hover'] = '#fff';
	$def_colors['menu2_hover_back'] = '#822f2c';
	
	$def_colors['menu3_color'] = '#ff5e58';
	$def_colors['menu3_link'] = '#fff';
	$def_colors['menu3_hover'] = '#fff';
	$def_colors['menu3_hover_back'] = '#822f2c';
	
	$def_colors['sidebar1_color'] = '#ff5e58';
	$def_colors['sidebar1_link'] = '#fff';
	$def_colors['sidebar1_hover'] = '#ccc';
	$def_colors['sidebar1_text'] = '#eee';
	
	$def_colors['sidebar2_color'] = '#ff5e58';
	$def_colors['sidebar2_link'] = '#fff';
	$def_colors['sidebar2_hover'] = '#ccc';
	$def_colors['sidebar2_text'] = '#eee';
	
	//columns
	$def_colors['sidebar3_color'] = '#ff5e58';
	$def_colors['sidebar3_link'] = '#fff';
	$def_colors['sidebar3_hover'] = '#000';
	$def_colors['sidebar3_text'] = '#eee';
	
	$def_colors['column_header_color'] = '#eee';
	$def_colors['column_header_text'] = '#000';
	
	$def_colors['border_color'] = '#fff';
	$def_colors['border_shadow_color'] = '#000';
	
	$def_colors['hover_color'] = '#822f2c';
	$def_colors['description_color'] = '#eded50';
	
	return $def_colors;
}
add_filter('jolene_def_colors', 'biker_def_colors');
/**
 * Add biker Color scheme to the list of color schemes.
 *
 * @since biker  1.0
 */
function biker_schemes($jolene_schemes) {
	$jolene_schemes['biker'] = __( 'Biker', 'biker' );

	return $jolene_schemes;
}
add_filter('jolene_schemes', 'biker_schemes');

/**
 * Set biker def background to ''.
 *
 * @since biker  1.0
 */
function biker_column_background($jolene_schemes) {
	return get_stylesheet_directory_uri() . '/img/texture.jpg';
}
add_filter('jolene_column_background', 'biker_column_background');
/**
 * Transform hex color to rgba
 *
 * @param string $color hex color. 
 * @param int $opacity opacity. 
 * @return string rgba color.
 * @since biker 1.0.1
 */
function biker_hex_to_rgba( $color, $opacity ) {

	if ($color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	$hex = 'ffffff';
	
	if ( 6 == strlen($color) ) {
			$hex = array( $color[0].$color[1], $color[2].$color[3], $color[4].$color[5] );
	} elseif ( 3 == strlen( $color ) ) {
			$hex = array( $color[0].$color[0], $color[1].$color[1], $color[2].$color[2] );
	}

	$rgb =  array_map('hexdec', $hex);

	return 'rgba('.implode(",",$rgb).','.$opacity.')';
}