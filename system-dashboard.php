<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bowo.io
 * @since             1.0.0
 * @package           System_Dashboard
 *
 * @wordpress-plugin
 * Plugin Name:       System Dashboard
 * Plugin URI:        https://wordpress.org/plugins/system-dashboard/
 * Description:       Centralized dashboard to monitor various WordPress components, stats and data, including the server.
 * Version:           2.8.20
 * Author:            Bowo
 * Author URI:        https://bowo.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       system-dashboard
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SYSTEM_DASHBOARD_VERSION', '2.8.20' );
define( 'SYSTEM_DASHBOARD_PLUGIN_SLUG', 'system-dashboard' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-system-dashboard-activator.php
 */
function activate_system_dashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-system-dashboard-activator.php';
	System_Dashboard_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-system-dashboard-deactivator.php
 */
function deactivate_system_dashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-system-dashboard-deactivator.php';
	System_Dashboard_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_system_dashboard' );
register_deactivation_hook( __FILE__, 'deactivate_system_dashboard' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-system-dashboard.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_system_dashboard() {

	$plugin = new System_Dashboard();
	$plugin->run();

}
run_system_dashboard();
