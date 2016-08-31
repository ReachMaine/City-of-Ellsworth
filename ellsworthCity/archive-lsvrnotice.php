<?php /* 
5July16 - zig  always use excerpt for the archive page.
*/ ?>
<?php get_header(); ?>

<?php $page_id = lsvr_get_current_page_id(); ?>

<?php // PAGE CONTENT BEFORE
get_template_part( 'components/page-content-before' ); ?>

<!-- PAGE CONTENT : begin -->
<div id="page-content">

	<!-- NOTICE LIST : begin -->
	<div class="cpt-archive-page notice-archive-page notice-page">

		<?php if ( is_tax( 'lsvrnoticecat' ) && term_description( get_queried_object()->term_id, 'lsvrnoticecat' ) !== '' ) : ?>
		<!-- ARCHIVE DESCRIPTION : begin -->
		<div class="archive-description">
			<div class="c-content-box">
				<?php echo wpautop( term_description( get_queried_object()->term_id, 'lsvrnoticecat' ) ); ?>
			</div>
		</div>
		<!-- ARCHIVE DESCRIPTION : end -->
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<!-- NOTICE : begin -->
				<article <?php post_class( 'notice' ); ?>>
					<div class="notice-inner c-content-box m-no-padding">

						<?php if ( has_post_thumbnail() && lsvr_get_field( 'notice_list_thumb', 'full' ) !== 'disable' ) : ?>
						<!-- NOTICE IMAGE : begin -->
						<div class="notice-image">
							<a href="<?php the_permalink(); ?>">
							<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id() ); ?>
							<?php if ( lsvr_get_field( 'notice_list_thumb', 'full' ) === 'cropped' ) : ?>
								<span class="notice-image-inner" style="background-image: url('<?php echo esc_url( $thumb_data['large'] ); ?>');"></span>
							<?php else: ?>
								<img src="<?php echo esc_url( $thumb_data['large'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>">
							<?php endif; ?>
							</a>
						</div>
						<!-- NOTICE IMAGE : end -->
						<?php endif; ?>

						<!-- NOTICE CORE : begin -->
						<div class="notice-core">

							<!-- NOTICE TITLE : begin -->
							<h2 class="notice-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<!-- NOTICE TITLE : end -->

							<?php  /* zig xout if ( $post->post_excerpt !== '' ) : */ ?>
								<!-- NOTICE CONTENT : begin -->
								<div class="notice-content"><?php the_excerpt(); ?></div>
								<!-- NOTICE CONTENT : end -->
							<?php  /* zig xout elseif ( $post->post_content ) : ?>
								<!-- NOTICE CONTENT : begin -->
								<div class="notice-content"><?php the_content(); ?></div>
								<!-- NOTICE CONTENT : end -->
							<?php endif; */ ?>

						</div>
						<!-- NOTICE CORE : end -->

						<!-- NOTICE FOOTER : begin -->
						<div class="notice-footer">
							<div class="notice-footer-inner">

								<!-- NOTICE DATE : begin -->
								<div class="notice-date">
									<span class="notice-date-inner">
										<i class="ico tp tp-clock2"></i>
										<?php if ( lsvr_get_field( 'notice_detail_categories_enable', true, true ) ) : ?>
											<?php $categories_html = ''; ?>
											<?php $terms = wp_get_post_terms( get_the_id(), 'lsvrnoticecat' ); ?>
											<?php foreach ( $terms as $term ) : ?>
												<?php $categories_html .= '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>, '; ?>
											<?php endforeach; ?>
											<?php if ( $categories_html !== '' ) : ?>
												<?php $categories_html = rtrim( $categories_html, ', ' ); ?>
												<?php echo sprintf( '%s in %s', get_the_date(), $categories_html ); ?>
											<?php else: ?>
												<?php echo get_the_date(); ?>
											<?php endif; ?>
										<?php else: ?>
											<?php echo get_the_date(); ?>
										<?php endif; ?>
									</span>
									<?php if( comments_open() ) : ?>
										<?php $comment_count = get_comment_count( get_the_ID() ); ?>
										<a href="<?php the_permalink(); ?>#comments" class="notice-comments"><?php echo @sprintf( __( '%d comments', 'lsvrtheme' ), $comment_count['approved'] ); ?></a>
									<?php endif; ?>
								</div>
								<!-- NOTICE DATE : end -->

							</div>
						</div>
						<!-- NOTICE FOOTER : end -->

					</div>
				</article>
				<!-- NOTICE : end -->

			<?php endwhile; ?>
		<?php else: ?>
			<p><?php _e( 'There are currently no notices', 'lsvrtheme' ); ?></p>
		<?php endif; ?>

	</div>
	<!-- NOTICE LIST : end -->

	<?php // PAGINATION
	get_template_part( 'components/pagination' ); ?>

</div>
<!-- PAGE CONTENT : end -->

<?php // PAGE CONTENT AFTER
get_template_part( 'components/page-content-after' ); ?>

<?php get_footer(); ?>