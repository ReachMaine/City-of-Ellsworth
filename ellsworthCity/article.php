<?php // SINGLE POST
/* 6jul16 zig - use exceprt for archive 
 *  4Oct16 zig - single put image inside article s.t. text will wrap around.
 */ 

if ( is_single() ) : ?>

    <article <?php post_class( 'article' ); ?>>
		<div class="c-content-box m-no-padding article-inner">

			<?php /* zxout moved image stuff. */ ?>

			<!-- ARTICLE CORE : begin -->
			<div class="article-core">
				
			
				<!-- ARTICLE CONTENT : begin -->
				<div class="article-content">
					<?php if ( has_post_thumbnail() && lsvr_get_field( 'article_detail_thumb', 'header' ) === 'top' ) : ?>
						<!-- ARTICLE IMAGE : begin -->
						<div class="article-image">
							<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id() ); ?>
							<?php if ( lsvr_get_field( 'article_detail_thumb_crop', true, true ) ) : ?>
								<span class="article-image-inner" style="background-image: url('<?php echo esc_url( $thumb_data['large'] ); ?>');"></span>
							<?php else: ?>
								<img src="<?php echo esc_url( $thumb_data['large'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>">
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<!-- ARTICLE IMAGE : end -->
					<div class="article-content-inner">
						<?php the_content(); ?>
						<?php wp_link_pages(); ?>
					</div>
				</div>
				<!-- ARTICLE CONTENT : end -->

			</div>
			<!-- ARTICLE CORE : end -->

			<!-- ARTICLE FOOTER : begin -->
			<div class="article-footer">
				<div class="article-footer-inner">

					<!-- ARTICLE DATE : begin -->
					<div class="article-date">

						<i class="ico tp tp-clock2"></i>
						<span class="article-date-holder">
						<?php if ( lsvr_get_field( 'article_detail_categories_enable', true, true ) ) : ?>
							<?php $categories_html = ''; ?>
							<?php $terms = wp_get_post_terms( get_the_id(), 'category' ); ?>
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

						<?php if ( lsvr_get_field( 'article_detail_author_enable', false, true ) ) : ?>
						<span class="article-author">
							<?php echo sprintf( 'by %s', get_the_author_posts_link() ); ?>
						</span>
						<?php endif; ?>

						<?php if( comments_open() ) : ?>
						<span class="article-comments">
							<?php $comment_count = get_comment_count( get_the_ID() ); ?>
							<a href="<?php the_permalink(); ?>#comments"><?php echo @sprintf( __( '%d comments', 'lsvrtheme' ), $comment_count['approved'] ); ?></a>
						</span>
						<?php endif; ?>

					</div>
					<!-- ARTICLE DATE : end -->

					<?php if ( has_tag() && lsvr_get_field( 'article_detail_tags_enable', true, true ) ) : ?>
					<!-- ARTICLE TAGS : begin -->
					<div class="article-tags">
						<i class="ico tp tp-tag"></i>
						<?php the_tags( '', ', ', '' ); ?>
					</div>
					<!-- ARTICLE TAGS : end -->
					<?php endif; ?>

				</div>
			</div>
			<!-- ARTICLE FOOTER : end -->

		</div>
    </article>

	<?php if ( lsvr_get_field( 'article_detail_navigation_enable', true, true ) ) : ?>
	<!-- ARTICLE NAVIGATION : begin -->
	<div class="c-content-box">
		<ul class="article-navigation">

			<?php $prev_post = get_adjacent_post( false, '', false ); ?>
			<?php if ( ! empty( $prev_post ) ): ?>
				<!-- PREV ARTICLE : begin -->
				<li class="prev<?php if ( has_post_thumbnail( $prev_post->ID ) ) { echo ' m-has-thumb'; } ?>">
					<div class="prev-inner">
						<?php if ( has_post_thumbnail( $prev_post->ID ) ) : ?>
							<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id( $prev_post->ID ) ); ?>
							<div class="nav-thumb"><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><img src="<?php echo $thumb_data['thumbnail']; ?>" alt=""></a></div>
						<?php endif; ?>
						<h5><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php _e( 'Newer Post', 'lsvrtheme' ); ?></a></h5>
						<a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo $prev_post->post_title; ?></a>
					</div>
				</li>
				<!-- PREV ARTICLE : end -->
			<?php endif; ?>

			<?php $next_post = get_adjacent_post( false, '', true ); ?>
			<?php if ( ! empty( $next_post ) ): ?>
				<!-- NEXT ARTICLE : begin -->
				<li class="next<?php if ( has_post_thumbnail( $next_post->ID ) ) { echo ' m-has-thumb'; } ?>">
					<div class="next-inner">
						<?php if ( has_post_thumbnail( $next_post->ID ) ) : ?>
							<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id( $next_post->ID ) ); ?>
							<div class="nav-thumb"><a href="<?php echo get_permalink( $next_post->ID ); ?>"><img src="<?php echo $thumb_data['thumbnail']; ?>" alt=""></a></div>
						<?php endif; ?>
						<h5><a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php _e( 'Older Post', 'lsvrtheme' ); ?></a></h5>
						<a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a>
					</div>
				</li>
				<!-- NEXT ARTICLE : end -->
			<?php endif; ?>

		</ul>
	</div>
	<!-- ARTICLE NAVIGATION : end -->
	<?php endif; ?>

    <?php if ( comments_open() ) : ?>
    <!-- ARTICLE COMMENTS : begin -->
	<div class="article-comments" id="comments">
		<div class="c-content-box">
		  <?php comments_template(); ?>
		</div>
	</div>
    <!-- ARTICLE COMMENTS : end -->
    <?php endif; ?>

<?php // POST LIST
else : ?>

    <article <?php post_class( 'article' ); ?>>
		<div class="c-content-box m-no-padding article-inner">

			<?php if ( has_post_thumbnail() && lsvr_get_field( 'article_list_thumb', 'full' ) !== 'disable' ) : ?>
			<!-- ARTICLE IMAGE : begin -->
			<div class="article-image">
				<a href="<?php the_permalink(); ?>">
				<?php $thumb_data = lsvr_get_image_data( get_post_thumbnail_id() ); ?>
				<?php if ( lsvr_get_field( 'article_list_thumb', 'full' ) === 'cropped' ) : ?>
					<span class="article-image-inner" style="background-image: url('<?php echo esc_url( $thumb_data['large'] ); ?>');"></span>
				<?php else: ?>
					<img src="<?php echo esc_url( $thumb_data['large'] ); ?>" alt="<?php echo esc_attr( $thumb_data['alt'] ); ?>">
				<?php endif; ?>
				</a>
			</div>
			<!-- ARTICLE IMAGE : end -->
			<?php endif; ?>

			<!-- ARTICLE CORE : begin -->
			<div class="article-core">

				<?php if ( get_the_title() !== '' ) : ?>
				<!-- ARTICLE TITLE : begin -->
				<h2 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<!-- ARTICLE TITLE : end -->
				<?php endif; ?>

				<div class="article-content">
				<?php /* zig xout  if ( $post->post_excerpt !== '' ) : */ ?>
					<!-- ARTICLE CONTENT : begin -->
					<div class="article-content-inner"><?php the_excerpt(); ?></div>
					<!-- ARTICLE CONTENT : end -->
				<?/* zig xout php elseif ( $post->post_content ) :  ?>
					<!-- ARTICLE CONTENT : begin -->
					<div class="article-content-inner"><?php the_content(); ?></div>
					<!-- ARTICLE CONTENT : end -->
				<?php endif; */ ?>
				</div>

			</div>
			<!-- ARTICLE CORE : end -->

			<!-- ARTICLE FOOTER : begin -->
			<div class="article-footer">
				<div class="article-footer-inner">

					<!-- ARTICLE DATE : begin -->
					<div class="article-date">

						<i class="ico tp tp-clock2"></i>
						<span class="article-date-holder">
						<?php if ( lsvr_get_field( 'article_detail_categories_enable', true, true ) ) : ?>
							<?php $categories_html = ''; ?>
							<?php $terms = wp_get_post_terms( get_the_id(), 'category' ); ?>
							<?php foreach ( $terms as $term ) : ?>
								<?php $categories_html .= '<a href="' . get_term_link( $term ) . '">' . $term->name . '</a>, '; ?>
							<?php endforeach; ?>
							<?php if ( $categories_html !== '' ) : ?>
								<?php $categories_html = rtrim( $categories_html, ', ' ); ?>
								<?php echo sprintf( '%s in %s', '<a href="' . get_permalink() . '" class="article-date-permalink">' . get_the_date() . '</a>', $categories_html ); ?>
							<?php else: ?>
								<?php echo '<a href="' . get_permalink() . '" class="article-date-permalink">' . get_the_date() . '</a>'; ?>
							<?php endif; ?>
						<?php else: ?>
							<?php echo '<a href="' . get_permalink() . '" class="article-date-permalink">' . get_the_date() . '</a>'; ?>
						<?php endif; ?>
						</span>

						<?php if( comments_open() ) : ?>
						<span class="article-comments">
							<?php $comment_count = get_comment_count( get_the_ID() ); ?>
							<a href="<?php the_permalink(); ?>#comments"><?php echo @sprintf( __( 'Comments (%d)', 'lsvrtheme' ), $comment_count['approved'] ); ?></a>
						</span>
						<?php endif; ?>

					</div>
					<!-- ARTICLE DATE : end -->

				</div>
			</div>
			<!-- ARTICLE FOOTER : end -->

		</div>
    </article>

<?php endif; ?>