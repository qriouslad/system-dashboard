<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    System_Dashboard
 * @subpackage System_Dashboard/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    System_Dashboard
 * @subpackage System_Dashboard/includes
 * @author     Bowo <hello@bowo.io>
 */
class System_Dashboard_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

        // Delete fast-ajax.php MU plugin

        $fast_ajax_file = WPMU_PLUGIN_DIR . '/fast-ajax.php';

        unlink( $fast_ajax_file );

        // Drop (delete) Access Log table
        
        global $wpdb;

        $page_access_log_table = $wpdb->prefix . 'sd_page_access_log';

        $sql = "DROP TABLE IF EXISTS {$page_access_log_table}";

        $wpdb->query( $sql );

        // Delete option in wp_options table for the various logging tools

        delete_option( 'system_dashboard_page_access_log' );

	}

}
