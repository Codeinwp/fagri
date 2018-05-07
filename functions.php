<?php
/**
 * Fagri functions and definitions.
 *
 * @package fagri
 * @since 1.0.0
 */

define( 'FAGRI_VERSION', '1.0.0' );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'fagri_parent_css' ) ) :
	/**
	 * Enqueue parent style
	 *
	 * @since 1.0.0
	 */
	function fagri_parent_css() {
		wp_enqueue_style( 'fagri_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap' ), FAGRI_VERSION );
		wp_style_add_data( 'fagri_parent', 'rtl', 'replace' );
		wp_style_add_data( 'hestia_style', 'rtl', 'replace' );
	}

endif;
add_action( 'wp_enqueue_scripts', 'fagri_parent_css', 10 );

/**
 * Enqueue customizer js
 */
function fagri_customizer_preview_js() {

	wp_enqueue_script( 'fagri-customizer-preview-js', get_stylesheet_directory_uri() . '/assets/js/customizer-preview.js', array( 'jquery', 'customize-preview' ), FAGRI_VERSION, true );
}
add_action( 'customize_preview_init', 'fagri_customizer_preview_js', 10 );

/* Require files */
$fagri_customizer_controls = get_stylesheet_directory() . '/inc/customizer/customizer.php';
if ( file_exists( $fagri_customizer_controls ) ) {
	require_once $fagri_customizer_controls;
}

$fagri_inline_style = get_stylesheet_directory() . '/inc/inline-style.php';
if ( file_exists( $fagri_inline_style ) ) {
	require_once $fagri_inline_style;
}

$fagri_front_page_sections = get_stylesheet_directory() . '/inc/fp-sections.php';
if ( file_exists( $fagri_front_page_sections ) ) {
	require_once $fagri_front_page_sections;
}

/**
 * Change default font family for front end display.
 *
 * @return string
 *
 * @since 1.0.0
 */
function fagri_font_default_frontend() {
	return 'Montserrat';
}
add_filter( 'hestia_headings_default', 'fagri_font_default_frontend' );
add_filter( 'hestia_body_font_default', 'fagri_font_default_frontend' );

/**
 * Change default value of accent color
 *
 * @return string - default accent color
 * @since 1.0.0
 */
function fagri_accent_color() {
	return '#2ca8ff';
}
add_filter( 'hestia_accent_color_default', 'fagri_accent_color' );

/**
 * Change default value of gradient color
 *
 * @return string - default gradient color
 * @since 1.0.0
 */
function fagri_gradient_color() {
	return '#51bcda';
}
add_filter( 'hestia_header_gradient_default', 'fagri_gradient_color' );

/**
 * Change default header image in Big Title Section
 *
 * @since 1.0.0
 * @return string - path to image
 */
function fagri_header_background_default() {
	return get_stylesheet_directory_uri() . '/assets/img/header.jpg';
}
add_filter( 'hestia_big_title_background_default', 'fagri_header_background_default' );

/**
 * Add opacity to rgb.
 *
 * @param array $rgb RGB color.
 * @param int   $opacity Opacity value.
 */
function fagri_rgb_to_rgba( $rgb, $opacity ) {

	if ( ! is_array( $rgb ) ) {
		return '';
	}
	// Check for opacity
	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0;
		}
		$output = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ',', $rgb ) . ')';
	}

	return $output;
}

/**
 * HEX colors conversion to RGBA.
 *
 * @param array|string $input RGB color.
 * @param int          $opacity Opacity value.
 */
function fagri_hex_rgba( $input, $opacity = false ) {

	// Convert hexadeciomal color to rgb(a)
	$rgb = hestia_hex_rgb( $input );
	return hestia_rgb_to_rgba( $rgb, $opacity );
}

/**
 * Remove parent theme actions
 *
 * @since 1.0.0
 */
function fagri_remove_hestia_actions() {

	/* Remove three points from blog read more button */
	remove_filter( 'excerpt_more', 'hestia_excerpt_more', 10 );

}
add_action( 'after_setup_theme', 'fagri_remove_hestia_actions' );

/**
 * Replace excerpt more button and points with nothing
 *
 * @return string - string to show instead of excerpt more
 * @since 1.0.0
 */
function fagri_remove_excerpt_more_points() {

	if ( is_archive() || is_home() ) {
		return '<a class="moretag" href="' . esc_url( get_permalink( $post->ID ) ) . '"> ' . esc_html__( 'Read more', 'fagri' ) . '</a>';
	} else {
		return '';
	}
}
add_filter( 'excerpt_more', 'fagri_remove_excerpt_more_points' );

/**
 * Customize excerpt length on Blog page
 *
 * If current page is blog
 * 15 words if sidebar is active
 * 35 words if sidebar is hidden
 *
 * other pages than blog inherits the value from Hestia
 *
 * @param int $length - initial length.
 *
 * @return int - the new length
 *
 * @since 1.0.0
 */
function fagri_excerpt_length( $length ) {

	if ( is_archive() || is_home() ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			return 35;
		}
		return 15;
	}
	return $length;
}
add_filter( 'excerpt_length', 'fagri_excerpt_length', 1000 );

/**
 * Change metadata on Blog Post
 *
 * @return string - information to show on the bottom of the post
 */
function fagri_blog_post_metadata() {

	$author_name   = get_the_author_meta( 'display_name' );
	$author_email  = get_the_author_meta( 'user_email' );
	$author_avatar = get_avatar( $author_email, 30 );

	$post_categories = get_the_category_list( ' • ' );

	return sprintf(
		/* translators: %1$s is Author name wrapped, %2$s is Time */
		esc_html__( '%1$s %2$s', 'fagri' ),
		/* translators: %1$s is author gravatar */
		sprintf(
			'<span class="author-avatar">%1$s</span>',
			$author_avatar
		),
		/* translators: %1$s is Author name, %2$s is author link */
		sprintf(
			'<a href="%2$s" title="%1$s" class="vcard author"><strong class="fn">%1$s</strong></a>',
			esc_html( get_the_author() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
		)
	);
}
add_filter( 'hestia_blog_post_meta', 'fagri_blog_post_metadata' );

/**
 * Import options from Hestia
 *
 * @since 1.0.0
 */
function fagri_get_lite_options() {
	$hestia_mods = get_option( 'theme_mods_hestia' );
	if ( ! empty( $hestia_mods ) ) {
		foreach ( $hestia_mods as $hestia_mod_k => $hestia_mod_v ) {
			set_theme_mod( $hestia_mod_k, $hestia_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'fagri_get_lite_options' );

/**
 * Change default welcome notice that appears after theme first installed
 */
function fagri_welcome_notice_filter() {

	$theme = wp_get_theme();

	$theme_name = $theme->get( 'Name' );
	$theme      = $theme->parent();

	$theme_slug = $theme->get_template();

	$var = '<p>' . sprintf( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our %2$swelcome page%3$s.', $theme_name, '<a href="' . esc_url( admin_url( 'themes.php?page=' . $theme_slug . '-welcome' ) ) . '">', '</a>' ) . '</p><p><a href="' . esc_url( admin_url( 'themes.php?page=' . $theme_slug . '-welcome' ) ) . '" class="button" style="text-decoration: none;">' . sprintf( 'Get started with %s', $theme_name ) . '</a></p>';

	return $var;
}
add_filter( 'hestia_welcome_notice_filter', 'fagri_welcome_notice_filter' );

/**
 * Change About page defaults
 *
 * * TODO update description here
 *
 * @param string $old_value Old value beeing filtered.
 * @param string $parameter Specific parameter for filtering.
 */
function fagri_about_page_filter( $old_value, $parameter ) {

	switch ( $parameter ) {
		case 'menu_name':
		case 'pro_menu_name':
			$return = esc_html__( 'About fagri', 'fagri' );
			break;
		case 'page_name':
		case 'pro_page_name':
			$return = esc_html__( 'About fagri', 'fagri' );
			break;
		case 'welcome_title':
		case 'pro_welcome_title':
			/* translators: s - theme name */
			$return = sprintf( esc_html__( 'Welcome to %s! - Version ', 'fagri' ), 'fagri' );
			break;
		case 'welcome_content':
		case 'pro_welcome_content':
			$return = esc_html__( 'Fagri is a responsive WordPress theme with multipurpose design. It is a good fit for both small businesses and corporate businesses, as it is highly customizable via the Live Customizer. You can use Fagri for restaurants, startups, freelancer resume, creative agencies, portfolios, WooCommerce, or niches like sports, medical, blogging, fashion, lawyer sites etc. It has a one-page design, Sendinblue newsletter integration, widgetized footer, and a clean appearance. The theme is compatible with Elementor Page Builder, Photo Gallery, Flat Parallax Slider, and Travel Map; it is mobile friendly and optimized for SEO.', 'fagri' );
			break;
		default:
			$return = '';
	}
	return $return;
}
add_filter( 'hestia_about_page_filter', 'fagri_about_page_filter', 0, 3 );

/**
 * Declare text domain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function fagri_theme_setup() {
	load_child_theme_textdomain( 'fagri', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'fagri_theme_setup' );

