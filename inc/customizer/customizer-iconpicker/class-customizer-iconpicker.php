<?php
/**
 * This class allows developers to implement an icon picker control.
 *
 * @package fagri
 * @since 1.0.0
 */
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Class Customizer_Iconpicker - icon picker
 *
 * @since 1.0.0
 * @access public
 */
class Customizer_Iconpicker extends WP_Customize_Control {

	/**
	 * Control id
	 *
	 * @var - id
	 */
	public $id;

	/**
	 * Control default value
	 *
	 * @var string - default value.
	 */
	public $customizer_icon_container = '';

	/**
	 * Class constructor
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );

		if ( file_exists( get_stylesheet_directory() . '/inc/customizer/customizer-iconpicker/icons.php' ) ) {
			$this->customizer_icon_container = 'inc/customizer/customizer-iconpicker/icons';
		}
	}

	/**
	 * Enqueue resources for the control
	 */
	public function enqueue() {
		wp_enqueue_style( 'font-awesome' );

		wp_enqueue_style( 'iconpicker-style', get_stylesheet_directory_uri() . '/inc/customizer/customizer-iconpicker/css/admin-style.css', array(), time() );

		wp_enqueue_script( 'iconpicker-script', get_stylesheet_directory_uri() . '/inc/customizer/customizer-iconpicker/js/fontawesome-iconpicker.js', array( 'jquery' ), time(), true );

	}

	/**
	 * Render icon picker control
	 */
	public function render_content() {
		?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<span class="description customize-control-description">
				<?php
				echo sprintf(
					/* translators: 1. link to font awesome icons */
					esc_html__( 'Note: Some icons may not be displayed here. You can see the full list of icons at %1$s.', 'fagri' ),
					sprintf( '<a href="http://fontawesome.io/icons/" rel="nofollow">%s</a>', esc_html__( 'http://fontawesome.io/icons/', 'fagri' ) )
				);
				?>
			</span>


		<div class="input-group icp-container">
			<input data-placement="bottomRight" class="icp icp-auto"
				value="
				<?php
				if ( ! empty( $this->value() ) ) {
					echo esc_attr( $this->value() );
				}
				?>
				"
				type="text" <?php $this->link(); ?>">
				<span class="input-group-addon">
					<i class="fa <?php echo esc_attr( $this->value() ); ?>"></i>
				</span>
		</div>
		<?php
		get_template_part( $this->customizer_icon_container );

	}
}
