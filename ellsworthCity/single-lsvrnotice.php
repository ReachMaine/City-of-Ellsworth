<?php /* Mods 
	8July25 - zig move posted date to top of article. 
*/ ?>
<?php get_header(); ?>



<?php $page_id = lsvr_get_current_page_id(); ?>



<?php // PAGE CONTENT BEFORE

get_template_part( 'components/page-content-before' ); ?>



<!-- PAGE CONTENT : begin -->

<div id="page-content">



	<!-- NOTICE DETAIL : begin -->

	<div class="notice-single-page notice-page">



		<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>



			<!-- NOTICE : begin -->

			<article <?php post_class( 'notice' ); ?>>

				<div class="notice-inner c-content-box m-no-padding">



					<?php if ( has_post_thumbnail() && lsvr_get_field( 'notice_detail_thumb' ) === 'top' ) : ?>

					<!-- NOTICE IMAGE : begin -->

					<div class="notice-image">

						<a href="<?php the_permalink(); ?>">

						<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id() ); ?>

						<?php if ( lsvr_get_field( 'notice_detail_thumb_crop', true, true ) ) : ?>

							<span class="notice-image-inner" style="background-image: url('<?php echo esc_url( $thumb_data['large'] ); ?>');"></span>

						<?php else: ?>

							<img src="<?php echo esc_url( $thumb_data['large'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>">

						<?php endif; ?>

						</a>

					</div>

					<!-- NOTICE IMAGE : end -->

					<?php endif; ?>

					<!-- NOTICE HEADER : begin -->

					<div class="notice-header">
						<div class="notice-header-inner">

							<!-- NOTICE DATE : begin -->
							<div class="notice-date">
								<i class="ico tp tp-clock2"></i>
								<span class="notice-date-holder">
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
							</div>
							<!-- NOTICE DATE : end -->
						</div>
					</div>
					<!-- NOTICE HEADER : end -->

					<!-- NOTICE CORE : begin -->

					<div class="notice-core">



						<!-- NOTICE CONTENT : begin -->

						<div class="notice-content"><?php the_content(); ?></div>

						<!-- NOTICE CONTENT : end -->



					</div>

					<!-- NOTICE CORE : end -->



					<!-- NOTICE FOOTER : begin -->
					<div class="notice-footer">
						<div class="notice-footer-inner">
							<!-- NOTICE DATE : begin -->
							<div class="notice-date">
								<?php if ( lsvr_get_field( 'notice_detail_author_enable', false, true ) ) : ?>
								<span class="notice-author">
									<?php echo sprintf( 'by %s', get_the_author_posts_link() ); ?>
								</span>
								<?php endif; ?>

							</div>
							<!-- NOTICE DATE : end -->
						</div>
					</div>
					<!-- NOTICE FOOTER : end -->



				</div>

			</article>

			<!-- NOTICE : end -->



		    <?php if ( comments_open() ) : ?>

		    <!-- ARTICLE COMMENTS : begin -->

			<div class="article-comments" id="comments">

				<div class="c-content-box">

				  <?php comments_template(); ?>

				</div>

			</div>

		    <!-- ARTICLE COMMENTS : end -->

		    <?php endif; ?>



		<?php endwhile; ?>

		<?php endif; ?>



	</div>

	<!-- NOTICE DETAIL : end -->



	<?php // PAGINATION

	get_template_part( 'components/pagination' ); ?>



</div>

<!-- PAGE CONTENT : end -->



<?php // PAGE CONTENT AFTER

get_template_part( 'components/page-content-after' ); ?>



<?php get_footer(); ?>