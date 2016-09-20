<?php

/* -----------------------------------------------------------------------------

    LOCALE INFO WIDGET

----------------------------------------------------------------------------- */
/* mods
*   zig - dont display date 
*/
if ( ! class_exists( 'Lsvr_Locale_Info_Widget' ) ) {
class Lsvr_Locale_Info_Widget extends WP_Widget {

    public function __construct() {
        $widget_ops = array( 'classname' => 'lsvr-locale-info', 'description' => __( 'Local weather, time, etc.', 'lsvrtoolkit' ) );
        parent::__construct( 'lsvr_locale_info_widget', __( 'LSVR Locale Info', 'lsvrtoolkit' ), $widget_ops );
    }

    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, array( 'title' => __( 'Locale Info', 'lsvrtoolkit' ) ) );

        $title = $instance['title'];

        ?>
		<p><?php _e( 'Locale settings can be set under <strong>Theme Options / Locale</strong>.', 'lsvrtoolkit' ); ?></p>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', 'lsvrtoolkit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <?php

    }

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        return $instance;

    }

    function widget( $args, $instance ) {

        extract( $args );

        $title = apply_filters( 'widget_title', $instance['title'] );
        if ( empty($title) ) { $title = false; }

        ?>

		<?php if ( lsvr_get_image_field( 'locale_widget_bg_image' ) ) : ?>
			<?php $before_widget = str_replace( 'widget-inner', 'widget-inner m-has-bg', $before_widget ); ?>
		<?php endif; ?>

		<?php echo $before_widget; ?>
            <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
            <div class="widget-content">
				<ul>

				<?php // GET LOCAL TIME
				if ( lsvr_get_field( 'locale_time_enable', true, true ) ) : ?>
				<li>
					<div class="row-title"><h4><?php _e( 'Local Time', 'lsvrtoolkit' ); ?></h4></div>
					<div class="row-value">

						<div class="local-date-holder"
							data-timestamp="<?php echo esc_attr( current_time( 'timestamp' ) ); ?>"
							data-timeformat="<?php echo esc_attr( get_option( 'time_format' ) ); ?>"
							data-timezone="<?php echo esc_attr( get_option( 'timezone_string' ) ); ?>">
							<div class="local-time"><?php echo current_time( get_option( 'time_format' ) ); ?></div>
						</div>

					</div>
				</li>
				<?php endif; ?>

				<?php // GET LOCAL WEATHER
				if ( lsvr_get_field( 'locale_weather_enable', false, true ) ) : ?>

					<?php // CURRENT WEATHER
					if ( lsvr_get_field( 'locale_weather_current_enable', true, true ) ) : ?>
					<li class="m-loading">
						<i class="fa fa-spinner fa-spin"></i>
						<div class="row-title">
							<h4><?php _e( 'Today', 'lsvrtoolkit' ); ?></h4>
							<?php $today_date = strtotime( current_time( 'm/d/Y' ) ); ?>
							<?php /* zig xout <small><?php echo date_i18n( get_option( 'date_format' ), $today_date ); ?></small> */ ?>
						</div>
						<div class="row-value">

							<div class="local-weather-holder"
								data-type="current"
								data-location-request="<?php echo esc_attr( lsvr_get_field( 'locale_weather_location', 'stowe,vermont,us' ) ); ?>"
								data-units-format="<?php echo esc_attr( lsvr_get_field( 'locale_weather_units_format', 'metric' ) ); ?>">

								<i class="local-icon"></i>
								<div class="local-temperature" title="<?php _e( 'Temperature', 'lsvrtoolkit' ); ?>"></div>
								<small class="local-wind-speed" title="<?php _e( 'Wind speed', 'lsvrtoolkit' ); ?>"></small>

							</div>

						</div>
					</li>
					<?php endif; ?>

					<?php // FORECAST
					if ( lsvr_get_field( 'locale_weather_forecast_length', 3 ) > 0 ) : ?>
						<?php for ( $i = 0; $i < lsvr_get_field( 'locale_weather_forecast_length', 0 ); $i++ ) : ?>
							<li class="m-loading">
								<i class="fa fa-spinner fa-spin"></i>
								<div class="row-title">
									<?php $forecast_date = strtotime( current_time( 'm/d/Y' ) ) + ( 60 * 60 * ( 24 * ( $i + 1 ) ) ); ?>
									<h4><?php echo substr(date_i18n( 'l', $forecast_date ),0,3); ?></h4>
									<?php /* zig xout <small ><?php echo date_i18n( get_option( 'date_format' ), $forecast_date ); ?></small> */ ?>
								</div>
								<div class="row-value">

									<div class="local-weather-holder"
										data-type="forecast"
										data-forecast-index="<?php echo $i; ?>"
										data-location-request="<?php echo esc_attr( lsvr_get_field( 'locale_weather_location' ) ); ?>"
										data-units-format="<?php echo esc_attr( lsvr_get_field( 'locale_weather_units_format', 'metric' ) ); ?>">

										<i class="local-icon"></i>
										<div class="local-temperature" title="<?php _e( 'Temperature', 'lsvrtoolkit' ); ?>"></div>
										<small class="local-wind-speed" title="<?php _e( 'Wind speed', 'lsvrtoolkit' ); ?>"></small>

									</div>

								</div>
							</li>
						<?php endfor; ?>
					<?php endif; ?>

				<?php endif; ?>

				<?php // GET CUSTOM FIELDS
				if ( is_array( lsvr_get_field( 'locale_custom_fields' ) ) ) : ?>

					<?php $custom_fields_arr = lsvr_consolidate_repeater_field( lsvr_get_field( 'locale_custom_fields' ), array( 'field_title', 'field_value' ) ); ?>
					<?php if ( is_array( $custom_fields_arr ) ) : ?>
						<?php foreach ( $custom_fields_arr as $custom_field ) : ?>
							<?php if ( is_array( $custom_field ) ) : ?>

								<?php $custom_field_title = array_key_exists( 'field_title', $custom_field ) ? $custom_field['field_title'] : ''; ?>
								<?php $custom_field_value = array_key_exists( 'field_value', $custom_field ) ? $custom_field['field_value'] : ''; ?>

								<li>
									<div class="row-title"><h4><?php echo $custom_field_title; ?></h4></div>
									<div class="row-value"><?php echo $custom_field_value; ?></div>
								</li>

							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>

				<?php endif; ?>

				</ul>
            </div>
		<?php echo $after_widget; ?>

        <?php

    }

}}

?>