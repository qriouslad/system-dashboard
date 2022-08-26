<?php

/**
 * Fired during plugin activation
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    System_Dashboard
 * @subpackage System_Dashboard/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    System_Dashboard
 * @subpackage System_Dashboard/includes
 * @author     Bowo <hello@bowo.io>
 */
class System_Dashboard_Activator {

	/**
	 * Load Fast Ajax MU plugin
	 *
	 * Long Description.
     *
     * @link https://plugins.svn.wordpress.org/plugin-logic/tags/1.0.7/plugin-logic.php
     * @link https://github.com/atwellpub/WordPress-Fast-Ajax-Mu-Plugin/blob/master/fast-ajax.php
	 * @since    1.0.0
	 */
	public static function activate() {

        $fast_ajax_file = WPMU_PLUGIN_DIR . '/fast-ajax.php';

        // Creates mu-plugin directory if it does not exist

        if ( !is_dir( WPMU_PLUGIN_DIR ) ) {

            if ( is_writable( WP_CONTENT_DIR ) ) {

                mkdir( WPMU_PLUGIN_DIR, 0755 );

            } else {}

        }

        // Creates fast-ajax.php as a must-use plugin

        if ( is_dir( WPMU_PLUGIN_DIR ) ) {

            if ( is_writeable( WPMU_PLUGIN_DIR ) ) {

            // Indentation with tabs are removed for the nowdoc declaration below to prevent errors on plugin activation in PHP versions up to 7.2. Heredoc / nowdoc is finicky as described in https://stackoverflow.com/q/16745654.

// https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.nowdoc
$file_content = <<<'EOD'
<?php

define('FAST_AJAX' , true );

/**
 * Enable Fast Ajax
 */
add_filter( 'option_active_plugins', 'ajax_disable_plugins' );
function ajax_disable_plugins($plugins){

    /* load all plugins if not in ajax mode */
    if ( !defined( 'DOING_AJAX' ) )  {
        return $plugins;
    }

    /* load all plugins if fast_ajax is set to false */
    if ( !isset($_REQUEST['fast_ajax']) || !$_REQUEST['fast_ajax'] )  {
        return $plugins;
    }

    /* load all plugins if load_plugins is set to all */
    if ( $_REQUEST['load_plugins'] == 'all' )  {
        return $plugins;
    }

    /* disable all plugins if none are told to load by the load_plugins array */
    if ( !isset($_REQUEST['load_plugins']) || !$_REQUEST['load_plugins'] )  {
        return array();
    }

    /* convert json */
    if (!is_array($_REQUEST['load_plugins']) && $_REQUEST['load_plugins']) {
        $_REQUEST['load_plugins'] = json_decode($_REQUEST['load_plugins'],true);
    }

    /* unset plugins not included in the load_plugins array */
    foreach ($plugins as $key => $plugin_path) {

        if (!in_array($plugin_path, $_REQUEST['load_plugins'] )) {
            unset($plugins[$key]);
        }

    }

    return $plugins;
}
EOD;

                file_put_contents( $fast_ajax_file, $file_content );

            }

        }

        // Include upgrade.php so we can use dbDelta() function to manipulate the database

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

        // Create database table for the Page Access logger in the Logs module

        global $wpdb;

        $page_access_log_table = $wpdb->prefix . 'sd_page_access_log';

        $sql = 
        "CREATE TABLE {$page_access_log_table} (
            ID int(11) unsigned NOT NULL AUTO_INCREMENT,
            access_on datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            from_ip varchar(255) NOT NULL DEFAULT '',
            page_url varchar(255) NOT NULL DEFAULT '',
            PRIMARY KEY (ID)
        ) 
        DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate};";

        dbDelta( $sql );

        // Create database table for the PHP Errors logger in the Logs module

        global $wpdb;

        $email_delivery_log_table = $wpdb->prefix . 'sd_email_delivery_log';

        $sql = 
        "CREATE TABLE {$email_delivery_log_table} (
            ID int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
            to_email varchar(100) NOT NULL,
            subject varchar(255) NOT NULL,
            message text NOT NULL,
            headers text NOT NULL,
            attachments TEXT NOT NULL DEFAULT '',
            sent_on varchar(50) NOT NULL,
            sent_on_gmt varchar(50) NOT NULL
        )
        DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate};";

        dbDelta( $sql );

        // Create options for various logging tools and set default values

        // Page Access Log

        $option_value = array(
            'status'    => 'disabled',
            'on'        => date( 'Y-m-d H:i:s' ),
        );

        update_option( 'system_dashboard_page_access_log', $option_value, false );

        // Errors Log

        $option_value = array(
            'status'    => 'disabled',
            'on'        => date( 'Y-m-d H:i:s' ),
        );

        update_option( 'system_dashboard_errors_log', $option_value, false );

        // Email Delivery Log

        $option_value = array(
            'status'    => 'disabled',
            'on'        => date( 'Y-m-d H:i:s' ),
        );

        update_option( 'system_dashboard_email_delivery_log', $option_value, false );

        // Create /logs directory inside /uploads/system-dashboard directory

        $base_dir_path = wp_upload_dir()['basedir'] . '/' . SYSTEM_DASHBOARD_PLUGIN_SLUG;
        $logs_base_dir_path = $base_dir_path . '/logs';
        $errors_log_dir_path = $logs_base_dir_path . '/errors';
        $plain_domain = str_replace( array( ".", "-" ), "", $_SERVER['SERVER_NAME'] );
        $errors_log_file_path = $errors_log_dir_path . '/' . $plain_domain . '_debug.log';

        // Create base directories in Uploads folder if they don't exist

        if ( !is_dir( $base_dir_path ) ) {
            mkdir( $base_dir_path );
        }

        if ( !is_dir( $logs_base_dir_path ) ) {
            mkdir( $logs_base_dir_path );
        } else {}

        if ( !is_dir( $errors_log_dir_path ) ) {
            mkdir( $errors_log_dir_path );
        } else {}

        // Create empty log file
        if ( !is_file( $errors_log_file_path ) ) {
            file_put_contents( $errors_log_file_path, '' );
        } else {}

	}

}
