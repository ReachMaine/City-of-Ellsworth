<?php /* tribe-events custom functions */

//add_action('tribe_events_bar_after_template', 'coe_before_events_list');
add_action('tribe_events_after_the_title', 'coe_before_events_list');
function coe_before_events_list() {
	echo do_shortcode('[text-blocks id="calendar-pre-amble"]');
}