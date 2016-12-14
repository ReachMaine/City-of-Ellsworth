<?php /* mods
* 20Sept16 zig - link the title & dont show the permalink hard.
  14Dec16 zig - add google custom search results to page instead.
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
		<!--gcse:searchresults></gcse:searchresults-->
		<script>
		  (function() {
		    var cx = '015839424189047853552:jvd_hoouktu';
		    var gcse = document.createElement('script');
		    gcse.type = 'text/javascript';
		    gcse.async = true;
		    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
		    var s = document.getElementsByTagName('script')[0];
		    s.parentNode.insertBefore(gcse, s);
		  })();
		</script>
		<gcse:searchresults-only></gcse:searchresults-only>
	</div>
</div>
<!-- PAGE CONTENT : end -->

<?php // PAGE CONTENT AFTER
get_template_part( 'components/page-content-after' ); ?>

<?php get_footer(); ?>
