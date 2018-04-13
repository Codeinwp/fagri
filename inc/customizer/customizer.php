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
	$wp_customize->add_setting(
		'fagri_testimonials_background', array(
			'default'           => get_stylesheet_directory_uri() . '/assets/img/testimonials4.jpg',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
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

	if ( class_exists( 'Hestia_Customize_Control_Tabs' ) ) {
		/* Remove pricing tabs control from Hestia Pro */
		$wp_customize->remove_control( 'hestia_pricing_tabs' );

		/* Add another pricing tabs control in order to include the icon picker */
		$wp_customize->add_control(
			new Hestia_Customize_Control_Tabs(
				$wp_customize, 'hestia_pricing_tabs', array(
					'section' => 'hestia_pricing',
					'tabs'    => array(
						'general' => array(
							'nicename' => esc_html__( 'General', 'hestia-pro' ),
							'icon'     => 'cogs',
							'controls' => array(
								'hestia_pricing_hide',
								'hestia_pricing_title',
								'hestia_pricing_subtitle',
							),
						),
						'first'   => array(
							'nicename' => esc_html__( 'First', 'hestia-pro' ),
							'icon'     => 'table',
							'controls' => array(
								'fagri_pricing_table_one_icon',
								'hestia_pricing_table_one_title',
								'hestia_pricing_table_one_price',
								'hestia_pricing_table_one_features',
								'hestia_pricing_table_one_link',
								'hestia_pricing_table_one_text',
							),
						),
						'second'  => array(
							'nicename' => esc_html__( 'Second', 'hestia-pro' ),
							'icon'     => 'table',
							'controls' => array(
								'fagri_pricing_table_two_icon',
								'hestia_pricing_table_two_title',
								'hestia_pricing_table_two_price',
								'hestia_pricing_table_two_features',
								'hestia_pricing_table_two_link',
								'hestia_pricing_table_two_text',
							),
						),
					),
				)
			)
		);
	}

}
add_action( 'customize_register', 'fagri_customize_register', 99 );
