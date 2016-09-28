<?php
/**
 * Plugin Name: The Events Calendar Extension: Link Imported Events Back to Facebook
 * Description: Add a link back to the Facebook.com event on events imported from Facebook.
 * Version: 1.0.0
 * Author: Modern Tribe, Inc.
 * Author URI: http://m.tri.be/1971
 * License: GPLv2 or later
 */

defined( 'WPINC' ) or die;

class Tribe__Extension__Link_Imported_Events_Back_to_Facebook {

    /**
     * The semantic version number of this extension; should always match the plugin header.
     */
    const VERSION = '1.0.0';

    /**
     * Each plugin required by this extension
     *
     * @var array Plugins are listed in 'main class' => 'minimum version #' format
     */
    public $plugins_required = array(
        'Tribe__Events__Main'               => '4.2',
        'Tribe__Events__Facebook__Importer' => '4.2'
    );

    /**
     * The constructor; delays initializing the extension until all other plugins are loaded.
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( $this, 'init' ), 100 );
    }

    /**
     * Extension hooks and initialization; exits if the extension is not authorized by Tribe Common to run.
     */
    public function init() {

        // Exit early if our framework is saying this extension should not run.
        if ( ! function_exists( 'tribe_register_plugin' ) || ! tribe_register_plugin( __FILE__, __CLASS__, self::VERSION, $this->plugins_required ) ) {
            return;
        }

        add_action( 'tribe_events_single_event_before_the_content', array( $this, 'add_link_to_fb_event' ) );
    }

    /**
     * Add a link to the Facebook event at the start of event content.
     */
    public function add_link_to_fb_event() {
      
        $fbid = tribe_get_event_meta( get_the_ID(), '_FacebookID' );

        // Only proceed if this event is indeed imported from Facebook.
        if ( empty( $fbid ) )
            return;

        printf( '<p><a href="http://facebook.com/events/%s" target="_blank" rel="nofollow">See this event on Facebook</a></p>', absint( $fbid ) );
    }
}

new Tribe__Extension__Link_Imported_Events_Back_to_Facebook();
