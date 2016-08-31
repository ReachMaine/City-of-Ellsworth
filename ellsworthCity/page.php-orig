<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php // PAGE CONTENT BEFORE
	get_template_part( 'components/page-content-before' ); ?>

	<!-- PAGE CONTENT : begin -->
	<div id="page-content"<?php if ( lsvr_get_field( 'meta_content_boxed', 'single' ) === 'disable' ) { echo ' class="m-no-boxes"'; } ?>>

		<?php if ( lsvr_get_field( 'meta_content_boxed', 'single' ) === 'single' ) : ?>

			<div class="c-content-box">
				<div class="page-content-inner">
					<?php the_content(); ?>
				</div>
			</div>

		<?php else: ?>

			<div class="page-content-inner">

				<?php the_content(); ?>

			    <?php if ( comments_open() ) : ?>
			    <!-- ARTICLE COMMENTS : begin -->
				<div class="article-comments" id="comments">
					<div class="c-content-box">
					  <?php comments_template(); ?>
					</div>
				</div>
			    <!-- ARTICLE COMMENTS : end -->
			    <?php endif; ?>

			</div>

		<?php endif; ?>

	</div>
	<!-- PAGE CONTENT : end -->

	<?php // PAGE CONTENT AFTER
	get_template_part( 'components/page-content-after' ); ?>

<?php endwhile; ?>

<?php get_footer(); ?>