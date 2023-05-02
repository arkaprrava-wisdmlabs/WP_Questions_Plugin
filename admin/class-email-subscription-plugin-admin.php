<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://arkaprava.com
 * @since      1.0.0
 *
 * @package    Email_Subscription_Plugin
 * @subpackage Email_Subscription_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Email_Subscription_Plugin
 * @subpackage Email_Subscription_Plugin/admin
 * @author     Arkaprava <chakraarkaprava@gmail.com>
 */
class Email_Subscription_Plugin_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/email-subscription-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/email-subscription-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function es_settings_init() {
		register_setting( 'es', 'es_options' );
	
		add_settings_section(
			'es_settings_section',
			'', '',
			'es'
		);
		add_settings_field(
			'es_settings_field',
			__( 'post links per updation', 'es' ),
			array($this,'es_settings_field_callback'),
			'es',
			'es_settings_section',
		);
	}
	public function es_settings_field_callback() {
		$options = get_option( 'es_options' );
		?>
		<input type="number" name="es_options" id="es_options" placeholder="no. of latest post" value="<?php echo $options; ?>">
		<?php
	}
	public function es_options_page() {
		add_menu_page(
			__('Email Subscription','es'),
			'Email Subscription',
			'manage_options',
			'es',
			array($this,'es_options_page_html')
		);
	}
	public function es_options_page_html() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'es_messages', 'es_message', __( 'Settings Saved', 'es' ), 'updated' );
		}
		settings_errors( 'es_messages' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'es' );
				do_settings_sections( 'es' );
				submit_button( 'Save Settings' );
				?>
			</form>
		</div>
		<?php
	}
	public function es_mail(){
		$message = $this->es_data_loader();
		$subject = 'Recent Post Notification';
		$headers = '';
		$to_list = $this->es_get_subscription_emails();
		foreach($to_list as $to){
			$content_type = function() { return 'text/html'; };
			add_filter( 'wp_mail_content_type', $content_type );
			wp_mail( $to, $subject, $message, $headers );
			remove_filter( 'wp_mail_content_type', $content_type );
		}
	}
	public function es_data_loader(){
		$post_per_page = get_option( 'es_options' );
		$news = array(
			'post_type'=>'post',
			'post_status'=>'publish',
			'date_query'    => array(
				'column'  => 'post_date',
				'after'   => '- 1 days'
			),
			'posts_per_page' => $post_per_page
		);
		$data = array();
		$query = new WP_query($news);
		if($query->have_posts()){
			while($query->have_posts()){
				$query->the_post();
				$title = '<strong>'.get_the_title().'</strong>';
				$link = '<a href="'.get_the_permalink().'">'.get_the_permalink().'</a>' ;
				$post = array(
					'title' => $title,
					'link' => $link
				);
				array_push($data, $post);
			}
			ob_start();
			?>
			<table id="elements">
				<thead>
					<th>News Title</th>
					<th>link</th>
				</thead>
				<tbody>
					<?php
					foreach($data as $dat){
						?>
						<tr>
							<td><?php echo $dat['title']; ?></td>
							<td><?php echo $dat['link']; ?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<style>
				#elements {
					border-collapse: collapse;
					width: 900px;
					margin: 20px 50px;
				}
				#elements th, #elements td {
					border: 1px solid #ddd;
					padding: 8px;
					text-align: center;
				}
	
				#elements tr:nth-child(even){background-color: #f3f3f3;}
	
				#elements tr:hover {background-color: #fafafa;}
	
				#elements th {
					padding-top: 12px;
					padding-bottom: 12px;
					background-color: #ffffff;
					color: #black;
				}
			</style>
			<?php
			$html = ob_get_clean();
			return $html;
		}
		else{
			return "<h1>no recent post<h1>";
		}
	}
	public function es_get_subscription_emails(){
		global $wpdb, $table_prefix;
		$table_name = $table_prefix."subscription_emails";
		$q = "SELECT email FROM `$table_name`;";
		$results = $wpdb->get_results($q);
		$mail = array();
		foreach($results as $result){
			array_push($mail,$result->email);
		}
		return $mail;
	}
}
