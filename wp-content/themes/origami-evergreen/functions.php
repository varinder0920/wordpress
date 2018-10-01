<?php

/**
 * Enqueue scripts and styles for Origami Evergreen
 *
 * @action wp_enqueue_scripts
 */
function origami_evergreen_enqueue_scripts(){
	wp_enqueue_style('origami-original', get_template_directory_uri().'/style.css');
	wp_enqueue_script('origami-evergreen-menu', get_stylesheet_directory_uri().'/js/menu.js', array('jquery'));
}
add_action('wp_enqueue_scripts', 'origami_evergreen_enqueue_scripts', 9);

/**
 * Change the default background settings for Origami Evergreen.
 *
 * @param $background
 * @return mixed
 * @filter origami_custom_background
 */
function origami_evergreen_filter_background($background){
	$background['default-image'] = get_stylesheet_directory_uri().'/images/background.png';
	$background['default-color'] = 'd8d2c9';
	return $background;
}
add_filter('origami_custom_background', 'origami_evergreen_filter_background');

/**
 * We'll render our own logo.
 *
 * @action origami_before_page_container
 */
function origami_evergreen_render_logo(){
	get_template_part('parts/logo', 'evergreen');
}
add_action('origami_before_page_container', 'origami_evergreen_render_logo', 9);

/**
 * Create the new top menu.
 *
 * @action origami_before_page_container
 */
function origami_evergreen_display_top_menu(){
	?><div id="origami-evergreen-wrapper"><div id="main-menu-wrapper"><?php

	wp_nav_menu(array(
		'theme_location' => 'primary',
		'menu_id' => 'top-bar-menu',
	));
	?></div><?php
}
add_action('origami_before_page_container', 'origami_evergreen_display_top_menu');

/**
 * Close off the page container.
 *
 * @action origami_after_page_container
 */
function origami_evergreen_origami_after_page_container(){
	?></div><?php
}
add_action('origami_after_page_container', 'origami_evergreen_origami_after_page_container');

/**
 *
 */
function origami_evergreen_before_footer_widgets(){
	// Close off #page-container and open the footer widgets wrapper
	?></div><?php
}
add_action('origami_before_footer_widgets', 'origami_evergreen_before_footer_widgets');

function origami_evergreen_after_footer_widgets(){
	// Close off footer widgets wrapper
	?><div><?php
}
add_action('origami_after_footer_widgets', 'origami_evergreen_after_footer_widgets');

/**
 * This just displays the Google web fonts. Overwrites the function in Origami parent theme.
 */
function origami_enqueue_google_webfonts(){
	wp_enqueue_style('google-webfonts', 'http://fonts.googleapis.com/css?family=Roboto+Slab:400');
}

/**
 * We need to change some customizer values if Origami Premium is installed
 */
function origami_evergreen_premium_filter_customizer($settings){
	$settings['origami_fonts']['title_font']['default'] = 'Roboto Slab';
	$settings['origami_fonts']['heading_font']['default'] = 'Helvetica Neue';
	$settings['origami_page']['background_color']['default'] = '#fbf9f5';

	unset($settings['origami_page']['border_color']);
	unset($settings['origami_menu']);

	return $settings;
}
add_filter('origami_siteorigin_theme_customizer_settings', 'origami_evergreen_premium_filter_customizer');