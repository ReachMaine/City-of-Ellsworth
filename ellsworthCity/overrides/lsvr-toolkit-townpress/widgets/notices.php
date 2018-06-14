<?php

/* -----------------------------------------------------------------------------

    NOTICES WIDGET

----------------------------------------------------------------------------- */
/* mods
* 14jun18 zig - put sticky notices at the top of the list & mark it with a class of 'sticky'
*/
if ( ! class_exists( 'Lsvr_Notices_Widget' ) ) {
class Lsvr_Notices_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-notices', 'description' => __( 'List notices.', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_notices_widget', __( 'LSVR Notices', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Notices', 'lsvrtoolkit' ), 'category' => 'none',
			'limit' => 5, 'show_excerpt' => 'on', 'show_all_btn_label' => __( 'See All Notices', 'lsvrtoolkit' ) ) );

        $title = $instance['title'];
		$category = $instance['category'];
		$limit = $instance['limit'];
		$show_excerpt = $instance['show_excerpt'];
		$show_all_btn_label = $instance['show_all_btn_label'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" >
        </p>

		<?php $terms_arr = get_terms( 'lsvrnoticecat' ); ?>
		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php echo __( 'Category:', 'lsvrtoolkit' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
			<option value="none"<?php if ( $category === 'none' ) { echo ' selected'; } ?>><?php _e( 'None (list all)', 'lsvrtoolkit' ); ?></option>
			<?php if ( is_array( $terms_arr ) ) : ?>
				<?php foreach ( $terms_arr as $term ) : ?>
					<?php if ( is_object( $term ) && property_exists( $term, 'term_id' ) && property_exists( $term, 'name' ) ) : ?>
						<option value="<?php echo $term->term_id; ?>"<?php if ( ( $category !== 'none' ) && ( intval( $category ) === $term->term_id ) ) { echo ' selected'; } ?>><?php echo $term->name; ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</select></p>

		<p><label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php echo __( 'Limit:', 'lsvrtoolkit' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>">
			<option value="none"<?php if ( $limit === 'none' ) { echo ' selected'; } ?>><?php _e( 'None (list all)', 'lsvrtoolkit' ); ?></option>
			<?php for ( $i = 1; $i <= 10; $i++ ) : ?>
				<option value="<?php echo $i; ?>"<?php if ( intval( $limit ) === intval( $i ) ) { echo ' selected'; } ?>><?php echo $i; ?></option>
			<?php endfor; ?>
		</select></p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" <?php if ( isset( $show_excerpt ) && $show_excerpt === 'on' ) { echo ' checked'; } ?>>
            <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php echo __( 'Show Excerpt', 'lsvrtoolkit' ); ?></label>
        </p>

		<p>
            <label for="<?php echo $this->get_field_id( 'show_all_btn_label' ); ?>"><?php echo __( 'More Button Label:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'show_all_btn_label' ); ?>" name="<?php echo $this->get_field_name( 'show_all_btn_label' ); ?>" type="text" value="<?php echo $show_all_btn_label; ?>" >
        </p>
		<p><?php _e( 'Leave blank do disable more button.', 'lsvrtoolkit' ); ?></p>

        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
		$instance['category'] = $new_instance['category'];
		$instance['limit'] = $new_instance['limit'];
		$instance['show_excerpt'] = $new_instance['show_excerpt'];
		$instance['show_all_btn_label'] = $new_instance['show_all_btn_label'];
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
    		$category = $instance['category'];
    		$limit = $instance['limit'];
    		$limit = $limit === 'none' ? 1000 : intval( $limit );
    		$show_excerpt = $instance['show_excerpt'];
    		$show_all_btn_label = $instance['show_all_btn_label'];
        if ( empty($title) ) { $title = false; }

        ?>

        <?php echo $before_widget; ?>
        <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
        <div class="widget-content">

				<?php // QUERY
				$q_args = array(
					'posts_per_page' => $limit,
					'post_type' => 'lsvrnotice',
					'order' => 'DESC',
					'orderby' => 'post_date',
					'post_status' => array( 'publish' ),
					'suppress_filters' => false,
				);
				if ( $category !== 'none' ) {
					$q_args[ 'tax_query' ] = array( array( 'taxonomy' => 'lsvrnoticecat', 'field' => 'id', 'terms' => array( intval( $category ) ) ) );
				}

				// GET NOTICES
				$notices = get_posts( $q_args ); ?>

				<?php if ( is_singular( 'lsvrnotice' ) ) : ?>
					<?php global $wp_query; ?>
					<?php $current_id = $wp_query->queried_object; ?>
					<?php $current_id = $current_id->ID; ?>
				<?php else: ?>
					<?php $current_id = false; ?>
				<?php endif; ?>

				<?php if ( ! empty( $notices ) ) : ?>
          <?php /* zig reorder notice s.t. stickies are first */
          $sticky_posts = get_option( 'sticky_posts' );
          $num_posts = count( $notices );
          $sticky_offset = 0;
          // Find the sticky posts
          for ($i = 0; $i < $num_posts; $i++) {

              // Put sticky posts at the top of the notices array
              if ( in_array( $notices[$i]->ID, $sticky_posts ) ) {
                  $sticky_post = $notices[$i];

                  // Remove sticky from current position
                  array_splice( $notices, $i, 1 );

                  // Move to front, after other stickies
                  array_splice( $notices, $sticky_offset, 0, array($sticky_post) );
                  $sticky_offset++;

              }
          }
          ?>
					<ul>
					<?php foreach ( $notices as $notice ) : ?>

            <?php $notice_class = "";
            if ( $current_id === $notice->ID ) { $notice_class .= "m-active " ; }
            if (  in_array($notice->ID,$sticky_posts ) ) { $notice_class .= "sticky "; }
            ?>
						<li<?php if ( $notice_class ) { echo ' class="'.$notice_class.'"'; } ?>>
							<div class="notice-inner">

								<h4 class="notice-title"><a href="<?php echo get_the_permalink( $notice->ID ); ?>"><?php echo $notice->post_title; ?></a></h4>
								<span class="notice-date"><?php echo get_the_date( get_option( 'date_format' ), $notice->ID ); ?></span>

								<?php if ( isset( $show_excerpt ) && $show_excerpt === 'on' ) : ?>
									<div class="notice-excerpt">
										<?php echo wpautop( $notice->post_excerpt ); ?>
									</div>
								<?php endif; ?>

							</div>
						</li>

					<?php endforeach; ?>
					</ul>

					<?php if ( $show_all_btn_label !== '' ) : ?>
						<?php $show_all_btn_link = $category !== 'none' ? get_term_link( intval( $category ), 'lsvrnoticecat' ) : get_post_type_archive_link( 'lsvrnotice' ); ?>
						<p class="show-all-btn">
							<a href="<?php echo esc_url( $show_all_btn_link ); ?>"><?php echo _e( $show_all_btn_label, 'lsvrtoolkit' ); ?></a>
						</p>
					<?php endif; ?>

				<?php else : ?>
					<p><?php _e( 'There are no notices at this time.', 'lsvrtoolkit' ); ?></p>
				<?php endif; ?>

            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>
