<?php /* mods 
* 20Sept16 zig - link the title & dont show the permalink hard.
*/ ?>
<?php get_header(); ?>

<?php global $wp_query;
$total_results = $wp_query->found_posts;
$search_query = get_search_query(); ?>

<?php // PAGE CONTENT BEFORE
get_template_part( 'components/page-content-before' ); ?>

<!-- PAGE CONTENT : begin -->
<div id="page-content">
	<div class="search-results-page">

		<div class="c-content-box m-no-padding">
			<?php get_search_form() ?>
		</div>

		<?php if ( have_posts() ) : ?>

			<h2><?php echo @sprintf( __( '%d Results for <strong>"%s"</strong>', 'lsvrtheme' ), $total_results, $search_query ); ?></h2>

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="c-content-box">
					<?php $cpt = get_post_type(); 
					$title_extra_end = "";
					$extra_html = ""; // for debuging
					$extra_html .= $cpt;
					$extra_html .= " id: ".$post->ID." ";
					$blerb = "";
					$ext_link = "";
					$link_title = true;
					$short_desc_len = 20;
					$short_desc = "";
					$scontent = "";
					switch ($cpt) {
						case 'lsvrdocument':
							$link_title = false; // dont link title (since it's a PDF/document)
							$doctype = get_post_meta($post->ID, 'meta_document_type', true);
							switch($doctype) {
								case 'pdf':
									$title_extra_end = " (pdf)";
									break;
								default:
									$extra_html .= " nope ";
									break;
							}
							if (has_excerpt()) {
								$short_desc .= $post->post_excerpt;
							} 
							$extra_html .= " (".$doctype.")";
							//echo "<pre>"; var_dump(get_lsrvdoc_link( $post->ID )); echo "</pre>";
							$ext_link .= '<a target="_blank" href="'.get_lsrvdoc_link( $post->ID ).'">Open pdf document</a>.';
							break;

						case 'attachment':
							$extra_html .= " - (".$post->post_mime_type.")";
							$link_title = false;
							switch($post->post_mime_type){
								case 'application/pdf':
									$extra_html .= " attachment title [".get_the_title().']';
									$scontent .= get_post_meta($post->ID, 'searchwp_content', true);
									$linked_docID = get_attachment_lsrvdoc($post->ID);
									$extra_html .= " linked id is: (".$linked_docID.")";

									if ($linked_docID) {
										$ext_link .= '<a target="_blank" href="'.get_lsrvdoc_link( $post->ID ).'">Open pdf document</a>.';
										if ($post->post_excerpt) {
											$short_desc = $post->post_excerpt;
										}
									} else {
										$ext_link .= '<a target="_blank" href="'.wp_get_attachment_url( $post->ID ).'">Open pdf document</a>.';
									}
									$title_extra_end = " (pdf)";
									break;
								case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
								case "application/vnd.ms-excel":
									$ext_link .= '<a target="_blank" href="'.wp_get_attachment_url( $post->ID ).'">Download attachment</a>.';
									$title_extra_end = " (spreadsheet)";
									break;
								case "image/jpeg":
								case "image/png":
									$title_extra_end = "(image)";
									// allow to fall through									
								default: 
									$ext_link .= '<a target="_blank" href="'.wp_get_attachment_url( $post->ID ).'">View attachment</a>.';
								break;
							} // end post_mime_type switch
							break;

						case 'tribe_events':
							$title_extra_end = " (event)";
							$short_desc .= 'Date: '.tribe_get_start_date($post->ID, true);
							$short_desc .= get_the_excerpt();
							$scontent .= get_the_content();
							break;

						case 'page':
							$short_desc .= wp_trim_words(wp_strip_all_tags( do_shortcode(get_the_content()) ), 20);
							$scontent = get_the_content();
							break;

						default:
							$short_desc .= get_the_excerpt();
							$scontent = get_the_content();
					}  
					echo '<!--'.$extra_html.'-->'; 
					$scontent = wp_strip_all_tags( do_shortcode($scontent) );
					$short_desc = wp_trim_words( wp_strip_all_tags( do_shortcode($short_desc) ), $short_desc_len);
					if ($scontent) { 
						$blerb .= find_searchstring_surround($search_query, $scontent, 25, 'item-blerb-searchq');
					}
					/* Displaying.... title(+/- link), short_desc, search_blurb, external_link */ ?>
					<h3 class="item-title">
						<?php if ($link_title) { ?>
							<a href="<?php the_permalink(); ?>"><?php the_title(); /* echo '<span class="search-title-extra">'.$title_extra_end.'</span>'; */ ?></a>
						<?php  } else { 
							the_title(); /*  echo '<span class="search-title-extra">'.$title_extra_end.'</span>'; */
						} ?>
					</h3>
					<?php /* zig xout <p class="item-link"><a href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a></p> */ ?>		
					<?php 

					echo '<div class="item-text">';
						if ($short_desc) {
							echo '<div class="item-excerpt">';
							echo $short_desc;
							echo '</div>';
						}
						if ($blerb) {
							echo '<div class="item-blerb">';
							echo '....'.$blerb.'....';
							echo '</div>';
						}
						if ($ext_link) {
							echo '<div class="item-link">'.$ext_link; 
							echo '<span class="search-title-extra">'.$title_extra_end.'</span>'; 
							echo '</div>';
						}	
					echo '</div>'; // end item-text
					?>
				</div> <!-- end content box -->

			<?php endwhile; ?>

			<?php // PAGINATION
			get_template_part( 'components/pagination' ); ?>

		<?php else : ?>

			<p class="c-alert-message m-info">
				<i class="ico fa fa-info-circle"></i>
				<?php _e( 'No results found.', 'lsvrtheme' ); ?>
			</p>

		<?php endif; ?>

	</div>
</div>
<!-- PAGE CONTENT : end -->

<?php // PAGE CONTENT AFTER
get_template_part( 'components/page-content-after' ); ?>

<?php get_footer(); ?>