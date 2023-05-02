<?php

/**
 * Fired during plugin activation
 *
 * @link       https://arkaprava.com
 * @since      1.0.0
 *
 * @package    Email_Subscription_Plugin
 * @subpackage Email_Subscription_Plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Email_Subscription_Plugin
 * @subpackage Email_Subscription_Plugin/includes
 * @author     Arkaprava <chakraarkaprava@gmail.com>
 */
class Email_Subscription_Plugin_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb, $table_prefix;
		$table_name = $table_prefix.'subscription_emails';
		$q = "CREATE TABLE IF NOT EXISTS `$table_name` (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			email varchar(50) NOT NULL UNIQUE,
			PRIMARY KEY  (id)
		)";
		$wpdb->query($q);
		if ( !wp_next_scheduled( 'email_latest_posts_daily_to_subscribers' ) ) {
			wp_schedule_event( time(), 'daily', 'email_latest_posts_daily_to_subscribers' );
		}
	}

}
