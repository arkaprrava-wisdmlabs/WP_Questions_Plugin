<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://arkaprava.com
 * @since      1.0.0
 *
 * @package    Email_Subscription_Plugin
 * @subpackage Email_Subscription_Plugin/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Email_Subscription_Plugin
 * @subpackage Email_Subscription_Plugin/includes
 * @author     Arkaprava <chakraarkaprava@gmail.com>
 */
class Email_Subscription_Plugin_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$timestamp = wp_next_scheduled( 'email_latest_posts_daily_to_subscribers' );
    	wp_unschedule_event( $timestamp, 'email_latest_posts_daily_to_subscribers' );
	}

}
