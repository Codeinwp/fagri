<?php
/**
 * This file contains all the pluggable functions from the parent theme that are overwritten in order to extend parent theme functionality. Also, there are some functions used within the overwritten functions of the parent theme
 */

/**
 * Display metadata for blog post on front page blog section
 *
 * @since 1.0.0
 */
function fagri_blog_section_metadata() {

	$author_name = get_the_author_meta( 'display_name' );
	$author_email = get_the_author_meta( 'user_email' );
	$author_avatar = get_avatar( $author_email, 40 );

	$utility_text = '<span class="fagri-metadata-avatar">%1$s</span><span class="fagri-metadata-autor">%2$s</span>';

	printf(
		$utility_text,
		$author_avatar,
		$author_name
	);
}

/**
 * Overriding hestia function in order to add a metadata row
 * Get content for blog section.
 *
 * @param bool $is_callback Flag to check if it's callback or not.
 * @since 1.0.0
 */
function hestia_blog_content( $is_callback = false ) {

	$hestia_blog_items = get_theme_mod( 'hestia_blog_items', 3 );
	if ( ! $is_callback ) {
		?>
		<div class="hestia-blog-content">
		<?php
	}

	$args                   = array(
		'ignore_sticky_posts' => true,
	);
	$args['posts_per_page'] = ! empty( $hestia_blog_items ) ? absint( $hestia_blog_items ) : 3;

	$hestia_blog_categories = get_theme_mod( 'hestia_blog_categories' );

	if ( ! empty( $hestia_blog_categories[0] ) && sizeof( $hestia_blog_categories ) >= 1 ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $hestia_blog_categories,
			),
		);
	}

	$loop = new WP_Query( $args );

	$allowed_html = array(
		'br'     => array(),
		'em'     => array(),
		'strong' => array(),
		'i'      => array(
			'class' => array(),
		),
		'span'   => array(),
	);

	if ( $loop->have_posts() ) :
		$i = 1;
		echo '<div class="row" ' . hestia_add_animationation( 'fade-up' ) . '>';
		while ( $loop->have_posts() ) :
			$loop->the_post();
			?>
			<article class="col-xs-12 col-ms-10 col-ms-offset-1 col-sm-8 col-sm-offset-2 <?php echo apply_filters( 'hestia_blog_per_row_class', 'col-md-4' ); ?> hestia-blog-item">
				<div class="card card-plain card-blog">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="card-image">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail( 'hestia-blog' ); ?>
							</a>
						</div>
					<?php endif; ?>
					<div class="content">
						<h6 class="category"><?php hestia_category(); ?></h6>
						<h4 class="card-title">
							<a class="blog-item-title-link" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
								<?php echo wp_kses( force_balance_tags( get_the_title() ), $allowed_html ); ?>
							</a>
						</h4>
						<p class="card-description"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
						<p class="fagri-blog-section-metadata"><?php fagri_blog_section_metadata(); ?></p>
					</div>
				</div>
			</article>
			<?php
			if ( $i % apply_filters( 'hestia_blog_per_row_no', 3 ) == 0 ) {
				echo '</div><!-- /.row -->';
				echo '<div class="row" ' . hestia_add_animationation( 'fade-up' ) . '>';
			}
			$i++;
		endwhile;
		echo '</div>';

		wp_reset_postdata();
	endif;

	if ( ! $is_callback ) {
		?>
		</div>
		<?php
	}
}