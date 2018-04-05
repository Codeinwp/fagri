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
 * Change default fonts.
 *
 * @since 1.0.0
 */
function fagri_change_defaults( $wp_customize ) {

	/* Change default fonts */
	$fagri_headings_font = $wp_customize->get_setting( 'hestia_headings_font' );
	if ( ! empty( $fagri_headings_font ) ) {
		$fagri_headings_font->default = fagri_font_default_frontend();
	}
	$fagri_body_font = $wp_customize->get_setting( 'hestia_body_font' );
	if ( ! empty( $fagri_body_font ) ) {
		$fagri_body_font->default = fagri_font_default_frontend();
	}

}
add_action( 'customize_register', 'fagri_change_defaults', 99 );

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
 * Add color_accent on some elements
 *
 * @since 1.0.0
 */
function fagri_inline_style() {

	$color_accent = get_theme_mod( 'accent_color', '#2ca8ff' );
	$hestia_features_repeaters = get_theme_mod( 'hestia_features_content' );

	$hestia_features_content = json_decode( $hestia_features_repeaters );

	$custom_css = '';

	/* Feature box repeaters, icon shadow and title color, hover state included */
	if ( ! empty ( $hestia_features_content ) ) {
		foreach( $hestia_features_content as $index=>$value ) {

			$nth_of_type = $index + 1;
			$color_rgba = fagri_hex_rgba( $value->color, 0.3 );
			$color_rgba_on_hover = fagri_hex_rgba( $value->color, 0.35 );

			/* Hestia Pro */
			if ( isset( $value->choice ) ) {
				if ( $value->choice == 'customizer_repeater_icon' ) {

					$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html($nth_of_type ) . ') .hestia-info > a .icon { box-shadow: 0 9px 30px -6px ' .  esc_html( $color_rgba ) . '; }';
					$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html($nth_of_type ) . ') .hestia-info > a:hover .icon { box-shadow: 0 15px 35px 0 ' .  esc_html( $color_rgba_on_hover ) . '; }';
					$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html( $nth_of_type ) . ') .hestia-info > a:hover .info-title { color: ' . esc_html( $value->color ) . '; }';
				} else {
					$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html( $nth_of_type ) . ') .hestia-info > a:hover .info-title { color: ' . esc_html( $color_accent ) . '; }';
				}
			} else { /* Hestia Lite */
				$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html($nth_of_type ) . ') .hestia-info > a .icon { box-shadow: 0 9px 30px -6px ' .  esc_html( $color_rgba ) . '; }';
				$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html($nth_of_type ) . ') .hestia-info > a:hover .icon { box-shadow: 0 15px 35px 0 ' .  esc_html( $color_rgba_on_hover ) . '; }';
				$custom_css .= '.hestia-features-content .feature-box:nth-of-type(' . esc_html( $nth_of_type ) . ') .hestia-info > a:hover .info-title { color: ' . esc_html( $value->color ) . '; }';
			}

		}
	}

	if ( ! empty( $color_accent ) ) {

		// TODO: Add inline style
	}

	wp_add_inline_style( 'fagri_parent', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'fagri_inline_style', 10 );

/**
 * Remove parent theme actions
 *
 * @since 1.0.0
 */
// function fagri_remove_hestia_actions() {
//
// * Remove three points from blog read more button */
// remove_filter( 'excerpt_more', 'hestia_excerpt_more', 10 );
//
// }
// add_action( 'after_setup_theme', 'fagri_remove_hestia_actions' );
/**
 * Remove product description except from Single Product Page
 *
 * @since 1.0.0
 */
// function fagri_remove_product_description() {
//
// if ( class_exists( 'WooCommerce' ) ) {
// if ( ! is_product() ) {
// add_filter( 'woocommerce_short_description', '__return_empty_string' );
// }
// }
// }
// add_action( 'template_redirect', 'fagri_remove_product_description' );
/**
 * Replace excerpt "Read More" text with a link.
 *
 * @since 1.0.0
 */
// function fagri_excerpt_more( $more ) {
// global $post;
// if ( ( ( 'page' === get_option( 'show_on_front' ) ) ) || is_single() || is_archive() || is_home() ) {
// return '<a class="moretag" href="' . esc_url( get_permalink( $post->ID ) ) . '"> ' . esc_html__( 'Read more', 'fagri' ) . '</a>';
// }
//
// return $more;
// }
// add_filter( 'excerpt_more', 'fagri_excerpt_more' );
/**
 * Remove boxed layout control
 *
 * @since 1.0.0
 */
function fagri_remove_boxed_layout( $wp_customize ) {

	$wp_customize->remove_control( 'hestia_general_layout' );
}
add_action( 'customize_register', 'fagri_remove_boxed_layout', 100 );

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
 * Change default header image in Big Title Section
 *
 * @since 1.0.0
 * @return string - path to image
 */
function fagri_header_background_default() {
	return get_stylesheet_directory_uri() . '/assets/img/header.jpg';
}
add_filter( 'hestia_big_title_background_default', 'fagri_header_background_default' );


add_filter( 'hestia_welcome_notice_filter', 'fagri_welcome_notice_filter' );

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

add_filter( 'hestia_about_page_filter', 'fagri_about_page_filter', 0, 3 );

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

/**
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
function fagri_theme_setup() {
	load_child_theme_textdomain( 'fagri', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'fagri_theme_setup' );
