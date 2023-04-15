<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    System_Dashboard
 * @subpackage System_Dashboard/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    System_Dashboard
 * @subpackage System_Dashboard/includes
 * @author     Bowo <hello@bowo.io>
 */
class System_Dashboard {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      System_Dashboard_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SYSTEM_DASHBOARD_VERSION' ) ) {
			$this->version = SYSTEM_DASHBOARD_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'system-dashboard';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - System_Dashboard_Loader. Orchestrates the hooks of the plugin.
	 * - System_Dashboard_i18n. Defines internationalization functionality.
	 * - System_Dashboard_Admin. Defines all hooks for the admin area.
	 * - System_Dashboard_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-system-dashboard-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-system-dashboard-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-system-dashboard-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-system-dashboard-public.php';

		/**
		 * Include CodeStar framework
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/codestar-framework/codestar-framework.php';

		/**
		 * Include libraries/classes added via composer
		 */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';

		$this->loader = new System_Dashboard_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the System_Dashboard_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new System_Dashboard_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Check if current screen is this plugin's (System Dashboard plugin's) main page
	 *
	 * @since 1.6.1
	 */
	public function is_sd() {

		$request_uri = $_SERVER['REQUEST_URI']; // e.g. /wp-admin/index.php?page=system-dashboard

		if ( strpos( $request_uri, 'index.php?page=' . $this->plugin_name ) !== false ) {

			return true; // Yes, this is the system dashboard page

		} else {

			return false; // Nope, this is NOT the system dashboard page


		}

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new System_Dashboard_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'sd_remove_codestar_submenu' );

		if ( is_admin() && $this->is_sd() ) {

			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		} else {}

		// Only process dashboard functions if the current page is the dashboard page. Otherwise, only show the 'System' link under the Dashboard menu.

		if ( is_admin() && $this->is_sd() ) {

			$this->loader->add_action( 'csf_loaded', $plugin_admin, 'sd_dashboard_page' );

			// Replace WP version text in footer
			$this->loader->add_action( 'update_footer', $plugin_admin, 'footer_version_text', 20 );

		} elseif ( is_admin() && ( ! $this->is_sd() ) ) {

			$this->loader->add_action( 'admin_menu', $plugin_admin, 'sd_register_submenu' );

		}

		$this->loader->add_filter( 'plugin_action_links_'.$this->plugin_name.'/'.$this->plugin_name.'.php', $plugin_admin, 'sd_add_plugin_action_links' );
		// $this->loader->add_filter( 'plugin_row_meta', $plugin_admin, 'sd_add_plugin_meta_links', $this->plugin_name.'/'.$this->plugin_name.'.php', 'data', 'active' );

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'sd_suppress_admin_notices', 5 ); // Load early with priority 5 (default is 10)

		// Register AJAX callback functions
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'sd_ajax_calls' );
		$this->loader->add_action( 'wp_ajax_sd_db_tables', $plugin_admin, 'sd_db_tables' );
		$this->loader->add_action( 'wp_ajax_sd_db_specs', $plugin_admin, 'sd_db_specs' );
		$this->loader->add_action( 'wp_ajax_sd_db_details', $plugin_admin, 'sd_db_details' );
		$this->loader->add_action( 'wp_ajax_sd_post_types', $plugin_admin, 'sd_post_types' );
		$this->loader->add_action( 'wp_ajax_sd_taxonomies', $plugin_admin, 'sd_taxonomies' );
		$this->loader->add_action( 'wp_ajax_sd_old_slugs', $plugin_admin, 'sd_old_slugs' );
		$this->loader->add_action( 'wp_ajax_sd_media_count', $plugin_admin, 'sd_media_count' );
		$this->loader->add_action( 'wp_ajax_sd_image_sizes', $plugin_admin, 'sd_image_sizes' );
		$this->loader->add_action( 'wp_ajax_sd_mime_types', $plugin_admin, 'sd_mime_types' );
		$this->loader->add_action( 'wp_ajax_sd_media_handling', $plugin_admin, 'sd_media_handling' );
		$this->loader->add_action( 'wp_ajax_sd_directory_sizes', $plugin_admin, 'sd_directory_sizes' );
		$this->loader->add_action( 'wp_ajax_sd_filesystem_permissions', $plugin_admin, 'sd_filesystem_permissions' );
		$this->loader->add_action( 'wp_ajax_sd_custom_fields', $plugin_admin, 'sd_custom_fields' );
		$this->loader->add_action( 'wp_ajax_sd_user_count', $plugin_admin, 'sd_user_count' );
		$this->loader->add_action( 'wp_ajax_sd_roles_capabilities', $plugin_admin, 'sd_roles_capabilities' );
		$this->loader->add_action( 'wp_ajax_sd_rewrite_rules', $plugin_admin, 'sd_rewrite_rules' );
		$this->loader->add_action( 'wp_ajax_sd_shortcodes', $plugin_admin, 'sd_shortcodes' );
		$this->loader->add_action( 'wp_ajax_sd_option_value', $plugin_admin, 'sd_option_value' );
		$this->loader->add_action( 'wp_ajax_sd_cache_value', $plugin_admin, 'sd_cache_value' );
		$this->loader->add_action( 'wp_ajax_sd_global_value', $plugin_admin, 'sd_global_value' );
		$this->loader->add_action( 'wp_ajax_sd_wpcore_hooks', $plugin_admin, 'sd_wpcore_hooks' );
		$this->loader->add_action( 'wp_ajax_sd_hooks', $plugin_admin, 'sd_hooks' );
		$this->loader->add_action( 'wp_ajax_sd_classes', $plugin_admin, 'sd_classes' );
		$this->loader->add_action( 'wp_ajax_sd_functions', $plugin_admin, 'sd_functions' );
		$this->loader->add_action( 'wp_ajax_sd_constants', $plugin_admin, 'sd_constants' );
		$this->loader->add_action( 'wp_ajax_sd_viewer', $plugin_admin, 'sd_viewer' );
		$this->loader->add_action( 'wp_ajax_sd_viewer_url', $plugin_admin, 'sd_viewer_url' );
		$this->loader->add_action( 'wp_ajax_sd_php_info', $plugin_admin, 'sd_php_info' );

		$this->loader->add_action( 'wp_ajax_sd_toggle_logs', $plugin_admin, 'sd_toggle_logs' );
		$this->loader->add_action( 'wp_ajax_sd_page_access_log', $plugin_admin, 'sd_page_access_log' );
		$this->loader->add_action( 'wp_ajax_sd_errors_log', $plugin_admin, 'sd_errors_log' );
		$this->loader->add_action( 'wp_ajax_sd_email_delivery_log', $plugin_admin, 'sd_email_delivery_log' );

		// Register loggers when they're enabled

		// Page Access logger

		$page_access_log = get_option( 'system_dashboard_page_access_log' );
		if ( ! empty( $page_access_log['status'] ) && ( $page_access_log['status'] == 'enabled' ) ) {
			$this->loader->add_action( 'init', $plugin_admin, 'sd_page_access_logger' );
		}

		// Email Delivery logger

		$email_delivery_log = get_option( 'system_dashboard_email_delivery_log' );
		if ( ! empty( $email_delivery_log['status'] ) && ( $email_delivery_log['status'] == 'enabled' ) ) {
			$this->loader->add_filter( 'wp_mail', $plugin_admin, 'sd_email_delivery_logger' );
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new System_Dashboard_Public( $this->get_plugin_name(), $this->get_version() );

		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    System_Dashboard_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
