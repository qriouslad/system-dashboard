<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bowo.io
 * @since      1.0.0
 *
 * @package    System_Dashboard
 * @subpackage System_Dashboard/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    System_Dashboard
 * @subpackage System_Dashboard/admin
 * @author     Bowo <hello@bowo.io>
 */

class System_Dashboard_Admin {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/system-dashboard-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-json-viewer', plugin_dir_url( __FILE__ ) . 'css/jquery.json-viewer.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/system-dashboard-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-json-viewer', plugin_dir_url( __FILE__ ) . 'js/jquery.json-viewer.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Get HTML partials
	 *
	 * @since 1.0.0
	 */
	public function sd_html( $partial, $content = '', $classes = '', $data_attributes = array(), $id = '' ) {

		if ( !empty( $classes ) ) {

			$additional_classes = ' ' . $classes;
			$class_output = ' class="' . $classes . '"';

		} else {

			$additional_classes = '';
			$class_output = '';

		}

		$data_atts = '';

		foreach ( $data_attributes as $key => $value ) {

			if ( empty( $value ) ) {

				$data_atts = 'data-' . $key . ' ';

			} else {

				$data_atts .= 'data-' . $key . '="' . $value . '" ';

			}

		}

		if ( !empty( $id ) ) {

			$id_output = ' id="' . $id . '"';

		} else {

			$id_output = '';

		}

		// Inline accordions

		if ( $partial == 'accordions-start' ) {

			return '<div class="group" ' . $data_atts . '><dl class="mc-collapsible" data-controls="data-controls">';

		} elseif ( $partial == 'accordions-start-margin-default' ) {

			return '<div class="group margin-default" ' . $data_atts . '><dl class="mc-collapsible" data-controls="data-controls">';

		} elseif ( $partial == 'accordions-start-simple-margin-default' ) {

			return '<div class="group margin-default" ' . $data_atts . '><dl class="mc-collapsible">';

		} elseif ( $partial == 'accordions-start-simple' ) {

			return '<div class="group" ' . $data_atts . '><dl class="mc-collapsible">';

		} elseif ( $partial == 'accordions-start-left' ) {

			return '<div class="group" ' . $data_atts . '><dl class="mc-collapsible ac-left">';

		} elseif ( $partial == 'accordion-head' ) {

			return '<dt ' . $id_output . $class_output . $data_atts . '>' . $content . '</dt>';

		} elseif ( $partial == 'accordion-body' ) {

			return '<dd>' . $content . '</dd>';

		} elseif ( $partial == 'accordions-end' ) {

			return '</dl></div>';

		} elseif ( $partial == 'search-filter' ) {

			return '<div class="field-parts search-filter"><div class="field-part first-part full-width"><input type="text" placeholder="Search..." ' . $data_atts . ' /><div class="search-filter-additional-info">' . $content . '</div></div></div>';

		}

		// Field content

		elseif ( $partial == 'field-content-start' ) {

			return '<div class="field-parts ' . $additional_classes . '" '. $data_atts .'>';

		} elseif ( $partial == 'field-content-first' ) {

			return '<div class="field-part first-part ' . $additional_classes . '">' . $content . '</div>';

		} elseif ( $partial == 'field-content-second' ) {

			return '<div class="field-part second-part ' . $additional_classes . '">' . $content . '</div>';

		} elseif ( $partial == 'field-content-end' ) {

			return '</div>';

		}

		// Ajax call receiver div

		elseif ( $partial == 'ajax-receiver' ) {

			return '<div id="spinner-' . $content . '"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="' . $content . '-content"></div>';

		}

	}

	/** 
	 * Preview various output of functions related to WordPress URLs, directories and paths
	 *
	 * @since 1.0.0
	 */
	public function sd_tests() {

		$output = '';

		$output = 'get_site_url() - ' . get_site_url() . '<br />';
		$output .= 'admin_url() - ' . admin_url() . '<br />';
		$output .= 'content_url() - ' . content_url() . '<br />';

		$output .= 'wp_upload_dir()[\'baseurl\'] - ' . wp_upload_dir()['baseurl'] . '<br />';
		$output .= 'wp_upload_dir()[\'url\'] - ' . wp_upload_dir()['url'] . '<br />';
		$output .= 'wp_upload_dir()[\'basedir\'] - ' . wp_upload_dir()['basedir'] . '<br />';
		$output .= 'wp_upload_dir()[\'path\'] - ' . wp_upload_dir()['path'] . '<br />';

		$output .= 'plugins_url() - ' . plugins_url() . '<br />';
		$output .= 'plugin_dir_url(  __DIR__ ) - ' . plugin_dir_url(  __DIR__ ) . '<br />';
		$output .= 'plugin_dir_url(  __FILE__ ) - ' . plugin_dir_url(  __FILE__ ) . '<br />';

		$output .= 'plugin_dir_path( __FILE__ ) - ' . plugin_dir_path( __FILE__ ) . '<br />';
		$output .= 'plugin_dir_path( __DIR__ ) - ' . plugin_dir_path( __DIR__ ) . '<br />';

		$output .= 'get_template_directory_uri() - ' . get_template_directory_uri() . '<br />';
		$output .= 'get_stylesheet_directory_uri() - ' . get_stylesheet_directory_uri() . '<br />';
		$output .= 'get_stylesheet_uri() - ' . get_stylesheet_uri() . '<br />';
		$output .= 'get_theme_root_uri() - ' . get_theme_root_uri() . '<br />';

		$output .= 'get_theme_root() - ' . get_theme_root() . '<br />';
		$output .= 'get_theme_roots() - ' . get_theme_roots() . '<br />';
		$output .= 'get_template_directory() - ' . get_stylesheet_directory() . '<br />';
		$output .= 'get_stylesheet_directory() - ' . get_stylesheet_directory() . '<br />';
		$output .= 'get_stylesheet_directory_uri() - ' . get_stylesheet_directory() . '<br />';

		$output .= 'FAST_AJAX: ' . FAST_AJAX;

		return $output;

	}


	/**
	 * print_r variable value -- for debugging
	 *
	 * @since 1.0.0
	 */
	public function printr_var( $var = '' ) {

		return '<pre>' . print_r( $var, TRUE ) . '</pre>';

	}

	/**
	 * Get overview of the WordPress installation
	 *
	 * @since 1.0.0
	 */
	
	public function sd_wp_overview() {

		$output = '';

		$output .= '<strong>Site Health</strong>: <br />' . $this->sd_site_health() . '<br />';

		$output .= '<strong>Theme</strong>: <br /><a href="'. wp_get_theme()->get( 'ThemeURI' ) .'" target="_blank">'.wp_get_theme()->get( 'Name' ) .'</a> '.wp_get_theme()->get( 'Version' ).'<br />';

		if ( !empty( wp_get_theme()->get( 'Author' ) ) ) {

			$output .= 'by <a href="'.wp_get_theme()->get( 'AuthorURI' ).'" target="_blank">'. wp_get_theme()->get( 'Author' ) .'</a><br />';

		}

		if ( ! function_exists( 'get_plugins' ) ) {

		    require_once ABSPATH . 'wp-admin/includes/plugin.php';

		}

		$output .= '<strong>Plugins</strong>: <br /><a href="/wp-admin/plugins.php" target="_blank">' . count( get_plugins() ) . ' installed</a><br /><a href="/wp-admin/plugins.php?plugin_status=active" target="_blank">' . count( get_option( 'active_plugins' ) ) . ' active</a><br />';

		$output .= '<strong>Timezone</strong>: <br />' . get_option( 'timezone_string' ) . '<br />';

		$output .= '<strong>Current Date Time</strong>: <br />' . current_time( 'F j, Y - H:i' ) . '<br />';

		$output .= '<strong>Your IP</strong>: <br />' . $this->sd_get_user_ip() . '<br />';

		$output .= '<div style="display: none;">' . $this->sd_active_plugins( 'original', 'print_r') . '</div>';

		return $output;

	}

	/**
	 * Get Site Health status. Modified from WP core function wp_dashboard_site_health()
	 *
	 * @link wp-admin/includes/dashboard.php
	 * @link wp-admin/js/site-health.js
	 * @since 1.1.0
	 */
	public function sd_site_health() {

		$output = '';

		$get_issues = get_transient( 'health-check-site-status-result' );

		$issue_counts = array();

		if ( false !== $get_issues ) {
			$issue_counts = json_decode( $get_issues, true );
		}

		if ( ! is_array( $issue_counts ) || ! $issue_counts ) {
			$issue_counts = array(
				'good'        => 0,
				'recommended' => 0,
				'critical'    => 0,
			);
		}

		$issues_total = $issue_counts['recommended'] + $issue_counts['critical'];

		// From recalculateProgress() in site-health.js

		$tests_total = $issue_counts['good'] + $issue_counts['recommended'] + ( $issue_counts['critical'] * 1.5 );

		$tests_failed = ( $issue_counts['recommended'] * 0.5 ) + ( $issue_counts['critical'] * 1.5 );

		$tests_score = 0;
		if ( $tests_total > 0 ) {
			$tests_score = 100 - ceil( ( $tests_failed / $tests_total ) * 100 );
		}

		if ( ( 80 <= $tests_score ) && ( 0 === (int) $issue_counts['critical'] ) ) {

			$site_health_dot_class = 'green';

		} else {

			$site_health_dot_class = 'orange';

		}

		$output .= '<div class="site-health-dot ' . $site_health_dot_class . '"><span style="display:none;">' . $tests_score . '</span></div>';

		if ( false === $get_issues ) {

			$output .= 'Visit the <a href="' . esc_url( admin_url( 'site-health.php' ) ) . '">Site Health screen</a> to perform checks now.';

		} else {

			if ( $issues_total <= 0 ) {
				$output .= 'Great job! Your site currently passes all site health <a href="' . esc_url( admin_url( 'site-health.php' ) ) . '" target="_blank">checks</a>.';
			} elseif ( 1 === (int) $issue_counts['critical'] )  {
				$output .= 'Your site has <a href="' . esc_url( admin_url( 'site-health.php' ) ) . '" target="_blank">a critical issue</a> that should be addressed as soon as possible. ';
			} elseif ( $issue_counts['critical'] > 1 ) {
				$output .= 'Your site has <a href="' . esc_url( admin_url( 'site-health.php' ) ) . '" target="_blank">critical issues</a> that should be addressed as soon as possible.';
			} elseif ( 1 === (int) $issue_counts['recommended'] ) {
				$output .= 'Looking good, but <a href="' . esc_url( admin_url( 'site-health.php' ) ) . '" target="_blank">one thing</a> can be improved.';
			} else {
				$output .= 'Looking good, but <a href="' . esc_url( admin_url( 'site-health.php' ) ) . '" target="_blank">some things</a> can be improved.';
			}

		}

		return $output;

	}

	/**
	 * Get overview of server / hosting
	 *
	 * @since 1.0.0
	 */
	public function sd_server_overview() {

		$output = '';

		$output .= '<strong>Operating System</strong>: <br />' . $this->sd_os_info(). '<br />';

		$output .= '<strong>Web Server</strong>: <br />' .$_SERVER['SERVER_SOFTWARE'] . ' | ' . php_sapi_name() . '<br />';

		$output .= '<strong>IP Address</strong>: <br />' . $_SERVER['SERVER_ADDR'] . '<br />';

		$output .= '<strong>Location</strong>: <br />' . $this->sd_server_location() . '<br />';

		$output .= '<strong>Timezone</strong>: <br />' . date_default_timezone_get() . '<br />';

		$output .= '<strong>Server Date Time</strong>: <br />' . date( 'F j, Y - H:i', time() );

		return $output;

	}

	/**
	 * Get MySQL version
	 * 
	 * @link https://plugins.trac.wordpress.org/browser/debug-info/tags/1.3.10/debug-info.php
	 * @since 1.0.0
	 */
	function sd_get_mysql_version() {

		 if ( is_callable( 'mysqli_get_client_info' ) ) {

		 	$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );

			return mysqli_get_server_info( $connection );		 	

		 } elseif ( !is_callable( 'mysqli_get_client_info' ) ) {

			global $wpdb;

			$rows = $wpdb->get_results('select version() as mysqlversion');

			if (!empty($rows)) {
			         return $rows[0]->mysqlversion;
			}

		 } else {

			return 'Undetectable';

		 }

	}

	/**
	 * Get user's IP address
	 * 
	 * @link https://plugins.trac.wordpress.org/browser/simple-system-status/tags/2.1.3/views/output.php
	 * @since 1.0.0
	 */
	public function sd_get_user_ip() {

		$ip = '127.0.0.1';

		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return apply_filters( 'edd_get_ip', $ip );
	}

	/**
	 * Get post types info 
	 * 
	 * @link https://plugins.trac.wordpress.org/browser/wp-system-info/trunk/class/common.php
	 * @since 1.0.0
	 */
	public function sd_post_types_info(){

		global $wpdb;

		$post_types = $wpdb->get_results( "SELECT post_type AS 'type', count(1) AS 'count' FROM {$wpdb->posts} GROUP BY post_type ORDER BY count DESC;" );

		$output = '';

		foreach ( $post_types as $post_type ) {

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', $post_type->type );
			$output .= $this->sd_html( 'field-content-second', $post_type->count );
			$output .= $this->sd_html( 'field-content-end' );

		}

		return $output;

	}

	/**
	 * Get taxonomies info
	 *
	 * @since 1.0.0
	 */
	public function sd_get_taxonomies_info( $type = 'name' ) {

		$taxonomies_info = '';

		$args = array(
			'public' => true,
		);

		$output = 'names';

		$operator = 'and';

		$taxonomies = get_taxonomies( $args, $output, $operator );

		if ( !empty( $taxonomies ) ) {

			foreach ( $taxonomies as $taxonomy ) {

				$args = array(
					'taxonomy'		=> $taxonomy,
				);

				$taxonomies_info .= $this->sd_html( 'field-content-start' );
				$taxonomies_info .= $this->sd_html( 'field-content-first', $taxonomy );
				$taxonomies_info .= $this->sd_html( 'field-content-second', wp_count_terms( $args ) . ' terms');
				$taxonomies_info .= $this->sd_html( 'field-content-end' );

			}

		}

		return $taxonomies_info;

	}

	/**
	 * Get old slugs
	 *
	 * @link http://plugins.svn.wordpress.org/remove-old-slugspermalinks/tags/2.6.0/includes/class-alg-slugs-manager-core.php
	 * @since 1.5.0
	 */
	public function sd_old_slugs() {

		global $wpdb;

		$query = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_wp_old_slug' ORDER BY post_id";

		$results = $wpdb->get_results( $query );

		$results_array = json_decode( json_encode( $results ), true );

		$output = $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<strong>Old Slug >> Current Slug</strong>' );
		$output .= $this->sd_html( 'field-content-second', '<strong>Post Title (ID - Type)</strong>' );
		$output .= $this->sd_html( 'field-content-end' );			


		foreach ( $results_array as $old_slug ) {

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', $old_slug['meta_value'] . ' >> ' . get_post_field( 'post_name', $old_slug['post_id'] ) );
			$output .= $this->sd_html( 'field-content-second', '<a href="'. get_the_permalink( $old_slug['post_id'] ) .'" target="_blank">' . get_the_title( $old_slug['post_id'] ) . '</a> (' . $old_slug['post_id'] . ' - ' . get_post_field( 'post_type', $old_slug['post_id'] ) . ')' );
			$output .= $this->sd_html( 'field-content-end' );			

		}

		return $output;

	}

	/** 
	 * Get media/attachments count by MIME type
	 * 
	 * @link https://plugins.trac.wordpress.org/browser/cl-wp-info/trunk/class-cl-wp-info.p	 
	 * @since 1.0.0
	 */
	public function sd_media_count_by_mime(){

		$attachments_count = wp_count_attachments();
		$output = '';

		foreach ( $attachments_count as $media_type => $media_num ) {

			if ( $media_num > 1 ) {
				$unit = 'files';
			} else {
				$unit = 'file';
			}

	        if ( ! empty( $media_num ) && $media_type !== 'trash' ) {

				$output .= $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', $media_type );
				$output .= $this->sd_html( 'field-content-second', $media_num . ' ' . $unit);
				$output .= $this->sd_html( 'field-content-end' );

	        }

		}

		return $output;

	}

	/**
	 * Get list of MIME types and associated file extensions
	 *
	 * @since 1.0.0
	 */
	public function sd_get_mime_types_file_extensions() {

		$mime_types = get_allowed_mime_types();

		$output = '';

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<strong>File Extension(s)</strong>' );
		$output .= $this->sd_html( 'field-content-second', '<strong>MIME Type</strong>' );
		$output .= $this->sd_html( 'field-content-end' );

		foreach ( $mime_types as $extensions => $mime_type ) {

			$extensions = str_replace( "|", " | ", $extensions );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', $extensions );
			$output .= $this->sd_html( 'field-content-second', $mime_type, 'long-value' );
			$output .= $this->sd_html( 'field-content-end' );

		}

		// $output .= '<pre>' . print_r( $mime_types, true ) . '</pre>';

		return $output;

	}

	/**
	 * Get info on media handling
	 *
	 * @link wp-admin/includes/class-wp-debug-data.php
	 * @since 1.2.0
	 */
	public function sd_media_handling() {

		$output = '';

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'Active editor' );
		$output .= $this->sd_html( 'field-content-second', _wp_image_editor_choose() );
		$output .= $this->sd_html( 'field-content-end' );

		// Get ImageMagic information, if available.
		if ( class_exists( 'Imagick' ) ) {
			// Save the Imagick instance for later use.
			$imagick             = new Imagick();
			$imagemagick_version = $imagick->getVersion();
		} else {
			$imagemagick_version = __( 'Not available' );
		}

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'ImageMagick version number' );
		$output .= $this->sd_html( 'field-content-second', ( is_array( $imagemagick_version ) ? $imagemagick_version['versionNumber'] : $imagemagick_version ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'ImageMagick version string' );
		$output .= $this->sd_html( 'field-content-second', ( is_array( $imagemagick_version ) ? $imagemagick_version['versionString'] : $imagemagick_version ) );
		$output .= $this->sd_html( 'field-content-end' );

		$imagick_version = phpversion( 'imagick' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'Imagick version' );
		$output .= $this->sd_html( 'field-content-second', ( $imagick_version ) ? $imagick_version : __( 'Not available' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'Max size of post data allowed' );
		$output .= $this->sd_html( 'field-content-second', ini_get( 'post_max_size' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'Max size of an uploaded file' );
		$output .= $this->sd_html( 'field-content-second', ini_get( 'upload_max_filesize' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'Max number of files allowed' );
		$output .= $this->sd_html( 'field-content-second', number_format( ini_get( 'max_file_uploads' ) ) );
		$output .= $this->sd_html( 'field-content-end' );

		// Get GD information, if available.
		if ( function_exists( 'gd_info' ) ) {
			$gd = gd_info();
		} else {
			$gd = false;
		}

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'GD version' );
		$output .= $this->sd_html( 'field-content-second', ( is_array( $gd ) ? $gd['GD Version'] : 'Not available' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$gd_image_formats     = array();
		$gd_supported_formats = array(
			'GIF Create' => 'GIF',
			'JPEG'       => 'JPEG',
			'PNG'        => 'PNG',
			'WebP'       => 'WebP',
			'BMP'        => 'BMP',
			'AVIF'       => 'AVIF',
			'HEIF'       => 'HEIF',
			'TIFF'       => 'TIFF',
			'XPM'        => 'XPM',
		);

		foreach ( $gd_supported_formats as $format_key => $format ) {
			$index = $format_key . ' Support';
			if ( isset( $gd[ $index ] ) && $gd[ $index ] ) {
				array_push( $gd_image_formats, $format );
			}
		}

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'GD supported file formats' );
		$output .= $this->sd_html( 'field-content-second', implode( ', ', $gd_image_formats ) );
		$output .= $this->sd_html( 'field-content-end' );

		// Get Ghostscript information, if available.
		if ( function_exists( 'exec' ) ) {
			$gs = exec( 'gs --version' );

			if ( empty( $gs ) ) {
				$gs = 'Not available';
			} else {
			}
		} else {
			$gs = 'Unable to determine if Ghostscript is installed';
		}

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'Ghostscript version' );
		$output .= $this->sd_html( 'field-content-second', $gs );
		$output .= $this->sd_html( 'field-content-end' );

		return $output;

	}

	/**
	 * Get user roles and associated capabilities
	 * 
	 * @param string $type default_roles | custom_roles
	 * @param string $return role_names | role_capabilities
	 * @since 1.0.0
	 */
	public function sd_get_user_roles_capabilities( $return = 'all' ) {

		$default_wp_roles = array( 'administrator', 'editor', 'author', 'contributor', 'subscriber' );

		$default_capabilities = array(
			'create_sites',
			'delete_sites',
			'manage_network',
			'manage_sites',
			'manage_network_users',
			'manage_network_plugins',
			'manage_network_themes',
			'manage_network_options',
			'upgrade_network',
			'setup_network',
			'activate_plugins',
			'delete_others_pages',
			'delete_others_posts',
			'delete_pages',
			'delete_posts',
			'delete_private_pages',
			'delete_private_posts',
			'delete_published_pages',
			'delete_published_posts',
			'edit_dashboard',
			'edit_others_pages',
			'edit_others_posts',
			'edit_pages',
			'edit_posts',
			'edit_private_pages',
			'edit_private_posts',
			'edit_published_pages',
			'edit_published_posts',
			'edit_theme_options',
			'export',
			'import',
			'list_users',
			'manage_categories',
			'manage_links',
			'manage_options',
			'moderate_comments',
			'promote_users',
			'publish_pages',
			'publish_posts',
			'read_private_pages',
			'read_private_posts',
			'read',
			'remove_users',
			'switch_themes',
			'upload_files',
			'customize',
			'delete_site',
			'update_core',
			'update_plugins',
			'update_themes',
			'install_plugins',
			'install_themes',
			'delete_themes',
			'delete_plugins',
			'edit_plugins',
			'edit_themes',
			'edit_files',
			'edit_users',
			'add_users',
			'create_users',
			'delete_users',
			'unfiltered_html',
			'unfiltered_upload',
			'level_10',
			'level_9',
			'level_8',
			'level_7',
			'level_6',
			'level_5',
			'level_4',
			'level_3',
			'level_2',
			'level_1',
			'level_0',
		);

		// https://paulund.co.uk/get-database-table-prefix-in-wordpress
		global $wpdb;
		$table_prefix = $wpdb->prefix;

		$user_roles_option_name = $table_prefix . 'user_roles';

		$roles_capabilities = get_option( $user_roles_option_name );

		$default_roles = array();
		$custom_roles = array();
		
		$output = $this->sd_html( 'accordions-start' );

		foreach ( $roles_capabilities as $roleslug => $role_properties ) {

			$role_default_capabilities = array();
			$role_custom_capabilities = array();
			$role_default_caps_string = '';
			$role_custom_caps_string = '';

			if ( in_array( $roleslug, $default_wp_roles ) ) {

				// $output .= $roleslug . ' is default.<br />';
				$role_type = 'Defaul role';
				$default_roles[] = $roleslug;

			} else {

				// $output .= $roleslug . ' is custom.<br />';
				$role_type = 'Custom role';
				$custom_roles[] = $roleslug;

			}

			// foreach( $properties as $property_name => $property_value ) {

			// }

			$caps_output = '';

			$role_title = $role_properties['name'] . ' (' . $roleslug . ') - ' . $role_type;

			foreach ( $role_properties['capabilities'] as $capability => $enabled ) {

				if ( in_array( $capability, $default_capabilities ) ) {

					$role_default_capabilities[] = $capability;

					$role_default_caps_string .= $capability . '<br />';


				} else {

					$role_custom_capabilities[] = $capability;

					$role_custom_caps_string .= $capability . '<br />';
				}

			}

			// if ( $property_name == 'name' ) {

			// }

			// if ( $property_name == 'capabilities' ) {

			// }

			if ( $return = 'all' ) {

				$output .= $this->sd_html( 'accordion-head', $role_title );

				$caps_output .= $this->sd_html( 'field-content-start', 'plain-content' );
				$caps_output .= $this->sd_html( 'field-content-first', '<div class="field-part-title"><strong>Default capabilities:</strong></div>
								<div class="field-part-content">' . $role_default_caps_string . '</div>' );
				$caps_output .= $this->sd_html( 'field-content-second', '<div class="field-part-title"><strong>Custom capabilities:</strong></div>
								<div class="field-part-content">' . $role_custom_caps_string . '</div>' );
				$caps_output .= $this->sd_html( 'field-content-end' );


				$output .= $this->sd_html( 'accordion-body', $caps_output );

			} elseif ( $return = 'default_roles' ) {

				$output .= '<pre>' . $default_roles . '</pre>';

			} elseif ( $return = 'custom_roles' ) {

				$output .= '<pre>' . $custom_roles . '</pre>';

			}

		}

		$output .= $this->sd_html( 'accordions-end' );

		return $output;

	}

	/** 
	 * Get media/attachments info by MIME type 
	 * 
	 * @link https://plugins.trac.wordpress.org/browser/cl-wp-info/trunk/class-cl-wp-info.php 
	 * @since 1.0.0
	 */
	public function sd_get_user_count_by_role( $type ) {

		$users = count_users();
		$output = '';

		if ( $type == 'total' ) {

			$output .= '<div class="field-info-line full-width">' . $users['total_users'] .' users</div>';

			return $output;

		} elseif ( $type == 'by_role' ) {

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', 'All roles' );
			$output .= $this->sd_html( 'field-content-second', $users['total_users'] .' users' );
			$output .= $this->sd_html( 'field-content-end' );

			foreach ( $users['avail_roles'] as $role => $count ) {
				if ( !empty( $count ) ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', $role );
					$output .= $this->sd_html( 'field-content-second', $count .' users' );
					$output .= $this->sd_html( 'field-content-end' );

				}
			}

			// $output .= '<pre>' . print_r( $users['avail_roles'], true ) . '</pre>';

			return $output;

		}

	}

	/**
	 * Get list of all defined custom fields
	 * 
	 * @link https://css-tricks.com/snippets/wordpress/dump-all-custom-fields/
	 * @since 1.0.0
	 */	
	public function sd_get_all_custom_fields( $type = 'public' ) {

		global $wpdb;

		$query = "
	        SELECT DISTINCT($wpdb->postmeta.meta_key) 
	        FROM $wpdb->postmeta;
	    ";

	    $results = $wpdb->get_results($query);

	    $meta_keys = array();

		if ( is_array( $results ) ) {

			foreach( $results as $result ) {

			    $result = json_decode( json_encode( $result ), true ); // convert stdClass to array

			    $meta_keys[] = $result['meta_key'];

			}

		}

		$output = '';
		$private_custom_fields = array();
		$public_custom_fields = array();
		$private_custom_fields_count = 0;
		$public_custom_fields_count = 0;

		foreach ( $meta_keys as $meta_key ) {

			// https://www.php.net/manual/en/function.substr.php Example #3
			if ( $meta_key[0] == '_' ) {

				$private_custom_fields[] = $meta_key;
				sort( $private_custom_fields );

				$private_custom_fields_count++;

			} else {

				$public_custom_fields[] = $meta_key;
				sort( $public_custom_fields );

				$public_custom_fields_count++;

			}

		}

		if ( $type == 'public' ) {

			foreach( $public_custom_fields as $public_custom_field ) {

				$output .= $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', $public_custom_field, 'full-width' );
				$output .= $this->sd_html( 'field-content-end' );

			}

		} elseif ( $type == 'private' ) {

			foreach( $private_custom_fields as $private_custom_field ) {

				$output .= $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', $private_custom_field, 'field-full-width' );
				$output .= $this->sd_html( 'field-content-end' );

			}

		} elseif ( $type == 'public-count' ) {

			$output = $public_custom_fields_count;

		} elseif ( $type == 'private-count' ) {

			$output = $private_custom_fields_count;

		} else {}

		// return '<pre>' . print_r( $private_custom_fields, true ) . '</pre>';
		return $output;

	}

	/** 
	 * Check if shell_exec PHP function is enabled
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function is_shell_exec_enabled() {

		/*Check if shell_exec() is enabled on this server*/
		if (function_exists('shell_exec') && !in_array('shell_exec', array_map('trim', explode(', ', ini_get('disable_functions'))))) {

	    	/*If enabled, check if shell_exec() actually have execution power*/
			$returnVal = shell_exec('pwd');

			if (!empty($returnVal)) {
				return true;
			} else {
				return false;
			}

		} else {

			return false;

		}

	}

	/** 
	 * Check if exec PHP function is enabled
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function is_exec_enabled() {

		/*Check if exec() is enabled on this server*/
		if (function_exists('exec') && !in_array('exec', array_map('trim', explode(', ', ini_get('disable_functions'))))) {

	    	/*If enabled, check if exec() actually have execution power*/
			$returnVal = exec('pwd');

			if (!empty($returnVal)) {
				return true;
			} else {
				return false;
			}

		} else {

			return false;

		}

	}

	/**
	 * Format file size originally in bytes
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_format_filesize($bytes)	{

		if (($bytes / pow(1024, 5)) > 1) {
			return number_format_i18n(($bytes / pow(1024, 5)), 0) . ' ' . __('PB', 'wp-server-stats');
		} elseif (($bytes / pow(1024, 4)) > 1) {
			return number_format_i18n(($bytes / pow(1024, 4)), 0) . ' ' . __('TB', 'wp-server-stats');
		} elseif (($bytes / pow(1024, 3)) > 1) {
			return number_format_i18n(($bytes / pow(1024, 3)), 0) . ' ' . __('GB', 'wp-server-stats');
		} elseif (($bytes / pow(1024, 2)) > 1) {
			return number_format_i18n(($bytes / pow(1024, 2)), 0) . ' ' . __('MB', 'wp-server-stats');
		} elseif ($bytes / 1024 > 1) {
			return number_format_i18n($bytes / 1024, 0) . ' ' . __('KB', 'wp-server-stats');
		} elseif ($bytes >= 0) {
			return number_format_i18n($bytes, 0) . ' ' . __('bytes', 'wp-server-stats');
		} else {
			return __('Unknown', 'wp-server-stats');
		}
	}

	/**
	 * Format file size originally in kilobytes (kB)
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_format_filesize_kB( $kiloBytes ) {
		if (($kiloBytes / pow(1024, 4)) > 1) {
			return number_format_i18n(($kiloBytes / pow(1024, 4)), 0) . ' PB';
		} elseif (($kiloBytes / pow(1024, 3)) > 1) {
			return number_format_i18n(($kiloBytes / pow(1024, 3)), 0) . ' TB';
		} elseif (($kiloBytes / pow(1024, 2)) > 1) {
			return number_format_i18n(($kiloBytes / pow(1024, 2)), 0) . ' GB';
		} elseif (($kiloBytes / 1024) > 1) {
			return number_format_i18n($kiloBytes / 1024, 0) . ' MB';
		} elseif ($kiloBytes >= 0) {
			return number_format_i18n($kiloBytes / 1, 0) . ' KB';
		} else {
			return 'Unknown';
		}
	}

	/**
	 * Get server uptime
	 *
	 * @since 1.0.0
	 */
	public function sd_server_uptime() {

		if ($this->is_shell_exec_enabled()) {

			$uptime = trim(shell_exec("cut -d. -f1 /proc/uptime"));
			$uptime = number_format_i18n($uptime / 60 / 60 / 24). ' days';

		} else {

			$uptime = 'Undetectable. Please enable \'shell_exec\' function in PHP first.';

		}

		return $uptime;

	}

	/** 
	 * Get server OS info 
	 * 
	 * @link https://www.cyberciti.biz/faq/find-linux-distribution-name-version-number/
	 * @since 1.0.0 
	 */
	public function sd_os_info() {

		if ( $this->is_shell_exec_enabled() ) {

			$os = shell_exec( 'lsb_release -a' );
			$os = str_replace( "Description", " | Description", $os );
			$os = str_replace( "Release", " | Release", $os );
			$os = str_replace( "Codename", " | Codename", $os );
			$os_array = explode(" | ", $os);
			$os = $os_array[1];
			$os = str_replace( ":", "", $os );
			$os = str_replace( "Description", "", $os );

			if ( empty( $os ) ) {
				$os = 'Undetectable';
			}

		} else {

			$os = php_uname( 's' ) .' | '. php_uname( 'r' ) .' | '. php_uname( 'v' );

		}

		return $os;

	}

	/**
	 * Get server location
	 * 
	 * @link https://plugins.trac.wordpress.org/browser/server-info-wp/trunk/init.php
	 * @since 1.2.0
	 */
	public function sd_server_location() {

		if ( function_exists( 'file_get_contents' ) && isset( $_SERVER['SERVER_ADDR'] ) ) {

			$location_data = get_transient('sd_server_location');

			if ($location_data === false) {

				$location_data = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['SERVER_ADDR'] ) );

				set_transient('sd_server_location', $location_data, WEEK_IN_SECONDS);

			}

			$location = $location_data['geoplugin_city'].', '.$location_data['geoplugin_countryName'];

		} else {

			$location = 'Undetectable';

		}

		return $location;

	}

	/**
	 * Get server CPU Type
	 *
	 * @since 1.0.0
	 */
	public function sd_cpu_type() {

		if ($this->is_shell_exec_enabled()) {

			$sd_cpu_type = get_transient('sd_cpu_type');

			if ($sd_cpu_type === false) {

				$sd_cpu_type = shell_exec( 'grep "model name" /proc/cpuinfo | uniq' );
				$sd_cpu_type = str_replace( ":", "", $sd_cpu_type );
				$sd_cpu_type = str_replace( "model name", "", $sd_cpu_type );
				$sd_cpu_type = trim( $sd_cpu_type );

				set_transient('sd_cpu_type', $sd_cpu_type, WEEK_IN_SECONDS);

			}

		} else {

			$sd_cpu_type = 'Undetectable. Please enable \'shell_exec\' function in PHP first.';

		}

		return $sd_cpu_type;

	}

	/**
	 * Get server CPU count
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_cpu_count() {

				$cpu_count = get_transient('sd_cpu_count');

				if ($cpu_count === false) {

					if ($this->is_shell_exec_enabled()) {

						$cpu_count = shell_exec('cat /proc/cpuinfo |grep "physical id" | sort | uniq | wc -l');

						set_transient('sd_cpu_count', $cpu_count, WEEK_IN_SECONDS);

					} else {

						$cpu_count = 'Undetectable';

					}
				}

				return $cpu_count;
			}

	/**
	 * Get server CPU core count
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_cpu_core_count() {

		$cpu_core_count = get_transient('sd_cpu_core_count');

		if ($cpu_core_count === false) {

			if ($this->is_shell_exec_enabled()) {

				$cpu_core_count = shell_exec("echo \"$((`cat /proc/cpuinfo | grep cores | grep -o -E '[0-9]+' | uniq` * `cat /proc/cpuinfo |grep 'physical id' | sort | uniq | wc -l`))\"");

				set_transient('sd_cpu_core_count', $cpu_core_count, WEEK_IN_SECONDS);

			} else {

				$cpu_core_count =  'Undetectable';

			}

		}

		return $cpu_core_count;
	}

	/**
	 * Get server CPU load average across all CPU cores
	 * 
	 * @link https://www.site24x7.com/blog/load-average-what-is-it-and-whats-the-best-load-average-for-your-linux-servers
	 * @since 1.0.0
	 */
	public function sd_cpu_load_average() {

		if ( $this->is_shell_exec_enabled() ) {

			$cpu_core_count = $this->sd_cpu_core_count();
			if ( !is_numeric( $cpu_core_count ) ) {
				$cpu_core_count = 1;
			}

			$cpu_load_average = shell_exec("uptime");
			$cpu_load_average_array = explode( ", ", $cpu_load_average );

			$last_1minute = (float)trim( array_pop( $cpu_load_average_array ) );

			if ( is_numeric( $last_1minute ) ) {

				$last_1minutes_pct_num = ( $last_1minute / $cpu_core_count ) * 100;
				$last_1minutes_pct_num_rounded = round( $last_1minutes_pct_num, 0 );
				$last_1minutes_pct = $last_1minutes_pct_num_rounded .'%';

			} else {

				$last_1minutes_pct = 'N/A';

			}

			$last_5minutes = (float)trim( array_pop( $cpu_load_average_array ) );

			if ( is_numeric( $last_5minutes ) ) {

				$last_5minutes_pct_num = ( $last_5minutes / $cpu_core_count ) * 100;
				$last_5minutes_pct_num_rounded = round( $last_5minutes_pct_num, 0 );
				$last_5minutes_pct = $last_5minutes_pct_num_rounded .'%';

			} else {

				$last_5minutes_pct = 'N/A';

			}

			$last_15minutes = array_pop( $cpu_load_average_array );
			$last_15minutes = str_replace(":", "", $last_15minutes);
			$last_15minutes = (float)trim( str_replace("load average", "", $last_15minutes) );

			if ( is_numeric( $last_15minutes ) ) {

				$last_15minutes_pct_num = ( $last_15minutes / $cpu_core_count ) * 100;
				$last_15minutes_pct_num_rounded = round( $last_15minutes_pct_num, 0 );
				$last_15minutes_pct = $last_15minutes_pct_num_rounded .'%';

			} else {

				$last_15minutes_pct = 'N/A';

			}

			$cpu_load_average = 'Last 15 minutes: '. $last_15minutes_pct .'<br /> Last 5 minutes: '. $last_5minutes_pct .'<br /> Last 1 minute: '. $last_1minutes_pct;

		} else {

			$cpu_load_average = 'Undetectable. Please enable \'shell_exec\' function in PHP first.';

		}

		return $cpu_load_average;
	}


	/**
	 * Get server total RAM
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_total_ram()	{

		if ($this->is_shell_exec_enabled()) {

			$total_ram = get_transient('sd_total_ram');

			if ($total_ram === false) {

				$total_ram = shell_exec("grep -w 'MemTotal' /proc/meminfo | grep -o -E '[0-9]+'");

				set_transient('sd_total_ram', $total_ram, WEEK_IN_SECONDS);

			}

		} else {

			$total_ram = 'Undetectable';

		}

		return trim($total_ram);
	}

	/**
	 * Get server RAM cache
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_ram_cache() {

		if ($this->is_shell_exec_enabled()) {

			$ram_cache = shell_exec("grep -w 'Cached' /proc/meminfo | grep -o -E '[0-9]+'");

		} else {

			$ram_cache= 'Undetectable';

		}

		return trim($ram_cache);
	}

	/**
	 * Get server RAM buffer
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_ram_buffer() {

		if ($this->is_shell_exec_enabled()) {

			$ram_buffer = shell_exec("grep -w 'Buffers' /proc/meminfo | grep -o -E '[0-9]+'");

		} else {

			$ram_buffer= 'Undetectable';

		}

		return trim($ram_buffer);
	}

	/**
	 * Get server free RAM
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_free_ram()
	{
		if ($this->is_shell_exec_enabled()) {

			$free_ram = shell_exec("grep -w 'MemFree' /proc/meminfo | grep -o -E '[0-9]+'");

			if ( ( $this->sd_ram_cache() != 'Undetectable' ) && ( $this->sd_ram_buffer() != 'Undetectable' ) ) {

				if( !is_null( $this->sd_ram_cache() ) || !is_null( $this->sd_ram_buffer() ) ) {
					$ram_cache = is_null( $this->sd_ram_cache() ) ? 0 : (int) $this->sd_ram_cache();
					$ram_buffer = is_null( $this->sd_ram_buffer() ) ? 0 : (int) $this->sd_ram_buffer();
					$free_ram_final = (int) $free_ram + $ram_cache + $ram_buffer;
				} else {
					$free_ram_final = $free_ram;
				}

			} else {

				$free_ram_final = 'Undetectable';

			}

		} else {

			$free_ram_final = 'Undetectable';

		}

		return trim($free_ram_final);
	}

	/**
	 * Get server used RAM
	 *
	 * @since 1.0.0
	 */
	public function sd_used_ram() {

		if ($this->is_shell_exec_enabled()) {

			$free_ram = $this->sd_free_ram();
			$total_ram = $this->sd_total_ram();

			if ( ( $free_ram != 'Undetectable' ) && ( $total_ram != 'Undetectable' ) ) {

				$used_ram = $this->sd_format_filesize_kB( $total_ram - $free_ram ) .' ('. round( ( ( ( $total_ram - $free_ram ) / $total_ram ) * 100 ), 0).'%)';

			} else {

				$used_ram = 'Undetectable';

			}		

		} else {

			$used_ram = 'Undetectable';

		}

		return $used_ram;

	}

	/**
	 * Return RAM usage
	 *
	 * @since 2.0.2
	 */
	public function sd_ram_usage() {

		$used_ram = $this->sd_used_ram();
		$total_ram = $this->sd_total_ram();

		if ( ( $used_ram != 'Undetectable' ) && ( $total_ram != 'Undetectable' ) ) {

			return $used_ram .' used of '. $this->sd_format_filesize_kB( $total_ram ) .' total';

		} else {

			return 'Undetectable. Please enable \'shell_exec\' function in PHP first.';

		}

	}

	/**
	 * Return total RAM for display
	 *
	 * @since 2.0.2
	 */
	public function sd_total_ram_display() {

		$total_ram = $this->sd_total_ram();

		if ( $total_ram == 'Undetectable' ) {

			return 'Undetectable. Please enable \'shell_exec\' function in PHP first.';

		} else {

			return $this->sd_format_filesize_kB( $total_ram );

		}

	}

	/**
	 * Get server free disk space
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-disk-free/tags/0.2.3/wp-disk-free.php
	 * @since 1.0.0
	*/
	public function sd_free_disk_space() {

		if ( function_exists( 'disk_free_space' ) ) {

			$free_disk_space = disk_free_space( dirname(__FILE__) );

		} else {

			$free_disk_space = 'Undetectable';

		}

		return $free_disk_space;

	}

	/**
	 * Get server total disk space
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-disk-free/tags/0.2.3/wp-disk-free.php
	 * @since 1.0.0
	 */
	public function sd_total_disk_space() {

		if ( function_exists( 'disk_total_space' ) ) {

			$total_disk_space = get_transient('sd_total_disk_space');

			if ($total_disk_space === false) {

					$total_disk_space = disk_total_space( dirname(__FILE__) );

					set_transient('sd_total_disk_space', $total_disk_space, WEEK_IN_SECONDS);

			}

		} else {

			$total_disk_space = 'Undetectable';

		}

		return $total_disk_space;

	}

	/**
	 * Get disk usage stats
	 *
	 * @since 2.0.2
	 */
	public function sd_disk_usage() {

		$free_disk_space = $this->sd_free_disk_space();
		$total_disk_space = $this->sd_total_disk_space();
		$used_disk_space = $total_disk_space - $free_disk_space;

		if ( ( $free_disk_space != 'Undetectable' ) && ( $total_disk_space != 'Undetectable' ) ) {

			return $this->sd_format_filesize( $used_disk_space ) . ' used (' . round ( ( ( $used_disk_space / $total_disk_space ) * 100 ), 0 ) . '%) of ' . $this->sd_format_filesize( $total_disk_space ) . ' total';

		} else {

			return 'Undetectable';

		}

	}

	/**
	 * Get PHP detail specifications (via AJAX call)
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_php_info() {

		if ( isset( $_REQUEST ) ) {


			if ( !class_exists( 'DOMDocument' ) ) {
				return 'Please enable DOMDocument extension first.';
			} else {

				ob_start();
				phpinfo();
				$phpinfo = ob_get_contents();
				ob_end_clean();

			    // Use DOMDocument to parse phpinfo()
				libxml_use_internal_errors(true);
				$html = new DOMDocument('1.0', 'UTF-8');
				$html->loadHTML($phpinfo);

			    // Style process
				$tables = $html->getElementsByTagName('table');
				foreach ($tables as $table) {
					$table->setAttribute('class', 'widefat'); // use WP default styles
				}

			    // We only need the <body>
				$xpath = new DOMXPath($html);
				$body = $xpath->query('/html/body');

			    // Save HTML fragment
				libxml_use_internal_errors(false);
				$phpinfo_html = $html->saveXml($body->item(0));

				echo $phpinfo_html;

			}

		}

	}

	/**
	 * Get error reporting levels
	 *
	 * @link https://plugins.svn.wordpress.org/query-monitor/tags/3.8.2/collectors/environment.php
	 * @since 1.6.0
	 */
	public function sd_error_reporting() {

		$error_reporting = error_reporting();

		$levels = array(
			'E_ERROR' => false,
			'E_WARNING' => false,
			'E_PARSE' => false,
			'E_NOTICE' => false,
			'E_CORE_ERROR' => false,
			'E_CORE_WARNING' => false,
			'E_COMPILE_ERROR' => false,
			'E_COMPILE_WARNING' => false,
			'E_USER_ERROR' => false,
			'E_USER_WARNING' => false,
			'E_USER_NOTICE' => false,
			'E_STRICT' => false,
			'E_RECOVERABLE_ERROR' => false,
			'E_DEPRECATED' => false,
			'E_USER_DEPRECATED' => false,
			'E_ALL' => false,
		);

		foreach ( $levels as $level => $reported ) {
			if ( defined( $level ) ) {
				$c = constant( $level );
				if ( $error_reporting & $c ) {
					$levels[ $level ] = true;
				}
			}
		}

		$output = '';
		$error_types = '';

		$output .= $this->sd_html( 'accordions-start-simple' );
		$output .= $this->sd_html( 'accordion-head', 'View Details' );

		foreach ( $levels as $type => $status ) {

			if ( $status ) {
				$symbol = '<div class="sd__symbol sd__symbol--green">&check;</div>';
			} else {
				$symbol = '<div class="sd__symbol sd__symbol--red">&cross;</div>';				
			}

			$error_types .= $this->sd_html( 'field-content-start' );
			$error_types .= $this->sd_html( 'field-content-first', $type );
			$error_types .= $this->sd_html( 'field-content-second', $symbol );
			$error_types .= $this->sd_html( 'field-content-end' );

		}

		$output .= $this->sd_html( 'accordion-body', $error_types );
		$output .= $this->sd_html( 'accordions-end' );

		return $output;

	}

	/**
	 * Get directory size (including all sub-directories and files)
	 * 
	 * @link https://plugins.svn.wordpress.org/ressources/trunk/ressources.php
	 * @link https://explainshell.com/explain?cmd=du+-h+--max-depth%3D1
	 * @since 1.0.0
	 */
	public function sd_dir_size( $path ) {

		if ($this->is_exec_enabled()) {

			// Uses CLI command 'du'. More accurate.
			exec('du -h --max-depth=1 ' . $path, $result);
			$dir_size = explode("\t", array_pop($result)); // list of directories sizes
			$dir_size = $dir_size[0].'B'; // only get the size of $path (last one)
			$dir_size = str_replace("MB", " MB", $dir_size);
			$dir_size = str_replace("GB", " GB", $dir_size);

		} else {

			// Use WordPress native function. Less accurate.
			$dir_size = size_format ( get_dirsize( $path ) );

		}

		return $dir_size;

	}

	/**
	 * Get WP directory sizes
	 *
	 * @since 2.0.0
	 */
	public function sd_wp_dir_sizes() {

		$output = '';

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'All directories and files' );
		$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( str_replace( "/wp-content", "", WP_CONTENT_DIR ) ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'wp-admin directory' );
		$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( ABSPATH . '/wp-admin' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'wp-includes directory' );
		$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( ABSPATH . '/wp-includes' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'wp-content directory' );
		$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( WP_CONTENT_DIR ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'Uploads directory' );
		$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( WP_CONTENT_DIR.'/uploads' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'Plugins directory' );
		$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( WP_CONTENT_DIR.'/plugins' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'Themes directory' );
		$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( WP_CONTENT_DIR.'/themes' ) );
		$output .= $this->sd_html( 'field-content-end' );

		return $output;

	}

	/**
	 * Get filesystem permission status
	 *
	 * @link wp-admin/includes/class-wp-debug-data.php
	 * @since 1.0.0
	 */
	public function sd_filesystem_permissions() {

		$output = '';

		if ( wp_is_writable( ABSPATH ) ) {
			$is_writable_abspath = 'Writeable';
		} else {
			$is_writable_abspath = 'Not writeable';			
		}

		if ( wp_is_writable( WP_CONTENT_DIR ) ) {
			$is_writable_wp_content_dir = 'Writeable';
		} else {
			$is_writable_wp_content_dir = 'Not writeable';			
		}

		if ( wp_is_writable( wp_upload_dir()['basedir'] ) ) {
			$is_writable_upload_dir = 'Writeable';
		} else {
			$is_writable_upload_dir = 'Not writeable';			
		}

		if ( wp_is_writable( WP_PLUGIN_DIR ) ) {
			$is_writable_wp_plugin_dir = 'Writeable';
		} else {
			$is_writable_wp_plugin_dir = 'Not writeable';			
		}

		if ( wp_is_writable( get_theme_root( get_template() ) ) ) {
			$is_writable_template_directory = 'Writeable';
		} else {
			$is_writable_template_directory = 'Not writeable';			
		}

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'The main WordPress directory' );
		$output .= $this->sd_html( 'field-content-second', $is_writable_abspath );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'The wp-content directory' );
		$output .= $this->sd_html( 'field-content-second', $is_writable_wp_content_dir );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'The uploads directory' );
		$output .= $this->sd_html( 'field-content-second', $is_writable_upload_dir );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'The plugins directory' );
		$output .= $this->sd_html( 'field-content-second', $is_writable_wp_plugin_dir );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'The themes directory' );
		$output .= $this->sd_html( 'field-content-second', $is_writable_template_directory );
		$output .= $this->sd_html( 'field-content-end' );

		return $output;

	}

	/**
	 * File and URL viewer
	 *
	 * @param string $filename
	 * @since 1.5.0
	 */
	public function sd_viewer() {

		if ( isset( $_REQUEST ) ) {

			$filename = $_REQUEST['filename'];

			$file_path = ABSPATH . $filename;
				
			if ( !file_exists( $file_path ) ) {

				if ( $filename == 'robots.txt' ) {

					$response = wp_remote_get( get_site_url() . '/' . $filename );

					$file_content = nl2br( trim( wp_remote_retrieve_body( $response ) ) );

					$output = $file_content;

				} else {

					$output = $file_path . ' does not exist';

				}

			} else {

				$file_content = nl2br( trim( file_get_contents( $file_path, true ) ) );

				$output = $file_content;

			}

			echo $output;

		}

	}

	/**
	 * Get WP REST API main response
	 *
	 * @since 2.0.0
	 */
	public function sd_wp_rest_api() {

		if ( isset( $_REQUEST ) ) {

			$response = wp_remote_get( get_site_url() . '/wp-json/wp/v2' );

			echo trim( wp_remote_retrieve_body( $response ) );

		}

	}

	/**
	 * Add default WP sitemap URL to robots.txt if site is set to public / crawlable, i.e. blog_public option equals 1
	 *
	 * @link wp-includes/sitemaps/class-wp-sitemaps.php
	 * @link wp-includes/sitemaps/class-wp-sitemaps-index.php
	 * @since 1.5.2
	 */
	public function sd_robots_sitemap( $output, $public ) {

		global $wp_rewrite;

		if ( ! $wp_rewrite->using_permalinks() ) {
			$sitemap_url = home_url( '/?sitemap=index' );
		}

		$sitemap_url = home_url( '/wp-sitemap.xml' );

		if ( $public ) {
			$output .= "\nSitemap: " . esc_url( $sitemap_url ) . "\n";
		}

		return $output;

	}

	/**
	 * Get database disk usage
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	*/
	public function sd_db_disk_usage( $type = 'data' )
	{

		$db_disk_usage = get_transient('sd_db_disk_usage');

		if ($db_disk_usage === false) {

			global $wpdb;
			$db_data_disk_usage = 0;
			$db_index_disk_usage = 0;
			$tablesstatus = $wpdb->get_results("SHOW TABLE STATUS");

			foreach ($tablesstatus as $tablestatus) {
				$db_data_disk_usage += $tablestatus->Data_length;
				$db_index_disk_usage += $tablestatus->Index_length;
			}

			$db_data_disk_usage = $this->sd_format_filesize($db_data_disk_usage);
			$db_index_disk_usage = $this->sd_format_filesize($db_index_disk_usage);

			$db_disk_usage = array( 
				'data' => $db_data_disk_usage, 
				'index' => $db_index_disk_usage,
			);

			set_transient('sd_db_disk_usage', $db_disk_usage, DAY_IN_SECONDS);

		}

		return $db_disk_usage[$type];
	}

	/**
	 * List DB tables
	 * 
	 * @link https://plugins.svn.wordpress.org/wptools/tags/3.13/functions/functions.php
	 * @since 1.0.0
	 */
	public function sd_db_tables() {

		global $wpdb;

		$prefix = $wpdb->prefix;
		$tables = $wpdb->get_results("SHOW TABLE STATUS");

		$output = $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<strong>Table Name</strong>' );
		$output .= $this->sd_html( 'field-content-second', '<strong>Size</strong>' );
		$output .= $this->sd_html( 'field-content-end' );

		foreach( $tables as $table ) {

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', $table->Name, 'long-value' );
			$output .= $this->sd_html( 'field-content-second', $this->sd_format_filesize( $table->Data_length ) );
			$output .= $this->sd_html( 'field-content-end' );

		}

		echo $output;

	}

	/** 
	 * Get database uptime
	 *
	 * @since 1.0.0
	 */
	public function sd_db_uptime() {

		global $wpdb;

		$db_uptime_query = $wpdb->get_results("SHOW GLOBAL STATUS LIKE 'Uptime'");

		if ( isset( $db_uptime_query[0]->Value ) ) {
			$db_uptime = $db_uptime_query[0]->Value;
			$dtf = new \DateTime('@0');
			$dtt = new \DateTime("@$db_uptime");
			// $db_uptime_formatted = $dtf->diff($dtt)->format('%a days, %h hours, %i minutes and %s seconds');
			$db_uptime_formatted = $dtf->diff($dtt)->format('%a days');
		}

		return $db_uptime_formatted;

	}

	/**
	 * Get database client info
	 *
	 * @link wp-admin/includes/class-wp-debug-data.php
	 * @since 1.0.0
	 */
	public function sd_db_client( $type = 'info' ) {

		global $wpdb;

		if ( is_resource( $wpdb->dbh ) ) {
			// Old mysql extension.
			$extension = 'mysql';
		} elseif ( is_object( $wpdb->dbh ) ) {
			// mysqli or PDO.
			$extension = get_class( $wpdb->dbh );
		} else {
			// Unknown sql extension.
			$extension = null;
		}

		if ( isset( $wpdb->use_mysqli ) && $wpdb->use_mysqli ) {
			$client_version = $wpdb->dbh->client_info;
		} else {

			if ( is_callable( 'mysql_get_client_info' ) ) {

				// phpcs:ignore WordPress.DB.RestrictedFunctions.mysql_mysql_get_client_info,PHPCompatibility.Extensions.RemovedExtensions.mysql_DeprecatedRemoved
				if ( preg_match( '|[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2}|', mysql_get_client_info(), $matches ) ) {
					$client_version = $matches[0];
				} else {
					$client_version = null;
				}

			} else {

				$client_version = 'Undetectable';

			}

		}

		if ( $type == 'extension' ) {

			return $extension;

		} elseif ( $type == 'client_version' ) {

			return $client_version;

		} else {}

	}

	/**
	 * Get database key specifications
	 * 
	 * @link https://plugins.svn.wordpress.org/wptools/tags/3.13/functions/functions.php
	 * @since 1.0.0
	 */
	public function sd_db_specs() {

		global $wpdb;

		$default_storage_engine_query = $wpdb->get_row("SHOW VARIABLES LIKE 'default_storage_engine'");
		$default_storage_engine = $default_storage_engine_query->Value;

		$innodb_buffer_pool_size_query = $wpdb->get_row("SHOW VARIABLES LIKE 'innodb_buffer_pool_size'");
		$innodb_buffer_pool_size = $this->sd_format_filesize( $innodb_buffer_pool_size_query->Value );

		$key_buffer_size_query = $wpdb->get_row("SHOW VARIABLES LIKE 'key_buffer_size'");
		$key_buffer_size = $this->sd_format_filesize( $key_buffer_size_query->Value );

		$max_allowed_packet_query = $wpdb->get_row("SHOW VARIABLES LIKE 'max_allowed_packet'");
		$max_allowed_packet = $this->sd_format_filesize( $max_allowed_packet_query->Value );

		$max_connection_query = $wpdb->get_row("SHOW VARIABLES LIKE 'max_connections'");
		$max_connection = number_format_i18n( $max_connection_query->Value );

		$query_cache_limit_query = $wpdb->get_row("SHOW VARIABLES LIKE 'query_cache_limit'");
		$query_cache_limit = $this->sd_format_filesize( $query_cache_limit_query->Value );

		$query_cache_size_query = $wpdb->get_row("SHOW VARIABLES LIKE 'query_cache_size'");
		$query_cache_size = $this->sd_format_filesize( $query_cache_size_query->Value );

		$query_cache_type_query = $wpdb->get_row("SHOW VARIABLES LIKE 'query_cache_type'");
		$query_cache_type = $query_cache_type_query->Value;

		$db_specs = array(
			array(
				'name'					=> 'Extension',
				'value'					=> $this->sd_db_client( 'extension' ),
			),
			array(
				'name'					=> 'Client Version',
				'value'					=> $this->sd_db_client( 'client_version' ),
			),
			array(
				'name'					=> 'Engine',
				'value'					=> $default_storage_engine,
			),
			array(
				'name'					=> 'Host',
				'value'					=> DB_HOST,
			),
			array(
				'name'					=> 'Name',
				'value'					=> DB_NAME,
			),
			array(
				'name'					=> 'User',
				'value'					=> DB_USER,
			),
			array(
				'name'					=> 'innodb_buffer_pool_size',
				'value'					=> $innodb_buffer_pool_size,
			),
			array(
				'name'					=> 'key_buffer_size',
				'value'					=> $key_buffer_size,
			),
			array(
				'name'					=> 'max_allowed_packet',
				'value'					=> $max_allowed_packet,
			),
			array(
				'name'					=> 'max_connections',
				'value'					=> $max_connection,
			),
			array(
				'name'					=> 'query_cache_limit',
				'value'					=> $query_cache_limit,
			),
			array(
				'name'					=> 'query_cache_size',
				'value'					=> $query_cache_size,
			),
			array(
				'name'					=> 'query_cache_type',
				'value'					=> $query_cache_type,
			),
		);

		$output = '';

		foreach ( $db_specs as $spec ) {

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', $spec['name'] );
			$output .= $this->sd_html( 'field-content-second', $spec['value'] );
			$output .= $this->sd_html( 'field-content-end' );

		}

		echo $output;

	}

	/** 
	 * Get database technical details
	 * 
	 * @link https://plugins.svn.wordpress.org/wptools/tags/3.13/functions/functions.php
	 * @since 1.0.0
	 */
	public function sd_db_details() {

		if ( isset( $_REQUEST ) ) {

			global $wpdb;
			$dbinfo = $wpdb->get_results("SHOW VARIABLES");

			$output = '';

			if ( !empty( $dbinfo ) ) {

				foreach( $dbinfo as $info ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', $info->Variable_name );
					$output .= $this->sd_html( 'field-content-second', $info->Value );
					$output .= $this->sd_html( 'field-content-end' );

				}

			} else {

				$output .= 'Undetectable';

			}

			echo $output;

		}

	}

	/**
	 * Display cron jobs
	 * 
	 * @link https://plugins.svn.wordpress.org/wptools/tags/3.13/functions/functions_cron_manager.php
	 * @link https://plugins.svn.wordpress.org/debug-bar-cron/tags/0.1.3/class-debug-bar-cron.php
	 * @since 1.0.0
	 */
	public function sd_cron_events( $type = 'wpcore', $return = 'events' ) {

		$wpcore_cron_hooks = array(
			'wp_scheduled_delete',
			'wp_scheduled_auto_draft_delete',
			'upgrader_scheduled_cleanup',
			'importer_scheduled_cleanup',
			'publish_future_post',
			'do_pings',
			'wp_version_check',
			'wp_update_plugins',
			'wp_update_themes',
			'wp_privacy_delete_old_export_files',
			'wp_site_health_scheduled_check',
		);

		$crons = _get_cron_array();

		$wpcore_crons = '';
		$custom_crons = '';
		$wpcore_crons_count = 0;
		$custom_crons_count = 0;

		$header = $this->sd_html( 'field-content-start' );
		$header .= $this->sd_html( 'field-content-first', '<strong>Hook</strong>' );
		$header .= $this->sd_html( 'field-content-second', '<strong>Recurrence</strong>' );
		$header .= $this->sd_html( 'field-content-end' );

		$wpcore_crons .= $header;
		$custom_crons .= $header;

		foreach ( $crons as $cron ) {

			foreach( $cron as $c ) {

				$schedule_array = array_column($c, 'schedule');

				if ( !empty( trim( $schedule_array[0] ) ) ) {
					$schedule = esc_attr( $schedule_array[0] );
				} else {
					$schedule = 'singlerun';
				}

			}

			if ( in_array( key( $cron ), $wpcore_cron_hooks ) ) {

				$wpcore_crons .= $this->sd_html( 'field-content-start' );
				$wpcore_crons .= $this->sd_html( 'field-content-first', key( $cron ), 'long-value' );
				$wpcore_crons .= $this->sd_html( 'field-content-second', $schedule, 'long-value' );
				$wpcore_crons .= $this->sd_html( 'field-content-end' );

				$wpcore_crons_count++;

			} else {

				$custom_crons .= $this->sd_html( 'field-content-start' );
				$custom_crons .= $this->sd_html( 'field-content-first', key( $cron ), 'long-value' );
				$custom_crons .= $this->sd_html( 'field-content-second', $schedule, 'long-value' );
				$custom_crons .= $this->sd_html( 'field-content-end' );

				$custom_crons_count++;

			}

		}

		if ( $type == 'wpcore' ) {

			if ( $return == 'events' ) {

				return $wpcore_crons;

			} elseif ( $return == 'count' ) {

				return $wpcore_crons_count;

			} else {}

		} elseif ( $type == 'custom' ) {

			if ( $return == 'events' ) {

				return $custom_crons;

			} elseif ( $return == 'count' ) {

				return $custom_crons_count;

			} else {}

		} elseif ( $type == 'all' ) {

			if ( $return == 'count' ) {

				return count( $crons );

			}

		} elseif ( $type == 'schedules' ) {

			$schedules = wp_get_schedules();

			if ( $return == 'list' ) {

				$output = '';

				foreach ( $schedules as $interval_name => $data ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', $interval_name );
					$output .= $this->sd_html( 'field-content-second', $data['display'] );
					$output .= $this->sd_html( 'field-content-end' );

				}

				return $output;

			} elseif ( $return == 'count' ) {

				return count( $schedules );

			}

		}

	}

	/**
	 * Display rewrite rules
	 *
	 * @param string $type list | total_count
	 * @since 1.8.0
	 */
	public function sd_rewrite_rules( $type = 'list' ) {

		$rewrite_rules = get_option( 'rewrite_rules' );

		$output = '';
		$count = 0;

		// $output .= $this->sd_html( 'field-content-start' );
		// $output .= $this->sd_html( 'field-content-first', '<strong>URL Structure</strong>' );
		// $output .= $this->sd_html( 'field-content-second', '<strong>Query Parameters</strong>' );
		// $output .= $this->sd_html( 'field-content-end' );

		foreach ( $rewrite_rules as $key => $value ) {

			$output .= $this->sd_html( 'field-content-start', '', 'flex-direction-column' );
			$output .= $this->sd_html( 'field-content-first', $key, 'full-width long-value' );
			$output .= $this->sd_html( 'field-content-second', '&#10132; ' . $value, 'full-width long-value' );
			$output .= $this->sd_html( 'field-content-end' );

			$count++;

		}

		if ( $type == 'list' ) {

			return $output;

		} elseif ( $type == 'total_count' ) {

			return $count;

		}

	}

	/**
	 * Function to retrieve a displayable string representing the callback.
	 *
	 * @link https://plugins.svn.wordpress.org/debug-bar-shortcodes/tags/2.0.3/class-debug-bar-shortcodes-render.php
	 * @param mixed $callback A callback.
	 * @return string
	 */
	public function sd_determine_callback_type( $callback ) {

		if ( ( ! is_string( $callback ) && ! is_object( $callback ) ) && ( ! is_array( $callback ) || ( is_array( $callback ) && ( ! is_string( $callback[0] ) && ! is_object( $callback[0] ) ) ) ) ) {
			// Type 1 - not a callback.
			return '';
		}
		elseif ( is_string( $callback ) && false === strpos( $callback, '::' ) ) {
			// Type 4 - simple string function (includes lambda's).
			return sanitize_text_field( $callback ) . '()';
		}
		elseif ( is_string( $callback ) && false !== strpos( $callback, '::' ) ) {
			// Type 5 - static class method calls - string.
			return '[<em>class</em>] ' . str_replace( '::', ' :: ', sanitize_text_field( $callback ) ) . '()';
		}
		elseif ( is_array( $callback ) && ( is_string( $callback[0] ) && is_string( $callback[1] ) ) ) {
			// Type 6 - static class method calls - array.
			return '[<em>class</em>] ' . sanitize_text_field( $callback[0] ) . ' :: ' . sanitize_text_field( $callback[1] ) . '()';
		}
		elseif ( is_array( $callback ) && ( is_object( $callback[0] ) && is_string( $callback[1] ) ) ) {
			// Type 7 - object method calls.
			return '[<em>object</em>] ' . get_class( $callback[0] ) . ' -> ' . sanitize_text_field( $callback[1] ) . '()';
		}
		else {
			// Type 8 - undetermined.
			return '<pre>' . var_export( $callback, true ) . '</pre>';
		}
	}

	/**
	 * Display shortcodes
	 *
	 * @param string $type list | total_count
	 * @since 1.8.0
	 */
	public function sd_shortcodes( $type = 'list' ) {

		global $shortcode_tags;

		$output = '';

		if ( ( is_array( $shortcode_tags ) ) && ( !empty( $shortcode_tags ) ) ) {

			ksort( $shortcode_tags );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '<strong>Shortcode</strong>' );
			$output .= $this->sd_html( 'field-content-second', '<strong>Rendered By</strong>' );
			$output .= $this->sd_html( 'field-content-end' );

			foreach ( $shortcode_tags as $shortcode => $callback ) {

				$output .= $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', '[' . $shortcode . ']' );
				$output .= $this->sd_html( 'field-content-second', $this->sd_determine_callback_type( $callback ) );
				$output .= $this->sd_html( 'field-content-end' );

			}

			if ( $type == 'list' ) {

				return $output;

			} else {

				return count( $shortcode_tags );

			}

		}

	}

	/**
	 * Get options that are not transients
	 *
	 * @link http://plugins.svn.wordpress.org/options-inspector/tags/2.1.1/option-inspector.php
	 * @link http://plugins.svn.wordpress.org/options-view/tags/2.09/lib/class-tt-optionsview-list-table.php
	 * @since 1.3.0
	 */
	public function sd_options( $type = 'wpcore' ) {

		$wpcore_initial_options = array( 'siteurl', 'home', 'blogname', 'blogdescription', 'users_can_register', 'admin_email', 'start_of_week', 'use_balanceTags', 'use_smilies', 'require_name_email', 'comments_notify', 'posts_per_rss', 'rss_use_excerpt', 'mailserver_url', 'mailserver_login', 'mailserver_pass', 'mailserver_port', 'default_category', 'default_comment_status', 'default_ping_status', 'default_pingback_flag', 'posts_per_page', 'date_format', 'time_format', 'links_updated_date_format', 'comment_moderation', 'moderation_notify', 'permalink_structure', 'rewrite_rules', 'hack_file', 'blog_charset', 'moderation_keys', 'active_plugins', 'category_base', 'ping_sites', 'comment_max_links', 'gmt_offset', 'default_email_category', 'recently_edited', 'template', 'stylesheet', 'comment_registration', 'html_type', 'use_trackback', 'default_role', 'db_version', 'uploads_use_yearmonth_folders', 'upload_path', 'blog_public', 'default_link_category', 'show_on_front', 'tag_base', 'show_avatars', 'avatar_rating', 'upload_url_path', 'thumbnail_size_w', 'thumbnail_size_h', 'thumbnail_crop', 'medium_size_w', 'medium_size_h', 'avatar_default', 'large_size_w', 'large_size_h', 'image_default_link_type', 'image_default_size', 'image_default_align', 'close_comments_for_old_posts', 'close_comments_days_old', 'thread_comments', 'thread_comments_depth', 'page_comments', 'comments_per_page', 'default_comments_page', 'comment_order', 'sticky_posts', 'widget_categories', 'widget_text', 'widget_rss', 'uninstall_plugins', 'timezone_string', 'page_for_posts', 'page_on_front', 'default_post_format', 'link_manager_enabled', 'finished_splitting_shared_terms', 'site_icon', 'medium_large_size_w', 'medium_large_size_h', 'wp_page_for_privacy_policy', 'show_comments_cookies_opt_in', 'admin_email_lifespan', 'disallowed_keys', 'comment_previously_approved', 'auto_plugin_theme_update_emails', 'auto_update_core_dev', 'auto_update_core_minor', 'auto_update_core_major', 'wp_force_deactivated_plugins', 'initial_db_version', 'wp_user_roles', 'fresh_site', 'widget_block', 'sidebars_widgets', 'cron', 'widget_pages', 'widget_calendar', 'widget_archives', 'widget_media_audio', 'widget_media_image', 'widget_media_gallery', 'widget_media_video', 'widget_meta', 'widget_search', 'widget_tag_cloud', 'widget_nav_menu', 'widget_custom_html', 'recovery_keys', 'theme_mods_twentytwentytwo', 'https_detection_errors', 'can_compress_scripts', 'recently_activated', 'finished_updating_comment_type' );

		$options_core = array();
		$options_noncore = array();

		$options_total_count = 0;
		$options_wpcore_count = 0;
		$options_noncore_count = 0;

		$output = '';

		if ( $type == 'wpcore' ) {

			$output .= $this->sd_html( 'search-filter', '', '', ['search-options-wpcore' => ''] );

		} elseif ( $type == 'noncore' ) {

			$output .= $this->sd_html( 'search-filter', '', '', ['search-options-noncore' => ''] );

		}

		$names = '';

		global $wpdb;

		// $options = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options ORDER BY option_name" );
		// $options = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}options ORDER BY option_name" ) );
		$options = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options" );

		if ( !empty( $options ) ) {

			$autoloaded_count = 0;
			$autoloaded_size = 0;

			foreach ( $options as $option ) {

				$id = $option->option_id;
				$name = $option->option_name;

				$value = maybe_unserialize( $option->option_value );
				$value_type_raw = gettype( $value );

				$autoload = $option->autoload;

				// $size_raw = $wpdb->get_var( $wpdb->prepare( "SELECT LENGTH(option_value) FROM $wpdb->options WHERE option_name = %s LIMIT 1", $name ) );
				$size_raw = strlen( $option->option_value );
				$size_formatted = size_format( $size_raw );

				if ( !empty( $value ) ) {
					$size = 'size: ' . $size_formatted;
					$size_formatted_array = explode( " ", $size_formatted );
					$size_order = strtolower( $size_formatted_array[1] );
					$value_type = ' - type: ' . $value_type_raw;
				} elseif( ( empty( $value ) ) && is_numeric( $value ) ) {
					$size = 'size: ' . $size_formatted;
					$size_formatted_array = explode( " ", $size_formatted );
					$size_order = strtolower( $size_formatted_array[1] );
					$value_type = ' - type: ' . $value_type;
				} else {
					$size = 'empty ';
					$size_order = 'empty';
					$value_type = '';
				}

				if ( $autoload == 'yes' ) {
					$autoloaded = 'autoloaded - ';
					$autoloaded_string = '_autoloaded';
					$autoloaded_count++;
					$autoloaded_size += $size_raw;
				} else {
					$autoloaded = '';					
					$autoloaded_string = '';
				}

				// Ignore options with name starting with underscore as they are transients
				if ( $name[0] !== '_' ) {

					$content = '';

					if ( $type == 'wpcore' ) {

						if ( in_array( $name, $wpcore_initial_options ) ) {

							$content .= $this->sd_html( 'field-content-start', '', 'flex-direction-column' );
							$content .= $this->sd_html( 'field-content-first', '<div id="spinner-' . $id . '"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="option_id_' . $id . '" class="option__value ajax-value"></div>', 'full-width long-value' );
							$content .= $this->sd_html( 'field-content-end' );

							$data_atts = array(
								'id'		=> $id,
								'loaded'	=> 'no',
								'name'		=> $name,
							);

							// Search filter data attributes
							$search_atts = array(
								'opt-core'	=> '',
								'opt-core-name'	=> $name . $autoloaded_string . '_' . $size_order . '_' . $value_type_raw,
							);

							$output .= $this->sd_html( 'accordions-start-simple-margin-default', '', '', $search_atts );
							$output .= $this->sd_html( 'accordion-head', 'ID: ' . $id . ' - ' . $name . ' | ' . $autoloaded . $size . $value_type, 'option__name', $data_atts, 'option-name-'.$id );
							$output .= $this->sd_html( 'accordion-body', $content );
							$output .= $this->sd_html( 'accordions-end' );

						}

					} elseif ( $type == 'noncore' ) {

						if ( !in_array( $name, $wpcore_initial_options ) ) {

							$content .= $this->sd_html( 'field-content-start', '', 'flex-direction-column' );
							$content .= $this->sd_html( 'field-content-first', '<div id="spinner-' . $id . '"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="option_id_' . $id . '" class="option__value ajax-value"></div>', 'full-width long-value' );
							$content .= $this->sd_html( 'field-content-end' );

							$data_atts = array(
								'id'		=> $id,
								'loaded'	=> 'no',
								'name'		=> $name,
							);

							// Search filter data attributes
							$search_atts = array(
								'opt-noncore'	=> '',
								'opt-noncore-name'	=> $name . $autoloaded_string . '_' . $size_order . '_' . $value_type_raw,
							);

							$output .= $this->sd_html( 'accordions-start-simple-margin-default', '', '', $search_atts );
							$output .= $this->sd_html( 'accordion-head', 'ID: ' . $id . ' - ' . $name . ' | ' . $autoloaded . $size . $value_type, 'option__name', $data_atts, 'option-name-'.$id );
							$output .= $this->sd_html( 'accordion-body', $content );
							$output .= $this->sd_html( 'accordions-end' );

						}

					} elseif ( $type == 'total_count' ) {

						$options_total_count++;

					} elseif ( $type == 'wpcore_count' ) {

						if ( in_array( $name, $wpcore_initial_options ) ) {

							$options_wpcore_count++;

						}

					} elseif ( $type == 'noncore_count' ) {

						if ( !in_array( $name, $wpcore_initial_options ) ) {

							$options_noncore_count++;

						}

					} else {}

				} else {}

			}

			if ( ( $type == 'wpcore' ) || ( $type == 'noncore' ) ) {

				return $output;

			} elseif ( $type == 'total_count' ) {

				return $options_total_count;

			} elseif ( $type == 'wpcore_count' ) {

				return $options_wpcore_count;

			} elseif ( $type == 'noncore_count' ) {

				return $options_noncore_count;

			} elseif ( $type == 'total_count_autoloaded' ) {

				return $autoloaded_count;

			} elseif ( $type == 'total_autoloaded_size' ) {

			 return size_format( $autoloaded_size );

			} else {}

		}

	}

	/**
	 * Get transients data
	 * 
	 * @link https://plugins.svn.wordpress.org/wptools/tags/3.13/functions/functions_transiente_manager.php
	 * @since 1.0.0
	 */
	public function sd_transients( $return_type = 'list', $x_type = 'expired' ) {

		global $wpdb;

		$args = array();

		$defaults = array(
			'offset'	=> 0,
			'number'	=> 1000,
			'searc'		=> '',
		);

		$args       = wp_parse_args($args, $defaults);

		$sql = "SELECT * FROM $wpdb->options WHERE option_name LIKE '%\_transient\_%' AND option_name NOT LIKE '%\_transient\_timeout%'";
		$offset = absint($args['offset']);
		$number = absint($args['number']);
		$sql .= " ORDER BY option_id DESC LIMIT $offset,$number;";

		$transients = $wpdb->get_results($sql);

		$output = '';
		$n = 0; // Start transients counter by expiry type
		$transients_total_count = 0;
		$autoloaded_count = 0;
		$autoloaded_size = 0;

		$output .= $this->sd_html( 'accordions-start-simple' );
		
		foreach( $transients as $transient ) {

			// Get transient name

			$transient_name_full = $transient->option_name;
			$length = false !== strpos( $transient->option_name, 'site_transient_' ) ? 16 : 11;
			$transient_name = substr( $transient->option_name, $length, strlen($transient->option_name) );

			// Get other transient info

			$id = $transient->option_id;
			$autoload = $transient->autoload;
			// $size_raw = $wpdb->get_var( $wpdb->prepare( "SELECT LENGTH(option_value) FROM $wpdb->options WHERE option_name = %s LIMIT 1", $transient_name_full ) );
			$size_raw = strlen( $transient->option_value );
			$value = maybe_unserialize( $transient->option_value );
			$value_type = gettype( $value );

			// Set HTML data-attributes values

			$data_atts = array(
				'id'		=> $id,
				'loaded'	=> 'no',
				'name'		=> $transient_name_full,
			);

			if ( !empty( $value ) ) {
				$size = 'size: ' . size_format( $size_raw );
				$value_type = ' - type: ' . $value_type;
			} elseif( ( empty( $value ) ) && is_numeric( $value ) ) {
				$size = 'size: ' . size_format( $size_raw );
				$value_type = ' - type: ' . $value_type;
			} else {
				$size = 'empty ';
				$value_type = '';
			}


			if ( $autoload == 'yes' ) {
				$autoloaded = 'autoloaded - ';
				$autoloaded_count++;
				$autoloaded_size += $size_raw;
			} else {
				$autoloaded = '';					
			}


			// Get transient expiry

			$time_now  = time();

			if ( false !== strpos( $transient->option_name, 'site_transient_') ) {
				$expiry = get_option('_site_transient_timeout_' . $transient_name );
			} else {
				$expiry = get_option('_transient_timeout_' . $transient_name );
			}

			if ( empty( $expiry ) ) {
				$expiry_type = 'neverexpire';
				$expiry_formatted = '';
			} elseif ( $time_now > $expiry ) {
				$expiry_type = 'expired';
				$expiry_formatted = '';
			} else {
				$expiry_type = 'active';
				$expiry_formatted = human_time_diff( $time_now, $expiry );
			}

			$transient_content = $this->sd_html( 'field-content-start', '', 'flex-direction-column' );
			$transient_content .= $this->sd_html( 'field-content-first', '<div id="spinner-' . $id . '"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="transient_id_' . $id . '" class="option__value ajax-value"></div>', 'full-width long-value' );
			$transient_content .= $this->sd_html( 'field-content-end' );
			

			if ( $x_type == 'active' ) {
				$expiry_note = ' Expires in ' . $expiry_formatted;
			} elseif ( $x_type == 'neverexpire' ) {
				$expiry_note = '';
			} elseif ( $x_type == 'expired' ) {
				$expiry_note = '';
			}

			if ( $x_type == $expiry_type ) {

				$output .= $this->sd_html( 'accordion-head', 'ID: ' . $id . ' - ' . $transient_name . ' | ' . $autoloaded . $size . $value_type . '<br />' . $expiry_note, 'transient__name', $data_atts, 'transient-name-'.$id );
				$output .= $this->sd_html( 'accordion-body', $transient_content );

				$n++;

			}

			$transients_total_count++;

		}

		$output .= $this->sd_html( 'accordions-end' );

		if ( $return_type == 'list' ) {

			return $output;

		} elseif ( $return_type == 'count' ) {

			return $n;

		} elseif ( $return_type == 'total_count' ) {

			return $transients_total_count;

		} elseif ( $return_type == 'total_count_autoloaded' ) {

			return $autoloaded_count;

		} elseif ( $return_type == 'total_autoloaded_size' ) {

			 return size_format( $autoloaded_size );

		} else {}

	}

	/**
	 * Add fast AJAX MU plugin
	 *
	 * @link https://github.com/atwellpub/WordPress-Fast-Ajax-Mu-Plugin
	 * @since 2.0.1
	 */
	public function sd_fast_ajax_mu() {

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

	/**
	 * Triggers varioius AJAX calls
	 *
	 * @link https://sharewebdesign.com/blog/wordpress-ajax-call/
	 * @since 1.3.0
	 */
	public function sd_ajax_calls() {

		if ( defined( 'FAST_AJAX' ) ) {

			// Do nothing, Fast AJAX MU plugin has been installed

		} else {

			// Install Fast AJAX MU plugin for use in the following AJAX calls
			$this->sd_fast_ajax_mu();

		}

		?>

		<script id="sd-ajax-calls">

			jQuery( document ).ready( function() {

				// https://stackoverflow.com/a/60408183
				function isJsonString( jsonString ) {

				  // This function below ('printError') can be used to print details about the error, if any.
				  // Please, refer to the original article (see the end of this post)
				  // for more details. I suppressed details to keep the code clean.
				  //
				  let printError = function(error, explicit) {
				  console.log(`[${explicit ? 'EXPLICIT' : 'INEXPLICIT'}] ${error.name}: ${error.message}`);
				  }


				  try {
				      JSON.parse( jsonString );
				      return true; // It's a valid JSON format
				  } catch (e) {
				      return false; // It's not a valid JSON format
				  }

				}

				// Initiate the collapsibles on newly loaded dt elements from AJAX call result
				function initMcCollapsible( className ) {
					document.querySelectorAll( className + " dl.mc-collapsible").forEach((dl) => {
				        dl.querySelectorAll( className + " dt").forEach((dt) => {
				            dt.addEventListener("click", (e) => {
				                let dt = e.srcElement;
				                let dl = dt.parentElement;
				                console.dir(dt);
				                console.log(`${dt.innerHTML} clicked`);
				                const dd = dt.nextElementSibling;
				                if ((dd === null || dd === void 0 ? void 0 : dd.tagName) != "DD") {
				                    console.error('Details "DD" not found');
				                    return;
				                }
				                console.log(`${dt.innerHTML} details is`);
				                console.dir(dd);
				                if (dt.classList.contains("active")) {
				                    dt.classList.remove("active");
				                    dd.style.maxHeight = 0; //Max hieght for the animation
				                }
				                else {
				                    //Close other items if single mode
				                    dl.getAttribute("data-single-mode") && openAll(dl, false);
				                    //Activate current item
				                    dt.classList.add("active");
				                    // dd.style.maxHeight = dd.scrollHeight + "px"; //Max hieght for the animation
				                    dd.style.maxHeight = "unset"; //Max hieght for the animation
				                }
				                //Check if all item are active for the controls and update accordingly
				                if (dl.querySelector("div.control")) {
				                    const closeStatus = dl.querySelectorAll("dt").length -
				                        dl.querySelectorAll("dt.active").length;
				                    closeStatus == 0
				                        ? dl.querySelector("div.control").classList.add("controls-open")
				                        : dl.querySelector("div.control").classList.remove("controls-open");
				                }
				            });
				        });
					});
				}

				jQuery('.db-tables .csf-accordion-title').attr('data-loaded','no');
				jQuery('.db-specs .csf-accordion-title').attr('data-loaded','no');
				jQuery('.db-details .csf-accordion-title').attr('data-loaded','no');
				jQuery('.wpcore-hooks .csf-accordion-item:nth-child(1) .csf-accordion-title').attr('data-loaded','no');
				jQuery('.wpcore-hooks .csf-accordion-item:nth-child(2) .csf-accordion-title').attr('data-loaded','no');
				jQuery('.theme-hooks .csf-accordion-title').attr('data-loaded','no');
				jQuery('.plugins-hooks .csf-accordion-title').attr('data-loaded','no');
				jQuery('.constant-values .csf-accordion-title').attr('data-loaded','no');
				jQuery('.constant-docs .csf-accordion-title').attr('data-loaded','no');
				jQuery('.wpconfig .csf-accordion-title').attr('data-loaded','no');
				jQuery('.htaccess .csf-accordion-title').attr('data-loaded','no');
				jQuery('.restapi_viewer .csf-accordion-title').attr('data-loaded','no');
				jQuery('.robotstxt .csf-accordion-title').attr('data-loaded','no');
				jQuery('.phpinfo-details .csf-accordion-title').attr('data-loaded','no');

				// Get database tables

				jQuery('.db-tables .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_db_tables',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#db-tables-content').prepend(data);
								jQuery('.db-tables .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-db-tables').fadeOut( 0 );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get database key specifications

				jQuery('.db-specs .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_db_specs',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#db-specs-content').prepend(data);
								jQuery('.db-specs .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-db-specs').fadeOut( 0 );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get database detail specifications

				jQuery('.db-details .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_db_details',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#db-details-content').prepend(data);
								jQuery('.db-details .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-db-details').fadeOut( 0 );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get option value

				jQuery('.option__name').click( function() {

					var optionName = this.dataset.name;
					var optionId = this.dataset.id;
					var optionLoaded = this.dataset.loaded;

					if ( optionName == 'active_plugins' ) {
						var fastAjaxValue = false;
						var loadedPlugins = 'all';
					} else {
						var fastAjaxValue = true;
						var loadedPlugins = ["system-dashboard/system-dashboard.php"];
					}

					if ( optionLoaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_option_value',
								'option_name':optionName,
								'fast_ajax':fastAjaxValue,
								'load_plugins':loadedPlugins
							},
							success:function(data) {
								// console.log('result: ' + optionId + ' - ' + data);

								if ( isJsonString(data) ) {
									var dataObj = JSON.parse(data);
									jQuery('#option_id_' + optionId).jsonViewer(dataObj,{collapsed: true, rootCollapsable: false, withQuotes: false, withLinks: false});
								} else {
									jQuery('#option_id_' + optionId).prepend(data);
								}

								jQuery('#option-name-' + optionId).attr('data-loaded','yes');
								jQuery('#spinner-' + optionId).fadeOut( 0 );

							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get transient value

				jQuery('.transient__name').click( function() {

					var transientName = this.dataset.name;
					var transientId = this.dataset.id;
					var transientLoaded = this.dataset.loaded;

					if ( transientLoaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_option_value',
								'option_name':transientName,
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								// console.log('result: ' + transientId + ' - ' + data);

								if ( isJsonString(data) ) {
									var dataObj = JSON.parse(data);
									jQuery('#transient_id_' + transientId).jsonViewer(dataObj,{collapsed: true, rootCollapsable: false, withQuotes: false, withLinks: false});
								} else {
									jQuery('#transient_id_' + transientId).prepend(data);
								}

								jQuery('#transient-name-' + transientId).attr('data-loaded','yes');
								jQuery('#spinner-' + transientId).fadeOut( 0 );

							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get WP core action hooks

				jQuery('.wpcore-hooks .csf-accordion-item:nth-child(1) .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_wpcore_hooks',
								'type':'action',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#core-action-hooks-content').prepend(data);
								jQuery('.wpcore-hooks .csf-accordion-item:nth-child(1) .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-core-action-hooks').fadeOut( 0 );

								// Search filter script
						        jQuery('[data-search-wpcore-action-hooks]').on('keyup', function() {
						            var searchVal = jQuery(this).val();
						            var filterItems = jQuery('[data-core-act-hook]');

						            if ( searchVal != '' ) {
						                filterItems.addClass('hidden');
						                jQuery('[data-core-act-hook][data-core-act-hook-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
						            } else {
						                filterItems.removeClass('hidden');
						            }
						        });

							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get WP core filter hooks

				jQuery('.wpcore-hooks .csf-accordion-item:nth-child(2) .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_wpcore_hooks',
								'type':'filter',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#core-filter-hooks-content').prepend(data);
								jQuery('.wpcore-hooks .csf-accordion-item:nth-child(2) .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-core-filter-hooks').fadeOut( 0 );

								// Search filter script
						        jQuery('[data-search-wpcore-filter-hooks]').on('keyup', function() {
						            var searchVal = jQuery(this).val();
						            var filterItems = jQuery('[data-core-fil-hook]');

						            if ( searchVal != '' ) {
						                filterItems.addClass('hidden');
						                jQuery('[data-core-fil-hook][data-core-fil-hook-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
						            } else {
						                filterItems.removeClass('hidden');
						            }
						        });
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get hooks of active theme

				jQuery('.theme-hooks .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_hooks',
								'type':'active_theme',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#theme-hooks-content').prepend(data);
								jQuery('.theme-hooks .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-theme-hooks').fadeOut( 0 );
								initMcCollapsible( ".theme-hooks" );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get hooks of active plugins

				jQuery('.plugins-hooks .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_hooks',
								'type':'active_plugins'
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#plugins-hooks-content').prepend(data);
								jQuery('.plugins-hooks .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-plugins-hooks').fadeOut( 0 );
								initMcCollapsible( ".plugins-hooks" );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get global variable's value

				jQuery('.global__name').click( function() {

					var name = this.dataset.name;
					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_global_value',
								'global_name':name,
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {

								if ( isJsonString(data) ) {
									var dataObj = JSON.parse(data);
									jQuery('#global_id_' + name).jsonViewer(dataObj,{collapsed: true, rootCollapsable: false, withQuotes: false, withLinks: false});
								} else {
									jQuery('#global_id_' + name).prepend(data);
								}

								jQuery('#global-name-' + name).attr('data-loaded','yes');
								jQuery('#spinner-' + name).fadeOut( 0 );

							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get defind constant values

				jQuery('.constant-values .csf-accordion-title').click( function() {

					var name = this.dataset.name;
					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_constants',
								'type':'defined',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#constant-values-content').prepend(data);
								jQuery('.constant-values .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-constant-values').fadeOut( 0 );
								initMcCollapsible( ".constant-values" );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get constant docs

				jQuery('.constant-docs .csf-accordion-title').click( function() {

					var name = this.dataset.name;
					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_constants',
								'type':'docs',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#constant-docs-content').prepend(data);
								jQuery('.constant-docs .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-constant-docs').fadeOut( 0 );
								initMcCollapsible( ".constant-docs" );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get content of wp-config.php

				jQuery('.wpconfig .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_viewer',
								'filename':'wp-config.php',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#wpconfig-content').prepend(data);
								jQuery('.wpconfig .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-wpconfig').fadeOut( 0 );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get content of .htaccess

				jQuery('.htaccess .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_viewer',
								'filename':'.htaccess',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#htaccess-content').prepend(data);
								jQuery('.htaccess .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-htaccess').fadeOut( 0 );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get content of .htaccess

				jQuery('.robotstxt .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_viewer',
								'filename':'robots.txt',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#robotstxt-content').prepend(data);
								jQuery('.robotstxt .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-robotstxt').fadeOut( 0 );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get REST API JSON

				jQuery('.restapi_viewer .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_wp_rest_api',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {

								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call

								if ( isJsonString(data) ) {
									var dataObj = JSON.parse(data);
									jQuery('#restapi-content').jsonViewer(dataObj,{collapsed: true, rootCollapsable: false, withQuotes: false, withLinks: false});
								} else {
									jQuery('#restapi-content').prepend(data);
								}
								jQuery('.restapi_viewer .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-restapi').fadeOut( 0 );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get formatted phpinfo() content

				jQuery('.phpinfo-details .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_php_info',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#phpinfo-content').prepend(data);
								jQuery('.phpinfo-details .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-phpinfo').fadeOut( 0 );
							},
							erro:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

			} );

		</script>

		<?php

	}

	/**
	 * Get formatted value of an option (including transients, which are options too). Triggered by an AJAX call.
	 *
	 * @link https://sharewebdesign.com/blog/wordpress-ajax-call/
	 * @since 1.3.0
	 */
	public function sd_option_value() {

		if ( isset( $_REQUEST ) ) {

			$option_name = $_REQUEST['option_name'];

			$option_value = maybe_unserialize( get_option( $option_name ) );

			$option_value_type = gettype( $option_value );

			if  ( ( $option_value_type == 'array' ) || ( $option_value_type == 'object' ) ) {

				// JSON_UNESCAPED_SLASHES will remove backslashes used for escaping, e.g. \' will become just '. stripslashes will further remove backslashes using to escape backslashes, e.g. double \\ will become a single \. JSON_PRETTY_PRINT and <pre> beautifies the output on the HTML side.

				// echo '<pre>' . stripslashes( json_encode( $option_value, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) ) . '</pre>'; // Raw JSON beautified
				echo json_encode( $option_value ); // for JSON Tree viewer

			} elseif ( ( $option_value_type == 'boolean' ) || ( $option_value_type == 'integer' ) || ( $option_value_type == 'string' ) ) {

				echo '<pre>' . htmlspecialchars( $option_value ) . '</pre>'; // Raw JSON beautified

			} else {}

		} else {

			echo 'None. Please define option name first.';

		}

		wp_die();

	}

	/**
	 * List WP core action and filter hooks
	 * 
	 * @link https://github.com/johnbillion/wp-hooks
	 *
	 * @param string $type action | filter
	 * @param string $return hooks | count
	 * @since 1.0.0
	 */
	public function sd_wpcore_hooks() {

		if ( isset( $_REQUEST ) ) {

			$type = $_REQUEST['type'];

			$wp_reference_base_url = 'https://developer.wordpress.org/reference/hooks';		

			$response = wp_remote_get( plugin_dir_url( __DIR__ ). 'admin/references/wpcore_hooks_actions_filters.json' );
			$hooks_json = wp_remote_retrieve_body( $response );

			$hooks = json_decode( $hooks_json, TRUE ); // convert into array

			$output = '';
			$action_hooks = '';
			$filter_hooks = '';
			$action_hooks_count = 0;
			$filter_hooks_count = 0;

			foreach ( $hooks as $hook ) {

				$hook_name_clean = str_replace("{", "", $hook['name']);
				$hook_name_clean = str_replace("}", "", $hook_name_clean);
				$hook_name_clean = str_replace("$", "", $hook_name_clean);
				$hook_name_clean = str_replace(">", "-", $hook_name_clean);

				if ( strpos( $hook['type'], 'action' ) !== false ) {

					// Search filter data attributes
					$search_atts = array(
						'core-act-hook'			=> '',
						'core-act-hook-name'	=> $hook['name'],
					);

					$action_hooks .= $this->sd_html( 'field-content-start', '', '', $search_atts, '' );
					$action_hooks .= $this->sd_html( 'field-content-first', '<a href="' . $wp_reference_base_url . '/' . $hook_name_clean . '/" target="_blank">'. $hook['name'] . '</a> <br /><span>' . $hook['file'] . '</span>' );
					$action_hooks .= $this->sd_html( 'field-content-second', $hook['description'] );
					$action_hooks .= $this->sd_html( 'field-content-end' );

					$action_hooks_count++;

				} elseif ( strpos( $hook['type'], 'filter' ) !== false ) {

					// Search filter data attributes
					$search_atts = array(
						'core-fil-hook'			=> '',
						'core-fil-hook-name'	=> $hook['name'],
					);

					$filter_hooks .= $this->sd_html( 'field-content-start', '', '', $search_atts, '' );
					$filter_hooks .= $this->sd_html( 'field-content-first', '<a href="' . $wp_reference_base_url . '/' . $hook_name_clean . '/" target="_blank">'. $hook['name'] . '</a> <br /><span>' . $hook['file'] . '</span>' );
					$filter_hooks .= $this->sd_html( 'field-content-second', $hook['description'] );
					$filter_hooks .= $this->sd_html( 'field-content-end' );

					$filter_hooks_count++;

				} else {}

			}

			if ( $type == 'action' ) {

				// Add search filter box and total hooks count
				$output .= $this->sd_html( 'search-filter', 'Total: ' . $action_hooks_count . ' hooks', '', ['search-wpcore-action-hooks' => ''] );

				$output .= $action_hooks;

			} elseif ( $type == 'filter' ) {

				// Add search filter box and total hooks count
				$output .= $this->sd_html( 'search-filter', 'Total: ' . $filter_hooks_count . ' hooks', '', ['search-wpcore-filter-hooks' => ''] );

				$output .= $filter_hooks;

			} else {}

			echo $output;

		}

	}

	/**
	 * [Unused function] Get list of WP hooks active on the current page
	 * 
	 * @link https://plugins.svn.wordpress.org/fastdev/tags/1.7.1/app/Hooks.php
	 * @link https://web.archive.org/web/20220301044611/https://www.hardworkingnerd.com/whats-the-difference-between-wp_filter-and-wp_actions/ 
	 * @since 1.0.0
	 */
	public function sd_list_of_hooks() {

		global $wp_actions;
		global $wp_filter;

		$output = '';
		$wp_reference_base_url = 'https://developer.wordpress.org/reference';
		$hooks = array();

		foreach( $wp_actions as $hook => $value ) {

			$hooks[] = $hook;

		}

		foreach( $wp_filter as $hook => $value ) {

			// $value is a closure object that can be inspected with ReflectionFunction, reference: https://stackoverflow.com/a/47713318

			$hooks[] = $hook;

		}

		$hooks = array_unique( $hooks );

		sort( $hooks );

		foreach ( $hooks as $hook ) {

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '<a href="' . $wp_reference_base_url . '/classes/' . $hook . '/" target="_blank">'. $hook .'</a>', 'full-width' );
			$output .= $this->sd_html( 'field-content-end' );

		}

		return $output;
	}


	/**
	 * Prepare theme file for file editor preview
	 *
	 * @since 1.0.0
	 */
	public function sd_prepare_theme_filename_for_preview( $filename ) {

		$filename = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $filename );
		$filename_for_editor_preprocessed = str_replace( "/wp-content/themes/", "", $filename );
		$filename_array = explode( "/", ltrim( $filename_for_editor_preprocessed, "/" ) ); // remove first slash and turn into array
		array_shift( $filename_array ); // remove first element, which is the theme slug
		$filename_for_editor_raw = implode( "/", $filename_array ); // put back together as string
		$filename_for_editor = urlencode( $filename_for_editor_raw );

		return $filename_for_editor;

	}

	/**
	 * Get sorted list of all declared classes
	 * 
	 * @link https://plugins.svn.wordpress.org/fastdev/tags/1.7.1/app/Classes.php
	 * @link https://www.php.net/manual/en/function.get-declared-classes.php
	 * @link https://www.php.net/manual/en/class.reflectionclass.php
	 * @link https://www.php.net/manual/en/reflectionclass.getfilename.php
	 * @since 1.0.0
	 */
	public function sd_get_all_classes( $type = 'core' ) {

		$output = '';
		$wp_reference_base_url = 'https://developer.wordpress.org/reference';
		$plugin_file_editor_base_url = '/wp-admin/plugin-editor.php?file=';
		$theme_file_editor_base_url = '/wp-admin/theme-editor.php?file=';

		$classes = get_declared_classes();

		sort( $classes );

		$classes_core = array();
		$classes_plugins = array();
		$classes_themes = array();

		foreach( $classes as $class ) {

			// Get the filename where class is defined
			// https://www.php.net/manual/en/reflectionclass.getfilename.php
			$rc = new \ReflectionClass( $class );
			$filename = $rc->getFileName();

			if ( ! empty( $filename ) ) {
				$filename = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $filename );

				if ( strpos( $filename, 'wp-includes' ) !== false ) {
					$classes_core[] = $class;
				}

				if ( strpos( $filename, 'wp-content/plugins' ) !== false ) {
					$classes_plugins[] = $class;
				}

				if ( strpos( $filename, 'wp-content/themes' ) !== false ) {
					$classes_themes[] = $class;
				}

			}

		}

		if ( $type == 'core' ) {

			$classes_output = '';
			$class_count = 0;

			foreach( $classes_core as $class ) {

				$class_lc = strtolower( $class );
				$rc = new \ReflectionClass( $class );
				$filename = $rc->getFileName();

				if ( ! empty( $filename ) ) {
					$filename = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $filename );
				}

				$class_methods = get_class_methods( $class );
				$class_methods_output = '';

				foreach ( $class_methods as $method ) {

					$class_methods_output .= '<div class="field-part-item">' . $method . '</div>';

				}

				$classes_output .= $this->sd_html( 'field-content-start' );
				$classes_output .= $this->sd_html( 'field-content-first', '<strong>' . $class .'</strong> (' . count( $class_methods ) . ' methods)<br /><a href="' . $wp_reference_base_url . '/classes/' . $class_lc . '/" target="_blank">' . $filename .'</a>' . $class_methods_output, 'full-width' );
				$classes_output .= $this->sd_html( 'field-content-end' );

				$class_count++;

			}

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '<strong>There are ' . $class_count . ' classes in total</strong>', 'full-width' );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $classes_output;

		} elseif ( $type == 'plugins' ) {

			$active_plugin_dirfile_names = $this->sd_active_plugins( 'original', 'raw' );

			$output .= $this->sd_html( 'accordions-start' );

			// for each 'plugin-slug/plugin-slug.php'
			foreach ( $active_plugin_dirfile_names as $dirfile_name ) {

				$plugin_slug_array = explode( "/", $dirfile_name );
				$plugin_slug = $plugin_slug_array[0];

				$plugins_path = str_replace( $this->plugin_name . '/', "", plugin_dir_path( __DIR__ ) );
				$plugin_file_path = $plugins_path . $dirfile_name;
				$plugin_data = get_plugin_data( $plugin_file_path );
		
				$classes_output = '';
				$classes_count = 0;

				foreach( $classes_plugins as $class ) {

					$class_lc = strtolower( $class );
					$rc = new \ReflectionClass( $class );
					$filename = $rc->getFileName();

					if ( ! empty( $filename ) ) {
						$filename = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $filename );
						$filename_for_editor = urlencode( str_replace( "/wp-content/plugins/", "", $filename ) );
					}

					$filename_array = explode( "/", $filename );
					$class_plugin_slug = $filename_array[3];

					if ( $plugin_slug == $class_plugin_slug ) {

						$class_methods = get_class_methods( $class );
						$class_methods_output = '';

						foreach ( $class_methods as $method ) {

							$class_methods_output .= '<div class="field-part-item">' . $method . '</div>';

						}

						$classes_output .= $this->sd_html( 'field-content-start' );
						$classes_output .= $this->sd_html( 'field-content-first', '<strong>' . $class . '</strong> (' . count( $class_methods ) . ' methods)<br /><a href="' . $plugin_file_editor_base_url . $filename_for_editor . '" target="_blank">' . $filename .'</a>' . $class_methods_output, 'full-width' );
						$classes_output .= $this->sd_html( 'field-content-end' );
						$classes_count++;

					}

				}

				$output .= $this->sd_html( 'accordion-head', $plugin_data['Name'] . ' v' . $plugin_data['Version'] . ' (' . $classes_count . ' classes)' );

				$output .= $this->sd_html( 'accordion-body', $classes_output );

			}

			$output .= $this->sd_html( 'accordions-end' );

		}  elseif ( $type == 'themes' ) {

			$classes_output = '';
			$classes_count = 0;

			foreach( $classes_themes as $class ) {

				$class_lc = strtolower( $class );
				$rc = new \ReflectionClass( $class );
				$filename = $rc->getFileName();

				if ( ! empty( $filename ) ) {
  					$filename_for_editor = $this->sd_prepare_theme_filename_for_preview( $filename );
				}

				$filename = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $filename );

				$class_methods = get_class_methods( $class );
				$class_methods_output = '';

				foreach ( $class_methods as $method ) {

					$class_methods_output .= '<div class="field-part-item">' . $method . '</div>';

				}

				$class_vars = get_class_vars( $class );

				$classes_output .= $this->sd_html( 'field-content-start' );
				$classes_output .= $this->sd_html( 'field-content-first', '<strong>' . $class .'</strong> (' . count( $class_methods ) . ' methods)<br /><a href="' . $theme_file_editor_base_url . $filename_for_editor . '" target="_blank">' . $filename .'</a>' . $class_methods_output, 'full-width' );
				$classes_output .= $this->sd_html( 'field-content-end' );
				$classes_count++;

			}

			$output = $this->sd_html( 'accordions-start-simple' );
			$output .= $this->sd_html( 'accordion-head', $this->sd_active_theme( 'name' ) . ' v' . $this->sd_active_theme( 'version' ) . ' (' . $classes_count . ' classes)' );
			$output .= $this->sd_html( 'accordion-body', $classes_output );
			$output .= $this->sd_html( 'accordions-end' );

		} else {}

		return $output;
	}

	/**
	 * Get list of all PHP user-facing functions
	 * 
	 * @link https://plugins.svn.wordpress.org/fastdev/tags/1.7.1/app/Functions.php
	 * @link https://www.php.net/manual/en/function.get-defined-functions.
	 * @link https://www.php.net/manual/en/class.reflectionfunction.php
	 * @since 1.0.0
	 */
	public function sd_get_all_user_functions( $type = 'core' ) {
		$all_functions = get_defined_functions();
		$user_functions = $all_functions['user'];
		sort( $user_functions );

		$functions_core = array();
		$functions_plugins = array();
		$functions_themes = array();

		$output = '';
		$wp_reference_base_url = 'https://developer.wordpress.org/reference';
		$wp_file_base_url = 'https://github.com/WordPress/WordPress/blob/master';
		$plugin_file_editor_base_url = '/wp-admin/plugin-editor.php?file=';
		$theme_file_editor_base_url = '/wp-admin/theme-editor.php?file=';

		foreach ( $user_functions as $function ) {

			// Get the filename where the function is defined
			// https://www.php.net/manual/en/reflectionclass.getfilename.php
			$rf = new \ReflectionFunction( $function );
			$filename = $rf->getFileName();

			if ( ! empty( $filename ) ) {
				$filename = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $filename );

				if ( strpos( $filename, 'wp-includes' ) !== false ) {
					$functions_core[] = $function;
				}

				if ( strpos( $filename, 'wp-content/plugins' ) !== false ) {
					$functions_plugins[] = $function;
				}

				if ( strpos( $filename, 'wp-content/themes' ) !== false ) {
					$functions_themes[] = $function;
				}

			}

		}

		if ( $type == 'core' ) {

			$output .= $this->sd_html( 'search-filter', '', '', ['search-functions-wpcore' => ''] );

			foreach( $functions_core as $function ) {

				$function_lc = strtolower( $function );
				$rf = new \ReflectionFunction( $function );
				$filename = $rf->getFileName();

				if ( ! empty( $filename ) ) {
					$filename = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $filename );
				}

				// Search filter data attributes
				$search_atts = array(
					'fn-core'	=> '',
					'fn-core-name'	=> $function_lc,
				);

				$output .= $this->sd_html( 'field-content-start', '', '', $search_atts, '' );
				$output .= $this->sd_html( 'field-content-first', '<a href="' . $wp_reference_base_url . '/functions/' . $function_lc . '/" target="_blank">' . $function .'</a><br /><a href="' . $wp_file_base_url . $filename . '" class="link-muted" target="_blank">' . $filename .'</a>', 'full-width' );
				$output .= $this->sd_html( 'field-content-end' );

			}

		} elseif ( $type == 'plugins' ) {

			$active_plugin_dirfile_names = $this->sd_active_plugins( 'original', 'raw' );

			$output .= $this->sd_html( 'accordions-start' );

			foreach ( $active_plugin_dirfile_names as $dirfile_name ) {

				$plugin_slug_array = explode( "/", $dirfile_name );
				$plugin_slug = $plugin_slug_array[0];

				$plugins_path = str_replace( $this->plugin_name . '/', "", plugin_dir_path( __DIR__ ) );
				$plugin_file_path = $plugins_path . $dirfile_name;
				$plugin_data = get_plugin_data( $plugin_file_path );
		
				$functions_output = '';
				$functions_count = 0;

				foreach( $functions_plugins as $function ) {

					$function_lc = strtolower( $function );
					$rf = new \ReflectionFunction( $function );
					$filename = $rf->getFileName();

					if ( ! empty( $filename ) ) {
						$filename = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $filename );
						$filename_for_editor = urlencode( str_replace( "/wp-content/plugins/", "", $filename ) );
					}

					$filename_array = explode( "/", $filename );
					$function_plugin_slug = $filename_array[3];

					if ( $plugin_slug == $function_plugin_slug ) {

						$functions_output .= $this->sd_html( 'field-content-start' );
						$functions_output .= $this->sd_html( 'field-content-first', $function .'<br /><a href="' . $plugin_file_editor_base_url . $filename_for_editor . '" target="_blank">' . $filename .'</a>', 'full-width' );
						$functions_output .= $this->sd_html( 'field-content-end' );

						$functions_count++;

					}

				}

				$output .= $this->sd_html( 'accordion-head', $plugin_data['Name'] . ' v' . $plugin_data['Version'] . ' (' . $functions_count . ' functions)' );

				$output .= $this->sd_html( 'accordion-body', $functions_output );

			}

			$output .= $this->sd_html( 'accordions-end' );

		}  elseif ( $type == 'themes' ) {

			$functions_output = '';
			$functions_count = 0;

			foreach( $functions_themes as $function ) {

				$function_lc = strtolower( $function );
				$rf = new \ReflectionFunction( $function );
				$filename = $rf->getFileName();

				if ( ! empty( $filename ) ) {
  					$filename_for_editor = $this->sd_prepare_theme_filename_for_preview( $filename );
					$filename = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $filename );
				}

				$functions_output .= $this->sd_html( 'field-content-start' );
				$functions_output .= $this->sd_html( 'field-content-first', $function .'<br /><a href="' . $theme_file_editor_base_url . $filename_for_editor . '" target="_blank">' . $filename .'</a>', 'full-width' );
				$functions_output .= $this->sd_html( 'field-content-end' );

				$functions_count++;

			}

			$output .= $this->sd_html( 'accordions-start-simple-margin-default' );
			$output .= $this->sd_html( 'accordion-head', $this->sd_active_theme( 'name' ) . ' v' . $this->sd_active_theme( 'version' ) . ' ( ' . $functions_count . ' functions)' );
			$output .= $this->sd_html( 'accordion-body', $functions_output );
			$output .= $this->sd_html( 'accordions-end' );

		} elseif ( $type == 'core-count' ) {

			$output = count( $functions_core );


		} elseif ( $type == 'plugins-count' ) {

			$output = count( $functions_plugins );


		} elseif ( $type == 'themes-count' ) {

			$output = count( $functions_themes );

		} else {}

		return $output;

	}

	/**
	 * Get global variables
	 *
	 *
	 * @param string $type single | group
	 * @param string $name e.g. shortcode_args
	 * @since 1.9.00
	 */
	public function sd_globals( $type = 'single', $name = 'shortcode_tags', $call = 'ajax' ) {

		$all_wpcore_globals = array(
			'wp_version', // Version globals
			'wp_db_version',
			'tinymce_version',
			'manifest_version',
			'required_php_version',
			'required_mysql_version',
			'wpdb', // Common globals
			'wp_post_types',
			'_wp_post_type_features',
			'wp_post_statuses',
			'post_type_meta_caps',
			'wp_taxonomies',
			'wp_roles',
			'wp_user_roles',
			'wp_scripts',
			'wp_styles',
			'wp_rewrite',
			'wp_actions',
			'wp_filter',
			'wp_current_filter',
			'wp_sitemaps',
			'allowedposttags',
			'allowedtags',
			'allowedentitynames',
			'allowedxmlentitynames',
			'phpmailer',
			'wp_object_cache',
			'_wp_using_ext_object_cache',
			'wp_filesystem',
			'wp_theme_directories', // Themes plugins globals
			'theme_dir',
			'_wp_theme_features',
			'_wp_registered_theme_features',
			'wp_did_header',
			'content_width',
			'custom_image_header',
			'custom_background',
			'editor_styles',
			'wp_customize',
			'wp_plugin_paths',
			'plugin_data',
			'wp_registered_settings',
			'wp_meta_keys',
			'concatenate_scripts',
			'compress_scripts',
			'compress_css',
			'shortcode_tags', // Various globals
			'_wp_registered_nav_menus',
			'wp_meta_boxes',
			'wp_registered_sidebars',
			'wp_registered_widgets',
			'wp_registered_widget_controls',
			'wp_registered_widget_updates',
			'wp_widget_factory',
			'sidebars_widgets',
			'_wp_sidebars_widgets',
			'_wp_deprecated_widgets_callbacks',
			'_wp_additional_image_sizes',
			'wpsmiliestrans',
			'wp_smiliessearch',
			'wp_embed',
			'wp_oembed',
			'block_core_latest_posts_excerpt_length',
			'upgrading',
			'timestart',
			'comment_depth',
			'current_screen', // Admin globals
			'pagenow',
			'post_type',
			'menu',
			'submenu',
			'admin_page_hooks',
			'wp_admin_bar',
			'current_user', // Current user globals
			'user_login',
			'userdata',
			'user_level',
			'user_ID',
			'user_email',
			'user_url',
			'user_identity',
			'login_grace_period',
			'wp', // Main WP Query globals
			'wp_query',
			'wp_the_query',
			'query_string',
			'posts',
			'post',
			'request',
			'single',
			'id',
			'super_admins', // Multisite globals
			'table_prefix',
			'blog_id',
			'switched',
			'_wp_switched_stack',
			'wp_local_package', // Locales & localization globals
			'locale',
			'wp_locale',
			'wp_locale_switcher',
			'text_direction',
			'l10n',
			'l10n_unloaded',
			'weekday',
			'weekday_initial',
			'weekday_abbrev',
			'month',
			'month_abbrev',
			'wp_rest_server', // REST API globals
			'wp_rest_additional_fields',
			'wp_rest_application_password_status',
			'wp_rest_auth_cookie',
			'is_lynx', // Browser detection globals
			'is_gecko',
			'is_winIE',
			'is_macIE',
			'is_opera',
			'is_NS4',
			'is_safari',
			'is_chrome',
			'is_iphone',
			'is_IE',
			'is_edge',
			'is_nginx', // Web server detection globals
			'is_apache',
			'is_IIS',
			'is_iis7',
			'post', // Posts loop globals
			'authordata',
			'currentday',
			'currentmonth',
			'page',
			'pages',
			'multipage',
			'numpages',
			'more',
			'comment', // Comments loop globals
			'template' // Front-end globals
		);

		$php_super_globals = array(
			'_SERVER',
			'_GET',
			'_POST',
			'_FILES',
			'_COOKIE',
			'_SESSION',
			'_REQUEST',
			'_ENV',
			'PHP_SELF',
		);

		// Version globals
		$version_globals = array(
			'wp_version',
			'wp_db_version',
			'tinymce_version',
			'manifest_version',
			'required_php_version',
			'required_mysql_version',
		);

		// Common globals
		$common_globals = array(
			'wpdb',
			'wp_post_types',
			'_wp_post_type_features',
			'wp_post_statuses',
			'post_type_meta_caps',
			'wp_taxonomies',
			'wp_roles',
			'wp_user_roles',
			'wp_scripts',
			'wp_styles',
			'wp_rewrite',
			'wp_actions',
			'wp_filter',
			'wp_current_filter',
			'wp_sitemaps',
			'allowedposttags',
			'allowedtags',
			'allowedentitynames',
			'allowedxmlentitynames',
			'phpmailer',
			'wp_object_cache',
			'_wp_using_ext_object_cache',
			'wp_filesystem',
		);

		// Themes plugins globals
		$themes_plugins_globals = array(
			'wp_theme_directories',
			'theme_dir',
			'_wp_theme_features',
			'_wp_registered_theme_features',
			'wp_did_header',
			'content_width',
			'custom_image_header',
			'custom_background',
			'editor_styles',
			'wp_customize',
			'wp_plugin_paths',
			'plugin_data',
			'wp_registered_settings',
			'wp_meta_keys',
			'concatenate_scripts',
			'compress_scripts',
			'compress_css',
		);

		// Various globals
		$various_globals = array(
			'shortcode_tags',
			'_wp_registered_nav_menus',
			'wp_meta_boxes',
			'wp_registered_sidebars',
			'wp_registered_widgets',
			'wp_registered_widget_controls',
			'wp_registered_widget_updates',
			'wp_widget_factory',
			'sidebars_widgets',
			'_wp_sidebars_widgets',
			'_wp_deprecated_widgets_callbacks',
			'_wp_additional_image_sizes',
			'wpsmiliestrans',
			'wp_smiliessearch',
			'wp_embed',
			'wp_oembed',
			'block_core_latest_posts_excerpt_length',
			'upgrading',
			'timestart',
			'comment_depth',
		);

		// Admin globals
		$admin_globals = array(
			'current_screen',
			'pagenow',
			'post_type',
			'menu',
			'submenu',
			'admin_page_hooks',
			'wp_admin_bar',
		);

		// Current user globals
		$current_user_globals = array(
			'current_user',
			'user_login',
			'userdata',
			'user_level',
			'user_ID',
			'user_email',
			'user_url',
			'user_identity',
			'login_grace_period',
		);

		// Main WP Query globals
		$main_wp_query_globals = array(
			'wp',
			'wp_query',
			'wp_the_query',
			'query_string',
			'posts',
			'post',
			'request',
			'single',
			'id',
		);

		// Multisite globals
		$multisite_globals = array(
			'super_admins',
			'table_prefix',
			'blog_id',
			'switched',
			'_wp_switched_stack',
		);

		// Locales & localization globals
		$locales_localization_globals = array(
			'wp_local_package',
			'locale',
			'wp_locale',
			'wp_locale_switcher',
			'text_direction',
			'l10n',
			'l10n_unloaded',
			'weekday',
			'weekday_initial',
			'weekday_abbrev',
			'month',
			'month_abbrev',
		);

		// REST API globals
		$rest_api_globals = array(
			'wp_rest_server',
			'wp_rest_additional_fields',
			'wp_rest_application_password_status',
			'wp_rest_auth_cookie',
		);

		// Browser detection globals
		$browser_detection_globals = array(
			'is_lynx',
			'is_gecko',
			'is_winIE',
			'is_macIE',
			'is_opera',
			'is_NS4',
			'is_safari',
			'is_chrome',
			'is_iphone',
			'is_IE',
			'is_edge',
		);

		// Web server detection globals
		$web_server_detection_globals = array(
			'is_nginx',
			'is_apache',
			'is_IIS',
			'is_iis7',
		);

		// Posts loop globals
		$posts_loop_globals = array(
			'post',
			'authordata',
			'currentday',
			'currentmonth',
			'page',
			'pages',
			'multipage',
			'numpages',
			'more',
		);

		// Comments loop globals
		$comments_loop_globals = array(
			'comment',
		);

		// Front-end globals
		$frontend_globals = array(
			'template'
		);

		// Non WP core globals

		// $non_wpcore_globals = array_keys( $GLOBALS );

		$all_globals = array_keys( $GLOBALS );

		$non_wpcore_globals = array();

		foreach ( $all_globals as $global ) {

			if ( ( !in_array( $global, $all_wpcore_globals ) ) && ( !in_array( $global, $php_super_globals ) ) ) {

				$non_wpcore_globals[] = $global;

			}

		}

		// Process output 

		$content = '';
		$output = '';

		if ( $type == 'single' ) {

			if ( $call == 'ajax' ) {

				$content .= $this->sd_html( 'field-content-start' );
				$content .= $this->sd_html( 'field-content-first','<div id="spinner-' . $name . '"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="global_id_' . $name . '" class="global__value ajax-value"></div>', 'full-width long-value' );
				$content .= $this->sd_html( 'field-content-end' );

				$data_atts = array(
					'name'		=> $name,
					'loaded'	=> 'no',
				);

				$output .= $this->sd_html( 'accordions-start-simple');
				$output .= $this->sd_html( 'accordion-head', $name, 'global__name', $data_atts, 'global-name-' . $name );
				$output .= $this->sd_html( 'accordion-body', $content );
				$output .= $this->sd_html( 'accordions-end' );

				return $output;

			} elseif ( $call == 'no_ajax' ) {

				global $$name;

				$output .= $this->sd_html( 'field-content-start', '', 'flex-direction-column' );
				$output .= $this->sd_html( 'field-content-first', '<strong>' . $name . '</strong>', 'full-width' );
				$output .= $this->sd_html( 'field-content-second', '<pre>' . print_r( $$name, true ) . '</pre>', 'full-width long-value' );
				$output .= $this->sd_html( 'field-content-end' );

				return $output;

			}

		} elseif ( $type == 'group' ) {

			foreach ( $$name as $global_name ) {

				if ( $call == 'ajax' ) {

					$content = $this->sd_html( 'field-content-start' );
					$content .= $this->sd_html( 'field-content-first','<div id="spinner-' . $global_name . '"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="global_id_' . $global_name . '" class="global__value ajax-value"></div>', 'full-width long-value' );
					$content .= $this->sd_html( 'field-content-end' );

					$data_atts = array(
						'name'		=> $global_name,
						'loaded'	=> 'no',
					);

					$output .= $this->sd_html( 'accordions-start-simple');
					$output .= $this->sd_html( 'accordion-head', $global_name, 'global__name', $data_atts, 'global-name-' . $global_name );
					$output .= $this->sd_html( 'accordion-body', $content );
					$output .= $this->sd_html( 'accordions-end' );

				} elseif ( $call == 'no_ajax' ) {

					global $global_name;

					$output .= $this->sd_html( 'field-content-start', '', 'flex-direction-column' );
					$output .= $this->sd_html( 'field-content-first', '<strong>' . $global_name . '</strong>', 'full-width' );
					$output .= $this->sd_html( 'field-content-second', '<pre>' . print_r( $global_name, true ) . '</pre>', 'full-width long-value' );
					$output .= $this->sd_html( 'field-content-end' );

				}

			}

			return $output;

		}

	}

	/**
	 * Get value of a global variable
	 *
	 * @link https://sharewebdesign.com/blog/wordpress-ajax-call/
	 * @since 1.3.0
	 */
	public function sd_global_value() {

		if ( isset( $_REQUEST ) ) {

			$global_name = $_REQUEST['global_name'];

			global $$global_name;

			$global_value = $$global_name;

			$global_value_type = gettype( $global_value );

			if  ( ( $global_value_type == 'array' ) || ( $global_value_type == 'object' ) ) {

				// JSON_UNESCAPED_SLASHES will remove backslashes used for escaping, e.g. \' will become just '. stripslashes will further remove backslashes using to escape backslashes, e.g. double \\ will become a single \. JSON_PRETTY_PRINT and <pre> beautifies the output on the HTML side.

				// echo '<pre>' . stripslashes( json_encode( $option_value, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) ) . '</pre>'; // Raw JSON beautified
				echo json_encode( $global_value ); // for JSON Tree viewer

			} elseif ( $global_value_type == 'boolean' ) {

				if ( $global_value ) {
					echo 'true';
				} else {
					echo 'false';
				}

			} elseif ( ( $global_value_type == 'integer' ) || ( $global_value_type == 'string' ) ) {

				echo '<pre>' . htmlspecialchars( $global_value ) . '</pre>'; // Raw JSON beautified

			} else {}

		} else {

			echo 'None. Please define global variable\'s name first.';

		}

		wp_die();

	}

	/**
	 * Get list of active plugins
	 *
	 * @since 1.0.0
	 */
	public function sd_active_plugins( $type = 'full', $return = 'raw' ) {

		$plugins = get_option( 'active_plugins' );

		sort( $plugins );

		 // returns array of directory / file names, e.g. plugin-slug/plugin-slug.php
		if ( $type == 'original' ) {

			switch ( $return ) {

				case 'raw';
					return $plugins;
					break;

				case 'print_r';
					return '<pre>' . print_r( $plugins, true ) . '</pre>';
					break;
			}

		 // returns array of directories, e.g. plugin-slug
		} elseif ( $type == 'directories' ) {

			$plugin_directories = array();

			foreach( $plugins as $plugin ) {

				$plugin_array = explode( "/", $plugin );
				$plugin_dir = $plugin_array[0];
				$plugin_directories[] = $plugin_dir;

			}

			switch ( $return ) {

				case 'raw';
					return $plugin_directories;
					break;

				case 'print_r';
					return '<pre>' . print_r( $plugin_directories, true ) . '</pre>';				
					break;

			}

		 // returns array of file names, e.g. plugin-slug.php
		} elseif ( $type == 'files' ) {

			$plugin_files = array();

			foreach( $plugins as $plugin ) {

				$plugin_array = explode( "/", $plugin );
				$plugin_file = $plugin_array[1];
				$plugin_files[] = $plugin_file;

			}

			switch ( $return ) {

				case 'raw';
					return $plugin_files;				
					break;

				case 'print_r';
					return '<pre>' . print_r( $plugin_files, true ) . '</pre>';				
					break;

			}

		// returns array of directory paths e, e.g. /home/user/apps/wp-root/wp-content/plugins/plugin-slug
		} elseif ( $type == 'paths' ) {

			$plugin_paths = array();

			foreach( $plugins as $plugin ) {

				$plugin_array = explode( "/", $plugin );
				$plugin_dirname = $plugin_array[0];
				$plugin_path = $_SERVER[ 'DOCUMENT_ROOT' ] . '/wp-content/plugins/' . $plugin_dirname;
				$plugin_paths[] = $plugin_path;

			}

			switch ( $return ) {

				case 'raw';
					return $plugin_paths;				
					break;

				case 'print_r';
					return '<pre>' . print_r( $plugin_paths, true ) . '</pre>';				
					break;

			}

		// returns array of directory paths e, e.g. /home/user/apps/wp-root/wp-content/plugins/plugin-slug/plugin-slug.php
		} elseif ( $type == 'file_paths' ) {

			$plugin_file_paths = array();

			foreach( $plugins as $plugin ) {

				$plugin_dir_file = $_SERVER[ 'DOCUMENT_ROOT' ] . '/wp-content/plugins/' . $plugin;
				$plugin_file_paths[] = $plugin_dir_file;

			}

			switch ( $return ) {

				case 'raw';
					return $plugin_file_paths;				
					break;

				case 'print_r';
					return '<pre>' . print_r( $plugin_file_paths, true ) . '</pre>';				
					break;

			}

		} else {}


	}

	/**
	 * Get active theme data
	 *
	 * @since 1.0.0
	 */
	public function sd_active_theme( $type = 'path' ) {

		$theme = wp_get_theme();

		if ( $type == 'path' ) {

			return $_SERVER[ 'DOCUMENT_ROOT' ] . '/wp-content/themes/' . $theme->get( 'TextDomain' );

		} elseif ( $type == 'text_domain' ) {

			return $theme->get( 'TextDomain' );

		} elseif ( $type == 'name' ) {

			return $theme->get( 'Name' );

		} elseif ( $type == 'version' ) {

			return $theme->get( 'Version' );

		} elseif ( $type == 'version_trimmed' ) {

			// Remove dot, slash and underscore from version
			$version = str_replace( ".", "", $theme->get( 'Version' ) );
			$version = str_replace( "-", "", $version );
			$version = str_replace( "_", "", $version );

			return $version;

		} else {}

	}

	/** 
	 * Get hooks from active plugins and theme
	 *
	 * @param string $type Accepts 'active_plugins', 'active_theme'
	 * @since 1.0.0
	 */
	public function sd_hooks() {

		if ( isset( $_REQUEST ) ) {

			$type = $_REQUEST['type'];

			// This sd_hooks method can only works if shell_exec is enabled in PHP, so, check first.
			if ( $this->is_shell_exec_enabled() ) {

				$base_dir_path = wp_upload_dir()['basedir'] . '/' . $this->plugin_name;
				$hooks_base_dir_path = $base_dir_path . '/hooks';
				$plugins_hooks_dir_path = $hooks_base_dir_path . '/plugins';
				$themes_hooks_dir_path = $hooks_base_dir_path . '/themes';

				// Create base directories in Uploads folder if they don't exist

				if ( !is_dir( $base_dir_path ) ) {

					mkdir( $base_dir_path );

				}

				if ( !is_dir( $hooks_base_dir_path ) ) {

					mkdir( $hooks_base_dir_path );

				} else {}

				if ( !is_dir( $plugins_hooks_dir_path ) ) {

					mkdir( $plugins_hooks_dir_path );

				} else {}

				if ( !is_dir( $themes_hooks_dir_path ) ) {

					mkdir( $themes_hooks_dir_path );

				} else {}

				// Generate hooks for active plugins

				if ( $type == 'active_plugins' ) {

					$active_plugin_dirfile_names = $this->sd_active_plugins( 'original', 'raw' );

					$plugin_file_editor_base_url = '/wp-admin/plugin-editor.php?file=';

					$output = $this->sd_html( 'accordions-start' );

					// $plugins_data = array();

					foreach ( $active_plugin_dirfile_names as $dirfile_name ) {

						// Get plugin info, looking for version number
						$this_plugin_path = plugin_dir_path( __DIR__ );
						$plugins_path = str_replace( $this->plugin_name.'/', "", $this_plugin_path );
						$plugin_file_path = $plugins_path . $dirfile_name;
						$plugins_data = get_plugin_data( $plugin_file_path );

						// Remove dot, slash and underscore from version
						$plugin_version = str_replace( ".", "", $plugins_data['Version'] );
						$plugin_version = str_replace( "-", "", $plugin_version );
						$plugin_version = str_replace( "_", "", $plugin_version );

						// Prepare directory name for plugins hooks output files. Each version has a different folder.
						$dirfile_name_array = explode( "/", $dirfile_name);
						$directory_name = $dirfile_name_array[0];
						$plugin_hooks_path = $plugins_hooks_dir_path . '/' . $directory_name . '-' . $plugin_version;

						// Prepare shell command to generate hooks for the plugin
						// Go to plugins root folder before executing wp-hooks-generator which is symlink to /johnbillion/wp-hooks-generator/src/generate.php. Make sure generator is executable. The additional '2>&1' is to output error response as well, without which, blank response is returned in case of error

						$shell_command = 'cd ' . plugin_dir_path( __DIR__ ) . ' && chmod +x ./vendor/johnbillion/wp-hooks-generator/src/generate.php && ./vendor/johnbillion/wp-hooks-generator/src/generate.php --input=' . $plugins_path . $directory_name . ' --output=' . $plugins_hooks_dir_path . '/' . $directory_name . '-' . $plugin_version . ' 2>&1';

						$shell_output = '';

						// If no directory exist yet, create it
						if ( !is_dir( $plugin_hooks_path ) ) {

							mkdir( $plugin_hooks_path );

						} else {}

						// If no action hooks json have been generated for the plugin, generate it
						if ( !is_file( $plugins_hooks_dir_path . '/' . $directory_name . '-' . $plugin_version . '/actions.json' ) ) {

							$shell_output = shell_exec( $shell_command );

							// delay execution of wp_remote_get by 0.25 seconds, so file writing process can be completed properly first.
							sleep(0.25); 

						}

						// If hooks generation failed, output error message

						if ( !is_file( $plugins_hooks_dir_path . '/' . $directory_name . '-' . $plugin_version . '/actions.json' ) ) {

							$output .= $directory_name . '<pre>' . $shell_output . '</pre>';

						}

						$response = wp_remote_get( wp_upload_dir()['baseurl'] . '/' . $this->plugin_name . '/hooks/plugins/' . $directory_name . '-' . $plugin_version . '/actions.json' );
						$action_hooks_json = wp_remote_retrieve_body( $response );

						$response = wp_remote_get(  wp_upload_dir()['baseurl'] . '/' . $this->plugin_name . '/hooks/plugins/' . $directory_name . '-' . $plugin_version . '/filters.json'  );
						$filter_hooks_json = wp_remote_retrieve_body( $response );

						$action_hooks = json_decode( $action_hooks_json, TRUE )['hooks']; // convert into array
						$filter_hooks = json_decode( $filter_hooks_json, TRUE )['hooks']; // convert into array

						// Output action hooks

						$output .= '<h4 class="mc-collapsible-title">' . $plugins_data['Name'] . ' v' . $plugins_data['Version'] . '</h4>';

						if ( !empty( $action_hooks ) ) {
							$action_hooks_count = count( $action_hooks );
						} else {
							$action_hooks_count = 0;
						}

						$output .= $this->sd_html( 'accordion-head', 'Action Hooks (' . $action_hooks_count . ')' );

						$hooks_output = '';

						foreach ( $action_hooks as $hook ) {

							$plugin_file_editor_url = $plugin_file_editor_base_url . urlencode( $directory_name .'/'. $hook['file'] ) .'&plugin='. urlencode( $dirfile_name );

							$hooks_output .= $this->sd_html( 'field-content-start' );
							$hooks_output .= $this->sd_html( 'field-content-first', $hook['name'] . ' <br /><span><a href="' . $plugin_file_editor_url . '" target="_blank">' . $hook['file'] . '</a></span>' );
							$hooks_output .= $this->sd_html( 'field-content-second', $hook['doc']['description'] );
							$hooks_output .= $this->sd_html( 'field-content-end' );

						}

						if ( empty( $hooks_output ) ) {
							$hooks_output .= $this->sd_html( 'field-content-start' );
							$hooks_output .= $this->sd_html( 'field-content-first', 'There are no action hooks defined.', 'full-width' );
							$hooks_output .= $this->sd_html( 'field-content-end' );
						}

						$output .= $this->sd_html( 'accordion-body', $hooks_output );

						// Output filter hooks

						if ( !empty( $filter_hooks ) ) {
							$filter_hooks_count = count( $filter_hooks );
						} else {
							$filter_hooks_count = 0;
						}

						$output .= $this->sd_html( 'accordion-head', 'Filter Hooks (' . $filter_hooks_count . ')' );

						$hooks_output = '';

						foreach ( $filter_hooks as $hook ) {

							$plugin_file_editor_url = $plugin_file_editor_base_url . urlencode( $directory_name .'/'. $hook['file'] ) .'&plugin='. urlencode( $dirfile_name );

							$hooks_output .= $this->sd_html( 'field-content-start' );
							$hooks_output .= $this->sd_html( 'field-content-first', $hook['name'] . ' <br /><span><a href="' . $plugin_file_editor_url . '" target="_blank">' . $hook['file'] . '</a></span>' );
							$hooks_output .= $this->sd_html( 'field-content-second', $hook['doc']['description'] );
							$hooks_output .= $this->sd_html( 'field-content-end' );

						}

						if ( empty( $hooks_output ) ) {
							$hooks_output .= $this->sd_html( 'field-content-start' );
							$hooks_output .= $this->sd_html( 'field-content-first', 'There are no filter hooks defined.', 'full-width' );
							$hooks_output .= $this->sd_html( 'field-content-end' );
						}

						$output .= $this->sd_html( 'accordion-body', $hooks_output );

					}

					$output .= $this->sd_html( 'accordions-end' );

					echo $output;

				// Generate hooks for active theme

				} elseif ( $type == 'active_theme' ) {

					$theme_path = get_template_directory(); // absolute path to theme directory, without trailing slash
					$theme_path_array = explode( "/", $theme_path );
					$theme_dirname = end( $theme_path_array );
					$theme_version = $this->sd_active_theme( 'version_trimmed' );

					// Get theme hooks by first creating directory for hooks output files

					$active_theme_hooks_path = $themes_hooks_dir_path . '/' . $theme_dirname . '-' . $theme_version;

					$theme_file_editor_base_url = '/wp-admin/theme-editor.php?file=';

					$output = $this->sd_html( 'accordions-start' );

					// Go to plugins root folder before executing wp-hooks-generator which is symlink to /johnbillion/wp-hooks-generator/src/generate.php. The additional '2>&1' is to output error response as well, without which, blank response is returned in case of error

					$shell_command = 'cd ' . plugin_dir_path( __DIR__ ) . ' && chmod +x ./vendor/johnbillion/wp-hooks-generator/src/generate.php && ./vendor/johnbillion/wp-hooks-generator/src/generate.php --input=' . $theme_path . ' --output=' . $themes_hooks_dir_path . '/' . $theme_dirname . '-' . $theme_version . ' 2>&1';

					$shell_output = '';

					// If no directory exist, create it and generate hooks files in it

					if ( !is_dir( $active_theme_hooks_path ) ) {

						// Create directory
						mkdir( $active_theme_hooks_path );

					} else {}

					// If no action hooks json have been generated for the theme, generate it

					if ( !is_file( $themes_hooks_dir_path . '/' . $theme_dirname . '-' . $theme_version . '/actions.json' ) ) {

						// Generate hooks
						$shell_output = shell_exec( $shell_command );

						// delay execution of wp_remote_get by 0.25 seconds, so file writing process can be completed properly first.
						sleep(0.25); 

					}

					// If hooks generation failed, output error message

					if ( !is_file( $themes_hooks_dir_path . '/' . $theme_dirname . '-' . $theme_version . '/actions.json' ) ) {

						$output .= $theme_dirname . '<pre>' . $shell_output . '</pre>';

					}

					// Get json of action and filter hooks

					$response = wp_remote_get( wp_upload_dir()['baseurl'] . '/' . $this->plugin_name . '/hooks/themes/' . $theme_dirname . '-' . $theme_version . '/actions.json' );
					$action_hooks_json = wp_remote_retrieve_body( $response );

					$response = wp_remote_get( wp_upload_dir()['baseurl'] . '/' . $this->plugin_name . '/hooks/themes/' . $theme_dirname . '-' . $theme_version . '/filters.json' );
					$filter_hooks_json = wp_remote_retrieve_body( $response );

					$action_hooks = json_decode( $action_hooks_json, TRUE )['hooks']; // convert into array
					$filter_hooks = json_decode( $filter_hooks_json, TRUE )['hooks']; // convert into array

					// Output action hooks

					$output .= '<h4 class="mc-collapsible-title">' . $this->sd_active_theme( 'name' ) . ' ' . $this->sd_active_theme( 'version' ) . '</h4>';

					if ( !empty( $action_hooks ) ) {
						$action_hooks_count = count( $action_hooks );
					} else {
						$action_hooks_count = 0;
					}

					$output .= $this->sd_html( 'accordion-head', 'Action Hooks (' . $action_hooks_count . ')' );

					$hooks_output = '';

					foreach ( $action_hooks as $hook ) {

						$theme_file_editor_url = $theme_file_editor_base_url . $hook['file'];

						$hooks_output .= $this->sd_html( 'field-content-start' );
						$hooks_output .= $this->sd_html( 'field-content-first', $hook['name'] . ' <br /><span><a href="' . $theme_file_editor_url . '" target="_blank">' . $hook['file'] . '</a></span>' );
						$hooks_output .= $this->sd_html( 'field-content-second', $hook['doc']['description'], 'long-value' );
						$hooks_output .= $this->sd_html( 'field-content-end' );

					}

					if ( empty( $hooks_output ) ) {
							$hooks_output .= $this->sd_html( 'field-content-start' );
							$hooks_output .= $this->sd_html( 'field-content-first', 'There are no action hooks defined.', 'full-width' );
							$hooks_output .= $this->sd_html( 'field-content-end' );
					}

					$output .= $this->sd_html( 'accordion-body', $hooks_output );

					if ( !empty( $filter_hooks ) ) {
						$filter_hooks_count = count( $filter_hooks );
					} else {
						$filter_hooks_count = 0;
					}

					// Output filter hooks

					$output .= $this->sd_html( 'accordion-head', 'Filter Hooks (' . $filter_hooks_count . ')' );

					$hooks_output = '';

					foreach ( $filter_hooks as $hook ) {

						$theme_file_editor_url = $theme_file_editor_base_url . $hook['file'];

						$hooks_output .= $this->sd_html( 'field-content-start' );
						$hooks_output .= $this->sd_html( 'field-content-first', $hook['name'] . ' <br /><span><a href="' . $theme_file_editor_url . '" target="_blank">' . $hook['file'] . '</a></span>' );
						$hooks_output .= $this->sd_html( 'field-content-second', $hook['doc']['description'] );
						$hooks_output .= $this->sd_html( 'field-content-end' );

					}

					if ( empty( $hooks_output ) ) {
						$hooks_output .= $this->sd_html( 'field-content-start' );
						$hooks_output .= $this->sd_html( 'field-content-first', 'There are no filter hooks defined.', 'full-width' );
						$hooks_output .= $this->sd_html( 'field-content-end' );
					}

					$output .= $this->sd_html( 'accordion-body', $hooks_output );

					$output .= $this->sd_html( 'accordions-end' );

					echo $output;

				} else {}

			} else {

				$output = 'Undetectable. Please enable \'shell_exec\' function in PHP first.';

				echo $output;

			}

		}
		
	}


	/** Get WordPress constants
	 * 
	 * @since 1.0.0
	 */
	public function sd_constants() {

		if ( isset( $_REQUEST ) ) {

			$type = $_REQUEST['type'];

			$wp_constants = array(

				'general'	=> array(
					'title'		=> 'General',
					'constants'	=> array(
						array(
							'name'		=> 'AUTOSAVE_INTERVAL',
							'description'	=> 'Defines an interval, in which WordPress should do an autosave.',
							'value'			=> 'Time in seconds (Default: 60)',
						),
						array(
							'name'		=> 'CORE_UPGRADE_SKIP_NEW_BUNDLED',
							'description'	=> 'Allows you to skip new bundles files like plugins and/or themes on upgrades.',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'DISABLE_WP_CRON',
							'description'	=> 'Deactivates the cron function of WordPress.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'EMPTY_TRASH_DAYS',
							'description'	=> 'Controls the number of days before WordPress permanently deletes posts, pages, attachments, and comments, from the trash bin.',
							'value'			=> 'time in days (Default: 30)',
						),
						array(
							'name'		=> 'IMAGE_EDIT_OVERWRITE',
							'description'	=> 'Allows WordPress to override an image after editing or to save the image as a copy.',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'MEDIA_TRASH',
							'description'	=> '(De)activates the trash bin function for media.',
							'value'			=> 'true|false (Default: false)',
						),
						array(
							'name'		=> 'WPLANG',
							'description'	=> 'Defines the language which WordPress should use.',
							'value'			=> 'e.g. en_US | de_DE',
						),
						array(
							'name'		=> 'WP_DEFAULT_THEME',
							'description'	=> 'Defines a default theme for new sites, also used as fallback for a broken theme.',
							'value'			=> 'template name (Default: twentyeleven)',
						),
						array(
							'name'		=> 'WP_CRON_LOCK_TIMEOUT',
							'description'	=> 'Defines a period of time in which only one cronjob will be fired. Since WordPress 3.3.',
							'value'			=> 'time in seconds (Default: 60)',
						),
						array(
							'name'		=> 'WP_MAIL_INTERVAL',
							'description'	=> 'Defines a period of time in which only one mail request can be done.',
							'value'			=> 'time in seconds (Default: 300)',
						),
						array(
							'name'		=> 'WP_POST_REVISIONS',
							'description'	=> '(De)activates the revision function for posts. A number greater than 0 defines the number of revisions for one post.',
							'value'			=> 'true|false|number (Default: true)',
						),
						array(
							'name'		=> 'WP_MAX_MEMORY_LIMIT',
							'description'	=> 'Allows you to change the maximum memory limit for some WordPress functions.',
							'value'			=> '(Default: 256M)',
						),
						array(
							'name'		=> 'WP_MEMORY_LIMIT',
							'description'	=> 'Defines the memory limit for WordPress.',
							'value'			=> '(Default: 32M, for Multisite 64M)',
						),
						array(
							'name'		=> 'WP_AUTO_UPDATE_CORE',
							'description'	=> 'Manages core auto-updates.',
							'value'			=> 'true | false | minor',
						),
						array(
							'name'		=> 'AUTOMATIC_UPDATER_DISABLED',
							'description'	=> 'Disables the auto-update engine introduced in version 3.7.',
							'value'			=> 'true | valse',
						),
						array(
							'name'		=> 'REST_API_VERSION',
							'description'	=> 'Version of REST API in WordPress core.',
							'value'			=> '',
						),
					)
				),

				'status'	=> array(
					'title'		=> 'Status',
					'constants'	=> array(
						array(
							'name'		=> 'APP_REQUEST',
							'description'	=> 'Will be defined if it’s an Atom Publishing Protocol request.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'COMMENTS_TEMPLATE',
							'description'	=> 'Will be defined if the comments template is loaded.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'DOING_AJAX',
							'description'	=> 'Will be defined if it’s an AJAX request.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'DOING_AUTOSAVE',
							'description'	=> 'Will be defined if WordPress is doing an autosave for posts.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'DOING_CRON',
							'description'	=> 'Will be defined if WordPress is doing a cronjob.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'IFRAME_REQUEST',
							'description'	=> 'Will be defined if it’s an inlineframe request.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'IS_PROFILE_PAGE',
							'description'	=> 'Will be defined if a user change his profile settings.',
							'value'			=> 'tre',
						),
						array(
							'name'		=> 'SHORTINIT',
							'description'	=> 'Can be defined to load only the half of WordPress.',
							'value'			=> 'true',
						),
						array(
							'name'	=> 'WP_ADMIN',
							'description'	=> 'Will be defined if it’s a request in backend of WordPress.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'WP_BLOG_ADMIN',
							'description'	=> 'Will be defined if it’s a request in /wp-admin/.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'WP_IMPORTING',
							'description'	=> 'Will be defined if WordPress is importing data.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'WP_INSTALLING',
							'description'	=> 'Will be defined on an new installation or on an upgrade.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'WP_INSTALLING_NETWORK',
							'description'	=> 'Will be defined if it’s a request in network admin or on installing a network. Since WordPress 3.3, previous WP_NETWORK_ADMIN_PAGE.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'WP_LOAD_IMPORTERS',
							'description'	=> 'Will be defined if you visit the importer overview (Tools → Importer).',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'WP_NETWORK_ADMIN',
							'description'	=> 'Will be defined if it’s a request in /wp-admin/network/.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'WP_REPAIRING',
							'description'	=> 'Will be defined if it’s a request to /wp-admin/maint/repair.php.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'WP_SETUP_CONFIG',
							'description'	=> 'Will be defined if WordPress will be installed or configured.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'WP_UNINSTALL_PLUGIN',
							'description'	=> 'Will be defined if a plugin wil be uninstalled (for uninstall.php).',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'WP_USER_ADMIN',
							'description'	=> 'Will be defined if it’s a request in /wp-admin/user/.',
							'value'			=> 'values',
						),
						array(
							'name'		=> 'XMLRPC_REQUEST',
							'description'	=> 'Will be defined if it’s a request over the XML-RPC API.',
							'value'			=> 'true',
						),
					)
				),

				'database'	=> array(
					'title'		=> 'Database',
					'constants'	=> array(
						array(
							'name'		=> 'DB_CHARSET',
							'description'	=> 'Defines the database charset.',
							'value'			=> 'See MySQL docs (Default: utf8)',
						),
						array(
							'name'		=> 'DB_COLLATE',
							'description'	=> 'Defines the database collation.',
							'value'			=> 'See MySQL docs (Default: utf8_general_ci)',
						),
						array(
							'name'		=> 'DB_HOST',
							'description'	=> 'Defines the database host.',
							'value'			=> 'IP address, domain and/or port (Default: localhost)',
						),
						array(
							'name'		=> 'DB_NAME',
							'description'	=> 'Defines the database name.',
							'value'			=> '',
						),
						array(
							'name'		=> 'DB_USER',
							'description'	=> 'Defines the database user.',
							'value'			=> '',
						),
						array(
							'name'		=> 'DB_PASSWORD',
							'description'	=> 'Defines the database password.',
							'value'			=> '',
						),
						array(
							'name'		=> 'WP_ALLOW_REPAIR',
							'description'	=> 'Allows you to automatically repair and optimize the database tables via /wp-admin/maint/repair.php.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'CUSTOM_USER_TABLE',
							'description'	=> 'Allows you to define a custom user table.',
							'value'			=> 'table name',
						),
						array(
							'name'		=> 'CUSTOM_USER_META_TABLE',
							'description'	=> 'Allows you to define a custom user meta table.',
							'value'			=> 'table name',
						),
					)
				),

				'paths_dirs_links'	=> array(
					'title'		=> 'Paths, Directories & Links',
					'constants'	=> array(
						array(
							'name'		=> 'ABSPATH',
							'description'	=> 'Absolute path to the WordPress root dir.',
							'value'			=> 'path to wp-load.php',
						),
						array(
							'name'		=> 'WPINC',
							'description'	=> 'Relative path to the /wp-includes/. You can’t change it.',
							'value'			=> 'wp-includes',
						),
						array(
							'name'		=> 'WP_LANG_DIR',
							'description'	=> 'Absolute path to the folder with language files.',
							'value'			=> 'WP_CONTENT_DIR /languages or WP_CONTENT_DIR WPINC /languages',
						),
						array(
							'name'		=> 'WP_PLUGIN_DIR',
							'description'	=> 'Absolute path to the plugins dir.',
							'value'			=> 'WP_CONTENT_DIR /plugins',
						),
						array(
							'name'		=> 'WP_PLUGIN_URL',
							'description'	=> 'URL to the plugins dir.',
							'value'			=> 'WP_CONTENT_URL /plugins',
						),
						array(
							'name'		=> 'WP_CONTENT_DIR',
							'description'	=> 'Absolute path to thewp-content dir.',
							'value'			=> 'ABSPATH /wp-content',
						),
						array(
							'name'		=> 'WP_CONTENT_URL',
							'description'	=> 'URL to the wp-content dir.',
							'value'			=> '{Site URL}/wp-content',
						),
						array(
							'name'		=> 'WP_HOME',
							'description'	=> 'Home URL of your WordPress.',
							'value'			=> '',
						),
						array(
							'name'		=> 'WP_SITEURL',
							'description'	=> 'URL to the WordPress root dir.',
							'value'			=> 'values',
						),
						array(
							'name'		=> 'WP_TEMP_DIR',
							'description'	=> 'Absolute path to a dir, where temporary files can be saved.',
							'value'			=> '',
						),
						array(
							'name'		=> 'WPMU_PLUGIN_DIR',
							'description'	=> 'Absolute path to the must use plugin dir.',
							'value'			=> 'WP_CONTENT_DIR /mu-plugins',
						),
						array(
							'name'		=> 'WPMU_PLUGIN_URL',
							'description'	=> 'URL to the must use plugin dir.',
							'value'			=> 'WP_CONTENT_URL /mu-plugins',
						),
						array(
							'name'		=> 'PLUGINDIR',
							'description'	=> 'Allows for the plugins directory to be moved from the default location.',
							'value'			=> 'wp-content/plugins ',
						),
						array(
							'name'		=> 'MUPLUGINDIR',
							'description'	=> 'Allows for the mu-plugins directory to be moved from the default location.',
							'value'			=> 'wp-content/mu-plugins',
						),
					)
				),

				'file_system_connections'	=> array(
					'title'		=> 'File System & Connections',
					'constants'	=> array(
						array(
							'name'		=> 'FS_CHMOD_DIR',
							'description'	=> 'Defines the read and write permissions for directories.',
							'value'			=> 'See PHP handbook (Default: 0755)',
						),
						array(
							'name'		=> 'FS_CHMOD_FILE',
							'description'	=> 'Defines the read and write permissions for files.',
							'value'			=> 'ee PHP handbook (Default: 0644)',
						),
						array(
							'name'		=> 'FS_CONNECT_TIMEOUT',
							'description'	=> 'Defines a timeout for building a connection.',
							'value'			=> 'time in seconds (Default: 30)',
						),
						array(
							'name'		=> 'FS_METHOD',
							'description'	=> 'Defines the method to connect to the filesystem.',
							'value'			=> 'direct|ssh|ftpext|ftpsockets',
						),
						array(
							'name'		=> 'FS_TIMEOUT',
							'description'	=> 'Defines a timeout after a connection has been lost.',
							'value'			=> 'time in seconds (Default: 30)',
						),
						array(
							'name'		=> 'FTP_BASE',
							'description'	=> 'Path to the WordPress root dir.',
							'value'			=> 'ABSPATH',
						),
						array(
							'name'		=> 'FTP_CONTENT_DIR',
							'description'	=> 'Path to the /wp-content/ dir.',
							'value'			=> 'WP_CONTENT_DIR',
						),
						array(
							'name'		=> 'FTP_HOST',
							'description'	=> 'Defines the FTP host.',
							'value'			=> 'IP Adresse, Domain und/oder Port',
						),
						array(
							'name'		=> 'FTP_LANG_DIR',
							'description'	=> 'Path to the folder with language files.',
							'value'			=> 'WP_LANG_DIR',
						),
						array(
							'name'		=> 'FTP_PASS',
							'description'	=> 'Defines the FTP password.',
							'value'			=> '',
						),
						array(
							'name'		=> 'FTP_PLUGIN_DIR',
							'description'	=> 'Path to the plugin dir.',
							'value'			=> 'WP_PLUGIN_DIR',
						),
						array(
							'name'		=> 'FTP_PRIKEY',
							'description'	=> 'Defines a private key for SSH.',
							'value'			=> '',
						),
						array(
							'name'		=> 'FTP_PUBKEY',
							'description'	=> 'Defines a public key for SSH.',
							'value'			=> '',
						),
						array(
							'name'		=> 'FTP_SSH',
							'description'	=> '(De)activates SSH.',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'FTP_SSL',
							'description'	=> '(De)activates SSL.',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'FTP_USER',
							'description'	=> 'Defines the FTP username.',
							'value'			=> '',
						),
						array(
							'name'		=> 'WP_PROXY_BYPASS_HOSTS',
							'description'	=> 'Allows you to define some adresses which shouldn’t be passed through a proxy.',
							'value'			=> 'www.example.com, *.example.org',
						),
						array(
							'name'		=> 'WP_PROXY_HOST',
							'description'	=> 'Defines the proxy address.',
							'value'			=> 'IP address or domain',
						),
						array(
							'name'		=> 'WP_PROXY_PASSWORD',
							'description'	=> 'Defines the proxy password.',
							'value'			=> '',
						),
						array(
							'name'		=> 'WP_PROXY_PORT',
							'description'	=> 'Defines the proxy port.',
							'value'			=> '',
						),
						array(
							'name'		=> 'WP_PROXY_USERNAME',
							'description'	=> 'Defines the proxy username.',
							'value'			=> '',
						),
						array(
							'name'		=> 'WP_HTTP_BLOCK_EXTERNAL',
							'description'	=> 'Allows you to block external request.',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'WP_ACCESSIBLE_HOSTS',
							'description'	=> 'If WP_HTTP_BLOCK_EXTERNAL is defined you can add hosts which shouldn’t be blocked.',
							'value'			=> 'www.example.com, *.example.org',
						),
					)
				),

				'multisite'	=> array(
					'title'		=> 'WordPress Multisite',
					'constants'	=> array(
						array(
							'name'		=> 'ALLOW_SUBDIRECTORY_INSTALL',
							'description'	=> 'Allows you to install Multisite in a subdirectory.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'BLOGUPLOADDIR',
							'description'	=> 'Absolute path to the site specific upload dir.',
							'value'			=> 'WP_CONTENT_DIR /blogs.dir/{Blog ID}/files/',
						),
						array(
							'name'		=> 'BLOG_ID_CURRENT_SITE',
							'description'	=> 'Blog ID of the main site.',
							'value'			=> '1',
						),
						array(
							'name'		=> 'DOMAIN_CURRENT_SITE',
							'description'	=> 'Domain of the main site.',
							'value'			=> 'domain',
						),
						array(
							'name'		=> 'DIEONDBERROR',
							'description'	=> 'When defined database errors will be displayed on screen.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'ERRORLOGFILE',
							'description'	=> 'When defined database erros will be logged into a file.',
							'value'			=> 'absolute path to a writeable file',
						),
						array(
							'name'		=> 'MULTISITE',
							'description'	=> 'Will be defined if Multisite is used.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'NOBLOGREDIRECT',
							'description'	=> 'Defines an URL of a site on which WordPress should redirect, if registration is closed or a site doesn’t exists.',
							'value'			=> '%siteurl% for mainsite or custom URL',
						),
						array(
							'name'		=> 'PATH_CURRENT_SITE',
							'description'	=> 'Path to the main site.',
							'value'			=> '',
						),
						array(
							'name'		=> 'UPLOADBLOGSDIR',
							'description'	=> 'Path to the upload base dir, relative to ABSPATH.',
							'value'			=> 'wp-content/blogs.dir',
						),
						array(
							'name'		=> 'SITE_ID_CURRENT_SITE',
							'description'	=> 'Network ID of the main site.',
							'value'			=> '1',
						),
						array(
							'name'		=> 'SUBDOMAIN_INSTALL',
							'description'	=> 'Defines if it’s a subdomain install or not.',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'SUNRISE',
							'description'	=> 'When defined WordPres will load the /wp-content/sunrise.php file.',
							'value'			=> 'true',
						),
						array(
							'name'		=> 'UPLOADS',
							'description'	=> 'Path to site specific upload dir, relative to ABSPATH.',
							'value'			=> 'UPLOADBLOGSDIR /{blogid}/files/',
						),
						array(
							'name'		=> 'WPMU_ACCEL_REDIRECT',
							'description'	=> '(De)activates support for X-Sendfile Header.',
							'value'			=> 'true|false (Default: false)',
						),
						array(
							'name'		=> 'WPMU_SENDFILE',
							'description'	=> '(De)activates support for X-Accel-Redirect Header.',
							'value'			=> 'true|false (Default: false)',
						),
						array(
							'name'		=> 'WP_ALLOW_MULTISITE',
							'description'	=> 'When defined the multisite function will be accessible (Tools → Network Setup).',
							'value'			=> 'true',
						),
					)
				),

				'cache_compression'	=> array(
					'title'		=> 'Cache & Compression',
					'constants'	=> array(
						array(
							'name'		=> 'WP_CACHE',
							'description'	=> 'When defined WordPres will load the /wp-content/advanced-cache.php file.',
							'value'			=> 'true|false (Default: false)',
						),
						array(
							'name'		=> 'WP_CACHE_KEY_SALT',
							'description'	=> 'Secret key.',
							'value'			=> '',
						),
						array(
							'name'		=> 'COMPRESS_CSS',
							'description'	=> '(De)activates the compressing of stylesheets.',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'COMPRESS_SCRIPTS',
							'description'	=> '(De)activates the compressing of Javascript files.',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'CONCATENATE_SCRIPTS',
							'description'	=> '(De)activates the consolidation of Javascript or CSS files before compressing.',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'ENFORCE_GZIP',
							'description'	=> '(De)activates gzip output.',
							'value'			=> 'true|false',
						),
					)
				),

				'themes'	=> array(
					'title'		=> 'Theme',
					'constants'	=> array(
						array(
							'name'	=> 'BACKGROUND_IMAGE',
							'description'	=> 'Defines the default background image.',
							'value'			=> '',
						),
						array(
							'name'	=> 'HEADER_IMAGE',
							'description'	=> 'Defines the default header image.',
							'value'			=> '',
						),
						array(
							'name'	=> 'HEADER_IMAGE_HEIGHT',
							'description'	=> 'Specifies the height of the header image.',
							'value'			=> '',
						),
						array(
							'name'	=> 'HEADER_IMAGE_WIDTH',
							'description'	=> 'Defines the width of the header image.',
							'value'			=> '',
						),
						array(
							'name'	=> 'HEADER_TEXTCOLOR',
							'description'	=> 'Determines the color of the header text.',
							'value'			=> '',
						),
						array(
							'name'	=> 'NO_HEADER_TEXT',
							'description'	=> 'Enables or disables support for header text.',
							'value'			=> 'true|false',
						),
						array(
							'name'	=> 'STYLESHEETPATH',
							'description'	=> 'Specifies the absolute path to the theme folder, which is the folder where the current parent or child theme\'s stylesheet file is located. It does not contain a trailing slash. See also. get_stylesheet_directory().',
							'value'			=> '',
						),
						array(
							'name'	=> 'TEMPLATEPATH',
							'description'	=> 'Specifies an absolute path from the root of the site to the current theme (parent, not child). Does not contain a slash at the end. See "Theme Loading". get_template_directory().',
							'value'			=> 'values',
						),
						array(
							'name'	=> 'WP_USE_THEMES',
							'description'	=> 'Enables or disables theme loading.',
							'value'			=> 'true|false',
						),
					)
				),

				'blocks'	=> array(
					'title'		=> 'Blocks',
					'constants'	=> array(
						array(
							'name'	=> 'WP_TEMPLATE_PART_AREA_HEADER',
							'description'	=> 'Constant for supported wp_template_part_area taxonomy (related to blocks)',
							'value'			=> 'header',
						),
						array(
							'name'	=> 'WP_TEMPLATE_PART_AREA_FOOTER',
							'description'	=> 'Constant for supported wp_template_part_area taxonomy (related to blocks)',
							'value'			=> 'footer',
						),
						array(
							'name'	=> 'WP_TEMPLATE_PART_AREA_SIDEBAR',
							'description'	=> 'Constant for supported wp_template_part_area taxonomy (related to blocks)',
							'value'			=> 'sidebar',
						),
						array(
							'name'	=> 'WP_TEMPLATE_PART_AREA_UNCATEGORIZED',
							'description'	=> 'Constant for supported wp_template_part_area taxonomy (related to blocks)',
							'value'			=> 'uncategorized',
						),
					),
				),

				'debug'	=> array(
					'title'		=> 'Debug',
					'constants'	=> array(
						array(
							'name'		=> 'SAVEQUERIES',
							'description'	=> '(De)activates the saving of database queries in an array ($wpdb->queries).',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'SCRIPT_DEBUG',
							'description'	=> '(De)activates the loading of compressed Javascript and CSS files.',
							'value'			=> 'true|false',
						),
						array(
							'name'		=> 'WP_DEBUG',
							'description'	=> '(De)activates the debug mode in WordPress.',
							'value'			=> 'true|false (Default: false)',
						),
						array(
							'name'		=> 'WP_DEBUG_DISPLAY',
							'description'	=> '(De)activates the display of errors on the screen.',
							'value'			=> 'true|false|null (Default: true)',
						),
						array(
							'name'		=> 'WP_DEBUG_LOG',
							'description'	=> '(De)activates the writing of errors to the /wp-content/debug.log file.',
							'value'			=> 'true|false (Default: false)',
						),
						array(
							'name'	=> 'WP_LOCAL_DEV',
							'description'	=> 'The default constant is not used anywhere in the core, but is intended as a general standard to enable, for example, some additional functionality when this constant is defined.',
							'value'			=> 'true',
						),
						array(
							'name'	=> 'WP_START_TIMESTAMP',
							'description'	=> 'WP code start time stamp - set as microtime( true ) at the moment of early file connection wp-includes/default-constants.php. Introduced in WP 5.2.',
							'value'			=> '',
						),
						array(
							'name'	=> 'WP_TESTS_CONFIG_FILE_PATH',
							'description'	=> 'Location of the wp-tests-config.php file which is used for PHPUnit tests.',
							'value'			=> '',
						),
					)
				),

				'security_cookies'	=> array(
					'title'		=> 'Security & Cookies',
					'constants'	=> array(
						array(
							'name'	=> 'ADMIN_COOKIE_PATH',
							'description'	=> 'Path to directory /wp-admin/.',
							'value'			=> 'SITECOOKIEPATH wp-admin Or for Multisite subdirectory ``SITECOOKIEPATH```',
						),
						array(
							'name'	=> 'ALLOW_UNFILTERED_UPLOADS',
							'description'	=> 'Allows unfiltered uploads by admins.',
							'value'			=> 'true',
						),
						array(
							'name'	=> 'AUTH_COOKIE',
							'description'	=> 'Cookie name for the authentication.',
							'value'			=> 'wordpress_ COOKIEHASH',
						),
						array(
							'name'	=> 'AUTH_KEY',
							'description'	=> 'Secret key.',
							'value'			=> 'See <a href="https://api.wordpress.org/secret-key/1.1/salt" target="blank">generator</a>',
						),
						array(
							'name'	=> 'AUTH_SALT',
							'description'	=> 'Secret key.',
							'value'			=> 'See <a href="https://api.wordpress.org/secret-key/1.1/salt" target="blank">generator</a>',
						),
						array(
							'name'	=> 'COOKIEHASH',
							'description'	=> 'Hash for generating cookie names.',
							'value'			=> '',
						),
						array(
							'name'	=> 'COOKIEPATH',
							'description'	=> 'Path to WordPress root dir.',
							'value'			=> 'Home URL without http(s)://',
						),
						array(
							'name'	=> 'COOKIE_DOMAIN',
							'description'	=> 'Domain of the WordPress installation.',
							'value'			=> 'false or for Multisite with subdomains .domain of the main site',
						),
						array(
							'name'	=> 'CUSTOM_TAGS',
							'description'	=> 'Allows you to override the list of secure HTML tags. See /wp-includes/kses.php.',
							'value'			=> 'true|false (Default: false)',
						),
						array(
							'name'	=> 'DISALLOW_FILE_EDIT',
							'description'	=> 'Allows you to disallow theme and plugin edits via WordPress editor.',
							'value'			=> 'true',
						),
						array(
							'name'	=> 'DISALLOW_FILE_MODS',
							'description'	=> 'Allows you to disallow the editing, updating, installing and deleting of plugins, themes and core files via WordPress Backend.',
							'value'			=> 'true',
						),
						array(
							'name'	=> 'DISALLOW_UNFILTERED_HTML',
							'description'	=> 'Allows you to disallow unfiltered HTML for every user, admins too.',
							'value'			=> 'true',
						),
						array(
							'name'	=> 'FORCE_SSL_ADMIN',
							'description'	=> 'Activates SSL for logins and in the backend.',
							'value'			=> 'true|false (Default: false)',
						),
						array(
							'name'	=> 'FORCE_SSL_LOGIN',
							'description'	=> 'Activates SSL for logins.',
							'value'			=> 'true|false (Default: false)',
						),
						array(
							'name'	=> 'LOGGED_IN_COOKIE',
							'description'	=> 'Cookie name for logins.',
							'value'			=> 'wordpress_logged_in_ COOKIEHASH',
						),
						array(
							'name'	=> 'LOGGED_IN_KEY',
							'description'	=> 'Secret key.',
							'value'			=> 'See <a href="https://api.wordpress.org/secret-key/1.1/salt" target="blank">generator</a>',
						),
						array(
							'name'	=> 'LOGGED_IN_SALT',
							'description'	=> 'Secret key.',
							'value'			=> 'See <a href="https://api.wordpress.org/secret-key/1.1/salt" target="blank">generator</a>',
						),
						array(
							'name'	=> 'NONCE_KEY',
							'description'	=> 'Secret key.',
							'value'			=> 'See <a href="https://api.wordpress.org/secret-key/1.1/salt" target="blank">generator</a>',
						),
						array(
							'name'	=> 'NONCE_SALT',
							'description'	=> 'Secret key.',
							'value'			=> 'See <a href="https://api.wordpress.org/secret-key/1.1/salt" target="blank">generator</a>',
						),
						array(
							'name'	=> 'PASS_COOKIE',
							'description'	=> 'Cookie name for the password.',
							'value'			=> 'wordpresspass_ COOKIEHASH',
						),
						array(
							'name'	=> 'PLUGINS_COOKIE_PATH',
							'description'	=> 'Path to the plugins dir.',
							'value'			=> 'WP_PLUGIN_URL without http(s)://',
						),
						array(
							'name'	=> 'SECURE_AUTH_COOKIE',
							'description'	=> 'Cookie name for the SSL authentication.',
							'value'			=> 'wordpress_sec_ COOKIEHASH',
						),
						array(
							'name'	=> 'SECURE_AUTH_KEY',
							'description'	=> 'Secret key.',
							'value'			=> 'See <a href="https://api.wordpress.org/secret-key/1.1/salt" target="blank">generator</a>',
						),
						array(
							'name'	=> 'SECURE_AUTH_SALT',
							'description'	=> 'Secret key.',
							'value'			=> 'See <a href="https://api.wordpress.org/secret-key/1.1/salt" target="blank">generator</a>',
						),
						array(
							'name'	=> 'SITECOOKIEPATH',
							'description'	=> 'Path of you site.',
							'value'			=> 'Site URL without http(s)://',
						),
						array(
							'name'	=> 'TEST_COOKIE',
							'description'	=> 'Cookie name for the test cookie.',
							'value'			=> 'wordpress_test_cookie',
						),
						array(
							'name'	=> 'USER_COOKIE',
							'description'	=> 'Cookie name for users.',
							'value'			=> 'wordpressuser_ COOKIEHASH',
						),
						array(
							'name'	=> 'WP_FEATURE_BETTER_PASSWORDS',
							'description'	=> '',
							'value'			=> 'true|false',
						),
						array(
							'name'	=> 'RECOVERY_MODE_COOKIE',
							'description'	=> '',
							'value'			=> '',
						),
					)
				),

				'time'	=> array(
					'title'		=> 'Time',
					'constants'	=> array(
						array(
							'name'		=> 'MINUTE_IN_SECONDS',
							'description'	=> 'Minute in seconds',
							'value'			=> '60',
						),
						array(
							'name'		=> 'HOUR_IN_SECONDS',
							'description'	=> 'Hour in seconds',
							'value'			=> '60 * MINUTE_IN_SECONDS',
						),
						array(
							'name'		=> 'DAY_IN_SECONDS',
							'description'	=> 'Day (day) in seconds',
							'value'			=> '24 * HOUR_IN_SECONDS',
						),
						array(
							'name'		=> 'WEEK_IN_SECONDS',
							'description'	=> 'Week in seconds',
							'value'			=> '7 * DAY_IN_SECONDS',
						),
						array(
							'name'		=> 'MONTH_IN_SECONDS',
							'description'	=> 'Month in seconds',
							'value'			=> '30 * DAY_IN_SECONDS',
						),
						array(
							'name'		=> 'YEAR_IN_SECONDS',
							'description'	=> 'Year in seconds ',
							'value'			=> '365 * DAY_IN_SECONDS',
						),
					)
				),

				'filesize'	=> array(
					'title'		=> 'File Size',
					'constants'	=> array(
						array(
							'name'		=> 'KB_IN_BYTES',
							'description'	=> 'KiloByte in Bytes',
							'value'			=> '1024',
						),
						array(
							'name'		=> 'MB_IN_BYTES',
							'description'	=> 'MegaByte in Bytes',
							'value'			=> '1048576',
						),
						array(
							'name'		=> 'GB_IN_BYTES',
							'description'	=> 'GigaByte in Bytes',
							'value'			=> '1073741824',
						),
						array(
							'name'		=> 'TB_IN_BYTES',
							'description'	=> 'TeraByte in Bytes',
							'value'			=> '1099511627776',
						),
					)
				),

			);
		

			$wp_constants_array = array();
			$output = '';

			// Output all defined constants by category

			if ( $type == 'defined' ) {

				$output .= $this->sd_html( 'accordions-start' );

				foreach ( $wp_constants as $category ) {

					$category_title = $category['title'];
					$defined_constants = array();
					$constants_output = '';

					foreach ( $category['constants'] as $constant ) {

						$wp_constants_array[] = $constant['name'];

						if ( ( defined( $constant['name'] ) ) && ( !empty( constant( $constant['name'] ) ) ) ) {

							$constant_name = $constant['name'];
							$constant_value = constant( $constant['name'] );

							$constants_output .= $this->sd_html( 'field-content-start' );
							$constants_output .= $this->sd_html( 'field-content-first', $constant_name );
							$constants_output .= $this->sd_html( 'field-content-second', wp_kses_post( $constant_value ), 'long-value' );
							$constants_output .= $this->sd_html( 'field-content-end' );

							$defined_constants[] = $constant_name;

						}

					}

					// Only output categories with at least one defined constant

					if ( count( $defined_constants ) > 0 ) {

						$output .= $this->sd_html( 'accordion-head', $category_title );
						$output .= $this->sd_html( 'accordion-body', $constants_output );

					}

				}

				// Get constants defined by themes and plugins

				$php_constants = get_defined_constants( true );
				$php_user_constants = $php_constants['user'];
				$plugins_themes_constants = array();
				$plugins_themes_constants_output = '';

				foreach ( $php_user_constants as $constant_name => $constant_value ) {

					if ( !in_array( $constant_name, $wp_constants_array ) ) {

						$plugins_themes_constants[] = array(
							$constant_name => $constant_value,
						);

						$constant_value_type = gettype( $constant_value );

						// Prevent PHP array-to-string conversion warning 
						if ( $constant_value_type == 'array' ) {
							$constant_value = serialize( $constant_value );
						}

						$plugins_themes_constants_output .= $this->sd_html( 'field-content-start' );
						$plugins_themes_constants_output .= $this->sd_html( 'field-content-first', $constant_name, 'long-value' );
						$plugins_themes_constants_output .= $this->sd_html( 'field-content-second', wp_kses_post( $constant_value ), 'long-value' );
						$plugins_themes_constants_output .= $this->sd_html( 'field-content-end' );

					}

				}

				if ( !empty( $plugins_themes_constants ) ) {

					$output .= $this->sd_html( 'accordion-head', 'From Themes and Plugins' );
					$output .= $this->sd_html( 'accordion-body', $plugins_themes_constants_output );

				}

				$output .= $this->sd_html( 'accordions-end' );

			} elseif ( $type == 'docs' ) {

				$output .= $this->sd_html( 'accordions-start' );

				foreach ( $wp_constants as $category ) {

					$constants_output = '';

					$output .= $this->sd_html( 'accordion-head', $category['title'] );

					foreach ( $category['constants'] as $constant ) {

						$constants_output .= $this->sd_html( 'field-content-start' );
						$constants_output .= $this->sd_html( 'field-content-first', $constant['name'] . '<br />Value: ' . $constant['value'] );
						$constants_output .= $this->sd_html( 'field-content-second', $constant['description'] );
						$constants_output .= $this->sd_html( 'field-content-end' );

					}

					$output .= $this->sd_html( 'accordion-body', $constants_output );

				}

				$output .= $this->sd_html( 'accordions-end' );

			} else {

				$output .= '<h4>' . $wp_constants[$category]['title'] . '</h4>';			

				foreach ( $wp_constants[$category]['constants'] as $constant ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', $constant['name'] . ' <br />Possible value(s): ' . wp_kses_post( $constant['value'] ) );
					$output .= $this->sd_html( 'field-content-second', $constant['description'] );
					$output .= $this->sd_html( 'field-content-end' );

				}

			}

			echo $output;

		}

	}

	/**
	 * List relevant tools and plugins
	 *
	 * @since 1.0.0
	 */
	public function sd_tools( $type ) {

		$tools = array(
			'overview' 	=> array(
				// array(
				// 	'type'		=> 'plugin',
				// 	'name'		=> 'Name',
				// 	'pointer'	=> 'sluglink',
				// 	'usenow'	=> '',
				// ),
			),
			'directories' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Disk Usage Sunburst',
					'pointer'	=> 'disk-usage-sunburst',
					'usenow'	=> '/wp-admin/tools.php?page=disk-usage-sunburst%2Frbdusb-disk-usage-sunburst.php',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Filester – File Manager Pro',
					'pointer'	=> 'filester',
					'usenow'	=> '/wp-admin/admin.php?page=njt-fs-filemanager',
				),
			),
			'database' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'SQL Buddy',
					'pointer'	=> 'sql-buddy',
					'usenow'	=> '/wp-admin/tools.php?page=sql-buddy-dashboard',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Entity Viewer',
					'pointer'	=> 'entity-viewer',
					'usenow'	=> '',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Database Browser',
					'pointer'	=> 'database-browser',
					'usenow'	=> '/wp-admin/tools.php?page=databasebrowser',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Better Search Replace',
					'pointer'	=> 'better-search-replace',
					'usenow'	=> '/wp-admin/tools.php?page=better-search-replace',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Query Monitor',
					'pointer'	=> 'query-monitor',
					'usenow'	=> '',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Advanced Database Cleaner',
					'pointer'	=> 'advanced-database-cleaner',
					'usenow'	=> '/wp-admin/admin.php?page=advanced_db_cleaner',
				),
			),
			'posttypes_taxonomies' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Entity Viewer',
					'pointer'	=> 'entity-viewer',
					'usenow'	=> '',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'MB Custom Post Types & Custom Taxonomies',
					'pointer'	=> 'mb-custom-post-type',
					'usenow'	=> '/wp-admin/edit.php?post_type=mb-post-type',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Slugs Manager',
					'pointer'	=> 'remove-old-slugspermalinks',
					'usenow'	=> '/wp-admin/tools.php?page=alg-slugs-manager',
				),
			),
			'media' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Mime Types Plus',
					'pointer'	=> 'mime-types-plus',
					'usenow'	=> '/wp-admin/admin.php?page=mimetypesplus-edit',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Media Cleaner – Clean & Optimize Space',
					'pointer'	=> 'media-cleaner',
					'usenow'	=> '/wp-admin/upload.php?page=wpmc_dashboard',
				),
			),
			'custom_fields' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Entity Viewer',
					'pointer'	=> 'entity-viewer',
					'usenow'	=> '',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Post Meta Data Manager',
					'pointer'	=> 'post-meta-data-manager',
					'usenow'	=> '',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Post Meta Manager',
					'pointer'	=> 'post-meta-manager',
					'usenow'	=> '/wp-admin/tools.php?page=pmm-pmeta-settings',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Advanced Custom Fields',
					'pointer'	=> 'advanced-custom-fields',
					'usenow'	=> '/wp-admin/edit.php?post_type=acf-field-group',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Custom Field Suite',
					'pointer'	=> 'custom-field-suite',
					'usenow'	=> '/wp-admin/edit.php?post_type=cfs',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Smart Custom Fields',
					'pointer'	=> 'smart-custom-fields',
					'usenow'	=> '/wp-admin/edit.php?post_type=smart-custom-fields',
				),
			),
			'constants' 	=> array(
				// array(
				// 	'type'		=> 'plugin',
				// 	'name'		=> 'Name',
				// 	'pointer'	=> 'slug',
				//	'usenow'	=> '',
				// ),
			),
			'users_roles_capabilities' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'User Role Editor',
					'pointer'	=> 'user-role-editor',
					'usenow'	=> '/wp-admin/options-general.php?page=settings-user-role-editor.php',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'PublishPress Capabilities – User Role Access, Editor Permissions, Admin Menus',
					'pointer'	=> 'capability-manager-enhanced',
					'usenow'	=> '/wp-admin/admin.php?page=pp-capabilities',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Members – Membership & User Role Editor Plugin',
					'pointer'	=> 'members',
					'usenow'	=> '/wp-admin/admin.php?page=roles',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Advanced Access Manager',
					'pointer'	=> 'advanced-access-manager',
					'usenow'	=> '/wp-admin/admin.php?page=aam',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'User Switching',
					'pointer'	=> 'user-switching',
					'usenow'	=> '/wp-admin/users.php',
				),
			),
			'viewer' => array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Robots.txt rewrite',
					'pointer'	=> 'robotstxt-rewrite',
					'usenow'	=> '/wp-admin/options-general.php?page=robots-txt-options',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Robots.txt Quick Editor',
					'pointer'	=> 'robots-txt-quick-editor',
					'usenow'	=> '/wp-admin/options-general.php?page=robots-txt-quick-editor-page',
				),
			),
			'emails' 	=> array(
				// array(
				// 	'type'		=> 'plugin',
				// 	'name'		=> 'Name',
				// 	'pointer'	=> 'slug',
				//	'usenow'	=> '',
				// ),
			),
			'options' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Option Inspector',
					'pointer'	=> 'options-inspector',
					'usenow'	=> '/wp-admin/options.php',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Options View',
					'pointer'	=> 'options-view',
					'usenow'	=> '/wp-admin/tools.php?page=optionsview',
				),
			),
			'transients' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Transients Manager',
					'pointer'	=> 'transients-manager',
					'usenow'	=> '/wp-admin/tools.php?page=transients-manager',
				),
			),
			'cron' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'WP Crontrol',
					'pointer'	=> 'wp-crontrol',
					'usenow'	=> '/wp-admin/options-general.php?page=crontrol_admin_options_page',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Crony Cronjob Manager',
					'pointer'	=> 'crony',
					'usenow'	=> '/wp-admin/admin.php?page=crony',
				),
			),
			'rewrite_rules' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Permalink Manager Lite',
					'pointer'	=> 'permalink-manager',
					'usenow'	=> 'url',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Custom Post Type Permalinks',
					'pointer'	=> 'custom-post-type-permalinks',
					'usenow'	=> 'url',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Combo WP Rewrite Slugs',
					'pointer'	=> 'combo-wp-rewrite-slugs',
					'usenow'	=> 'url',
				),
			),
			'shortcodes' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Post Snippets',
					'pointer'	=> 'post-snippets',
					'usenow'	=> 'url',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Code Snippets',
					'pointer'	=> 'code-snippets',
					'usenow'	=> 'url',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Unused Shortcodes',
					'pointer'	=> 'unused-shortcodes',
					'usenow'	=> 'url',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Remove Orphan Shortcodes',
					'pointer'	=> 'remove-orphan-shortcodes',
					'usenow'	=> 'url',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Shortcodes Finder',
					'pointer'	=> 'shortcodes-finder',
					'usenow'	=> 'url',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Shortcode Cleaner Lite',
					'pointer'	=> 'shortcode-cleaner-lite',
					'usenow'	=> 'url',
				),
			),
			'hooks' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Query Monitor',
					'pointer'	=> 'query-monitor',
					'usenow'	=> '',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Show Hooks',
					'pointer'	=> 'show-hooks',
					'usenow'	=> '',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Visual Action Hooks',
					'pointer'	=> 'visual-action-hooks',
					'usenow'	=> '',
				),
			),
			'classes' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Syntax Highlighter for Theme/Plugin Editor',
					'pointer'	=> 'syntax-highlighter-for-wp-editor',
					'usenow'	=> '',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'FastDev',
					'pointer'	=> 'fastdev',
					'usenow'	=> '/wp-admin/admin.php?page=fd-main',
				),
			),
			'functions' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Syntax Highlighter for Theme/Plugin Editor',
					'pointer'	=> 'syntax-highlighter-for-wp-editor',
					'usenow'	=> '',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'FastDev',
					'pointer'	=> 'fastdev',
					'usenow'	=> '/wp-admin/admin.php?page=fd-main',
				),
			),
			'logs' 	=> array(
				// array(
				// 	'type'		=> 'plugin',
				// 	'name'		=> 'Name',
				// 	'pointer'	=> 'slug',
				//	'usenow'	=> '',
				// ),
			),

		);

		$output = '';

		$output .= $this->sd_html( 'accordions-start-left' );
		$output .= $this->sd_html( 'accordion-head', 'View' );

		$tools_output = '';

		foreach( $tools[$type] as $tool ) {

			if ( $tool['type'] == 'plugin' ) {

				$plugin_file = '';

				$active_plugins = get_option( 'active_plugins' );

				sort( $active_plugins );

				foreach ( $active_plugins as $plugin_dirfile ) {

					if ( strpos( $plugin_dirfile, $tool['pointer'] ) !== false ) {

						$plugin_file = $plugin_dirfile;

					}

				}

				// $plugin_file = $tool['pointer'] . '/' . $tool['pointer'] .'.php';

				$plugin_url_base = 'https://wordpress.org/plugins/';
				$plugin_install_url_base = '/wp-admin/plugin-install.php?tab=plugin-information&plugin=';

				$tools_output .= $this->sd_html( 'field-content-start' );
				$tools_output .= $this->sd_html( 'field-content-first', '<a href="' . $plugin_url_base . $tool['pointer'] . '/" target="_blank">'. $tool['name'] .'</a>' );


				if ( is_plugin_active( $plugin_file ) ) {

					if ( !empty( $tool['usenow'] ) ) {

						$tools_output .= $this->sd_html( 'field-content-second', '<a href="' . $tool['usenow'] . '" target="_blank">Use Now &raquo;</a>' );

					} else {

						$tools_output .= $this->sd_html( 'field-content-second', 'Installed and activated' );

					}

				} else {

					$tools_output .= $this->sd_html( 'field-content-second', '<a href="' . $plugin_install_url_base . $tool['pointer'] . '" target="_blank">Install &raquo;</a>' );

				}

				$tools_output .= $this->sd_html( 'field-content-end' );

			} 

		}

		$output .= $this->sd_html( 'accordion-body', $tools_output );
		$output .= $this->sd_html( 'accordions-end' );

		return $output;

	}
	/**
	 * List relevant references
	 *
	 * @since 1.0.0
	 */
	public function sd_references( $type ) {

		$references = array(
			'overview' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Core code repository on GitHub',
					'pointer'	=> 'https://github.com/WordPress/WordPress',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'PHP Cross Reference of WordPress',
					'pointer'	=> 'https://phpxref.ftwr.co.uk/wordpress/nav.html?index.html',
				),
			),
			'directories' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress file/folder structure explained',
					'pointer'	=> 'https://devowl.io/2020/wordpress-file-folder-structure-explained/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Understanding the WordPress File and Directory Structure',
					'pointer'	=> 'https://qodeinteractive.com/magazine/wordpress-file-structure/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'A Comprehensive Guide on WordPress Files and How to Use Them',
					'pointer'	=> 'https://kinsta.com/knowledgebase/wordpress-files/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress File Permissions: Complete Beginner’s Guide',
					'pointer'	=> 'https://www.malcare.com/blog/wordpress-file-permissions/',
				),
			),
			'database' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Codex: Database Description',
					'pointer'	=> 'https://codex.wordpress.org/Database_Description',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'The Ultimate Developer’s Guide to the WordPress Database',
					'pointer'	=> 'https://deliciousbrains.com/tour-wordpress-database/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How to Clean up Your wp_options Table and Autoloaded Data',
					'pointer'	=> 'https://kinsta.com/knowledgebase/wp-options-autoloaded-data/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'A beginner’s guide to using SQL to query the WordPress database',
					'pointer'	=> 'https://hookturn.io/custom-wordpress-sql-queries-for-beginners/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How To Interact With The WordPress Database',
					'pointer'	=> 'https://www.smashingmagazine.com/2011/09/interacting-with-the-wordpress-database/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How To Interact With The WordPress Database | WPDB Development Tutorial',
					'pointer'	=> 'https://www.youtube.com/watch?v=gNnf2rRDWEw',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'wpdb - WordPress Database Access Abstraction Class',
					'pointer'	=> 'https://developer.wordpress.org/reference/classes/wpdb/',
				),
			),
			'posttypes_taxonomies' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Custom Post Types: The All-In-One Guide to Create and Use Them',
					'pointer'	=> 'https://kinsta.com/blog/wordpress-custom-post-types/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'The Complete Guide To WordPress Custom Post Types',
					'pointer'	=> 'https://www.smashingmagazine.com/2012/11/complete-guide-custom-post-types/',
				),
			),
			'media' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'MIME Types in WordPress',
					'pointer'	=> 'https://wpengine.com/support/mime-types-wordpress/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How to Modify Allowed Upload Mime Types in WordPress',
					'pointer'	=> 'https://www.isitwp.com/modify-allowed-upload-mime-types/',
				),
			),
			'custom_fields' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'Custom Fields - WordPress.org Documentation',
					'pointer'	=> 'https://wordpress.org/support/article/custom-fields/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Advanced Custom Fields Tutorial: Your Ultimate Guide',
					'pointer'	=> 'https://kinsta.com/blog/advanced-custom-fields/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Custom Fields 101: Tips, Tricks, and Hacks',
					'pointer'	=> 'https://www.wpbeginner.com/wp-tutorials/wordpress-custom-fields-101-tips-tricks-and-hacks/',
				),
			),
			'constants'		 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Constants Overview',
					'pointer'	=> 'https://wpengineer.com/2382/wordpress-constants-overview/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Constants of WordPress',
					'pointer'	=> 'https://wp-kama.com/1588/konstanty-wordpress',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WP-Config.php file – Tricks for Advance Users and Beginners',
					'pointer'	=> 'https://wp-umbrella.com/tutorials/wp-config-php/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'The WordPress wp-config File: A Comprehensive Guide',
					'pointer'	=> 'https://wpmudev.com/blog/wordpress-wp-config-file-guide/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Configuration Tricks',
					'pointer'	=> 'https://digwp.com/2009/06/wordpress-configuration-tricks/',
				),
			),
			'users_roles_capabilities' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'Roles and Capabilities - WordPress.org Documentation',
					'pointer'	=> 'https://wordpress.org/support/article/roles-and-capabilities/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Roles and Capabilities - Plugin Developer Handbook',
					'pointer'	=> 'https://developer.wordpress.org/plugins/users/roles-and-capabilities/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'The Complete Beginners Guide to WordPress User Roles and Capabilities',
					'pointer'	=> 'https://wpastra.com/wordpress-user-roles/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'The Ultimate Guide to WordPress User Roles and Capabilities',
					'pointer'	=> 'https://kinsta.com/blog/wordpress-user-roles/',
				),
			),
			'viewer' => array(
				array(
					'type'		=> 'link',
					'name'		=> 'The WordPress wp-config File: A Comprehensive Guide',
					'pointer'	=> 'https://wpmudev.com/blog/wordpress-wp-config-file-guide/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'wp-config.php File – An In-Depth View on How to Configure WordPress',
					'pointer'	=> 'https://kinsta.com/blog/wp-config-php/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Understanding and Configuring the .htaccess File in WordPress',
					'pointer'	=> 'https://webdesign.tutsplus.com/tutorials/understanding-and-configuring-the-htaccess-file-in-wordpress--cms-37360',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How to Use .htaccess File to Secure, Optimize, and Control Redirects in WordPress',
					'pointer'	=> 'https://www.cloudways.com/blog/wordpress-htaccess/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Robots.txt Guide – What It Is and How to Use It',
					'pointer'	=> 'https://kinsta.com/blog/wordpress-robots-txt/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How to Optimize Your WordPress Robots.txt for SEO',
					'pointer'	=> 'https://www.wpbeginner.com/wp-tutorials/how-to-optimize-your-wordpress-robots-txt-for-seo/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'The Complete Guide to WordPress REST API Basics',
					'pointer'	=> 'https://kinsta.com/blog/wordpress-rest-api/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress REST API: The Next Generation CMS Feature',
					'pointer'	=> 'https://www.toptal.com/wordpress/beginners-guide-wordpress-rest-api',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'The Ultimate Guide To The WordPress REST API',
					'pointer'	=> 'https://wpengine.com/resources/the-ultimate-guide-to-the-wordpress-rest-api/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'REST API Handbook',
					'pointer'	=> 'https://developer.wordpress.org/rest-api/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'REST API Resources',
					'pointer'	=> 'https://developer.wordpress.com/docs/api/',
				),
			),
			'emails' 	=> array(
				// array(
					// 'type'		=> 'link',
					// 'name'		=> 'Title',
					// 'pointer'	=> '',
				// ),
			),
			'options' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'Option Reference',
					'pointer'	=> 'https://web.archive.org/web/20220318094858/https://codex.wordpress.org/Option_Reference',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Understanding and Working With the WordPress Options Table',
					'pointer'	=> 'https://code.tutsplus.com/tutorials/understanding-and-working-with-the-wordpress-options-table--cms-21119',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Working with wp_options',
					'pointer'	=> 'https://docs.wpvip.com/technical-references/code-quality-and-best-practices/working-with-wp_options/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How to Clean up Your wp_options Table and Autoloaded Data',
					'pointer'	=> 'https://kinsta.com/knowledgebase/wp-options-autoloaded-data/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Keeping your WordPress options table in check',
					'pointer'	=> 'https://10up.com/blog/2017/wp-options-table/',
				),
			),
			'transients' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'Transients API Handbook',
					'pointer'	=> 'https://developer.wordpress.org/apis/handbook/transients/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'A Guide to Transients in WordPress',
					'pointer'	=> 'https://wpengine.com/resources/guide-to-transients-in-wordpress/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'The Deal with WordPress Transients',
					'pointer'	=> 'https://css-tricks.com/the-deal-with-wordpress-transients/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Understand Caching with WordPress Transients API',
					'pointer'	=> 'https://wpshout.com/know-wordpress-transients-api/',
				),
			),
			'cron' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'Cron - Wordpress.org Documentation',
					'pointer'	=> 'https://developer.wordpress.org/plugins/cron/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How to Create and Modify a WordPress Cron Job',
					'pointer'	=> 'https://kinsta.com/knowledgebase/wordpress-cron-job/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How to Disable wp-cron in WordPress (and Use a Real Cron Job Instead)',
					'pointer'	=> 'https://themeisle.com/blog/disable-wp-cron/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Better wp-cron using linux’s crontab',
					'pointer'	=> 'https://easyengine.io/tutorials/wordpress/wp-cron-crontab/',
				),
			),
			'rewrite_rules' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Common APIs Handbook: Rewrite',
					'pointer'	=> 'https://developer.wordpress.org/apis/handbook/rewrite/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How To Rewrite URLs In WordPress',
					'pointer'	=> 'https://paulund.co.uk/how-to-rewrite-urls-in-wordpress',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Mastering WordPress rewrite rules',
					'pointer'	=> 'https://brightminded.com/blog/mastering-wordpress-rewrite-rules/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'A (Mostly) Complete Guide to the WordPress Rewrite API',
					'pointer'	=> 'https://www.pmg.com/blog/a-mostly-complete-guide-to-the-wordpress-rewrite-api',
				),
			),
			'shortcodes' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Common APIs Handbook: The Shortcode API',
					'pointer'	=> 'https://developer.wordpress.org/apis/handbook/shortcode/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'How to Add a Shortcode in WordPress? (Beginner’s Guide)',
					'pointer'	=> 'https://www.wpbeginner.com/wp-tutorials/how-to-add-a-shortcode-in-wordpress/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Shortcodes: A Complete Guide',
					'pointer'	=> 'https://www.smashingmagazine.com/2012/05/wordpress-shortcodes-complete-guide/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Th Ultimate Guide to WordPress Shortcodes (With Examples to Create Your Own)',
					'pointer'	=> 'https://kinsta.com/blog/wordpress-shortcodes/',
				),
			),
			'hooks' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Functions and Hooks Database by WP-KAMA',
					'pointer'	=> 'https://wp-kama.com/functions/functions-db',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Hooks Database (by version, since WordPress v1.2.1)',
					'pointer'	=> 'https://profbrown.org/p/wp_hooks',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Hooks Reference',
					'pointer'	=> 'https://github.com/johnbillion/wp-hooks',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Hooks Generator',
					'pointer'	=> 'https://github.com/johnbillion/wp-hooks-generator',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'The WordPress Hooks Bootcamp: How to Use Actions, Filters and Custom Hooks',
					'pointer'	=> 'https://kinsta.com/blog/wordpress-hooks/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Core code repository on GitHub',
					'pointer'	=> 'https://github.com/WordPress/WordPress',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'PHP Cross Reference of WordPress',
					'pointer'	=> 'https://phpxref.ftwr.co.uk/wordpress/nav.html?index.html',
				),
			),
			'classes' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'How to approach object-oriented programming with WordPress',
					'pointer'	=> 'https://carlalexander.ca/approaching-object-oriented-programming-wordpress/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Object-Oriented Programming in WordPress',
					'pointer'	=> 'https://code.tutsplus.com/series/object-oriented-programming-in-wordpress--cms-699',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Improving WordPress Code With Modern PHP',
					'pointer'	=> 'https://www.smashingmagazine.com/2019/02/wordpress-modern-php/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Advanced WordPress Development: Writing Object-Oriented Plugins',
					'pointer'	=> 'https://wpmudev.com/blog/advanced-wordpress-development-writing-object-oriented-plugins/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'The Ultimate Guide to Object-Oriented PHP for WordPress Developers',
					'pointer'	=> 'https://wpengine.com/wp-content/uploads/2017/02/WP-EBK-LT-UltimateGuideToPhp-FINAL.pdf',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Core code repository on GitHub',
					'pointer'	=> 'https://github.com/WordPress/WordPress',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'PHP Cross Reference of WordPress',
					'pointer'	=> 'https://phpxref.ftwr.co.uk/wordpress/nav.html?index.html',
				),
			),
			'functions' 	=> array(
				// array(
				// 	'type'		=> 'link',
				// 	'name'		=> 'Title',
				// 	'pointer'	=> '',
				// ),
			),
			'globals' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'Codex: Global Variables',
					'pointer'	=> 'https://codex.wordpress.org/Global_Variables',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Global Variables of WordPress',
					'pointer'	=> 'https://wp-kama.com/1586/global-variables-in-wordpress',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'A Practical Use of WordPress Global Variables',
					'pointer'	=> 'https://code.tutsplus.com/tutorials/a-practical-use-of-wordpress-global-variables--cms-20854',
				),
			),
			'logs' 	=> array(
				// array(
				// 	'type'		=> 'link',
				// 	'name'		=> 'Title',
				// 	'pointer'	=> '',
				// ),
			),
		);

		$output = '';

		$output .= $this->sd_html( 'accordions-start-left' );
		$output .= $this->sd_html( 'accordion-head', 'View' );

		$references_output = '';

		foreach( $references[$type] as $reference ) {

			if ( $reference['type'] == 'link' ) {

				$references_output .= $this->sd_html( 'field-content-start' );
				$references_output .= $this->sd_html( 'field-content-first', '<a href="' . $reference['pointer'] . '/" target="_blank">'. $reference['name'] .'</a>', 'full-width' );
				$references_output .= $this->sd_html( 'field-content-end' );

			}

		}

		$output .= $this->sd_html( 'accordion-body', $references_output );
		$output .= $this->sd_html( 'accordions-end' );

		return $output;

	}
	 
	public function sd_register_submenu() {
	    add_submenu_page(
	        'index.php',
	        'System Dashboard',
	        'System',
	        'manage_options',
	        'system-dashboard',
	        'sd_register_submenu_callback' );
	}
	 
	public function sd_register_submenu_callback() {
	    echo 'Nothing to show here...';
	}

	/**
	 * Add plugin dashboard page
	 *
	 * @since    1.0.0
	 */
	public function sd_dashboard_page() {

		if ( class_exists( 'CSF' ) ) {

			// Set a unique slug-like ID

			$prefix = 'system-dashboard';

			// Create options

			CSF::createOptions ( $prefix, array(
				'menu_title' 		=> 'System',
				'menu_slug' 		=> 'system-dashboard',
				'menu_type'			=> 'submenu',
				'menu_parent'		=> 'index.php',
				'menu_position'		=> 1,
				// 'menu_icon'			=> 'dashicons-arrow-up-alt2',
				'framework_title' 	=> 'System Dashboard <small>by <a href="https://bowo.io" target="_blank">bowo.io</a></small>',
				'framework_class' 	=> 'sd-options',
				'show_bar_menu' 	=> false,
				'show_search' 		=> false,
				'show_reset_all' 	=> false,
				'show_reset_section' => false,
				'show_form_warning' => false,
				'save_defaults'		=> true,
				'show_footer' 		=> false,
				'footer_credit'		=> '<a href="https://wordpress.org/plugins/system-dashboard/" target="_blank">System Dashboard</a> (<a href="https://github.com/qriouslad/system-dashboard" target="_blank">github</a>) is built with the <a href="https://github.com/devinvinson/WordPress-Plugin-Boilerplate/" target="_blank">WordPress Plugin Boilerplate</a>, <a href="https://wppb.me" target="_blank">wppb.me</a> and <a href="https://github.com/Codestar/codestar-framework" target="_blank">CodeStar</a>.',
			) );

			CSF::createSection( $prefix, array(
				'title'		=> 'Options',
				'fields'	=> array(

					array(
						'id'		=> 'wordpress',
						'type'		=> 'tabbed',
						'title' 	=> 'WordPress v'. get_bloginfo( 'version' ),
						'subtitle'	=>  $this->sd_wp_overview(),
						'class'		=> 'main-section',
						'tabs'		=> array(
					
							array(
								'title'		=> 'Database',
								'fields'	=> array(
									array(
										'type'		=> 'content',
										'title'		=> 'System & Uptime',
										'content'	=> $this->sd_get_mysql_version() . ' / ' . $this->sd_db_uptime(),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Data & Index Size',
										'content'	=> $this->sd_db_disk_usage( 'data' ) . ' / ' . $this->sd_db_disk_usage( 'index' ),
									),
									array(
										'id'		=> 'db_tables',
										'type'		=> 'accordion',
										'title'		=> 'Tables',
										'class'		=> 'db-tables',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														// 'content'	=> $this->sd_db_tables(),
														// 'content'	=> '<div id="spinner-db-tables"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="db-tables"></div>', // AJAX loading via sd_db_tables()
														'content'	=> $this->sd_html( 'ajax-receiver', 'db-tables' ), // AJAX loading via sd_db_tables()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'db_key_specs',
										'type'		=> 'accordion',
										'title'		=> 'Key Info',
										'class'		=> 'db-specs',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														// 'content'	=> $this->sd_db_specs(),
														// 'content'	=> '<div id="spinner-db-specs"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="db-specs"></div>', // AJAX loading via sd_db_tables()
														'content'	=> $this->sd_html( 'ajax-receiver', 'db-specs' ), // AJAX loading via sd_db_specs()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'db_detail_specs',
										'type'		=> 'accordion',
										'title'		=> 'Detailed Specifications',
										'class'		=> 'db-details',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														// 'content'	=> $this->sd_db_details(),
														// 'content'	=> '<div id="spinner-db-details"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="db-details"></div>', // AJAX loading via sd_db_details()
														'content'	=> $this->sd_html( 'ajax-receiver', 'db-details' ), // AJAX loading via sd_db_details()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'database' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'database' ),
									),

								),
							),

							array(
								'title' => 'Post Types & Taxonomies',
								'fields' => array(
									array(
										'id'		=> 'post_types',
										'type'		=> 'accordion',
										'title'		=> 'Post Types Post Count',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_post_types_info(),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'taxonomies',
										'type'		=> 'accordion',
										'title'		=> 'Taxonomies Term Count',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_taxonomies_info(),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'pttax_old_slugs',
										'type'		=> 'accordion',
										'title'		=> 'Old Slugs',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_old_slugs(),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'posttypes_taxonomies' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'posttypes_taxonomies' ),
									),

								),
							),

							array(
								'title'		=> 'Media',
								'fields'	=> array(

									array(
										'id'		=> 'media_count_by_mime',
										'type'		=> 'accordion',
										'title'		=> 'Media Count by Mime Type',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_media_count_by_mime(),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'media_allowed_mime_types',
										'type'		=> 'accordion',
										'title'		=> 'Allowed Mime Types',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_mime_types_file_extensions(),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'media_handling',
										'type'		=> 'accordion',
										'title'		=> 'Media Handling',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_media_handling(),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'media' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'media' ),
									),

								),
							),

							array(
								'title' => 'Directories',
								'fields' => array(
									array(
										'type'		=> 'content',
										'title'		=> 'Root path',
										'content'	=> str_replace( "/wp-content", "", WP_CONTENT_DIR ),
									),
									array(
										'id'		=> 'directory_sizes',
										'type'		=> 'accordion',
										'title'		=> 'Directory Sizes',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_wp_dir_sizes(),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'filesystem_permissions',
										'type'		=> 'accordion',
										'title'		=> 'Filesystem Permissions',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_filesystem_permissions(),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'directories' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'directories' ),
									),
								),
							),

							array(
								'title' => 'Custom Fields',
								'fields' => array(

									array(
										'id'		=> 'custom_fields',
										'type'		=> 'accordion',
										'class'		=> 'custom-fields-tabs',
										'title'		=> 'By Type',
										'accordions'	=> array(

											array(
												'title'		=> 'View Public Fields (' . $this->sd_get_all_custom_fields( 'public-count' ) . ')',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_all_custom_fields( 'public' ),
													),													
												),
											),
											array(
												'title'		=> 'View Private Fields (' . $this->sd_get_all_custom_fields( 'private-count' ) . ')',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_all_custom_fields( 'private' ),
													),													
												),
											),

										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'custom_fields' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'custom_fields' ),
									),

								),
							),

							array(
								'title' => 'Users',
								'fields' => array(

									array(
										'id'		=> 'user_count_by_role',
										'type'		=> 'accordion',
										'title'		=> 'Users Count by Role',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_user_count_by_role( 'by_role' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'urc_tools',
										'type'		=> 'accordion',
										'title'		=> 'Roles & Capabilities',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_user_roles_capabilities(),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'users_roles_capabilities' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'users_roles_capabilities' ),
									),

								),
							),


						),
					),

					array(
						'id'		=> 'wordpress',
						'type'		=> 'tabbed',
						'title' 	=> ' ',
						'class'		=> 'wordpress-more-tabs',
						'tabs'		=> array(

							array(
								'title'		=> 'Options',
								'fields'	=> array(
									array(
										'type'		=> 'content',
										'title'		=> 'Total',
										'content'	=> $this->sd_options( 'total_count' ) . ' options',
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Autoloaded',
										'content'	=> $this->sd_options( 'total_count_autoloaded' ) . ' options | Total size: ' . $this->sd_options( 'total_autoloaded_size' ),
									),
									array(
										'id'		=> 'wp_core_options',
										'type'		=> 'accordion',
										'title'		=> 'Core',
										'subtitle'	=> $this->sd_options( 'wpcore_count' ) . ' options',
										'accordions'	=> array(
											array(
												'title'		=> 'View Options',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_options( 'wpcore' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'wp_noncore_options',
										'type'		=> 'accordion',
										'title'		=> 'Plugins & Themes',
										'subtitle'	=> $this->sd_options( 'noncore_count' ) . ' options',
										'accordions'	=> array(
											array(
												'title'		=> 'View Options',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_options( 'noncore' ),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'transients' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'transients' ),
									),

								),
							),

							array(
								'title'		=> 'Transients',
								'fields'	=> array(
									array(
										'type'		=> 'content',
										'title'		=> 'Total',
										'content'	=> $this->sd_transients( 'total_count' ) . ' transients',
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Autoloaded',
										'content'	=> $this->sd_transients( 'total_count_autoloaded' ) . ' transients | Total size: ' . $this->sd_transients( 'total_autoloaded_size' ),
									),
									array(
										'id'		=> 'transients_active',
										'type'		=> 'accordion',
										'title'		=> 'With Expiration',
										'subtitle'	=> $this->sd_transients( 'count', 'active' ) . ' transients',
										'accordions'	=> array(
											array(
												'title'		=> 'View Transients',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_transients( 'list', 'active' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'transients_expired',
										'type'		=> 'accordion',
										'title'		=> 'Expired',
										'subtitle'	=> $this->sd_transients( 'count', 'expired' ) . ' transients',
										'accordions'	=> array(
											array(
												'title'		=> 'View Transients',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_transients( 'list', 'expired' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'transients_neverexpire',
										'type'		=> 'accordion',
										'title'		=> 'Does Not Expire',
										'subtitle'	=> $this->sd_transients( 'count', 'neverexpire' ) . ' transients',
										'accordions'	=> array(
											array(
												'title'		=> 'View Transients',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_transients( 'list', 'neverexpire' ),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'transients' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'transients' ),
									),

								),
							),

							array(
								'title'		=> 'Cron',
								'fields'	=> array(
									array(
										'type'		=> 'content',
										'title'		=> 'Total',
										'content'	=> $this->sd_cron_events( 'all', 'count' ) . ' cron events',
									),
									array(
										'id'		=> 'cron_events',
										'type'		=> 'accordion',
										'title'		=> 'Core',
										'subtitle'		=> $this->sd_cron_events( 'wpcore', 'count' ) . ' events',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_cron_events( 'wpcore', 'events' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'cron_events',
										'type'		=> 'accordion',
										'title'		=> 'Theme & Plugins',
										'subtitle'		=> $this->sd_cron_events( 'custom', 'count' ) . ' events',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_cron_events( 'custom', 'events' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'cron_events',
										'type'		=> 'accordion',
										'title'		=> 'Schedules',
										'subtitle'		=> $this->sd_cron_events( 'schedules', 'count' ) . ' intervals',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_cron_events( 'schedules', 'list' ),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'cron' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'cron' ),
									),

								),
							),


							array(
								'title'		=> 'Rewrite Rules',
								'fields'	=> array(

									array(
										'type'		=> 'content',
										'title'		=> 'Total',
										'content'	=> $this->sd_rewrite_rules( 'total_count' ) . ' rules',
									),
									array(
										'id'		=> 'rewrite_rules',
										'type'		=> 'accordion',
										'title'		=> 'List',
										'subtitle'	=> 'URL Structure <br />&#10132; Query Parameters',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_rewrite_rules( 'list' ),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'rewrite_rules' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'rewrite_rules' ),
									),

								),
							),

							array(
								'title'		=> 'Shortcodes',
								'fields'	=> array(

									array(
										'type'		=> 'content',
										'title'		=> 'Total',
										'content'	=> $this->sd_shortcodes( 'total_count' ) . ' shortcodes',
									),
									array(
										'id'		=> 'shortcodes',
										'type'		=> 'accordion',
										'title'		=> 'List',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_shortcodes( 'list' ),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'shortcodes' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'shortcodes' ),
									),

								),
							),

							array(
								'title' => 'Viewer',
								'fields' => array(

									array(
										'id'		=> 'viewer_wpconfig',
										'type'		=> 'accordion',
										'title'		=> 'wp-config.php',
										'subtitle'	=> 'WordPress main configuration file',
										'class'		=> 'sd-viewer wpconfig',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'wpconfig' ), // AJAX loading via sd_viewer()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'viewer_htaccess',
										'type'		=> 'accordion',
										'title'		=> '.htaccess',
										'subtitle'	=> 'Apache server configuration only for the directory the file is in',
										'class'		=> 'htaccess',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'htaccess' ), // AJAX loading via sd_viewer()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'viewer_restapi',
										'type'		=> 'accordion',
										'title'		=> 'WordPress <a href="/wp-json/wp/v2" target="_blank">REST API</a>',
										'subtitle'	=> 'An interface for applications to interact with WordPress',
										'class'		=> 'restapi_viewer',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'restapi' ), // AJAX loading via sd_wp_rest_api()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'viewer_robots',
										'type'		=> 'accordion',
										'title'		=> 'robots.txt',
										'subtitle'	=> 'Tell search engine crawlers which URLs they can access on your site',
										'class'		=> 'robotstxt',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'robotstxt' ), // AJAX loading via sd_viewer()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Sitemap',
										'subtitle'	=> 'Contains information for search engines to crawl your site more efficiently',
										'content'	=> '<a href="/wp-sitemap.xml" target="_blank">Access now &raquo;</a>',
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'viewer' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'viewer' ),
									),

								),
							),

						),
					),

					array(
						'id'		=> 'wordpress',
						'type'		=> 'tabbed',
						'title' 	=> ' ',
						'class'		=> 'wordpress-more-tabs',
						'tabs'		=> array(

							array(
								'title'		=> 'Hooks',
								'fields'	=> array(
									array(
										'id'		=> 'hooks_wpcore',
										'type'		=> 'accordion',
										'title'		=> 'Core (v5.9)',
										'subtitle'	=> 'Links to the WordPress <a href="https://developer.wordpress.org/reference/" target="_blank">Code Reference</a> for each hook.',
										'class'		=> 'wpcore-hooks',
										'accordions'	=> array(
											array(
												'title'		=> 'View Action Hooks',
												'class'		=> 'core-action-hooks',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'core-action-hooks' ), // AJAX loading via sd_wpcore_hooks()
													),													
												),
											),
											array(
												'title'		=> 'View Filter Hooks',
												'class'		=> 'core-filter-hooks',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'core-filter-hooks' ), // AJAX loading via sd_wpcore_hooks()
													),													
												),
											),
											// array(
											// 	'title'		=> 'Hooks on this page',
											// 	'fields'	=> array(
											// 		array(
											// 			'type'		=> 'content',
											// 			'content'	=> $this->sd_list_of_hooks(),
											// 		),													
											// 	),
											// ),

										),
									),
									array(
										'id'		=> 'hooks_active_theme',
										'type'		=> 'accordion',
										'title'		=> 'Current Theme',
										'subtitle'	=> 'To preview links, ensure that <a href="/wp-admin/theme-editor.php" target="_blank">Theme File Editor</a> is not disabled.',
										'class'		=> 'sd__hooks theme-hooks',
										'accordions'	=> array(
											array(
												'title'		=> 'View Hooks',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'theme-hooks' ), // AJAX loading via sd_hooks()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'hooks_active_plugins',
										'type'		=> 'accordion',
										'title'		=> 'Active Plugins',
										'subtitle'	=> 'To preview links, ensure that <a href="/wp-admin/plugin-editor.php" target="_blank">Plugin File Editor</a> is not disabled.',
										'class'		=> 'sd__hooks plugins-hooks',
										'accordions'	=> array(
											array(
												'title'		=> 'View Hooks',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'plugins-hooks' ), // AJAX loading via sd_hooks()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'hooks' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'hooks' ),
									),

								),
							),

							array(
								'title'		=> 'Classes',
								'fields'	=> array(
									array(
										'id'		=> 'classes_core',
										'type'		=> 'accordion',
										'title'		=> 'Core',
										'subtitle'		=> 'Links to the WordPress <a href="https://developer.wordpress.org/reference/" target="_blank">Code Reference</a> for each class.',
										'accordions'	=> array(
											array(
												'title'		=> 'View Classes and Methods',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_all_classes( 'core' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'classes_themes',
										'type'		=> 'accordion',
										'title'		=> 'Current Theme',
										'subtitle'	=> 'To preview links, ensure that <a href="/wp-admin/theme-editor.php" target="_blank">Theme File Editor</a> is not disabled.',
										'accordions'	=> array(
											array(
												'title'		=> 'View Classes and Methods',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_all_classes( 'themes' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'classes_plugins',
										'type'		=> 'accordion',
										'title'		=> 'Active Plugins',
										'subtitle'	=> 'To preview links, ensure that <a href="/wp-admin/plugin-editor.php" target="_blank">Plugin File Editor</a> is not disabled.',
										'accordions'	=> array(
											array(
												'title'		=> 'View Classes and Methods',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_all_classes( 'plugins' ),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'classes' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'classes' ),
									),

								),
							),

							array(
								'title'		=> 'Functions',
								'fields'	=> array(
									array(
										'id'		=> 'functions_core',
										'type'		=> 'accordion',
										'title'		=> 'Core',
										'subtitle'		=> 'Links to the WordPress <a href="https://developer.wordpress.org/reference/" target="_blank">Code Reference</a> for each function.',
										'accordions'	=> array(
											array(
												'title'		=> 'View Functions'  . ' (' . $this->sd_get_all_user_functions( 'core-count' ) . ')',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_all_user_functions( 'core' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'functions_themes',
										'type'		=> 'accordion',
										'title'		=> 'Current Theme',
										'subtitle'	=> 'To preview links, ensure that <a href="/wp-admin/theme-editor.php" target="_blank">Theme File Editor</a> is not disabled.',
										'accordions'	=> array(
											array(
												'title'		=> 'View Functions'  . ' (' . $this->sd_get_all_user_functions( 'themes-count' ) . ')',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_all_user_functions( 'themes' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'functions_plugins',
										'type'		=> 'accordion',
										'title'		=> 'Active Plugins',
										'subtitle'	=> 'To preview links, ensure that <a href="/wp-admin/plugin-editor.php" target="_blank">Plugin File Editor</a> is not disabled.',
										'accordions'	=> array(
											array(
												'title'		=> 'View Functions'  . ' (' . $this->sd_get_all_user_functions( 'plugins-count' ) . ')',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_get_all_user_functions( 'plugins' ),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Tools',
										'content'	=> $this->sd_tools( 'classes' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'classes' ),
									),

								),
							),

							array(
								'title'		=> 'Globals',
								'fields'	=> array(

									array(
										'id'			=> 'version_globals',
										'type'			=> 'accordion',
										'title'			=> 'Version',
										'accordions'  	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'version_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'common_globals',
										'type'			=> 'accordion',
										'title'			=> 'Common',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'common_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'themes_plugins_globals',
										'type'			=> 'accordion',
										'title'			=> 'Themes & Plugins',
										'accordions'  	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'themes_plugins_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'various_globals',
										'type'			=> 'accordion',
										'title'			=> 'Various',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
													'type'    => 'content',
													'content' => $this->sd_globals( 'group', 'various_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'admin_globals',
										'type'			=> 'accordion',
										'title'			=> 'Admin',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'admin_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'current_user_globals',
										'type'			=> 'accordion',
										'title'			=> 'Current User',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'current_user_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'main_wp_query_globals',
										'type'			=> 'accordion',
										'title'			=> 'Main Query',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'main_wp_query_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'multisite_globals',
										'type'			=> 'accordion',
										'title'			=> 'Multisite',
										'accordions'	=> array(
										  array(
										    'title'   => 'View',
										    'fields'  => array(
										      array(
										        'type'    => 'content',
										        'content' => $this->sd_globals( 'group', 'multisite_globals', 'ajax' ),
										      ),                          
										    ),
										  ),
										),
									),
									array(
										'id'			=> 'locales_localization_globals',
										'type'			=> 'accordion',
										'title'			=> 'Locales & Localization',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'locales_localization_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'rest_api_globals',
										'type'			=> 'accordion',
										'title'			=> 'REST API',
										'accordions'	=> array(
										  array(
										    'title'   => 'View',
										    'fields'  => array(
										      array(
										        'type'    => 'content',
										        'content' => $this->sd_globals( 'group', 'rest_api_globals', 'ajax' ),
										      ),                          
										    ),
										  ),
										),
									),
									array(
										'id'			=> 'browser_detection_globals',
										'type'			=> 'accordion',
										'title'			=> 'Browser Detection',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'browser_detection_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'web_server_detection_globals',
										'type'			=> 'accordion',
										'title'			=> 'Web Server Detection',
										'accordions'  => array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'web_server_detection_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'posts_loop_globals',
										'type'			=> 'accordion',
										'title'			=> 'Posts Loop',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'posts_loop_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'comments_loop_globals',
										'type'			=> 'accordion',
										'title'			=> 'Comments Loop',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'comments_loop_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'frontend_globals',
										'type'			=> 'accordion',
										'title'			=> 'Front-End',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'frontend_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'non_wpcore_globals',
										'type'			=> 'accordion',
										'title'			=> 'Theme & Plugins',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'non_wpcore_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'id'			=> 'constants_reference',
										'type'			=> 'accordion',
										'title'			=> 'PHP Super Globals',
										'accordions'	=> array(
											array(
												'title'   => 'View',
												'fields'  => array(
													array(
														'type'    => 'content',
														'content' => $this->sd_globals( 'group', 'php_super_globals', 'ajax' ),
													),                          
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'globals' ),
									),

								),
							),

							array(
								'title'		=> 'Constants',
								'fields'	=> array(
									array(
										'id'		=> 'defined_constants',
										'type'		=> 'accordion',
										'title'		=> 'Defined Constants',
										'class'		=> 'constant-values',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														// 'content'	=> $this->sd_constants( 'defined' ),
														'content'	=> $this->sd_html( 'ajax-receiver', 'constant-values' ), // AJAX loading via sd_constants()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'constants_reference',
										'type'		=> 'accordion',
										'title'		=> 'Constants Documentation',
										'class'		=> 'constant-docs',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														// 'content'	=> $this->sd_constants( 'all' ),
														'content'	=> $this->sd_html( 'ajax-receiver', 'constant-docs' ), // AJAX loading via sd_constants()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'References',
										'content'	=> $this->sd_references( 'constants' ),
									),

								),
							),

						),
					),

					array(
						'id'		=> 'server',
						'type'		=> 'tabbed',
						'title' 	=> 'Server',
						'class'		=> 'main-section',
						'subtitle'	=> $this->sd_server_overview(),
						'tabs'		=> array(

							array(
								'title' => 'Monitor',
								'fields' => array(
									array(
										'type'		=> 'content',
										'title'		=> 'Uptime',
										'content'	=> $this->sd_server_uptime(),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'CPU Load Average',
										'subtitle'	=> 'Across all cores, by '. date( 'H:i:s', time() ),
										'content'	=> $this->sd_cpu_load_average(),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'RAM Usage',
										'subtitle'	=> 'At '. date( 'H:i:s', time() ),
										'content'	=> $this->sd_ram_usage(),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Disk Usage',
										'content'	=> $this->sd_disk_usage(),
									),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> 'Web Server',
									// 	'content'	=> $_SERVER['SERVER_SOFTWARE'],
									// ),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> 'Web Server Interface',
									// 	'content'	=> php_sapi_name(),
									// ),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> 'Database Engine',
									// 	'content'	=> $this->sd_get_mysql_version(),
									// ),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> 'Timezone',
									// 	'content'	=> date_default_timezone_get(),
									// ),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> 'Server Time',
									// 	'content'	=> date( 'F j, Y - H:i', time() ),
									// ),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> 'Server IP',
									// 	'content'	=> $_SERVER['SERVER_ADDR'],
									// ),

								),
							),

							array(
								'title' => 'Hardware',
								'fields' => array(

									array(
										'type'		=> 'content',
										'title'		=> 'CPU type',
										'content'	=> $this->sd_cpu_type(),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'CPU / Cores',
										'content'	=> $this->sd_cpu_count(). ' CPUs / '. $this->sd_cpu_core_count() . ' cores',
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Total RAM',
										'content'	=> $this->sd_total_ram_display(),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Total Disk Space',
										'content'	=> $this->sd_format_filesize( disk_total_space( dirname(__FILE__) ) ),
									),

								),
							),

							array(
								'title' => 'PHP',
								'fields' => array(
									array(
										'type'		=> 'content',
										'title'		=> 'Version',
										'content'	=> phpversion(),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'User',
										'content'	=> get_current_user(),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Max Execution Time',
										'content'	=> ini_get( 'max_execution_time' ). ' seconds',
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Max Input Time',
										'content'	=> ini_get( 'max_input_time' ). ' seconds',
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Max Input Vars',
										'content'	=> ini_get( 'max_input_vars' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Memory Limit',
										'content'	=> ini_get( 'memory_limit' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Post Max Size',
										'content'	=> ini_get( 'post_max_size' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Upload Max Size',
										'content'	=> ini_get( 'upload_max_filesize' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Extensions Loaded',
										'content'	=> implode(", ", get_loaded_extensions() ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Disabled Functions',
										'content'	=> str_replace( ",", ", ", ini_get( 'disable_functions' ) ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Error Reporting',
										'subtitle'	=> error_reporting(),
										'content'	=> $this->sd_error_reporting(),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'cURL',
										'content'	=> curl_version()['version'].' | '.curl_version()['ssl_version'],
									),
									array(
										'type'		=> 'content',
										'title'		=> 'allow_url_fopen',
										'content'	=> ( ini_get( 'allow_url_fopen' ) ? 'Yes' : 'No' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'fsockopen',
										'content'	=> ( function_exists('fsockopen') ? 'Yes' : 'No' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'SoapClient',
										'content'	=> ( class_exists('SoapClient') ? 'Yes' : 'No' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'DOMDocument',
										'content'	=> ( class_exists('DOMDocument') ? 'Yes' : 'No' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'GZip',
										'content'	=> ( is_callable('gzopen') ? 'Yes' : 'No' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'SUHOSIN',
										'content'	=> ( ( extension_loaded( 'suhosin' ) || ( defined( 'SUHOSIN_PATCH' ) && constant( 'SUHOSIN_PATCH' ) ) ) ? 'Yes' : 'No' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Imagick',
										'content'	=> ( extension_loaded( 'imagick' ) ? 'Yes' : 'No' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> 'Detailed Specifications',
										'content'	=> '',
									),
									array(
										'id'		=> 'phpinfo_details',
										'type'		=> 'accordion',
										'title'		=> '',
										'class'		=> 'phpinfo-details title-hidden',
										'accordions'	=> array(
											array(
												'title'		=> 'View',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'phpinfo' ), // AJAX loading via sd_php_info()
													),													
												),
											),
										),
									),

								),
							),

							// array(
							// 	'title' => 'Tests',
							// 	'fields' => array(

							// 		array(
							// 			'type'		=> 'content',
							// 			'content'	=> $this->sd_tests(),
							// 		),

							// 	),
							// ),

						),
					),

				),
			) );

		}
	}

	/**
	 * Add 'Dashboard' plugin action link.
	 *
	 * @since    1.0.0
	 */
	
	public function sd_add_plugin_action_links( $links ) {

		$settings_link = '<a href="index.php?page='.$this->plugin_name.'">View Dashboard</a>';

		array_unshift($links, $settings_link); 

		return $links; 

	}

	/**
	 * Add additional links in plugin meta row.
	 *
	 * @since    1.0.0
	 */
	
	public function sd_add_plugin_meta_links( $plugin_meta, $plugin_file ) {

		if ( strpos( $plugin_file, 'system-dashboard.php' ) !== false ) {

			$new_links = array(
				'donate'	=> '<a href="https://paypal.me/qriouslad" target="_blank">Donate</a>',
			);

			$plugin_meta = array_merge( $plugin_meta, $new_links );

		}

		return $plugin_meta;

	}

}
