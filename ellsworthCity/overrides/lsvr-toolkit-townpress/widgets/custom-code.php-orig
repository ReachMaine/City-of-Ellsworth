<?php
/* -----------------------------------------------------------------------------

    CUSTOM CODE WIDGET

----------------------------------------------------------------------------- */

if ( ! class_exists( 'Lsvr_Custom_Code_Widget' ) ) {
class Lsvr_Custom_Code_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-custom-code', 'description' => __( 'Put any code here', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_custom_code_widget', __( 'LSVR Custom Code', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '' ) );

        $title = $instance['title'];
        $content = $instance['content'];

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php echo __( 'Content:', 'lsvrtoolkit' ); ?></label>
            <textarea rows="6" class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"><?php echo $content; ?></textarea>
        </p>
		<p class="description"><?php _e( 'For example, you can insert an image here.', 'lsvrtoolkit' ); ?></p>
        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['content'] = $new_instance['content'];
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
        if ( empty($title) ) { $title = false; }
        $content = array_key_exists( 'content', $instance ) ? $instance['content'] : '';

        ?>

		<?php echo $before_widget; ?>
			<?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">

				<?php echo $content; ?>

            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>