<?php
/**
 * Plugin Name: The Events Calendar — Link Imported Events Back to Facebook
 * Description: Add a link back to the Facebook.com event on events imported from Facebook.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1x
 * License: GPLv2 or later
 */
 
defined( 'WPINC' ) or die;

/**
 * Add a link to the Facebook event at the start of event content.
 *
 * @return void
 */
function tribe_add_link_to_fb_event() {

	$fbid = tribe_get_event_meta( get_the_ID(), '_FacebookID' );

	// Only proceed if this event is indeed imported from Facebook.
	if ( empty( $fbid ) )
		return;

	printf( '<p><a href="http://facebook.com/events/%s" target="_blank" rel="nofollow">See this event on Facebook</a></p>', absint( $fbid ) );
}

add_action( 'tribe_events_single_event_before_the_content', 'tribe_add_link_to_fb_event' );
