<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://arkaprava.com
 * @since      1.0.0
 *
 * @package    Email_Subscription_Plugin
 * @subpackage Email_Subscription_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Email_Subscription_Plugin
 * @subpackage Email_Subscription_Plugin/public
 * @author     Arkaprava <chakraarkaprava@gmail.com>
 */
class Email_Subscription_Plugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Email_Subscription_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Email_Subscription_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/email-subscription-plugin-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Email_Subscription_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Email_Subscription_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/email-subscription-plugin-public.js', array( 'jquery' ), $this->version, false );

	}
	public function es_shortcode(){ 
		ob_start();
		?>
		<form method="post" id="subscription_form" class="subscription">
			<h1>Email Subscription</h1>
			<input type="email" name="email" id="email" placeholder="Enter Your Email" />
			<button type="submit" name="submit">Subscribe</button>
		</form>
		<?php
		$html = ob_get_clean();
		return $html;
	}

}
