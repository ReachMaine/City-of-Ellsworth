<?php

/* -----------------------------------------------------------------------------

    DOCUMENTS LIST WIDGET

----------------------------------------------------------------------------- */
/* mods 
*  user ordering as ddl (default, alpha, menu) instead of order_alpha (yes/now)
*/
if ( ! class_exists( 'Lsvr_DocumentsList_Widget' ) ) {
class Lsvr_DocumentsList_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-documents', 'description' => __( 'List documents ', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_documentslist_widget', __( 'LSVR Documents List', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, 
        	array( 'title' => __( 'Documents', 'lsvrtoolkit' ),  
        	'doclist' => '',
			'show_icons' => 'on', 
			'show_filesize' => 'on',
			'doc_order' => 'default',
			) );

        $title = $instance['title'];
		$show_icons = $instance['show_icons'];
		$show_filesize = $instance['show_filesize'];
		$doclist = $instance['doclist'];
		$doc_order = $instance['doc_order'];
        ?>
   
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" >
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'doclist' ); ?>"><?php echo __( 'Document List by slugs:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'doclist' ); ?>" name="<?php echo $this->get_field_name( 'doclist' ); ?>" type="text" value="<?php echo $doclist; ?>" >
        </p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_icons' ); ?>" name="<?php echo $this->get_field_name( 'show_icons' ); ?>" <?php if ( isset( $show_icons ) && $show_icons === 'on' ) { echo ' checked'; } ?>>
            <label for="<?php echo $this->get_field_id( 'show_icons' ); ?>"><?php echo __( 'Show File Icon', 'lsvrtoolkit' ); ?></label>
        </p>

		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'show_filesize' ); ?>" name="<?php echo $this->get_field_name( 'show_filesize' ); ?>" <?php if ( isset( $show_filesize ) && $show_filesize === 'on' ) { echo ' checked'; } ?>>
            <label for="<?php echo $this->get_field_id( 'show_filesize' ); ?>"><?php echo __( 'Show File Size', 'lsvrtoolkit' ); ?></label>
        </p>

		<p><label for="<?php echo $this->get_field_id( 'doc_order' ); ?>"><?php echo __( 'Ordering:', 'lsvrtoolkit' ); ?></label>
		
		<select class="widefat" id="<?php echo $this->get_field_id( 'doc_order' ); ?>" name="<?php echo $this->get_field_name( 'doc_order' ); ?>">

			<option value="default" <?php if  ( $doc_order == 'default' )  { echo ' selected'; } ?> > Default </option>
			<option value="alpha" <?php if ( $doc_order == 'alpha' )  { echo ' selected'; } ?> >Alphabetical </option>
			<option value="menu" <?php if ( $doc_order == 'menu' ) { echo ' selected'; } ?> >Menu Order</option>
		</select></p>

        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['doclist'] = $new_instance['doclist'];
		$instance['show_icons'] = $new_instance['show_icons'];
		$instance['show_filesize'] = $new_instance['show_filesize'];
		$instance['doc_order'] = $new_instance['doc_order'];
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
        $doclist = $instance['doclist'];
		$show_icons = $instance['show_icons'];
		$show_filesize = $instance['show_filesize'];
		$doc_order = $instance['doc_order'];

        if ( empty($title) ) { $title = false; }

        ?>

		<?php echo $before_widget; ?>
            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">

				<?php $today = current_time( 'Y-m-d H:i' ); ?>
				<?php // QUERY
				$doclist_arr = explode(",",$doclist);
				$limit = count($doclist_arr);
				$q_args = array(
					'posts_per_page' => $limit,
					'post_type' => 'lsvrdocument',
					'post_status' => array( 'publish' ),
					'suppress_filters' => false,
					//'include' => $doclist,
					'post_name__in' => $doclist_arr,
					'meta_query' => array(
						'relation' => 'OR',
							array( 'key' => 'meta_document_expiration_date',
								'value' => '',
								'compare' => 'NOT EXISTS',
							),
							array( 'key' => 'meta_document_expiration_date',
								'value' => $today,
								'compare' => '>=',
								'type' => 'CHAR'
							)
					)
				);
				//echo "<p>limit: ".$limit."</p>";
				//echo "<pre>".var_dump($q_args)."</pre>";
				switch ($doc_order) {
					case 'alpha':
						$q_args['orderby'] = 'title';
						$q_args['order'] = 'ASC';
						break;
					case 'menu':
						$q_args['orderby'] = 'menu_order';
						$q_args['order'] = 'ASC';
						break;				
					default:
						# code...
						break;
				}
				
				// GET POSTS
				$documents = get_posts( $q_args );
				?>

				<?php if ( is_singular( 'lsvrdocument' ) ) : ?>
					<?php global $wp_query; ?>
					<?php $current_id = $wp_query->queried_object; ?>
					<?php $current_id = $current_id->ID; ?>
				<?php else: ?>
					<?php $current_id = false; ?>
				<?php endif; ?>

				<?php if ( ! empty( $documents ) ) : ?>

					<ul class="document-list<?php if ( $show_icons ) { echo ' m-has-icons'; } ?>">
					<?php foreach ( $documents as $document ) : ?>

						<?php $document_file_location = get_post_meta( $document->ID, 'meta_document_file_location', true ) === '' ? 'local' : get_post_meta( $document->ID, 'meta_document_file_location', true ); ?>
						<?php if ( $document_file_location === 'external' ) {
							$document_file = get_post_meta( $document->ID, 'meta_document_external_file_url', true );
						} else {
							$document_file = get_post_meta( $document->ID, 'meta_document_file', true );
						} ?>

						<?php if ( ( $document_file_location === 'local' && is_array( $document_file ) ) || ( $document_file !== '' ) ) : ?>
						<li <?php post_class( 'document' ); ?>>
						<div class="document-inner">

							<?php $link_target = lsvr_get_field( 'document_new_tab_enable', true, true ) ? ' target="_blank"' : ''; ?>

							<?php if ( $show_icons ) : ?>
								<?php $document_type = get_post_meta( $document->ID, 'meta_document_type', true ); ?>
								<?php $document_type = $document_type === '' ? 'default' : $document_type; ?>
								<?php $document_type_icon = ''; ?>
								<?php $document_type_label = ''; ?>
								<?php if ( $document_type === 'custom' ) : ?>
									<?php $document_type_icon = get_post_meta( $document->ID, 'meta_document_custom_icon', true ); ?>
									<?php $document_type_label = get_post_meta( $document->ID, 'meta_document_custom_label', true ); ?>
								<?php else: ?>
									<?php $document_type = function_exists( 'lsvr_get_document_type' ) ? lsvr_get_document_type( $document_type ) : ''; ?>
									<?php if ( is_array( $document_type ) ) : ?>
										<?php $document_type_icon = $document_type['class']; ?>
										<?php $document_type_label = $document_type['label']; ?>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>

							<?php if ( $show_icons && $document_type_icon !== '' ) : ?>
							<div class="document-icon" title="<?php echo esc_attr( $document_type_label ); ?>"><i class="<?php echo esc_attr( $document_type_icon ); ?>"></i></div>
							<?php endif; ?>

							<h4 class="document-title">

								<?php // EXTERNAL FILE
								if ( $document_file_location === 'external' ) : ?>

									<a href="<?php echo esc_url( $document_file ); ?>"<?php echo $link_target; ?>><?php echo $document->post_title; ?></a>
									<?php if ( $show_filesize && get_post_meta( $document->ID, 'meta_document_external_file_size', true ) !== '' ) : ?>
										<span class="document-filesize">(<?php echo get_post_meta( $document->ID, 'meta_document_external_file_size', true ); ?>)</span>
									<?php endif; ?>

								<?php // LOCAL FILE
								else : ?>

									<?php if ( $document_file_location === 'local' ) {
										reset( $document_file );
										$document_id = key( $document_file );
										$document_link = reset( $document_file );
									} ?>

									<a href="<?php echo esc_url( $document_link ); ?>"<?php echo $link_target; ?>><?php echo $document->post_title; ?></a>
									<?php if ( $show_filesize ) : ?>
										<?php $document_size = (int) filesize( get_attached_file( $document_id ) ); ?>
										<?php $document_size = $document_size > 0 ? lsvr_filesize_convert( $document_size ) : false; ?>
										<span class="document-filesize">(<?php echo $document_size; ?>)</span>
									<?php endif; ?>

								<?php endif; ?>

							</h4>

						</div>
						</li>
						<?php endif; ?>

					<?php endforeach; ?>
					</ul>

				<?php else : ?>
					<p><?php _e( 'There are no documents at this time.', 'lsvrtoolkit' ); ?></p>
				<?php endif; ?>

            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>