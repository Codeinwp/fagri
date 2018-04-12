<?php
/**
 * Customizer functionality for the theme
 *
 * @package fagri
 * @since 1.0.0
 */

/**
 * Customizer controls
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @since 1.0.0
 */
function fagri_customize_register( $wp_customize ) {

	/* Remove boxed layout control, old priority 100 */
	$wp_customize->remove_control( 'hestia_general_layout' );

	/* Change default fonts, old priority 99 */
	$fagri_headings_font = $wp_customize->get_setting( 'hestia_headings_font' );
	if ( ! empty( $fagri_headings_font ) ) {
		$fagri_headings_font->default = fagri_font_default_frontend();
	}
	$fagri_body_font = $wp_customize->get_setting( 'hestia_body_font' );
	if ( ! empty( $fagri_body_font ) ) {
		$fagri_body_font->default = fagri_font_default_frontend();
	}

	/* Add Icon Picker for pricing section, old priority 99 */
	require_once ( get_stylesheet_directory() . '/inc/customizer/customizer-iconpicker/class-customizer-iconpicker.php' );

	$wp_customize->add_setting(
		'fagri_pricing_table_one_icon', array(
			'transport'         => 'postMessage',
			'default'           => 'fa-gift',
		)
	);
	$wp_customize->add_control(
		new Customizer_Iconpicker(
			$wp_customize, 'fagri_pricing_table_one_icon', array(
				'label'    => esc_html__( 'Pricing Table One: Icon','fagri'),
				'section'  => 'hestia_pricing',
				'priority' => 10,
			)
		)
	);

	$wp_customize->add_setting(
		'fagri_pricing_table_two_icon', array(
			'transport'         => 'postMessage',
			'default'           => 'fa-gift',
		)
	);
	$wp_customize->add_control(
		new Customizer_Iconpicker(
			$wp_customize, 'fagri_pricing_table_two_icon', array(
				'label'    => esc_html__( 'Pricing Table Two: Icon','fagri'),
				'section'  => 'hestia_pricing',
				'priority' => 10,
			)
		)
	);

	/* Option for background image in testimonials section, old priority none */
	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	$wp_customize->add_setting(
		'fagri_testimonials_background', array(
			'default'           => get_stylesheet_directory_uri() . '/assets/img/testimonials4.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $selective_refresh,
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'fagri_testimonials_background', array(
				'label'    => esc_html__( 'Background Image', 'fagri' ),
				'section'  => 'hestia_testimonials',
				'priority' => 4,
			)
		)
	);

	/* Selective refresh for testimonials background image option, old priority none */
	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial(
		'fagri_testimonials_background', array(
			'selector'            => '.fagri-testimonials-background-switcher',
			'setting'             => 'fagri_testimonials_background',
			'render_callback'     => 'fagri_testimonials_background_callback',
			'container_inclusive' => false,
			'fallback_refresh'    => false,
		)
	);
	}

}
add_action( 'customize_register', 'fagri_customize_register', 99 );

/**
 * Callback function for testimonials section background image
 *
 * @since 1.0.0
 */
function fagri_testimonials_background_callback() {
	$fagri_testimonials_bg_image = get_theme_mod( 'fagri_testimonials_background' );
	if ( ! empty ( $fagri_testimonials_bg_image ) ) {
		?>
		<style class="fagri-testimonials-bg-image">
			.fagri-testimonials-wrapper {
				background-image: url( <?php echo esc_url( $fagri_testimonials_bg_image ); ?> ) !important;
			}
		</style>
		<?php
	} else {
		?>
		<style class="fagri-testimonials-bg-image">
			.home .fagri-testimonials-wrapper {
				background-image: none !important;
                background-color: #ffffff !important;
			}
            .fagri-testimonials-wrapper .hestia-title {
                color: #000000 !important;
            }
            .fagri-testimonials-wrapper .description {
                color: #000000 !important;
            }
        </style>
		<?php
	}
}