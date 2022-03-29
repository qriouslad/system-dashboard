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

        if ( !is_dir( WPMU_PLUGIN_DIR ) ) {

            if ( is_writable( WP_CONTENT_DIR ) ) {

                mkdir( WPMU_PLUGIN_DIR, 0755 );

            } else {}

        }

        if ( is_dir( WPMU_PLUGIN_DIR ) ) {

            if ( is_writeable( WPMU_PLUGIN_DIR ) ) {

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

	}

}
