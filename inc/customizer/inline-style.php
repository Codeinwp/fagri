<?php
/**
 * Inline style for the theme
 *
 * @package fagri
 * @since 1.0.0
 */

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

		/* Team section, team member function */
		$custom_css .= '.home .fagri-team-wrapper .hestia-team .card-profile .col-md-7 .content .category { color: ' . esc_html( $color_accent ) . ' }';

		/* Testimonials quotes */
		$custom_css .= '.home .fagri-testimonials-wrapper .hestia-testimonials .hestia-testimonials-content .card-testimonial .content .card-description::before { color: ' . esc_html( $color_accent ) . '; }';

		/* Contact Form, fields border color */
		$custom_css .= ' .home .hestia-contact .card-contact .content .contact_name_wrap .form-group.is-focused { border-color: ' . esc_html( $color_accent ) . '; }';
		$custom_css .= ' .home .hestia-contact .card-contact .content .contact_email_wrap .form-group.is-focused { border-color: ' . esc_html( $color_accent ) . '; }';
		$custom_css .= ' .home .hestia-contact .card-contact .content .contact_subject_wrap .form-group.is-focused { border-color: ' . esc_html( $color_accent ) . '; }';

		/* Blog authors section function color */
		$custom_css .= '.authors-on-blog .card-profile.card-plain .col-md-7 .content .category { color: ' . esc_html( $color_accent ) . '; }';
	}

	/* Card pricing icon color */
	$custom_css .= '.home .hestia-pricing .card-pricing .content .fagri-pricing-icon-wrapper { box-shadow: 0px 9px 30px -6px ' . esc_html( $color_accent ) . '; }';
	$custom_css .= '.home .hestia-pricing .card-pricing .content .fagri-pricing-icon-wrapper { color: ' . esc_html( $color_accent ) . '; }';

	/* Card pricing table one colors */
	$custom_css .= '.home .hestia-pricing .hestia-table-one .card-pricing { background-color: ' . esc_html( $color_accent ) . '; }';
	$custom_css .= '.home .hestia-pricing .hestia-table-one .card-pricing .content .fagri-pricing-icon-wrapper { color: ' . esc_html( $color_accent ) . '; box-shadow: 0px 9px 30px -6px ' . esc_html( $color_accent ) . ';}';
	$custom_css .= '.home .hestia-pricing .hestia-table-one .card-pricing .content .btn { color: ' . esc_html( $color_accent ) . '; }';

	/* Home Blog section, post category color */
	$custom_css .= '.home .hestia-blogs .card-blog .content .category { color: ' . esc_html( $color_accent ) . '; }';
	$custom_css .= '.home .hestia-blogs article:nth-child(6n+1) .category a { color: ' . esc_html( $color_accent ) . '; }';
	$custom_css .= '.home .hestia-blogs article:nth-child(6n+2) .category a { color: ' . esc_html( $color_accent ) . '; }';
	$custom_css .= '.home .hestia-blogs article:nth-child(6n+3) .category a { color: ' . esc_html( $color_accent ) . '; }';
	$custom_css .= '.home .hestia-blogs article:nth-child(6n+4) .category a { color: ' . esc_html( $color_accent ) . '; }';
	$custom_css .= '.home .hestia-blogs article:nth-child(6n+5) .category a { color: ' . esc_html( $color_accent ) . '; }';
	$custom_css .= '.home .hestia-blogs article:nth-child(6n+6) .category a { color: ' . esc_html( $color_accent ) . '; }';

	/* Blog page, regular post's categories colors */
	$custom_css .= '.blog .blog-posts-wrap .card-blog:nth-of-type(2n+1) .category a { color: ' . esc_html( $color_accent ) . '; }';
	$custom_css .= '.blog .blog-posts-wrap .card-blog:nth-of-type(2n+2) .category a { color: ' . esc_html( $color_accent ) . '; }';

	wp_add_inline_style( 'fagri_parent', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'fagri_inline_style', 10 );