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
	 * The wp-config.php source file
	 *
	 * @since    2.7.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $wp_config_src;

	/**
	 * The configs defined in wp-config.php
	 *
	 * @since    2.7.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $wp_configs;

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
		$this->wp_config_src = '';
		$this->wp_configs = array();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/system-dashboard-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-json-viewer', plugin_dir_url( __FILE__ ) . 'css/jquery.json-viewer.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-datatables', plugin_dir_url( __FILE__ ) . 'css/datatables.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-fomantic-ui-accordion', plugin_dir_url( __FILE__ ) . 'css/fomantic-ui/accordion.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/system-dashboard-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-json-viewer', plugin_dir_url( __FILE__ ) . 'js/jquery.json-viewer.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-datatables', plugin_dir_url( __FILE__ ) . 'js/datatables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-fomantic-ui-accordion', plugin_dir_url( __FILE__ ) . 'js/fomantic-ui/accordion.js', array(), $this->version, false );

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
	 * Output HTML parts mainly for columns with widths equally divided between them
	 *
	 * @since 2.2.0
	 */
	public function sd_html_parts( $type, $classes = '', $first_part = '', $second_part = '', $third_part = '', $fourth_part = '' ) {
		
		$classes_output = '';

		if ( !empty( $classes ) ) {

			$classes_output = ' ' . $classes;
		}

		$output = '<div class="parts'. $classes_output .'">';

		if ( ( $type == 'halves' ) || ( $type == 'thirds' ) || ( $type == 'quarts' ) ) {
			$output .= '<div class="'. $type .'">'. $first_part .'</div>';
			$output .= '<div class="'. $type .'">'. $second_part .'</div>';
		}

		if ( ( $type == 'thirds' ) || ( $type == 'quarts' ) ) {
			$output .= '<div class="'. $type .'">'. $third_part .'</div>';
		}

		if ( $type == 'quarts' ) {
			$output .= '<div class="'. $type .'">'. $fourth_part .'</div>';
		}

		$output .= '</div>';

		return $output;

	}

	/** 
	 * Preview various output of functions related to WordPress URLs, directories and paths
	 *
	 * @since 1.0.0
	 */
	public function sd_tests() {

		$output = '';

		return $output;

	}

	/**
	 * Check if current installation is localhost or not
	 * 
	 * @since 2.8.5
	 */
	public function is_localhost() {
		
		$localhost = array( '127.0.0.1', '::1' );
		return in_array( $_SERVER['REMOTE_ADDR'], $localhost );

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

		$output = '<div class="wordpress-overview">';

		$output .= '<strong>' . __( 'Site Health', 'system-dashboard' ) . '</strong>: <br />' . $this->sd_site_health() . '<br />';

		$output .= '<strong>' . __( 'Theme', 'system-dashboard' ) . '</strong>: <br /><a href="'. wp_get_theme()->get( 'ThemeURI' ) .'" target="_blank">'.wp_get_theme()->get( 'Name' ) .'</a> v'.wp_get_theme()->get( 'Version' ).'<br />';

		// if ( !empty( wp_get_theme()->get( 'Author' ) ) ) {

		// 	$output .= 'by <a href="'.wp_get_theme()->get( 'AuthorURI' ).'" target="_blank">'. wp_get_theme()->get( 'Author' ) .'</a><br />';

		// }

		if ( ! function_exists( 'get_plugins' ) ) {

		    require_once ABSPATH . 'wp-admin/includes/plugin.php';

		}

		$output .= '<strong>' . __( 'Plugins', 'system-dashboard' ) . '</strong>: <br /><a href="/wp-admin/plugins.php" target="_blank">' . count( get_plugins() ) . ' ' . __( 'installed', 'system-dashboard' ) . '</a> | <a href="/wp-admin/plugins.php?plugin_status=active" target="_blank">' . count( get_option( 'active_plugins' ) ) . ' ' . __( 'active', 'system-dashboard' ) . '</a><br />';

		$output .= '<strong>' . __( 'Permalink Structure', 'system-dashboard' ) . '</strong>: <br />' . get_option( 'permalink_structure' ) . '<br />';

		$output .= '<strong>' . __( 'Search Engine Visibility', 'system-dashboard' ) . '</strong>: <br />' . ( ( 0 == get_option( 'blog_public' ) ) ? __( 'Discouraged', 'system-dashboard' ) : __( 'Encouraged', 'system-dashboard' ) ) . '<br />';

		$output .= '<strong>' . __( 'Timezone', 'system-dashboard' ) . '</strong>: <br />' . get_option( 'timezone_string' ) . '<br />';

		$output .= '<strong>' . __( 'Current Date Time', 'system-dashboard' ) . '</strong>: <br />' . current_time( 'F j, Y - H:i' ) . '<br />';

		$output .= '<strong>' . __( 'Your IP', 'system-dashboard' ) . '</strong>: <br />' . $this->sd_get_user_ip() . '<br />';

		$output .= '<div style="display: none;">' . $this->sd_active_plugins( 'original', 'print_r') . '</div>';

		$output .= '</div>';

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

		global $wpdb;

		$output = '<div class="server-overview">';

		$output .= '<strong>' . __( 'Operating System', 'system-dashboard' ) . '</strong>: <br />' . $this->sd_os_info(). '<br />';

		$output .= '<strong>' . __( 'Web Server', 'system-dashboard' ) . '</strong>: <br />' .$_SERVER['SERVER_SOFTWARE'] . ' | ' . php_sapi_name() . '<br />';

		if ( function_exists( 'file_get_contents' ) ) {

			if ( isset( $_SERVER['HTTP_X_SERVER_ADDR'] ) ) {

				$output .= '<strong>IP</strong>: <br />' . $_SERVER['HTTP_X_SERVER_ADDR'] . '<br />';

			} else {

				$output .= '<strong>IP</strong>: <br />' . $_SERVER['SERVER_ADDR'] . '<br />';
				
			}
		}

		// Get hostname info from cache or DB

		$hostname_query = wp_cache_get( 'sd_db_hostname', 'wpdb-queries' );

		if ( false === $hostname_query ) {
			$hostname_query = $wpdb->get_row("SHOW VARIABLES LIKE 'hostname'");
			wp_cache_set( 'sd_db_hostname', $hostname_query, 'wpdb-queries', YEAR_IN_SECONDS );
		}

		$hostname = $hostname_query->Value;

		$output .= '<strong>' . __( 'Hostname', 'system-dashboard' ) . '</strong>: <br />' . $hostname . '<br />';

		$output .= '<strong>' . __( 'Location', 'system-dashboard' ) . '</strong>: <br />' . $this->sd_server_location() . '<br />';

		$output .= '<strong>' . __( 'Timezone', 'system-dashboard' ) . '</strong>: <br />' . date_default_timezone_get() . '<br />';

		$output .= '<strong>' . __( 'Server Date Time', 'system-dashboard' ) . '</strong>: <br />' . date( 'F j, Y - H:i', time() );

		$output .= '</div>';

		return $output;

	}

	/**
	 * Get MySQL version
	 * 
	 * @link https://plugins.trac.wordpress.org/browser/debug-info/tags/1.3.10/debug-info.php
	 * @since 1.0.0
	 */
	function sd_get_mysql_version() {
		
		global $wpdb;

		 // if ( is_callable( 'mysqli_get_client_info' ) ) {

		 // 	$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		 	
		 // 	if ( ! is_bool( $connection ) ) {

		// 		return mysqli_get_server_info( $connection );		 	
		 		
		 // 	} else {
		 		
		 // 		return 'Undetectable';

		 // 	}

		 // } elseif ( !is_callable( 'mysqli_get_client_info' ) ) {

		// 	global $wpdb;

		// 	$rows = $wpdb->get_results('select version() as mysqlversion');

		// 	if (!empty($rows)) {
		// 	         return $rows[0]->mysqlversion;
		// 	}

		 // } else {

		// 	return 'Undetectable';

		 // }

		// return $wpdb->db_version(); // e.g. 10.5.23
		return $wpdb->db_server_info(); // e.g. 10.5.23-MariaDB-1:10.5.23+maria~ubu2004

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
			$ip = filter_var( $_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP );
		} elseif( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	/**
	 * Get post types info 
	 * 
	 * @link https://plugins.trac.wordpress.org/browser/wp-system-info/trunk/class/common.php
	 * @since 1.0.0
	 */
	public function sd_post_types(){

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			global $wpdb;

			$post_types = $wpdb->get_results( "SELECT post_type AS 'type', count(1) AS 'count' FROM {$wpdb->posts} GROUP BY post_type ORDER BY count DESC;" );

			$output = '';

			foreach ( $post_types as $post_type ) {

				$label_name = '';

				$post_type_object = get_post_type_object( $post_type->type );

				if ( isset( $post_type_object->labels ) ) {
					$labels = $post_type_object->labels;
					$label_name = isset( $labels->name ) ? ' (' . $labels->name . ')' : '';
				}

				$output .= $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', $post_type->type . $label_name );
				$output .= $this->sd_html( 'field-content-second', $post_type->count );
				$output .= $this->sd_html( 'field-content-end' );

			}

			echo $output;

		}

	}

	/**
	 * Get taxonomies info
	 *
	 * @since 1.0.0
	 */
	public function sd_taxonomies( $type = 'name' ) {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

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

			echo $taxonomies_info;

		}

	}

	/**
	 * Get old slugs
	 *
	 * @link http://plugins.svn.wordpress.org/remove-old-slugspermalinks/tags/2.6.0/includes/class-alg-slugs-manager-core.php
	 * @since 1.5.0
	 */
	public function sd_old_slugs() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			global $wpdb;

			$query = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_wp_old_slug' ORDER BY post_id";

			$results = $wpdb->get_results( $query );

			$results_array = json_decode( json_encode( $results ), true );

			$output = $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '<strong>Old Slug &#10132; Current Slug</strong>' );
			$output .= $this->sd_html( 'field-content-second', '<strong>Post Title (Post Type - Post ID)</strong>' );
			$output .= $this->sd_html( 'field-content-end' );			


			foreach ( $results_array as $old_slug ) {

				$output .= $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', $old_slug['meta_value'] . '<br />&#10132; ' . get_post_field( 'post_name', $old_slug['post_id'] ) );
				$output .= $this->sd_html( 'field-content-second', '<a href="'. get_the_permalink( $old_slug['post_id'] ) .'" target="_blank">' . get_the_title( $old_slug['post_id'] ) . '</a><br />(' . get_post_field( 'post_type', $old_slug['post_id'] ) . ' - ' . $old_slug['post_id'] . ')' );
				$output .= $this->sd_html( 'field-content-end' );			

			}

			echo $output;

		}

	}

	/** 
	 * Get media/attachments count by MIME type
	 * 
	 * @link https://plugins.trac.wordpress.org/browser/cl-wp-info/trunk/class-cl-wp-info.p	 
	 * @since 1.0.0
	 */
	public function sd_media_count() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

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

			echo $output;

		}
	}

	/**
	 * Get registered image sizes
	 *
	 * @link http://plugins.svn.wordpress.org/wp-system/tags/1.0.7/report.php
	 * @since 2.4.4
	 */
	public function sd_image_sizes() {
		
		if ( current_user_can( 'manage_options' ) ) {
			global $_wp_additional_image_sizes;

			do_action( 'inspect', [ '_wp_additional_image_sizes', $_wp_additional_image_sizes ] );

			$builtin_sizes = array( 'thumbnail', 'medium', 'large', 'full', 'post-thumbnail' );
			$sizes = array();

			$intermediate_image_sizes = get_intermediate_image_sizes();
			$additional_image_sizes = wp_get_additional_image_sizes();

			do_action( 'inspect', [ 'additional_image_sizes', $additional_image_sizes ] );

			foreach ( $intermediate_image_sizes as $size ) {

				if ( in_array( $size, $builtin_sizes ) ) {

					$sizes[$size] = array(
						'type'		=> 'Default',
						'width' 	=> get_option( $size . '_size_w' ),
						'height' 	=> get_option( $size . '_size_h' ),
						'crop'		=> (bool) get_option( $size . '_crop' ),
					);

				} elseif ( isset( $additional_image_sizes[$size] ) ) {

					$sizes[$size] = array(
						'type'		=> 'Custom',
						'width'		=> $additional_image_sizes[$size]['width'],
						'height'	=> $additional_image_sizes[$size]['height'],
						'crop'		=> $additional_image_sizes[$size]['crop'],
					);

				}

			}

			do_action( 'inspect', [ 'sizes', $sizes ] );

			$output = '';

			foreach ( $sizes as $key => $value ) {

				if ( isset( $value['crop'] ) ) {

					if ( $value['crop'] === true ) {

						$crop_value = __( ' | Crop: true', 'system-dashboard' );
						$size_type = __( 'Exactly', 'system-dashboard' );

					} elseif ( $value['crop'] === false ) {

						$crop_value = '';
						$size_type = __( 'Maximum', 'system-dashboard' );

					} else {

						$crop_value = __( ' | Crop: ', 'system-dashboard' ) . $value['crop'][0] . '-' . $value['crop'][1];
						$size_type = __( 'Exactly', 'system-dashboard' );

					}

				}

				$output .= $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', $key . ' ('. $value['type'] . $crop_value . ')' );
				$output .= $this->sd_html( 'field-content-second', $size_type . ' ' . $value['width'] . ' (width) x ' . $value['height'] . ' (height) pixels ' );
				$output .= $this->sd_html( 'field-content-end' );

			}			
		} else {
			$output = '';
		}

		echo $output;

	}

	/**
	 * Get list of MIME types and associated file extensions
	 *
	 * @since 1.0.0
	 */
	public function sd_mime_types() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$mime_types = get_allowed_mime_types();

			$output = '';

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '<strong>' . __( 'File Extension(s)', 'system-dashboard' ) . '</strong>' );
			$output .= $this->sd_html( 'field-content-second', '<strong>' . __( 'MIME Type', 'system-dashboard' ) . '</strong>' );
			$output .= $this->sd_html( 'field-content-end' );

			foreach ( $mime_types as $extensions => $mime_type ) {

				$extensions = str_replace( "|", " | ", $extensions );

				$output .= $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', $extensions );
				$output .= $this->sd_html( 'field-content-second', $mime_type, 'long-value' );
				$output .= $this->sd_html( 'field-content-end' );

			}

			echo $output;

		}

	}

	/**
	 * Get info on media handling
	 *
	 * @link wp-admin/includes/class-wp-debug-data.php
	 * @since 1.2.0
	 */
	public function sd_media_handling() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$output = '';

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'Active editor', 'system-dashboard' ) );
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
			$output .= $this->sd_html( 'field-content-first', __( 'ImageMagick version number', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', ( is_array( $imagemagick_version ) ? $imagemagick_version['versionNumber'] : $imagemagick_version ) );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'ImageMagick version string', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', ( is_array( $imagemagick_version ) ? $imagemagick_version['versionString'] : $imagemagick_version ) );
			$output .= $this->sd_html( 'field-content-end' );

			$imagick_version = phpversion( 'imagick' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'Imagick version', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', ( $imagick_version ) ? $imagick_version : __( 'Not available' ) );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'Max size of post data allowed', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', ini_get( 'post_max_size' ) );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'Max size of an uploaded file', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', ini_get( 'upload_max_filesize' ) );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'Max number of files allowed', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', number_format( ini_get( 'max_file_uploads' ) ) );
			$output .= $this->sd_html( 'field-content-end' );

			// Get GD information, if available.
			if ( function_exists( 'gd_info' ) ) {
				$gd = gd_info();
			} else {
				$gd = false;
			}

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'GD version', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', ( is_array( $gd ) ? $gd['GD Version'] : __( 'Not available', 'system-dashboard' ) ) );
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
				$index = $format_key . ' ' . __( 'Support', 'system-dashboard' );
				if ( isset( $gd[ $index ] ) && $gd[ $index ] ) {
					array_push( $gd_image_formats, $format );
				}
			}

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'GD supported file formats', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', implode( ', ', $gd_image_formats ) );
			$output .= $this->sd_html( 'field-content-end' );

			// Get Ghostscript information, if available.
			if ( function_exists( 'exec' ) ) {
				$gs = exec( 'gs --version' );

				if ( empty( $gs ) ) {
					$gs = __( 'Not available', 'system-dashboard' );
				} else {
				}
			} else {
				$gs = __( 'Unable to determine if Ghostscript is installed', 'system-dashboard' );
			}

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'Ghostscript version', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', $gs );
			$output .= $this->sd_html( 'field-content-end' );

			echo $output;

		}

	}

	/**
	 * Get user roles and associated capabilities
	 * 
	 * @param string $type default_roles | custom_roles
	 * @param string $return role_names | role_capabilities
	 * @since 1.0.0
	 */
	public function sd_roles_capabilities( $return = 'all' ) {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

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
					$role_type = __( 'Default role', 'system-dashboard' );
					$default_roles[] = $roleslug;

				} else {

					// $output .= $roleslug . ' is custom.<br />';
					$role_type = __( 'Custom role', 'system-dashboard' );
					$custom_roles[] = $roleslug;

				}

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

			echo $output;

		}

	}

	/** 
	 * Get media/attachments info by MIME type 
	 * 
	 * @link https://plugins.trac.wordpress.org/browser/cl-wp-info/trunk/class-cl-wp-info.php 
	 * @since 1.0.0
	 */
	public function sd_user_count() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$users = count_users();
			$output = '';

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', 'All roles' );
			$output .= $this->sd_html( 'field-content-second', $users['total_users'] .' ' . __( 'users', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-end' );

			foreach ( $users['avail_roles'] as $role => $count ) {

				if ( !empty( $count ) ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', $role );
					$output .= $this->sd_html( 'field-content-second', $count .' ' . __( 'users', 'system-dashboard' ) );
					$output .= $this->sd_html( 'field-content-end' );

				}

			}

			echo $output;

		}

	}

	/**
	 * Get list of all defined custom fields
	 * 
	 * @link https://css-tricks.com/snippets/wordpress/dump-all-custom-fields/
	 * @since 1.0.0
	 */	
	public function sd_custom_fields( $count = 'public-count' ) {

		global $wpdb;

		$query = "
	        SELECT DISTINCT($wpdb->postmeta.meta_key) 
	        FROM $wpdb->postmeta;
	    ";

	    // Get meta keys info from cache or DB

		$results = wp_cache_get( 'sd_db_postmeta_meta_keys', 'wpdb-queries' );

		if ( false === $results ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( 'sd_db_postmeta_meta_keys', $results, 'wpdb-queries', MINUTE_IN_SECONDS );
		}

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

		if ( isset( $_REQUEST ) && isset( $_REQUEST['type'] ) && current_user_can( 'manage_options' ) ) {

			$type = $_REQUEST['type'];

			if ( $type == 'public' ) {

				foreach( $public_custom_fields as $public_custom_field ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', $public_custom_field, 'full-width' );
					$output .= $this->sd_html( 'field-content-end' );

				}

				echo $output;

			} elseif ( $type == 'private' ) {

				foreach( $private_custom_fields as $private_custom_field ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', $private_custom_field, 'field-full-width' );
					$output .= $this->sd_html( 'field-content-end' );

				}

				echo $output;

			} else {}

		}

		if ( $count == 'public-count' ) {

			$output = $public_custom_fields_count;
			return $output;

		} elseif ( $count == 'private-count' ) {

			$output = $private_custom_fields_count;
			return $output;

		} else {}

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
		if ( is_numeric( $bytes ) ) {
			if (($bytes / pow(1024, 5)) > 1) {
				return number_format_i18n(($bytes / pow(1024, 5)), 0) . ' PB';
			} elseif (($bytes / pow(1024, 4)) > 1) {
				return number_format_i18n(($bytes / pow(1024, 4)), 0) . ' TB';
			} elseif (($bytes / pow(1024, 3)) > 1) {
				return number_format_i18n(($bytes / pow(1024, 3)), 0) . ' GB';
			} elseif (($bytes / pow(1024, 2)) > 1) {
				return number_format_i18n(($bytes / pow(1024, 2)), 0) . ' MB';
			} elseif ($bytes / 1024 > 1) {
				return number_format_i18n($bytes / 1024, 0) . ' KB';
			} elseif ($bytes >= 0) {
				return number_format_i18n($bytes, 0) . ' bytes';
			}
		} else {
			return __( 'Unknown', 'system-dashboard' );
		}
	}

	/**
	 * Format file size originally in kilobytes (kB)
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_format_filesize_kB( $kiloBytes ) {
		if ( is_numeric( $kiloBytes ) ) {
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
			}
		} else {
			return __( 'Unknown', 'system-dashboard' );
		}
	}

	/**
	 * Get server uptime
	 *
	 * @since 1.0.0
	 */
	public function sd_server_uptime() {
		
		if ( ! $this->is_localhost() && $this->is_shell_exec_enabled() ) {

			$raw_uptime = shell_exec("cut -d. -f1 /proc/uptime");

			if ( ! is_null( $raw_uptime ) ) {
				$uptime = trim(shell_exec("cut -d. -f1 /proc/uptime"));

				if ( is_numeric( $uptime ) ) {
					$uptime_in_days = (float) ( $uptime / 60 / 60 / 24 );
					$uptime = number_format_i18n( $uptime_in_days ). ' days';				
				} else {
					$uptime = __( 'Undetectable', 'system-dashboard' );					
				}
			} else {
				$uptime = __( 'Undetectable', 'system-dashboard' );				
			}

		} else {

			$uptime = __( 'Undetectable. Please enable \'shell_exec\' function in PHP first.', 'system-dashboard' );
			
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
			if ( ! is_null( $os ) && ! empty( $os ) ) {
				$os = str_replace( "Description", " | Description", $os );
				$os = str_replace( "Release", " | Release", $os );
				$os = str_replace( "Codename", " | Codename", $os );
				$os_array = explode(" | ", $os);
				if ( isset( $os_array[1] ) ) {
					$os = $os_array[1];
					$os = str_replace( ":", "", $os );
					$os = str_replace( "Description", "", $os );				
				} else {
					$os = __( 'Undetectable', 'system-dashboard' );
				}
			} else {
				$os = __( 'Undetectable', 'system-dashboard' );
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

		if ( ! $this->is_localhost() && function_exists( 'file_get_contents' ) ) {

			if ( isset( $_SERVER['HTTP_X_SERVER_ADDR'] ) ) {

				$server_ip = $_SERVER['HTTP_X_SERVER_ADDR'];

			} else {

				$server_ip = $_SERVER['SERVER_ADDR'];
				
			}

			$location_data = get_transient('sd_server_location');

			if ( false === $location_data ) {

				$location_data = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $server_ip ) );

				set_transient('sd_server_location', $location_data, WEEK_IN_SECONDS);

			}
			
			if ( is_array( $location_data ) && isset( $location_data['geoplugin_city'] ) && isset( $location_data['geoplugin_countryName'] ) ) {

				$location = $location_data['geoplugin_city'] . ', ' . $location_data['geoplugin_countryName'];

				$location = trim(trim($location),',');
				
			} else {
				
				$location = __( 'Undetectable', 'system-dashboard' );

			}

			return $location;

		} else {

			return __( 'Undetectable', 'system-dashboard' );

		}

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
				if ( ! is_null( $sd_cpu_type ) ) {
					$sd_cpu_type = str_replace( ":", "", $sd_cpu_type );
					$sd_cpu_type = str_replace( "model name", "", $sd_cpu_type );
					$sd_cpu_type = trim( $sd_cpu_type );

					set_transient('sd_cpu_type', $sd_cpu_type, WEEK_IN_SECONDS);					
				} else {
					$sd_cpu_type = __( 'Undetectable', 'system-dashboard' );
					set_transient('sd_cpu_type', $sd_cpu_type, WEEK_IN_SECONDS);					
				}

			}

		} else {

			$sd_cpu_type = __( 'Undetectable. Please enable \'shell_exec\' function in PHP first.', 'system-dashboard' );

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

		if ($this->is_shell_exec_enabled()) {

			$cpu_count = get_transient('sd_cpu_count');

			if ($cpu_count === false) {

				$cpu_count = shell_exec('cat /proc/cpuinfo |grep "physical id" | sort | uniq | wc -l');

				set_transient('sd_cpu_count', $cpu_count, WEEK_IN_SECONDS);

			}

		} else {

			$cpu_count = 'Undetectable';

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

		if ($this->is_shell_exec_enabled()) {

			$cpu_core_count = get_transient('sd_cpu_core_count');

			if ($cpu_core_count === false) {

				$cpu_core_count = shell_exec("echo \"$((`cat /proc/cpuinfo | grep cores | grep -o -E '[0-9]+' | uniq` * `cat /proc/cpuinfo |grep 'physical id' | sort | uniq | wc -l`))\"");

				set_transient('sd_cpu_core_count', $cpu_core_count, WEEK_IN_SECONDS);

			}

		} else {

			$cpu_core_count =  'Undetectable';

		}

		return $cpu_core_count;
	}

	/**
	 * Get CPUs and cores count
	 *
	 * @since 2.0.2
	 */
	public function sd_cpus_cores_count() {

		$cpus_count = $this->sd_cpu_count();
		$cores_count = $this->sd_cpu_core_count();

		if ( ( $cpus_count != 'Undetectable' ) && ( $cores_count != 'Undetectable' ) ) {

			return $this->sd_cpu_count(). ' CPUs / '. $this->sd_cpu_core_count() . ' ' . __( 'cores', 'system-dashboard' );

		} else {

			return __( 'Undetectable. Please enable \'shell_exec\' function in PHP first.', 'system-dashboard' );

		}

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

			if ( ! is_null( $cpu_load_average ) ) {
				
				$cpu_load_average_array = explode( ", ", $cpu_load_average );
				
				if ( is_array( $cpu_load_average_array ) && ! empty( $cpu_load_average_array ) ) {

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

					$cpu_load_average = __( 'Last 15 minutes', 'system-dashboard' ) . ': '. $last_15minutes_pct .' ('. $last_15minutes .')<br /> ' . __( 'Last 5 minutes', 'system-dashboard' ) . ': '. $last_5minutes_pct .' ('. $last_5minutes .')<br /> ' . __( 'Last 1 minute', 'system-dashboard' ) . ': '. $last_1minutes_pct .' ('. $last_1minute .')';	
					
				} else {

					$cpu_load_average = __( 'Undetectable', 'system-dashboard' );
					
				}
							
			} else {

				$cpu_load_average = __( 'Undetectable', 'system-dashboard' );
				
			}

		} else {

			$cpu_load_average = __( 'Undetectable. Please enable \'shell_exec\' function in PHP first.', 'system-dashboard' );

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

		if ( ! $this->is_localhost() && $this->is_shell_exec_enabled() ) {

			$total_ram = get_transient('sd_total_ram');

			if ($total_ram === false) {

				$total_ram = shell_exec("grep -w 'MemTotal' /proc/meminfo | grep -o -E '[0-9]+'");

				set_transient('sd_total_ram', $total_ram, WEEK_IN_SECONDS);

			}

		} else {

			$total_ram = 'Undetectable';

		}

		if ( ! is_null( $total_ram ) ) {

			return trim($total_ram);		

		} else {
			
			return 'Undetectable';

		}

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

			$ram_cache = 'Undetectable';

		}
		
		if ( ! is_null( $ram_cache ) ) {

			return trim($ram_cache);
			
		} else {

			return 'Undetectable';

		}

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

		if ( ! is_null( $ram_buffer ) ) {

			return trim($ram_buffer);		

		} else {

			return 'Undetectable';
			
		}

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

				if( !is_null( $free_ram ) || !is_null( $this->sd_ram_cache() ) || !is_null( $this->sd_ram_buffer() ) ) {
					$free_ram = is_null( $free_ram ) ? 0 : (int) $free_ram;
					$ram_cache = is_null( $this->sd_ram_cache() ) ? 0 : (int) $this->sd_ram_cache();
					$ram_buffer = is_null( $this->sd_ram_buffer() ) ? 0 : (int) $this->sd_ram_buffer();
					$free_ram_final = (int) $free_ram + $ram_cache + $ram_buffer;
				} else {
					$free_ram_final = is_null( $free_ram ) ? 0 : (int) $free_ram;;
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

		if ( ! $this->is_localhost() && $this->is_shell_exec_enabled() ) {

			$free_ram = $this->sd_free_ram();
			$total_ram = $this->sd_total_ram();

			if ( $free_ram != 'Undetectable' && is_numeric( $free_ram ) && $total_ram != 'Undetectable' && is_numeric( $total_ram ) ) {

				$used_ram = $this->sd_format_filesize_kB( (int) $total_ram - (int) $free_ram ) .' ('. round( ( ( ( (int) $total_ram - (int) $free_ram ) / (int) $total_ram ) * 100 ), 0).'%)';

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

			return __( 'Undetectable. Please enable \'shell_exec\' function in PHP first.', 'system-dashboard' );

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

			return __( 'Undetectable. Please enable \'shell_exec\' function in PHP first.', 'system-dashboard' );

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
	public function sd_total_disk_space( $type = 'raw' ) {

		if ( function_exists( 'disk_total_space' ) ) {

			$total_disk_space = get_transient('sd_total_disk_space');

			if ($total_disk_space === false) {

					$total_disk_space = disk_total_space( dirname(__FILE__) );

					set_transient('sd_total_disk_space', $total_disk_space, WEEK_IN_SECONDS);

			}

			if ( $type == 'raw' ) {

				// do nothing

			} elseif ( $type == 'formatted' ) {

				$total_disk_space = $this->sd_format_filesize( $total_disk_space );

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

		if ( ( $free_disk_space != 'Undetectable' ) && ( $total_disk_space != 'Undetectable' ) && ( $total_disk_space !== 0 ) ) {

			$used_disk_space = $total_disk_space - $free_disk_space;

			return $this->sd_format_filesize( $used_disk_space ) . ' (' . round ( ( ( $used_disk_space / $total_disk_space ) * 100 ), 0 ) . '%) used of ' . $this->sd_format_filesize( $total_disk_space ) . ' total';

		} else {

			return __( 'Undetectable', 'system-dashboard' );

		}

	}

	/**
	 * Get PHP detail specifications (via AJAX call)
	 * 
	 * @link https://plugins.svn.wordpress.org/wp-server-stats/trunk/wp-server-stats.php
	 * @since 1.0.0
	 */
	public function sd_php_info() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {


			if ( !class_exists( 'DOMDocument' ) ) {
				return __( 'Please enable DOMDocument extension first.', 'system-dashboard' );
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
	public function sd_directory_sizes() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$output = '';

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'All directories and files', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( str_replace( "/wp-content", "", WP_CONTENT_DIR ) ) . $this->sd_files_count( str_replace( "/wp-content", "", WP_CONTENT_DIR ) ) );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '/wp-admin' );
			$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( ABSPATH . '/wp-admin' ) . $this->sd_files_count( ABSPATH . '/wp-admin' ) );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '/wp-includes' );
			$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( ABSPATH . '/wp-includes' ) . $this->sd_files_count( ABSPATH . '/wp-includes' ) );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '/wp-content' );
			$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( WP_CONTENT_DIR ) . $this->sd_files_count( WP_CONTENT_DIR ) );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '/wp-content/uploads' );
			$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( WP_CONTENT_DIR.'/uploads' ) . $this->sd_files_count( WP_CONTENT_DIR.'/uploads' ) );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '/wp-content/plugins' );
			$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( WP_CONTENT_DIR.'/plugins' ) . $this->sd_files_count( WP_CONTENT_DIR.'/plugins' ) );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '/wp-content/themes' );
			$output .= $this->sd_html( 'field-content-second', $this->sd_dir_size( WP_CONTENT_DIR.'/themes' ) . $this->sd_files_count( WP_CONTENT_DIR.'/themes' ) );
			$output .= $this->sd_html( 'field-content-end' );

			echo $output;

		}

	}

	/**
	 * Get filesystem permission status
	 *
	 * @link wp-admin/includes/class-wp-debug-data.php
	 * @since 1.0.0
	 */
	public function sd_filesystem_permissions() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$output = '';

			$checkmark = '<span class="sd__symbol sd__symbol--green">&check;</span>';
			$xmark = '<span class="sd__symbol sd__symbol--red">&cross;</span>';

			if ( wp_is_writable( ABSPATH ) ) {
				$is_writable_abspath = $checkmark . ' ' . __( 'Writeable', 'system-dashboard' );
			} else {
				$is_writable_abspath = $xmark . ' ' . __( 'Not writeable', 'system-dashboard' );			
			}

			if ( wp_is_writable( WP_CONTENT_DIR ) ) {
				$is_writable_wp_content_dir = $checkmark . ' ' . __( 'Writeable', 'system-dashboard' );
			} else {
				$is_writable_wp_content_dir = $xmark . ' ' . __( 'Not writeable', 'system-dashboard' );			
			}

			if ( wp_is_writable( wp_upload_dir()['basedir'] ) ) {
				$is_writable_upload_dir = $checkmark . ' ' . __( 'Writeable', 'system-dashboard' );
			} else {
				$is_writable_upload_dir = $xmark . ' ' . __( 'Not writeable', 'system-dashboard' );			
			}

			if ( wp_is_writable( WP_PLUGIN_DIR ) ) {
				$is_writable_wp_plugin_dir = $checkmark . ' ' . __( 'Writeable', 'system-dashboard' );
			} else {
				$is_writable_wp_plugin_dir = $xmark . ' ' . __( 'Not writeable', 'system-dashboard' );			
			}

			if ( wp_is_writable( get_theme_root( get_template() ) ) ) {
				$is_writable_template_directory = $checkmark . ' ' . __( 'Writeable', 'system-dashboard' );
			} else {
				$is_writable_template_directory = $xmark . ' ' . __( 'Not writeable', 'system-dashboard' );			
			}

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', __( 'The main WordPress directory', 'system-dashboard' ) );
			$output .= $this->sd_html( 'field-content-second', $is_writable_abspath );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '/wp-content' );
			$output .= $this->sd_html( 'field-content-second', $is_writable_wp_content_dir );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '/wp-content/uploads' );
			$output .= $this->sd_html( 'field-content-second', $is_writable_upload_dir );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '/wp-content/plugins' );
			$output .= $this->sd_html( 'field-content-second', $is_writable_wp_plugin_dir );
			$output .= $this->sd_html( 'field-content-end' );

			$output .= $this->sd_html( 'field-content-start' );
			$output .= $this->sd_html( 'field-content-first', '/wp-content/themes' );
			$output .= $this->sd_html( 'field-content-second', $is_writable_template_directory );
			$output .= $this->sd_html( 'field-content-end' );

			echo $output;

		}

	}

	/**
	 * Get total number of files in a path
	 *
	 * @link https://stackoverflow.com/a/41848361
	 * @since 2.6.1
	 */
	public function sd_files_count( $path ) {

		$objects = new RecursiveIteratorIterator(
		    new RecursiveDirectoryIterator( $path ),
		    RecursiveIteratorIterator::SELF_FIRST // Include the directories in the count
		);

		$count = iterator_count( $objects );

		return ' - ' . number_format($count) . ' ' . __( 'files and directories', 'system-dashboard' );

	}
	/**
	 * File and URL viewer
	 *
	 * @param string $filename
	 * @since 1.5.0
	 */
	public function sd_viewer() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$filename = sanitize_text_field( $_REQUEST['filename'] );
			
			if ( in_array( $filename, array( 'wpcnfg', '.htaccess', 'robots.txt', '/wp-json/wp/v2' ) ) ) {
				
				if ( $filename == 'wpcnfg' ) {
					$file_path = $this->sd_wpconfig_file_path();
				} else {
					$file_path = ABSPATH . $filename;
				}
					
				if ( ! file_exists( $file_path ) ) {

					if ( $filename == 'robots.txt' ) {

						$response = wp_remote_get( get_site_url() . '/' . $filename );

						$file_content = nl2br( trim( wp_remote_retrieve_body( $response ) ) );

						$output = $file_content;

					} else {

						$output = $file_path . ' ' . __( 'does not exist', 'system-dashboard' );

					}

				} else {

					$file_content = nl2br( trim( file_get_contents( $file_path, true ) ) );

					$output = $file_content;

				}
				
			} else {
				
				$output = '';

			}

			echo wp_kses_post( $output );

		}

	}

	/**
	 * Get content of a URL
	 *
	 * @since 2.5.0
	 */
	public function sd_viewer_url() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$path = $_REQUEST['path'];

			$response = wp_remote_get( get_site_url() . $path );

			echo trim( wp_remote_retrieve_body( $response ) );

		}

	}

	/**
	 * Get output of WP core functions and constants for URLs and paths
	 *
	 * @since 2.5.1
	 */
	public function sd_urls_paths() {

		$code_reference_base_url = 'https://developer.wordpress.org/reference/functions/';

		$output = '';

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '$_SERVER[\'HOME\']' );
		$output .= $this->sd_html( 'field-content-second', isset( $_SERVER['HOME'] ) ? $_SERVER['HOME'] : '' );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '$_SERVER[\'HTTP_HOST\']' );
		$output .= $this->sd_html( 'field-content-second', $_SERVER['HTTP_HOST'] );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '$_SERVER[\'SERVER_NAME\']' );
		$output .= $this->sd_html( 'field-content-second', $_SERVER['SERVER_NAME'] );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '$_SERVER[\'DOCUMENT_ROOT\']' );
		$output .= $this->sd_html( 'field-content-second', $_SERVER['DOCUMENT_ROOT'] );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'ABSPATH' );
		$output .= $this->sd_html( 'field-content-second', constant( 'ABSPATH' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'dirname(ABSPATH)' );
		$output .= $this->sd_html( 'field-content-second', dirname(ABSPATH) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_site_url/" target="_blank">get_site_url()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_site_url() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_home_url/" target="_blank">get_home_url()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_home_url() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'admin_url/" target="_blank">admin_url()</a>' );
		$output .= $this->sd_html( 'field-content-second', admin_url() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'WPINC' );
		$output .= $this->sd_html( 'field-content-second', constant( 'WPINC' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'content_url/" target="_blank">content_url()</a>' );
		$output .= $this->sd_html( 'field-content-second', content_url() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'WP_CONTENT_URL' );
		$output .= $this->sd_html( 'field-content-second', constant( 'WP_CONTENT_URL' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'WP_CONTENT_DIR' );
		$output .= $this->sd_html( 'field-content-second', constant( 'WP_CONTENT_DIR' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', "<a href=\"'.$code_reference_base_url.'wp_upload_dir/\" target=\"_blank\">wp_upload_dir()</a>['baseurl']" );
		$output .= $this->sd_html( 'field-content-second', wp_upload_dir()['baseurl'] );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', "<a href=\"'.$code_reference_base_url.'wp_upload_dir/\" target=\"_blank\">wp_upload_dir()</a>['url']" );
		$output .= $this->sd_html( 'field-content-second', wp_upload_dir()['url'] );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', "<a href=\"'.$code_reference_base_url.'wp_upload_dir/\" target=\"_blank\">wp_upload_dir()</a>['basedir']" );
		$output .= $this->sd_html( 'field-content-second', wp_upload_dir()['basedir'] );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', "<a href=\"'.$code_reference_base_url.'wp_upload_dir/\" target=\"_blank\">wp_upload_dir()</a>['path']" );
		$output .= $this->sd_html( 'field-content-second', wp_upload_dir()['path'] );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'plugins_url/" target="_blank">plugins_url()</a>' );
		$output .= $this->sd_html( 'field-content-second', plugins_url() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'plugins_url/" target="_blank">plugins_url</a>( \'/\', __FILE__ )' );
		$output .= $this->sd_html( 'field-content-second', plugins_url( '/', __FILE__ ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'WP_PLUGIN_URL' );
		$output .= $this->sd_html( 'field-content-second', constant( 'WP_PLUGIN_URL' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'plugin_dir_url/" target="_blank">plugin_dir_url</a>( __DIR__ )' );
		$output .= $this->sd_html( 'field-content-second', plugin_dir_url( __DIR__ ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'plugin_dir_url/" target="_blank">plugin_dir_url</a>( __FILE__ )' );
		$output .= $this->sd_html( 'field-content-second', plugin_dir_url( __FILE__ ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'plugin_dir_path/" target="_blank">plugin_dir_path</a>( __DIR__ )' );
		$output .= $this->sd_html( 'field-content-second', plugin_dir_path( __DIR__ ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'plugin_dir_path/" target="_blank">plugin_dir_path</a>( __FILE__ )' );
		$output .= $this->sd_html( 'field-content-second', plugin_dir_path( __FILE__ ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'plugin_basename/" target="_blank">plugin_basename</a>( __FILE__ )' );
		$output .= $this->sd_html( 'field-content-second', plugin_basename( __FILE__ ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '__DIR__' );
		$output .= $this->sd_html( 'field-content-second', __DIR__ );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '__FILE__' );
		$output .= $this->sd_html( 'field-content-second', __FILE__ );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'WP_PLUGIN_DIR' );
		$output .= $this->sd_html( 'field-content-second', constant( 'WP_PLUGIN_DIR' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'PLUGINDIR' );
		$output .= $this->sd_html( 'field-content-second', constant( 'PLUGINDIR' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_theme_root_uri/" target="_blank">get_theme_root_uri()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_theme_root_uri() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_theme_root/" target="_blank">get_theme_root()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_theme_root() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_theme_roots/" target="_blank">get_theme_roots()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_theme_roots() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_template_directory_uri/" target="_blank">get_template_directory_uri()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_template_directory_uri() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_stylesheet_directory_uri/" target="_blank">get_stylesheet_directory_uri()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_stylesheet_directory_uri() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_stylesheet_uri/" target="_blank">get_stylesheet_uri()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_stylesheet_uri() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_template_directory/" target="_blank">get_template_directory()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_template_directory() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_stylesheet_directory/" target="_blank">get_stylesheet_directory()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_stylesheet_directory() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '<a href="'.$code_reference_base_url.'get_stylesheet_directory_uri/" target="_blank">get_stylesheet_directory_uri()</a>' );
		$output .= $this->sd_html( 'field-content-second', get_stylesheet_directory_uri() );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'WPMU_PLUGIN_DIR' );
		$output .= $this->sd_html( 'field-content-second', constant( 'WPMU_PLUGIN_DIR' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'WPMU_PLUGIN_URL' );
		$output .= $this->sd_html( 'field-content-second', constant( 'WPMU_PLUGIN_URL' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'MUPLUGINDIR' );
		$output .= $this->sd_html( 'field-content-second', constant( 'MUPLUGINDIR' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', 'WP_LANG_DIR' );
		$output .= $this->sd_html( 'field-content-second', constant( 'WP_LANG_DIR' ) );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '$_SERVER[\'REQUEST_URI\']' );
		$output .= $this->sd_html( 'field-content-second', $_SERVER['REQUEST_URI'], 'long-value' );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '$_SERVER[\'DOCUMENT_URI\']' );
		$output .= $this->sd_html( 'field-content-second', isset( $_SERVER['DOCUMENT_URI'] ) ? $_SERVER['DOCUMENT_URI'] : '' );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '$_SERVER[\'QUERY_STRING\']' );
		$output .= $this->sd_html( 'field-content-second', $_SERVER['QUERY_STRING'], 'long-value' );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '$_SERVER[\'SCRIPT_FILENAME\']' );
		$output .= $this->sd_html( 'field-content-second', $_SERVER['SCRIPT_FILENAME'] );
		$output .= $this->sd_html( 'field-content-end' );

		$output .= $this->sd_html( 'field-content-start' );
		$output .= $this->sd_html( 'field-content-first', '$_SERVER[\'PHP_SELF\']' );
		$output .= $this->sd_html( 'field-content-second', $_SERVER['PHP_SELF'] );
		$output .= $this->sd_html( 'field-content-end' );

		return $output;

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

			// Get tables data from cache or DB

			$tablesstatus = wp_cache_get( 'sd_db_show_table_status', 'wpdb-queries' );

			if ( false === $tablesstatus ) {
				$tablesstatus = $wpdb->get_results("SHOW TABLE STATUS");
				wp_cache_set( 'sd_db_show_table_status', $tablesstatus, 'wpdb-queries', MINUTE_IN_SECONDS );
			}

			// $tablesstatus = $wpdb->get_results("SHOW TABLE STATUS");

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
	public function sd_db_tables( $return = 'count-core' ) {

		global $wpdb;

		$prefix = $wpdb->prefix;

		// Get tables data from cache or DB

		$tables = wp_cache_get( 'sd_db_show_table_status', 'wpdb-queries' );

		if ( false === $tables ) {
			$tables = $wpdb->get_results("SHOW TABLE STATUS");
			wp_cache_set( 'sd_db_show_table_status', $tables, 'wpdb-queries', MINUTE_IN_SECONDS );
		}

		$wpcore_tables = array(
			$wpdb->prefix . 'commentmeta',
			$wpdb->prefix . 'comments',
			$wpdb->prefix . 'links',
			$wpdb->prefix . 'options',
			$wpdb->prefix . 'postmeta',
			$wpdb->prefix . 'posts',
			$wpdb->prefix . 'term_relationships',
			$wpdb->prefix . 'term_taxonomy',
			$wpdb->prefix . 'termmeta',
			$wpdb->prefix . 'terms',
			$wpdb->prefix . 'usermeta',
			$wpdb->prefix . 'users',
		);

		// On a multisite install, add multisite-specific tables
		// Modified from https://plugins.svn.wordpress.org/advanced-database-cleaner/tags/3.0.4/includes/functions.php >> aDBc_get_core_tables()
		if ( function_exists('is_multisite') && is_multisite() ){
			array_push( $wpcore_tables, $wpdb->prefix . 'blogs' );
			array_push( $wpcore_tables, $wpdb->prefix . 'blog_versions' );
			array_push( $wpcore_tables, $wpdb->prefix . 'blogmeta' );
			array_push( $wpcore_tables, $wpdb->prefix . 'registration_log' );
			array_push( $wpcore_tables, $wpdb->prefix . 'site' );
			array_push( $wpcore_tables, $wpdb->prefix . 'sitemeta' );
			array_push( $wpcore_tables, $wpdb->prefix . 'signups' );
		}

		$noncore_tables = array();

		foreach ( $tables as $table ) {

			if ( !in_array( $table->Name, $wpcore_tables ) ) {

				$noncore_tables[] = $table->Name;

			}

		}

		if ( $return == 'count-core' ) {

			return count( $wpcore_tables );

		} elseif ( $return == 'count-noncore' ) {

			return count( $noncore_tables );

		} else {}

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$type = $_REQUEST['type'];

			// Get installed plugins folder-name / slug array

			$installed_plugins_info = get_plugins();

			$installed_plugins = array();
			foreach ( $installed_plugins_info as $plugin_file => $plugin_info ) {
				$installed_plugins[] = $plugin_file; // array of 'plugin-folder/plugin-file.php'
			}

			$installed_plugins_slugs = array();
			foreach ( $installed_plugins as $installed_plugin ) {
				$installed_plugin = explode("/", $installed_plugin);
				$installed_plugins_slugs[] = $installed_plugin[0];
			}

			// Get active plugins folder-name / slug array

			$active_plugins = get_option( 'active_plugins' );
			$active_plugins_slugs = array();

			foreach ( $active_plugins as $active_plugin ) {
				$active_plugin = explode("/", $active_plugin);
				$active_plugins_slugs[] = $active_plugin[0];
			}

			// Get data array of relationship between table name and plugins creating and using it

			$tables_plugins = wp_remote_get( plugin_dir_url( __DIR__ ). 'admin/references/tables_and_plugins_relationships_by_wpoptimize.json' );
			$tables_plugins_relatioships = json_decode( wp_remote_retrieve_body( $tables_plugins ), true );

			if ( $type == 'core' ) {

				$output = $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', '<strong>' . __( 'Table Name', 'system-dashboard' ) . '</strong>' );
				$output .= $this->sd_html( 'field-content-second', $this->sd_html_parts( 'thirds', 'parts-heading', __( 'Data Size', 'system-dashboard' ), __( 'Index Size', 'system-dashboard' ), __( 'Rows', 'system-dashboard' ) ) );
				$output .= $this->sd_html( 'field-content-end' );

			} elseif ( $type == 'noncore' ) {

				$output = $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', '<strong>' . __( 'Table Name', 'system-dashboard' ) . '</strong> &#10132; <strong>' . __( 'Origin (Status)', 'system-dashboard' ) . '</strong>' );
				$output .= $this->sd_html( 'field-content-second', $this->sd_html_parts( 'thirds', 'parts-heading', __( 'Data Size', 'system-dashboard' ), __( 'Index Size', 'system-dashboard' ), __( 'Rows', 'system-dashboard' ) ) );
				$output .= $this->sd_html( 'field-content-end' );

			}

			$n = 1;

			foreach( $tables as $table ) {

				if ( $type == 'core' ) {

					if ( in_array( $table->Name, $wpcore_tables ) ) {

						$output .= $this->sd_html( 'field-content-start' );

						// If SQL Buddy is active, link to table viewer there

						if ( in_array( 'sql-buddy/sql-buddy.php', $active_plugins ) ) {
							$table_name_output = '<a href="/wp-admin/tools.php?page=sql-buddy-dashboard#/tables?table=' . $table->Name . '" target="_blank">' . $table->Name . '</a>';
						} else {
							$table_name_output = $table->Name;
						}

						$output .= $this->sd_html( 'field-content-first', $table_name_output, 'long-value' );
						$output .= $this->sd_html( 'field-content-second', $this->sd_html_parts( 'thirds', '', $this->sd_format_filesize( $table->Data_length ), $this->sd_format_filesize( $table->Index_length ), number_format( $table->Rows ) ) );
						$output .= $this->sd_html( 'field-content-end' );

					}

				} elseif ( $type == 'noncore' ) {

					if ( in_array( $table->Name, $noncore_tables ) ) {

						$output .= $this->sd_html( 'field-content-start' );

						// If SQL Buddy is active, link to table viewer there

						if ( in_array( 'sql-buddy/sql-buddy.php', $active_plugins ) ) {
							$table_name_output = $n . '. <a href="/wp-admin/tools.php?page=sql-buddy-dashboard#/tables?table=' . $table->Name . '" target="_blank">' . $table->Name . '</a>';
						} else {
							$table_name_output = $n . '. ' . $table->Name;
						}

						// Get table's origin plugin info

						$table_name = str_replace( $prefix, "", $table->Name); // remove prefix

						$origin_plugin_output = '';
						$orphaned_tables = array();

						// Check if table name is listed in the reference table_name<-->plugins relationships array

						if ( array_key_exists( $table_name, $tables_plugins_relatioships ) ) {

							$origin_plugins = $tables_plugins_relatioships[$table_name];

							foreach ( $origin_plugins as $origin_plugin ) {

								// Check if the originating plugin is installed or not, and if active or deactivated

								if ( in_array( $origin_plugin, $installed_plugins_slugs ) ) {

									$has_origin_plugin_installed = true;

									if ( in_array( $origin_plugin, $active_plugins_slugs ) ) {

										foreach ( $installed_plugins_info as $plugin_file => $plugin_info ) {

											if ( strpos( $plugin_file, $origin_plugin ) !== false ) {

												$plugin_status = __( 'active', 'system-dashboard' );

												$origin_plugin_output .= '<span class="db-table-origin-plugin">&#10132; <a href="https://wordpress.org/plugins/'.$origin_plugin.'/" target="_blank">' . $plugin_info['Name'] . '</a> ('. $plugin_status .')</span><br />';

											}

										}

									} else {

										foreach ( $installed_plugins_info as $plugin_file => $plugin_info ) {

											if ( strpos( $plugin_file, $origin_plugin ) !== false ) {

												$plugin_status = __( 'deactivated', 'system-dashboard' );

												$origin_plugin_output .= '<span class="db-table-origin-plugin">&#10132; <a href="https://wordpress.org/plugins/'.$origin_plugin.'/" target="_blank">' . $plugin_info['Name'] . '</a> ('. $plugin_status .')</span><br />';

											}

										}

									}

								} else {

									$has_origin_plugin_installed = false;

									$orphaned_tables[] = $table_name;

									$plugin_status = __( 'uninstalled', 'system-dashboard' );

									$origin_plugin_output .= '';

								}

							}

							// For tables that has no origin plugin installed but has detectable origin plugin

							if ( ( $has_origin_plugin_installed == false ) && ( count( $origin_plugins ) == 1 ) ) {

								$origin_plugin_output .= '<span class="db-table-origin-plugin">&#10132; <a href="https://wordpress.org/plugins/'.$origin_plugin.'/" target="_blank">' . $origin_plugin . '</a> ('. $plugin_status .')</span><br />';

							}

						} else {

							$origin_plugin_output .= '<span class="db-table-origin-plugin">&#10132; ' . __( 'Originating plugin is undetectable', 'system-dashboard' ) . '</span>';

						}

						$output .= $this->sd_html( 'field-content-first', $table_name_output . '<br />' .$origin_plugin_output , 'long-value' );
						$output .= $this->sd_html( 'field-content-second', '<div class="parts"><span class="thirds">' . $this->sd_format_filesize( $table->Data_length ) . '</span><span class="thirds">' . $this->sd_format_filesize( $table->Index_length ) . '</span><span class="thirds">' . number_format( $table->Rows ) . '</span></div>' );
						$output .= $this->sd_html( 'field-content-end' );

						$n++;

					}

				} else {}

			}

			echo $output;

		}

	}

	/** 
	 * Get database uptime
	 *
	 * @since 1.0.0
	 */
	public function sd_db_uptime() {

		global $wpdb;

		// Get uptime data from cache or DB

		$db_uptime_query = wp_cache_get( 'sd_db_uptime_query', 'wpdb-queries' );

		if ( false === $db_uptime_query ) {
			$db_uptime_query = $wpdb->get_results("SHOW GLOBAL STATUS LIKE 'Uptime'");
			wp_cache_set( 'sd_db_uptime_query', $db_uptime_query, 'wpdb-queries', MINUTE_IN_SECONDS );
		}

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

				$client_version = __( 'Undetectable', 'system-dashboard' );

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

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			global $wpdb;

			$default_storage_engine_query = $wpdb->get_row("SHOW VARIABLES LIKE 'default_storage_engine'");
			$default_storage_engine = $default_storage_engine_query->Value;

			$charset = $wpdb->charset;
			$collation = $wpdb->collate;

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
					'name'					=> __( 'Extension', 'system-dashboard' ),
					'value'					=> $this->sd_db_client( 'extension' ),
				),
				array(
					'name'					=> __( 'Client Version', 'system-dashboard' ),
					'value'					=> $this->sd_db_client( 'client_version' ),
				),
				array(
					'name'					=> __( 'Engine', 'system-dashboard' ),
					'value'					=> $default_storage_engine,
				),
				array(
					'name'					=> __( 'Character Set', 'system-dashboard' ),
					'value'					=> $charset,
				),
				array(
					'name'					=> __( 'Collation', 'system-dashboard' ),
					'value'					=> $collation,
				),
				array(
					'name'					=> __( 'Host', 'system-dashboard' ),
					'value'					=> DB_HOST,
				),
				array(
					'name'					=> __( 'Name', 'system-dashboard' ),
					'value'					=> DB_NAME,
				),
				array(
					'name'					=> __( 'User', 'system-dashboard' ),
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

	}

	/** 
	 * Get database technical details
	 * 
	 * @link https://plugins.svn.wordpress.org/wptools/tags/3.13/functions/functions.php
	 * @since 1.0.0
	 */
	public function sd_db_details() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

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

				$output .= __( 'Undetectable', 'system-dashboard' );

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
	public function sd_cron( $type = 'wpcore', $return = 'events' ) {

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
		$header .= $this->sd_html( 'field-content-first', '<strong>' . __( 'Hook', 'system-dashboard' ) . '</strong>' );
		$header .= $this->sd_html( 'field-content-second', '<strong>' . __( 'Recurrence', 'system-dashboard' ) . '</strong>' );
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
	public function sd_rewrite_rules() {

		$output = '';
		
		if ( current_user_can( 'manage_options' ) ) {
			$rewrite_rules = get_option( 'rewrite_rules' );

			if ( !empty( $rewrite_rules ) ) {

				foreach ( $rewrite_rules as $key => $value ) {

					$output .= $this->sd_html( 'field-content-start', '', 'flex-direction-column' );
					$output .= $this->sd_html( 'field-content-first', $key, 'full-width long-value' );
					$output .= $this->sd_html( 'field-content-second', '&#10132; ' . $value, 'full-width long-value' );
					$output .= $this->sd_html( 'field-content-end' );

				}

			} else {

				$output = __( 'Currently, there are no defined rewrite rules.', 'system-dashboard' );

			}			
		}

		echo $output;

	}

	/**
	 * Get # of rewrite rules
	 *
	 * @since 2.1.0
	 */
	public function sd_rewrite_rules_count() {

		$rewrite_rules = get_option( 'rewrite_rules' );

		if ( !empty( $rewrite_rules ) ) {

			$output = count( $rewrite_rules );

		} else {

			$output = 0;

		}

		return $output;

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
	public function sd_shortcodes() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			global $shortcode_tags;

			if ( ( is_array( $shortcode_tags ) ) && ( !empty( $shortcode_tags ) ) ) {

				ksort( $shortcode_tags );

				$output = '';

				$output .= $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', '<strong>' . __( 'Shortcode', 'system-dashboard' ) . '</strong>' );
				$output .= $this->sd_html( 'field-content-second', '<strong>' . __( 'Rendered By', 'system-dashboard' ) . '</strong>' );
				$output .= $this->sd_html( 'field-content-end' );

				foreach ( $shortcode_tags as $shortcode => $callback ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', '[' . $shortcode . ']' );
					$output .= $this->sd_html( 'field-content-second', $this->sd_determine_callback_type( $callback ) );
					$output .= $this->sd_html( 'field-content-end' );

				}

				echo $output;

			}

		}

	}

	/**
	 * Return # of shortcodes
	 *
	 * @since 2.1.0
	 */
	public function sd_shortcodes_count() {

		global $shortcode_tags;

		$output = count( $shortcode_tags );

		return $output;

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

	    // Get options info from cache or DB

		$options = wp_cache_get( 'sd_db_options', 'wpdb-queries' );

		if ( false === $options ) {
			// $options = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options ORDER BY option_name" );
			// $options = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}options ORDER BY option_name" ) );
			$options = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options" );
			wp_cache_set( 'sd_db_options', $options, 'wpdb-queries', MINUTE_IN_SECONDS );
		}

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
	 * Get largest autoloaded options
	 *
	 * @since 2.5.0
	 */
	public function sd_options_largest_autoloads() {

		global $wpdb;

		$table_prefix = $wpdb->prefix;
		$options_table = $table_prefix . 'options';

		$options = wp_cache_get( 'sd_options_largest_autoloads', 'wpdb-queries' );

		if ( false === $options ) {

			// $sql_query = "SELECT option_name, length(option_value) AS option_value_length FROM {$options_table} WHERE autoload='yes' ORDER BY option_value_length DESC LIMIT 10;";

			$sql_query = "SELECT * FROM {$options_table} WHERE autoload='yes' ORDER BY length(option_value) DESC LIMIT 10;";

			$options = $wpdb->get_results( $sql_query );

			wp_cache_set( 'sd_options_largest_autoloads', $options, 'wpdb-queries', MINUTE_IN_SECONDS );

		}

		$output = '';

		foreach ( $options as $option ) {

			$id = $option->option_id;
			$id_alt = $id . '-alt';
			$name = $option->option_name;

			$value = maybe_unserialize( $option->option_value );
			$value_type_raw = gettype( $value );

			$autoload = $option->autoload;

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
			} else {
				$autoloaded = '';					
				$autoloaded_string = '';
			}

			// Ignore options with name starting with underscore as they are transients
			if ( $name[0] !== '_' ) {

				$content = '';

				$content .= $this->sd_html( 'field-content-start', '', 'flex-direction-column' );
				$content .= $this->sd_html( 'field-content-first', '<div id="spinner-' . $id_alt . '"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="option_id_' . $id_alt . '" class="option__value ajax-value"></div>', 'full-width long-value' );
				$content .= $this->sd_html( 'field-content-end' );

				$data_atts = array(
					'id'		=> $id_alt,
					'loaded'	=> 'no',
					'name'		=> $name,
				);

				$output .= $this->sd_html( 'accordions-start-simple-margin-default' );
				$output .= $this->sd_html( 'accordion-head', 'ID: ' . $id . ' - ' . $name . ' | ' . $autoloaded . $size . $value_type, 'option__name', $data_atts, 'option-name-'.$id_alt );
				$output .= $this->sd_html( 'accordion-body', $content );
				$output .= $this->sd_html( 'accordions-end' );

			}

		}

		return $output;

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

		// Get transients from cache or DB

		$transients = wp_cache_get( 'sd_db_transients', 'wpdb-queries' );

		if ( false === $transients ) {
			$transients = $wpdb->get_results($sql);
			wp_cache_set( 'sd_db_transients', $transients, 'wpdb-queries', MINUTE_IN_SECONDS );
		}

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
	 * Get object cache data
	 *
	 * @since 2.3.0
	 */
	public function sd_object_cache( $return = '' ) {

		global $wp_object_cache;

		if ( is_object( $wp_object_cache ) ) {

			$object_vars = get_object_vars( $wp_object_cache ); // array

		}

		global $wpdb;
		$table_prefix = $wpdb->prefix;

		$output = '';
		$enable_persistent_cache_msg = __( 'Please enable a <a href="https://developer.wordpress.org/reference/classes/wp_object_cache/#persistent-cache-plugins" target="_blank">persistence object cache plugin</a> first to see the relevant info here.', 'system-dashboard' );
		$enable_persistent_cache_msg_full = __( 'Please enable a <a href="https://developer.wordpress.org/reference/classes/wp_object_cache/#persistent-cache-plugins" target="_blank">persistence object cache plugin</a> first to see the relevant info here. Plugins that have been tested to work with this module is listed under \'Tools\' below. For Redis implementation by managed WordPress hosting, only Runcloud Hub plugin is currently tested to work. Please <a href="https://wordpress.org/support/plugin/system-dashboard/" target="_blank">provide feedback</a> if it does not work with your hosting environment. Specifically, please post a sample cached key-value pairs from the Globals >> Common >> $wp_object_cache global, and also the relevant constants from Constants >> Defined Constants >> From Themes and Plugin, e.g. SOMEHOST_REDIS_ENABLED.', 'system-dashboard' );

		// Get Object Cache backend status

		if ( $return == 'status' ) {

			// Get object cache backend type

			// Redis Object Cache plugin - RunCloud Hub plugin - Powered Cache plugin
			if ( defined( 'WP_REDIS_PREFIX' ) || defined( 'RCWP_REDIS_DROPIN' ) || ( defined( 'POWERED_OBJECT_CACHE' ) && defined( 'WP_REDIS_OBJECT_CACHE' ) ) ) {

				$backend_type = ' with Redis backend';

			// Powered Cache plugin - Use Memcached plugin - Object Cache 4 everyone plugin
			} elseif ( ( defined( 'POWERED_OBJECT_CACHE' ) && !defined( 'WP_REDIS_OBJECT_CACHE' ) ) || defined( 'USE_MEMCACHED_OBJECT_CACHE_SCRIPT_VERSION' ) || defined( 'OC4EVERYONE_PREDEFINED_SERVER' ) ) {

				$backend_type = ' with Memcached backend';

			} else {}

			// Get the status

			if ( (bool) wp_using_ext_object_cache() ) {

				$output .= '<a href="https://developer.wordpress.org/reference/classes/wp_object_cache/#persistent-cache-plugins" target="_blank">Persistent object cache plugin</a>' . $backend_type . ' is <a href="'. network_admin_url( 'plugins.php?plugin_status=dropins' ) .'" target="_blank">in use</a>';

			} else {

				$output .= __( '<a href="https://developer.wordpress.org/reference/classes/wp_object_cache/#persistent-cache-plugins" target="_blank">Persistent object cache plugin</a> is not in use', 'system-dashboard' );

			}

			return $output;

		} 

		// Get cache hit stats

		if ( $return == 'stats' ) {

			if ( array_key_exists( 'cache_hits', $object_vars ) ) {

				$cache_hits = $object_vars['cache_hits'];
				$cache_misses = $object_vars['cache_misses'];
				$total = $cache_hits + $cache_misses;
				$percentage = round( ( ( $cache_hits / $total ) * 100 ), 1 );

				$output = $percentage . '% hit rate ('. number_format( $cache_hits ) .' hits, '. number_format( $cache_misses ) .' misses)';

				return $output;

			} else {

				return $enable_persistent_cache_msg;

			}

		} 

		// Get global groups

		if ( $return == 'global_groups' ) {

			if ( array_key_exists( 'global_groups', $object_vars ) ) {

				$global_groups = $object_vars['global_groups'];
				$global_groups_keys = array_keys( $global_groups );

				$last_element_key = array_pop( $global_groups );

				if ( is_bool( $last_element_key ) ) {

					foreach ( $global_groups_keys as $global_group ) {
						$output .= $global_group . '<br />';
					}

				} else {

					foreach ( $global_groups as $global_group ) {
						$output .= $global_group . '<br />';
					}

				}

				return $output;

			} else {

				return $enable_persistent_cache_msg;

			}

		}

		// Get non-persistent groups

		if ( $return == 'non_persistent_groups' ) {

			if ( array_key_exists( 'ignored_groups', $object_vars ) ) {

				// Redis
				$non_persistent_groups = $object_vars['ignored_groups'];

				foreach ( $non_persistent_groups as $non_persistent_group ) {

					$output .= $non_persistent_group . '<br />';

				}

			} elseif ( array_key_exists( 'no_mc_groups', $object_vars ) ) {

				// Memcached
				$non_persistent_groups = $object_vars['no_mc_groups'];

				foreach ( $non_persistent_groups as $non_persistent_group ) {

					$output .= $non_persistent_group . '<br />';

				}

			} elseif ( array_key_exists( 'non_persistent_groups', $object_vars ) ) {

				// Memcached using Powered Cache plugin
				$non_persistent_groups = $object_vars['non_persistent_groups'];

				foreach ( $non_persistent_groups as $non_persistent_group => $value ) {

					$output .= $non_persistent_group . '<br />';

				}

			} else {}

			if ( isset( $non_persistent_groups ) ) {

				return $output;

			} else {

				return $enable_persistent_cache_msg;

			}

		}

		// Get diagnostics data if available

		if ( $return == 'diagnostics' ) {

			if ( array_key_exists( 'diagnostics', $object_vars ) ) { // Redis object cache

				$diagnostics = $object_vars['diagnostics'];

				foreach ( $diagnostics as $key => $value ) {

					if ( $key != '0' ) {

						if ( $value === true ) {
							$value = 'true';
						} elseif ( $value === false ) {
							$value = 'false';
						} else {}

						if ( $key == 'client' ) {
							$key = 'Client';
						} elseif ( $key == 'host' ) {
							$key = 'Host';
						} elseif ( $key == 'port' ) {
							$key = 'Port';
						} elseif ( $key == 'timeout' ) {
							$key = 'Connection Timeout';
							$value = $value . 's';
						} elseif ( $key == 'retry_interval' ) {
							$key = 'Retry Interval';
							$value = $value . 'ms';
						} elseif ( $key == 'read_timeout' ) {
							$key = 'Read Timeout';
							$value = $value . 's';
						} elseif ( $key == 'database' ) {
							$key = 'Database';
						} elseif ( $key == 'ping' ) {
							$key = 'Ping';
						} 

						$output .= $this->sd_html( 'field-content-start' );
						$output .= $this->sd_html( 'field-content-first', $key );
						$output .= $this->sd_html( 'field-content-second', $value );
						$output .= $this->sd_html( 'field-content-end' );

					}

				}

				if ( method_exists( $wp_object_cache, 'redis_version' ) ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', 'Redis Version' );
					$output .= $this->sd_html( 'field-content-second', $wp_object_cache->redis_version() );
					$output .= $this->sd_html( 'field-content-end' );

				}

				if ( defined( 'WP_REDIS_PREFIX' ) ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', 'WP_REDIS_PREFIX' );
					$output .= $this->sd_html( 'field-content-second', WP_REDIS_PREFIX );
					$output .= $this->sd_html( 'field-content-end' );				

				}

				$dropins = array();

				foreach ( get_dropins() as $file => $details ) {

					$output .= $this->sd_html( 'field-content-start' );
					$output .= $this->sd_html( 'field-content-first', $file );
					$output .= $this->sd_html( 'field-content-second', $details['Name'] . ' v' . $details['Version'] . ' by ' . $details['Author'] );
					$output .= $this->sd_html( 'field-content-end' );

				}

				return $output;

			} elseif ( defined( 'USE_MEMCACHED_OBJECT_CACHE_SCRIPT_VERSION' ) && !empty( $wp_object_cache->stats() ) ) { // Memcached object cache via Use Memcached plugin

				$stats = $wp_object_cache->stats( true ); // array

				$output .= $this->sd_html( 'field-content-start' );
				$output .= $this->sd_html( 'field-content-first', 'IP & Port Number' );
				$output .= $this->sd_html( 'field-content-second', key( $stats[0] ) );
				$output .= $this->sd_html( 'field-content-end' );

				foreach ( $stats[0] as $key => $array ) {

					foreach ( $array as $key => $value ) {

						$output .= $this->sd_html( 'field-content-start' );
						$output .= $this->sd_html( 'field-content-first', $key );
						$output .= $this->sd_html( 'field-content-second', $value );
						$output .= $this->sd_html( 'field-content-end' );

					}

				}

				return $output;

			} else {

				return 'No diagnostics data is currently available';

			}

		}

		// Get cache content from global $wp_object_cache

		if ( $return == 'wp_object_cache_content' )  {

			if ( array_key_exists( 'cache', $object_vars ) ) {

				$cache_groups = $object_vars['cache'];

				$output .= $this->sd_html( 'field-content-start', '', 'single-top-part' );
				$output .= $this->sd_html( 'field-content-first', '<strong>Total</strong>: ' . count( $cache_groups ) . ' keys', 'full-width' );
				$output .= $this->sd_html( 'field-content-end' );

				foreach( $cache_groups as $key => $value ) {

					if ( defined( 'WP_REDIS_PREFIX' ) ) {

						$key_prefix = WP_REDIS_PREFIX;
						$key = str_replace( $key_prefix, '', $key );
						$key = str_replace( 'wp:', '', $key );

					} elseif ( defined( 'RCWP_REDIS_DROPIN' ) ) { // Runcloud.io RunCloud Hub - Redis Object Cache

						$key_prefix = RCWP_REDIS_DOMAIN . ':' . RCWP_REDIS_PREFIX . ':' . $table_prefix . ':';
						$key = str_replace( $key_prefix, '', $key );

					} elseif ( defined( 'POWERED_OBJECT_CACHE' ) && defined( 'WP_REDIS_OBJECT_CACHE' ) ) { // Powered Cache - Redis Object Cache

						$key_prefix = preg_replace( '/\s+/', '', WP_CACHE_KEY_SALT );
						$key = str_replace( $key_prefix, '', $key );

					} elseif ( ( defined( 'POWERED_OBJECT_CACHE' ) && !defined( 'WP_REDIS_OBJECT_CACHE' ) ) || defined( 'USE_MEMCACHED_OBJECT_CACHE_SCRIPT_VERSION' ) || defined( 'OC4EVERYONE_PREDEFINED_SERVER' ) ) { // Powered Cache - Memcached Object Cache || Use Memcached || Object Cache 4 everyone

						$key_prefix = preg_replace( '/\s+/', '', WP_CACHE_KEY_SALT . $table_prefix );
						$key = str_replace( $key_prefix, '', $key );
						// remove first string if it's a colon
						if ( $key[0] == ':' ) {
							$key = substr( $key, 1 );
						}

					} else {}

					$key_array = explode(':', $key);
					$cache_group = $key_array[0];
					$cache_key = $key_array[1];

					$content = $this->sd_html( 'field-content-start' );
					$content .= $this->sd_html( 'field-content-first', '<div id="spinner-' . $cache_key . '"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="cache_' . $cache_key . '" class="cache__value ajax-value"></div>', 'full-width long-value' );
					$content .= $this->sd_html( 'field-content-end' );


					$data_atts = array(
						'group'		=> $cache_group,
						'key'		=> $cache_key,
						'loaded'	=> 'no',
					);

					$output .= $this->sd_html( 'accordions-start-simple');
					$output .= $this->sd_html( 'accordion-head', 'Group: <span class="normal-weight">' . $cache_group . '</span> <span class="normal-weight">&#10132;</span> Key: <span class="normal-weight">' . $cache_key . '</span>', 'cache__name', $data_atts, 'cache-' . $cache_key );
					$output .= $this->sd_html( 'accordion-body', $content );
					$output .= $this->sd_html( 'accordions-end' );

				}

				return $output;

			} else {

				return $enable_persistent_cache_msg;

			}

		}

		// Get cache content directly from memory

		if ( $return == 'cache_content_from_memory' )  {	

			// Redis Object Cache plugin - RunCloud Hub plugin - Powered Cache plugin
			if ( class_exists( 'Redis' ) 
				&& ( defined( 'WP_REDIS_PREFIX' ) || defined( 'RCWP_REDIS_DROPIN' ) || ( defined( 'POWERED_OBJECT_CACHE' ) && defined( 'WP_REDIS_OBJECT_CACHE' ) ) ) 
			) {

				// Set a test cache key value

				$result = wp_cache_get( 'sd_test_cache' );

				if ( false === $result ) {
					$result = 'Seems to be working...';
					wp_cache_set( 'sd_test_cache', $result, 'redis-cache', 30 );
				}

				// Get redis cache keys

				$redis = new Redis();
				$redis->connect('127.0.0.1', 6379);
				$allKeys = $redis->keys('*');

				$this_site_keys = array();

				// Get raw cache keys only for the current site. Use key_prefix to filter such keys.

				foreach ( $allKeys as $key => $value ) {

					if ( defined( 'WP_REDIS_PREFIX' ) ) { // Redis Object Cache plugin

						$key_prefix = WP_REDIS_PREFIX;

					} elseif ( defined( 'RCWP_REDIS_DROPIN' ) ) { // Runcloud.io Runcloud Hub Plugin

						$key_prefix = RCWP_REDIS_DOMAIN . ':' . RCWP_REDIS_PREFIX . ':' . $table_prefix . ':';

					} elseif ( defined( 'POWERED_OBJECT_CACHE' ) && defined( 'WP_REDIS_OBJECT_CACHE' ) ) { // Powered Cache

						$key_prefix = preg_replace( '/\s+/', '', WP_CACHE_KEY_SALT );

					} else {}

					if ( strpos( $value, $key_prefix ) !== false ) {

						$this_site_keys[] = $value;

					}

				}

				// Get cleaned up cache keys for the current site

				$site_keys = array();

				foreach ( $this_site_keys as $key ) {

					if ( defined( 'WP_REDIS_PREFIX' ) ) { // Redis Object Cache plugin

						$key = str_replace( $key_prefix, '', $key );
						$key = str_replace( 'wp:', '', $key );

					}  elseif ( defined( 'RCWP_REDIS_DROPIN' ) ) { // Runcloud.io Runcloud Hub Plugin

						$key = str_replace( $key_prefix, '', $key );

					} elseif ( defined( 'POWERED_OBJECT_CACHE' ) && defined( 'WP_REDIS_OBJECT_CACHE' ) ) { // Powered Cache - Redis Object Cache

						$key = str_replace( $key_prefix, '', $key );

					} else {}

					$site_keys[] = $key;

				}

				// ob_start();
				// print_r( $site_keys );
				// $this_site_keys_formatted = ob_get_clean();

				// return $this_site_keys_formatted;

				$output .= $this->sd_html( 'field-content-start', '', 'single-top-part' );
				$output .= $this->sd_html( 'field-content-first', '<strong>Total</strong>: ' . count( $site_keys ) . ' keys', 'full-width' );
				$output .= $this->sd_html( 'field-content-end' );

				foreach ( $site_keys as $site_key ) {

					$key_array = explode(':', $site_key);
					$cache_group = $key_array[0];
					$cache_key = $key_array[1];

					$content = $this->sd_html( 'field-content-start' );
					$content .= $this->sd_html( 'field-content-first', '<div id="spinner-m' . $cache_key . '"><img class="spinner_inline" src="' .plugin_dir_url( __FILE__ ) . 'img/spinner.gif" /> loading...</div><div id="mcache_' . $cache_key . '" class="mcache__value ajax-value"></div>', 'full-width long-value' );
					$content .= $this->sd_html( 'field-content-end' );


					$data_atts = array(
						'group'		=> $cache_group,
						'key'		=> $cache_key,
						'loaded'	=> 'no',
					);

					$output .= $this->sd_html( 'accordions-start-simple');
					$output .= $this->sd_html( 'accordion-head', 'Group: <span class="normal-weight">' . $cache_group . '</span> <span class="normal-weight">&#10132;</span> Key: <span class="normal-weight">' . $cache_key . '</span>', 'mcache__name', $data_atts, 'mcache-' . $cache_key );
					$output .= $this->sd_html( 'accordion-body', $content );
					$output .= $this->sd_html( 'accordions-end' );

				}

				return $output;

			// Get memcached cache keys
			// Powered Cache - Memcached Object Cache || Use Memcached || Object Cache 4 everyone
			} elseif ( ( defined( 'POWERED_OBJECT_CACHE' ) && !defined( 'WP_REDIS_OBJECT_CACHE' ) ) || defined( 'USE_MEMCACHED_OBJECT_CACHE_SCRIPT_VERSION' ) || defined( 'OC4EVERYONE_PREDEFINED_SERVER' ) ) {

				$key_prefix = preg_replace( '/\s+/', '', WP_CACHE_KEY_SALT . $table_prefix );

				// Set a test cache key value

				$result = wp_cache_get( 'sd_test_cache' );

				if ( false === $result ) {
					$result = 'Seems to be working...';
					wp_cache_set( 'sd_test_cache', $result, '', 30 );
				}

				$all_keys = $this->get_memcached_keys();

				$this_site_keys = array();

				foreach ( $all_keys as $key ) {

					if ( strpos( $key, $key_prefix ) !== false ) {

						$this_site_keys[] = $key;

					}

				}

				$output .= $this->sd_html( 'field-content-start', '', 'single-top-part' );
				$output .= $this->sd_html( 'field-content-first', '<strong>Total</strong>: ' . count( $this_site_keys ) . ' keys', 'full-width' );
				$output .= $this->sd_html( 'field-content-end' );

				foreach ( $this_site_keys as $site_key ) {

					$key_prefix = preg_replace( '/\s+/', '', WP_CACHE_KEY_SALT . $table_prefix );
					$site_key = str_replace( $key_prefix, '', $site_key );
					// remove first string if it's a colon
					if ( $site_key[0] == ':' ) {
						$site_key = substr( $site_key, 1 );
					}

					$key_array = explode(':', $site_key);
					$cache_group = $key_array[0];
					$cache_key = $key_array[1];

					$output .= $this->sd_html( 'accordions-start-simple');
					// $output .= $this->sd_html( 'accordion-head', $site_key );
					$output .= $this->sd_html( 'accordion-head', 'Group: <span class="normal-weight">' . $cache_group . '</span> <span class="normal-weight">&#10132;</span> Key: <span class="normal-weight">' . $cache_key . '</span>' );
					$output .= $this->sd_html( 'accordion-body', 'Content here...' );
					$output .= $this->sd_html( 'accordions-end' );

				}

				return $output;

			} else {

				return $enable_persistent_cache_msg_full;

			}

		}

	}

	/**
	* Get all memcached keys. Special function because getAllKeys() is broken since memcached 1.4.23. 
	* Should only be needed on php 5.6 cleaned up version of code found on Stackoverflow.com by Maduka Jayalath
	* Seems to return inconsistent number of keys on each reload.
	*
	* @link https://www.php.net/manual/en/memcached.getallkeys.php#123793
	* @return array|int - all retrieved keys (or negative number on error)
	* @since 2.4.0
	*/
	public function get_memcached_keys( $host = '127.0.0.1', $port = 11211 ) {
	    $mem = @fsockopen($host, $port);
	    if ($mem === false)
	    {
	        return -1;
	    }

	    // retrieve distinct slab
	    $r = @fwrite($mem, 'stats items' . chr(10));
	    if ($r === false)
	    {
	        return -2;
	    }

	    $slab = [];
	    while (($l = @fgets($mem, 1024)) !== false)
	    {
	        // finished?
	        $l = trim($l);
	        if ($l == 'END')
	        {
	            break;
	        }

	        $m = [];
	        // <STAT items:22:evicted_nonzero 0>
	        $r = preg_match('/^STAT\sitems\:(\d+)\:/', $l, $m);
	        if ($r != 1)
	        {
	            return -3;
	        }
	        $a_slab = $m[1];

	        if (!array_key_exists($a_slab, $slab))
	        {
	            $slab[$a_slab] = [];
	        }
	    }

	    reset($slab);
	    foreach ($slab as $a_slab_key => &$a_slab)
	    {
	        $r = @fwrite($mem, 'stats cachedump ' . $a_slab_key . ' 100' . chr(10));
	        if ($r === false)
	        {
	            return -4;
	        }

	        while (($l = @fgets($mem, 1024)) !== false)
	        {
	            // finished?
	            $l = trim($l);
	            if ($l == 'END')
	            {
	                break;
	            }

	            $m = [];
	            // ITEM 42 [118 b; 1354717302 s]
	            $r = preg_match('/^ITEM\s([^\s]+)\s/', $l, $m);
	            if ($r != 1)
	            {
	                return -5;
	            }
	            $a_key = $m[1];

	            $a_slab[] = $a_key;
	        }
	    }

	    // close the connection
	    @fclose($mem);
	    unset($mem);

	    $keys = [];
	    reset($slab);
	    foreach ($slab AS &$a_slab)
	    {
	        reset($a_slab);
	        foreach ($a_slab AS &$a_key)
	        {
	            $keys[] = $a_key;
	        }
	    }
	    unset($slab);

	    return $keys;
	}

	/**
	 * Get formatted value of a cache object (key-value pair). Triggered by an AJAX call.
	 *
	 * @since 2.4.0
	 */
	public function sd_cache_value() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$cache_key = $_REQUEST['cache_key'];
			$cache_group = $_REQUEST['cache_group'];

			$cache_value = maybe_unserialize( wp_cache_get( $cache_key, $cache_group ) );

			$cache_value_type = gettype( $cache_value );

			if  ( ( $cache_value_type == 'array' ) || ( $cache_value_type == 'object' ) ) {

				// JSON_UNESCAPED_SLASHES will remove backslashes used for escaping, e.g. \' will become just '. stripslashes will further remove backslashes using to escape backslashes, e.g. double \\ will become a single \. JSON_PRETTY_PRINT and <pre> beautifies the output on the HTML side.

				// echo '<pre>' . stripslashes( json_encode( $option_value, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) ) . '</pre>'; // Raw JSON beautified
				echo json_encode( $cache_value ); // for JSON Tree viewer

			} elseif ( ( $cache_value_type == 'boolean' ) || ( $cache_value_type == 'integer' ) || ( $cache_value_type == 'string' ) ) {

				echo '<pre>' . htmlspecialchars( $cache_value ) . '</pre>'; // Raw JSON beautified

			} else {}

		} else {

			echo __( 'None. Please define cache key and cache group first.', 'system-dashboard' );

		}

		wp_die();

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
		
		// Generate nonce to secure ajax calls
		$nonce = wp_create_nonce( 'sd-nonce-key' );
		
		// Option value from wp_options table for the various logging tools

		$page_access_log = get_option( 'system_dashboard_page_access_log' );
		
		if ( is_array( $page_access_log ) && isset( $page_access_log['status'] ) ) {
			$page_access_log_status = $page_access_log['status'];		
		} else {
			$page_access_log_status = __( 'Unknown', 'system-dashboard' );
		}

		$errors_log = get_option( 'system_dashboard_errors_log' );

		if ( is_array( $errors_log ) && isset( $errors_log['status'] ) ) {
			$errors_log_status = $errors_log['status'];
		} else {
			$errors_log_status = __( 'Unknown', 'system-dashboard' );
		}

		$email_delivery_log = get_option( 'system_dashboard_email_delivery_log' );

		if ( is_array( $email_delivery_log ) && isset( $email_delivery_log['status'] ) ) {
			$email_delivery_log_status = $email_delivery_log['status'];
		} else {
			$email_delivery_log_status = __( 'Unknown', 'system-dashboard' );
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

				// A function that mimics PHP's htmlentities()
				function htmlEntities(str) {
					return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
				}

				jQuery('.core-db-tables .csf-accordion-title').attr('data-loaded','no');
				jQuery('.noncore-db-tables .csf-accordion-title').attr('data-loaded','no');
				jQuery('.db-specs .csf-accordion-title').attr('data-loaded','no');
				jQuery('.db-details .csf-accordion-title').attr('data-loaded','no');
				jQuery('.post-types .csf-accordion-title').attr('data-loaded','no');
				jQuery('.taxonomies .csf-accordion-title').attr('data-loaded','no');
				jQuery('.old-slugs .csf-accordion-title').attr('data-loaded','no');
				jQuery('.media-count .csf-accordion-title').attr('data-loaded','no');
				jQuery('.image-sizes .csf-accordion-title').attr('data-loaded','no');
				jQuery('.mime-types .csf-accordion-title').attr('data-loaded','no');
				jQuery('.media-handling .csf-accordion-title').attr('data-loaded','no');
				jQuery('.directory-sizes .csf-accordion-title').attr('data-loaded','no');
				jQuery('.filesystem-permissions .csf-accordion-title').attr('data-loaded','no');
				jQuery('.custom-fields .csf-accordion-item:nth-child(1) .csf-accordion-title').attr('data-loaded','no');
				jQuery('.custom-fields .csf-accordion-item:nth-child(2) .csf-accordion-title').attr('data-loaded','no');
				jQuery('.user-count .csf-accordion-title').attr('data-loaded','no');
				jQuery('.roles-capabilities .csf-accordion-title').attr('data-loaded','no');
				jQuery('.rewrite-rules .csf-accordion-title').attr('data-loaded','no');
				jQuery('.shortcodes .csf-accordion-title').attr('data-loaded','no');
				jQuery('.wpcore-hooks .csf-accordion-item:nth-child(1) .csf-accordion-title').attr('data-loaded','no');
				jQuery('.wpcore-hooks .csf-accordion-item:nth-child(2) .csf-accordion-title').attr('data-loaded','no');
				jQuery('.theme-hooks .csf-accordion-title').attr('data-loaded','no');
				jQuery('.plugins-hooks .csf-accordion-title').attr('data-loaded','no');
				jQuery('.core-classes .csf-accordion-title').attr('data-loaded','no');
				jQuery('.theme-classes .csf-accordion-title').attr('data-loaded','no');
				jQuery('.plugins-classes .csf-accordion-title').attr('data-loaded','no');
				jQuery('.core-functions .csf-accordion-title').attr('data-loaded','no');
				jQuery('.theme-functions .csf-accordion-title').attr('data-loaded','no');
				jQuery('.plugins-functions .csf-accordion-title').attr('data-loaded','no');
				jQuery('.constant-values .csf-accordion-title').attr('data-loaded','no');
				jQuery('.constant-docs .csf-accordion-title').attr('data-loaded','no');
				jQuery('.wpconfig .csf-accordion-title').attr('data-loaded','no');
				jQuery('.htaccess .csf-accordion-title').attr('data-loaded','no');
				jQuery('.restapi_viewer .csf-accordion-title').attr('data-loaded','no');
				jQuery('.robotstxt .csf-accordion-title').attr('data-loaded','no');
				jQuery('.page-access-log .csf-accordion-title').attr('data-loaded','no');
				jQuery('.errors-log .csf-accordion-title').attr('data-loaded','no');
				jQuery('.email-delivery-log .csf-accordion-title').attr('data-loaded','no');
				jQuery('.phpinfo-details .csf-accordion-title').attr('data-loaded','no');

				// Set data-status attribute of toggles / switches that turn certain tools on or off
				
				// Page Access Log

				var page_access_log_status = '<?php echo esc_js( $page_access_log_status ); ?>';
				jQuery('.page-access-log-switcher').attr('data-status',page_access_log_status);

				// Set toggle/switcher position

				if ( page_access_log_status == 'enabled' ) {
					jQuery('.page-access-log-checkbox').prop('checked', true);
				} else {
					jQuery('.page-access-log-checkbox').prop('checked', false);					
				}

				// Toggle Page Access Log tool on or off

				jQuery('.page-access-log-switcher').click( function() {

					var status = this.dataset.status;

					jQuery.ajax({
						url: ajaxurl,
						data: {
							'action':'sd_toggle_logs',
							'log_type':'page_access_log',
							'fast_ajax':true,
							'load_plugins':["system-dashboard/system-dashboard.php"]
						},
						success:function(data) {
							var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
							jQuery('#page-access-log-status').empty();
							jQuery('#page-access-log-status').prepend(data);
							if ( status == 'disabled' ) {
								jQuery('.page-access-log-switcher').attr('data-status','enabled');
							} else if ( status == 'enabled' ) {
								jQuery('.page-access-log-switcher').attr('data-status','disabled');
							}
						},
						error:function(errorThrown) {
							console.log(errorThrown);
						}
					});

				});

				// Get Page Access log entries

				jQuery('.page-access-log .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_page_access_log',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#page-access-log-content').prepend(data);
								jQuery('.page-access-log .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-page-access-log').fadeOut( 0 );
						        jQuery('#page-access-log').DataTable({
						        		order: [ 0, 'desc' ]
						        	});

							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Errors Log

				var errors_log_status = '<?php echo esc_js( $errors_log_status ); ?>';
				jQuery('.errors-log-switcher').attr('data-status',errors_log_status);

				// Set toggle/switcher position

				if ( errors_log_status == 'enabled' ) {
					jQuery('.errors-log-checkbox').prop('checked', true);
				} else {
					jQuery('.errors-log-checkbox').prop('checked', false);					
				}

				// Toggle Errors Log tool on or off

				jQuery('.errors-log-switcher').click( function() {

					var status = this.dataset.status;

					jQuery.ajax({
						url: ajaxurl,
						data: {
							'action':'sd_toggle_logs',
							'log_type':'errors_log',
							'fast_ajax':true,
							'load_plugins':["system-dashboard/system-dashboard.php"]
						},
						success:function(data) {
							var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
							jQuery('#errors-log-status').empty();
							jQuery('#errors-log-status').prepend(data);
							if ( status == 'disabled' ) {
								jQuery('.errors-log-switcher').attr('data-status','enabled');
							} else if ( status == 'enabled' ) {
								jQuery('.errors-log-switcher').attr('data-status','disabled');
							}
						},
						error:function(errorThrown) {
							console.log(errorThrown);
						}
					});

				});

				// Get Errors log entries

				jQuery('.errors-log .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_errors_log',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#errors-log-content').prepend(data);
								jQuery('.errors-log .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-errors-log').fadeOut( 0 );
						        jQuery('#errors-log').DataTable({
						        		pageLength: 5,
						        		order: [ 0, 'desc' ]
						        	});

							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Email Delivery Log

				var email_delivery_log_status = '<?php echo esc_js( $email_delivery_log_status ); ?>';
				jQuery('.email-delivery-log-switcher').attr('data-status',email_delivery_log_status);

				// Set toggle/switcher position

				if ( email_delivery_log_status == 'enabled' ) {
					jQuery('.email-delivery-log-checkbox').prop('checked', true);
				} else {
					jQuery('.email-delivery-log-checkbox').prop('checked', false);					
				}

				// Toggle Email Delivery Log tool on or off

				jQuery('.email-delivery-log-switcher').click( function() {

					var status = this.dataset.status;

					jQuery.ajax({
						url: ajaxurl,
						data: {
							'action':'sd_toggle_logs',
							'log_type':'email_delivery_log',
							'fast_ajax':true,
							'load_plugins':["system-dashboard/system-dashboard.php"]
						},
						success:function(data) {
							var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
							jQuery('#email-delivery-log-status').empty();
							jQuery('#email-delivery-log-status').prepend(data);
							if ( status == 'disabled' ) {
								jQuery('.email-delivery-log-switcher').attr('data-status','enabled');
							} else if ( status == 'enabled' ) {
								jQuery('.email-delivery-log-switcher').attr('data-status','disabled');
							}
						},
						error:function(errorThrown) {
							console.log(errorThrown);
						}
					});

				});

				// Get Email Delivery log entries

				jQuery('.email-delivery-log .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_email_delivery_log',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#email-delivery-log-content').prepend(data);
								jQuery('.email-delivery-log .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-email-delivery-log').fadeOut( 0 );
						        jQuery('#email-delivery-log').DataTable({
						        		pageLength: 5,
						        		order: [ 0, 'desc' ]
						        	});
				                jQuery(".ui.accordion").accordion(); // initialize Fomantic UI accordion to view email message content
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get WP Core database tables

				jQuery('.core-db-tables .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_db_tables',
								'type':'core',
								'fast_ajax':true,
								'load_plugins':["sql-buddy/sql-buddy.php","system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#core-db-tables-content').prepend(data);
								jQuery('.core-db-tables .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-core-db-tables').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get Non-core database tables

				jQuery('.noncore-db-tables .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_db_tables',
								'type':'noncore'
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#noncore-db-tables-content').prepend(data);
								jQuery('.noncore-db-tables .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-noncore-db-tables').fadeOut( 0 );
							},
							error:function(errorThrown) {
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
							error:function(errorThrown) {
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
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get post count by post type

				jQuery('.post-types .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_post_types'
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#post-types-content').prepend(data);
								jQuery('.post-types .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-post-types').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get taxonomies list and terms count

				jQuery('.taxonomies .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_taxonomies',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#taxonomies-content').prepend(data);
								jQuery('.taxonomies .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-taxonomies').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get old slugs info

				jQuery('.old-slugs .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_old_slugs',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#old-slugs-content').prepend(data);
								jQuery('.old-slugs .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-old-slugs').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get media count by mime type

				jQuery('.media-count .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_media_count',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#media-count-content').prepend(data);
								jQuery('.media-count .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-media-count').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get registered image sizes

				jQuery('.image-sizes .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_image_sizes',
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#image-sizes-content').prepend(data);
								jQuery('.image-sizes .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-image-sizes').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});
				// Get list of allowed mime types and file extensions

				jQuery('.mime-types .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_mime_types',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#mime-types-content').prepend(data);
								jQuery('.mime-types .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-mime-types').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get info on media handling

				jQuery('.media-handling .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_media_handling',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#media-handling-content').prepend(data);
								jQuery('.media-handling .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-media-handling').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get WP directory sizes

				jQuery('.directory-sizes .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_directory_sizes',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#directory-sizes-content').prepend(data);
								jQuery('.directory-sizes .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-directory-sizes').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get filesystem / directory permissions

				jQuery('.filesystem-permissions .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_filesystem_permissions',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#filesystem-permissions-content').prepend(data);
								jQuery('.filesystem-permissions .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-filesystem-permissions').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get list of public custom fields

				jQuery('.custom-fields .csf-accordion-item:nth-child(1) .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_custom_fields',
								'type':'public',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#public-custom-fields-content').prepend(data);
								jQuery('.custom-fields .csf-accordion-item:nth-child(1) .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-public-custom-fields').fadeOut( 0 );

							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get list of private custom fields

				jQuery('.custom-fields .csf-accordion-item:nth-child(2) .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_custom_fields',
								'type':'private',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#private-custom-fields-content').prepend(data);
								jQuery('.custom-fields .csf-accordion-item:nth-child(2) .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-private-custom-fields').fadeOut( 0 );

							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get user count by role

				jQuery('.user-count .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_user_count',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#user-count-content').prepend(data);
								jQuery('.user-count .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-user-count').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get user roles and capabilities

				jQuery('.roles-capabilities .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_roles_capabilities',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#roles-capabilities-content').prepend(data);
								jQuery('.roles-capabilities .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-roles-capabilities').fadeOut( 0 );
								initMcCollapsible( ".roles-capabilities" );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get list of rewrite rules

				jQuery('.rewrite-rules .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_rewrite_rules',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#rewrite-rules-content').prepend(data);
								jQuery('.rewrite-rules .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-rewrite-rules').fadeOut( 0 );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});
				// Get list of shorcodes and caller function

				jQuery('.shortcodes .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_shortcodes'
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#shortcodes-content').prepend(data);
								jQuery('.shortcodes .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-shortcodes').fadeOut( 0 );
							},
							error:function(errorThrown) {
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
							error:function(errorThrown) {
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
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});


				// Get cache value from $wp_object_cache

				jQuery('.cache__name').click( function() {

					var cacheKey = this.dataset.key;
					var cacheGroup = this.dataset.group;
					var optionLoaded = this.dataset.loaded;

					if ( optionLoaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_cache_value',
								'cache_key':cacheKey,
								'cache_group':cacheGroup,
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {

								if ( isJsonString(data) ) {
									var dataObj = JSON.parse(data);
									jQuery('#cache_' + cacheKey).jsonViewer(dataObj,{collapsed: true, rootCollapsable: false, withQuotes: false, withLinks: false});
								} else {
									jQuery('#cache_' + cacheKey).prepend(data);
								}

								jQuery('#cache-' + cacheKey).attr('data-loaded','yes');
								jQuery('#spinner-' + cacheKey).fadeOut( 0 );

							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get cache value from memory

				jQuery('.mcache__name').click( function() {

					var cacheKey = this.dataset.key;
					var cacheGroup = this.dataset.group;
					var optionLoaded = this.dataset.loaded;

					if ( optionLoaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_cache_value',
								'cache_key':cacheKey,
								'cache_group':cacheGroup,
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {

								if ( isJsonString(data) ) {
									var dataObj = JSON.parse(data);
									jQuery('#mcache_' + cacheKey).jsonViewer(dataObj,{collapsed: true, rootCollapsable: false, withQuotes: false, withLinks: false});
								} else {
									jQuery('#mcache_' + cacheKey).prepend(data);
								}

								jQuery('#mcache-' + cacheKey).attr('data-loaded','yes');
								jQuery('#spinner-m' + cacheKey).fadeOut( 0 );

							},
							error:function(errorThrown) {
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
							error:function(errorThrown) {
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
							error:function(errorThrown) {
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
							error:function(errorThrown) {
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
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get classes and methods from WP core

				jQuery('.core-classes .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_classes',
								'type':'core',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#core-classes-content').prepend(data);
								jQuery('.core-classes .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-core-classes').fadeOut( 0 );
								// initMcCollapsible( ".core-classes" );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get classes and methods from active theme

				jQuery('.theme-classes .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_classes',
								'type':'theme',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#theme-classes-content').prepend(data);
								jQuery('.theme-classes .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-theme-classes').fadeOut( 0 );
								initMcCollapsible( ".theme-classes" );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get classes and methods from active plugins

				jQuery('.plugins-classes .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_classes',
								'type':'plugins'
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#plugins-classes-content').prepend(data);
								jQuery('.plugins-classes .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-plugins-classes').fadeOut( 0 );
								initMcCollapsible( ".plugins-classes" );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get functions from WP core

				jQuery('.core-functions .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_functions',
								'type':'core',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#core-functions-content').prepend(data);
								jQuery('.core-functions .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-core-functions').fadeOut( 0 );

								// Search filter script
						        jQuery('[data-search-functions-wpcore]').on('keyup', function() {
						            var searchVal = jQuery(this).val();
						            var filterItems = jQuery('[data-fn-core]');

						            if ( searchVal != '' ) {
						                filterItems.addClass('hidden');
						                jQuery('[data-fn-core][data-fn-core-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
						            } else {
						                filterItems.removeClass('hidden');
						            }
						        });

							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get functions from active theme

				jQuery('.theme-functions .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_functions',
								'type':'theme',
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#theme-functions-content').prepend(data);
								jQuery('.theme-functions .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-theme-functions').fadeOut( 0 );
								initMcCollapsible( ".theme-functions" );
							},
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get functions from active plugins

				jQuery('.plugins-functions .csf-accordion-title').click( function() {

					var loaded = this.dataset.loaded;

					if ( loaded == 'no' ) {

						jQuery.ajax({
							url: ajaxurl,
							data: {
								'action':'sd_functions',
								'type':'plugins'
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#plugins-functions-content').prepend(data);
								jQuery('.plugins-functions .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-plugins-functions').fadeOut( 0 );
								initMcCollapsible( ".plugins-functions" );
							},
							error:function(errorThrown) {
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
								'global_name':name
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
							error:function(errorThrown) {
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
								'type':'defined'
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#constant-values-content').prepend(data);
								jQuery('.constant-values .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-constant-values').fadeOut( 0 );
								initMcCollapsible( ".constant-values" );
							},
							error:function(errorThrown) {
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
							error:function(errorThrown) {
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
								'filename':'wpcnfg', // wp-config.php, abbreviated to avoid blockage by GridPane / extra secure hosts
								'fast_ajax':true,
								'load_plugins':["system-dashboard/system-dashboard.php"]
							},
							success:function(data) {
								var data = data.slice(0,-1); // remove strange trailing zero in string returned by AJAX call
								jQuery('#wpconfig-content').prepend(data);
								jQuery('.wpconfig .csf-accordion-title').attr('data-loaded','yes');
								jQuery('#spinner-wpconfig').fadeOut( 0 );
							},
							error:function(errorThrown) {
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
							error:function(errorThrown) {
								console.log(errorThrown);
							}
						});

					} else {}

				});

				// Get content of robots.txt

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
							error:function(errorThrown) {
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
								'action':'sd_viewer_url',
								'path':'/wp-json/wp/v2',
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
							error:function(errorThrown) {
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
							error:function(errorThrown) {
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

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$option_name = $_REQUEST['option_name'];
			
			if ( ! empty( $option_name ) ) {

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

				echo __( 'None. Please define option name first.', 'system-dashboard' );
				
			}


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

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$type = $_REQUEST['type'];

			$wp_reference_base_url = 'https://developer.wordpress.org/reference/hooks';		

			if ( $type == 'action' ) {
				$response = wp_remote_get( plugin_dir_url( __DIR__ ). 'admin/references/actions.json' );
			} elseif ( $type == 'filter' ) {
				$response = wp_remote_get( plugin_dir_url( __DIR__ ). 'admin/references/filters.json' );
			}

			$hooks_json = wp_remote_retrieve_body( $response ); // as JSON
			$hooks = json_decode( $hooks_json, TRUE ); // convert into array
			$hooks = $hooks['hooks']; // only use the hooks array

			$output = '';
			$hooks_list = '';
			$hooks_count = 0;

			foreach ( $hooks as $hook ) {

				$hook_name = $hook['name'];
				$hook_slug = str_replace( array("{","}","$",">"), array("","","","-"), $hook_name ); // for href
				$hook_file = $hook['file'];
				$hook_short_description = $hook['doc']['description'];
				$hook_long_description = $hook['doc']['long_description'];

				$hook_tags = $hook['doc']['tags'];

				foreach ( $hook_tags as $hook_tag ) {
					if ( $hook_tag['name'] == 'since' ) {
						$hook_since_version = $hook_tag['content'];
					}
				}

				if ( $type == 'action' ) {

					// Search filter data attributes
					$search_atts = array(
						'core-act-hook'			=> '',
						'core-act-hook-name'	=> $hook['name'],
					);

				} elseif ( $type == 'filter' ) {

					// Search filter data attributes
					$search_atts = array(
						'core-fil-hook'			=> '',
						'core-fil-hook-name'	=> $hook['name'],
					);

				}

				$hooks_list .= $this->sd_html( 'field-content-start', '', '', $search_atts, '' );
				$hooks_list .= $this->sd_html( 'field-content-first', '<a href="' . $wp_reference_base_url . '/' . $hook_slug . '/" target="_blank">'. $hook_name . '</a> <br /><span>' . $hook_file . '</span><br /><span>Since ' . $hook_since_version . '</span>' );
				$hooks_list .= $this->sd_html( 'field-content-second', $hook_short_description . ' ' . $hook_long_description );
				$hooks_list .= $this->sd_html( 'field-content-end' );

				$hooks_count++;

			}

			// Add search filter box and total hooks count
			$output .= $this->sd_html( 'search-filter', 'Total: ' . $hooks_count . ' hooks', '', ['search-wpcore-action-hooks' => ''] );

			$output .= $hooks_list;

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
	public function sd_classes() {

		if ( isset( $_REQUEST ) && isset( $_REQUEST['type'] ) && current_user_can( 'manage_options' ) ) {

			$type = $_REQUEST['type'];

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

			}  elseif ( $type == 'theme' ) {

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

		}

		echo $output;

	}

	/**
	 * Get list of all PHP user-facing functions
	 * 
	 * @link https://plugins.svn.wordpress.org/fastdev/tags/1.7.1/app/Functions.php
	 * @link https://www.php.net/manual/en/function.get-defined-functions.
	 * @link https://www.php.net/manual/en/class.reflectionfunction.php
	 * @since 1.0.0
	 */
	public function sd_functions( $count = 'core' ) {
		$all_functions = get_defined_functions();
		$user_functions = $all_functions['user'];
		sort( $user_functions );

		$functions_core = array();
		$functions_plugins = array();
		$functions_theme = array();

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
					$functions_theme[] = $function;
				}

			}

		}

		// For AJAX calls

		if ( isset( $_REQUEST ) && isset( $_REQUEST['type'] ) && current_user_can( 'manage_options' ) ) {

			$type = $_REQUEST['type'];

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

				echo $output;

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

				echo $output;

			}  elseif ( $type == 'theme' ) {

				$functions_output = '';
				$functions_count = 0;

				foreach( $functions_theme as $function ) {

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

				echo $output;

			} else {}

		}

		// For direct function calls

		if ( $count == 'core-count' ) {

			$output = count( $functions_core );

			return $output;

		} elseif ( $count == 'plugins-count' ) {

			$output = count( $functions_plugins );

			return $output;

		} elseif ( $count == 'theme-count' ) {

			$output = count( $functions_theme );

			return $output;

		} else {}

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

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

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

			echo __( 'None. Please define global variable\'s name first.', 'system-dashboard' );

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

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

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
		
		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

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
						array(
							'name'		=> 'DIRECTORY_SEPARATOR',
							'description'	=> 'A predefined constant that contains either a forward slash or backslash depending on the OS your web server is on',
							'value'			=> '/ or \\',
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

							switch( gettype( $constant_value ) ) {
								case 'array':
								case 'object':
									$constant_value = '<pre>'.var_export($constant_value, true).'</pre>';
								break;
								case 'boolean':
									$constant_value = true === $constant_value ? 'true' : 'false';
								break;
							}

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

						switch(gettype( $constant_value ) ) {
							case 'array':
							case 'object':
								$constant_value = '<pre>'.var_export($constant_value, true).'</pre>';
							break;
							case 'boolean':
								$constant_value = true === $constant_value ? 'true' : 'false';
							break;
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
	 * Toggle logging tools on or off
	 *
	 * @since 2.6.0
	 */
	public function sd_toggle_logs() {

		$output = '';

		if ( isset( $_REQUEST ) && isset( $_REQUEST['log_type'] ) && current_user_can( 'manage_options' ) ) {

			$log_type = $_REQUEST['log_type'];

			// Page Access Log

			if ( $log_type == 'page_access_log' ) {


				// Set default value if option is not already set, e.g. users upgrading from older version of the plugin
				if ( get_option( 'system_dashboard_page_access_log' ) === false ) {

			        $option_value = array(
			            'status'    => 'disabled',
			            'on'        => date( 'Y-m-d H:i:s' ),
			        );

			        update_option( 'system_dashboard_page_access_log', $option_value, false );

				}

				$value = get_option( 'system_dashboard_page_access_log' );

				$date_time = date( 'Y-m-d H:i:s' );

				if ( $value['status'] == 'disabled' ) {

					$option_value = array(
						'status'	=> 'enabled',
						'on'		=> $date_time,
					);

					update_option( 'system_dashboard_page_access_log', $option_value, false );

					$output = 'Logging was enabled on ' . $date_time;

				} elseif ( $value['status'] == 'enabled' ) {

					$option_value = array(
						'status'	=> 'disabled',
						'on'		=> $date_time,
					);

					update_option( 'system_dashboard_page_access_log', $option_value, false );

					$output = 'Logging was disabled on ' . $date_time;

				} else {}

			}

			// Errors Log
			
			if ( $log_type == 'errors_log' ) {

				// Set default value if option is not already set, e.g. users upgrading from older version of the plugin
				if ( get_option( 'system_dashboard_errors_log' ) === false ) {

			        $option_value = array(
			            'status'    => 'disabled',
			            'on'        => date( 'Y-m-d H:i:s' ),
			        );

			        update_option( 'system_dashboard_errors_log', $option_value, false );

				}

				$value = get_option( 'system_dashboard_errors_log' );

				$date_time = date( 'Y-m-d H:i:s' );

				if ( $value['status'] == 'disabled' ) {

					$option_value = array(
						'status'	=> 'enabled',
						'on'		=> $date_time,
					);

					update_option( 'system_dashboard_errors_log', $option_value, false );

					// Assemble the errors log file path

			        $plain_domain = str_replace( array( ".", "-" ), "", $_SERVER['SERVER_NAME'] );
			        $errors_log_file_path = wp_upload_dir()['basedir'] . '/' . SYSTEM_DASHBOARD_PLUGIN_SLUG . '/logs/errors/' . $plain_domain . '_debug.log';

					// Define Debug constants in wp-config.php

					$this->sd_wpconfig_update( 'constant', 'WP_DEBUG', 'true' );
					$this->sd_wpconfig_update( 'constant', 'WP_DEBUG_LOG', $errors_log_file_path );
					$this->sd_wpconfig_update( 'constant', 'WP_DEBUG_DISPLAY', 'false' );

					$output = 'Logging was enabled on ' . $date_time;

				} elseif ( $value['status'] == 'enabled' ) {

					$option_value = array(
						'status'	=> 'disabled',
						'on'		=> $date_time,
					);

					update_option( 'system_dashboard_errors_log', $option_value, false );

					// Remove Debug constants in wp-config.php

					$this->sd_wpconfig_remove( 'constant', 'WP_DEBUG' );
					$this->sd_wpconfig_remove( 'constant', 'WP_DEBUG_LOG' );
					$this->sd_wpconfig_remove( 'constant', 'WP_DEBUG_DISPLAY' );

					$output = 'Logging was disabled on ' . $date_time;

				} else {}

			}

			// Email Delivery Log

			if ( $log_type == 'email_delivery_log' ) {


				// Set default value if option is not already set, e.g. users upgrading from older version of the plugin
				if ( get_option( 'system_dashboard_email_delivery_log' ) === false ) {

			        $option_value = array(
			            'status'    => 'disabled',
			            'on'        => date( 'Y-m-d H:i:s' ),
			        );

			        update_option( 'system_dashboard_email_delivery_log', $option_value, false );

				}

				$value = get_option( 'system_dashboard_email_delivery_log' );

				$date_time = date( 'Y-m-d H:i:s' );

				if ( $value['status'] == 'disabled' ) {

					$option_value = array(
						'status'	=> 'enabled',
						'on'		=> $date_time,
					);

					update_option( 'system_dashboard_email_delivery_log', $option_value, false );

					$output = 'Logging was enabled on ' . $date_time;

				} elseif ( $value['status'] == 'enabled' ) {

					$option_value = array(
						'status'	=> 'disabled',
						'on'		=> $date_time,
					);

					update_option( 'system_dashboard_email_delivery_log', $option_value, false );

					$output = 'Logging was disabled on ' . $date_time;

				} else {}

			}

		}

		echo $output;

	}

	/** 
	 * Page Access Log status
	 */
	public function sd_page_access_log_status() {

		$value = get_option( 'system_dashboard_page_access_log' );

		$status = $value['status'];
		$date_time = $value['on'];

		return '<div id="page-access-log-status" class="log-entries-header">Logging was '. $status .' on '. $date_time .'</div>';

	}

	/**
	 * Page Access Log content
	 *
	 * @since 2.6.0
	 */
	public function sd_page_access_log() {
		
		if ( current_user_can( 'manage_options' ) ) {
			$output = '<table id="page-access-log" class="wp-list-table widefat striped">
						<thead>
							<tr>
								<th>Date Time</th>
								<th>Visitor IP</th>
								<th>Page URI Accessed</th>							
							</tr>
						</thead>
						<tbody>';

			global $wpdb;

			$access_log_table = $wpdb->prefix . 'sd_page_access_log';

			$limit = 100;

			$sql = $wpdb->prepare( "SELECT * FROM {$access_log_table} ORDER BY ID DESC LIMIT %d", array( $limit ) );

			$results = $wpdb->get_results( $sql, ARRAY_A );

			foreach( $results as $log ) {

				$output .= '<tr>
								<td>'. $log['access_on'] .'</td>
								<td>'. $log['from_ip'] .'</td>
								<td>'. $log['page_url'] .'</td>
							</tr>';

			}

			$output .= '</tbody></table>';			
		} else {
			$output = '';
		}

		echo $output;

	}

	/** 
	 * Access logger
	 *
	 * @since 2.6.0
	 */
	public function sd_page_access_logger() {

		// Check status of logger

		$value = get_option( 'system_dashboard_page_access_log' );

		if ( $value['status'] == 'enabled' ) {

			// Get access/request data

			$request_uri = $_SERVER["REQUEST_URI"];

			$ip_address = addslashes( $_SERVER["REMOTE_ADDR"] );

			$date_time = date( 'Y-m-d H:i:s', $_SERVER["REQUEST_TIME"] );

			// Do not log anything for the following scenarios

			if ( 
				is_admin() 
				|| ( strpos( $request_uri, '/wp-includes/' ) !== false ) 
				|| ( strpos( $request_uri, '/wp-json/' ) !== false ) 
				|| ( strpos( $request_uri, 'author=' ) !== false ) 
				|| ( strpos( $request_uri, '.' ) !== false ) // e.g. wp-cron.php, xmlrpc.php, robots.txt
			) {
				return false;
			}

			// Log access details

	        global $wpdb;

	        $access_log_table = $wpdb->prefix . 'sd_page_access_log';

	        $data = array(
					'access_on'	=> $date_time,
					'from_ip'	=> $ip_address,
					'page_url'	=> sanitize_url( $request_uri ),
				);

	        $format = array(
					'%s',
					'%s',
					'%s',
				);

			$result = $wpdb->insert( $access_log_table, $data, $format );

		}

	}

	/** 
	 * Errors Log status
	 *
	 * @since 2.7.0
	 */
	public function sd_errors_log_status() {

		$value = get_option( 'system_dashboard_errors_log' );

		$status = $value['status'];
		$date_time = $value['on'];

		return '<div id="errors-log-status" class="log-entries-header">Logging was '. $status .' on '. $date_time .'</div>';

	}

	/**
	 * Get wp-config.php file path
	 *
	 * @since 2.7.0
	 * @link https://plugins.svn.wordpress.org/debug-log-config-tool/tags/1.1/src/Classes/vendor/WPConfigTransformer.php
	 */
	public function sd_wpconfig_file_path( $type = 'path' ) {

		// From wp-load.php

		if ( file_exists( ABSPATH . 'wp-config.php' ) ) {

			/** The config file resides in ABSPATH */
			$file = ABSPATH . 'wp-config.php';
			$location = 'WordPress root directory';


		} elseif ( @file_exists( dirname( ABSPATH ) . '/wp-config.php' ) && ! @file_exists( dirname( ABSPATH ) . '/wp-settings.php' ) ) {

			/** The config file resides one level above ABSPATH but is not part of another installation */
			$file = dirname( ABSPATH ) . '/wp-config.php';
			$location = 'parent directory of WordPress root';

		} else {

			$file = 'Undetectable.';
			$location = 'not in WordPress root or it\'s parent directory';

		}

		if ( $type == 'path' ) {
	        return $file;
		} elseif ( $type == 'location' ) {
			return $location;
		}


	}

	/**
	 * Get wp-config.php file info
	 *
	 * @since 2.7.0
	 * @link https://plugins.svn.wordpress.org/debug-log-config-tool/tags/1.1/src/Classes/vendor/WPConfigTransformer.php
	 */
	public function sd_wpconfig_file_info() {

		$file = $this->sd_wpconfig_file_path( 'path' );
		$location = $this->sd_wpconfig_file_path( 'location' );

		if ( !is_writable( $file ) ) {
			$status = 'not writeable';
        } else {
        	$status = 'writeable';
        }

        return '<div class="sd-viewer-intro sd-wpconfig-info">The file is located in ' . $location . ' ('. $file . ') and is ' . $status .'. File content is shown below.</div>';

	}

	/**
	 * Get debug.log file path
	 *
	 * @since 2.7.0
	 */
	public function sd_debuglog_file_info() {

		if ( defined( 'WP_DEBUG_LOG' ) && ( ! is_string( WP_DEBUG_LOG ) ) ) {

			// Assemble the errors log file path, i.e. use System Dashboard's log file
	        $plain_domain = str_replace( array( ".", "-" ), "", $_SERVER['SERVER_NAME'] );
	        $errors_log_file_path = wp_upload_dir()['basedir'] . '/' . SYSTEM_DASHBOARD_PLUGIN_SLUG . '/logs/errors/' . $plain_domain . '_debug.log';

		} elseif ( defined( 'WP_DEBUG_LOG' ) && is_string( WP_DEBUG_LOG ) ) {

			$errors_log_file_path = WP_DEBUG_LOG;

		}

        $errors_log_short_file_path = str_replace( ABSPATH, "", $errors_log_file_path );

        if ( file_exists( $errors_log_file_path ) ) {
	        $size = $this->sd_format_filesize( wp_filesize( $errors_log_file_path ) );
	        return '<div class="log-entries-footer">Log file: /' . $errors_log_short_file_path . ' (' . $size . ')</div>';
        } else {
        	return '<div class="log-entries-footer">There\'s no debug log file at ' . $errors_log_short_file_path . '</div>';
        }

	}

	/**
	 * Get configs in wp-config.php
	 * 
	 * @since 2.7.0
	 * @link https://plugins.svn.wordpress.org/debug-log-config-tool/tags/1.1/src/Classes/vendor/WPConfigTransformer.php
	 */
	public function sd_wpconfig_configs( $return_type = 'raw' ) {

		$src = file_get_contents( $this->sd_wpconfig_file_path() );

		$configs             = array();
		$configs['constant'] = array();
		$configs['variable'] = array();		

		// Strip comments.
		foreach ( token_get_all( $src ) as $token ) {
			if ( in_array( $token[0], array( T_COMMENT, T_DOC_COMMENT ), true ) ) {
				$src = str_replace( $token[1], '', $src );
			}
		}

		preg_match_all( '/(?<=^|;|<\?php\s|<\?\s)(\h*define\s*\(\s*[\'"](\w*?)[\'"]\s*)(,\s*(\'\'|""|\'.*?[^\\\\]\'|".*?[^\\\\]"|.*?)\s*)((?:,\s*(?:true|false)\s*)?\)\s*;)/ims', $src, $constants );
		preg_match_all( '/(?<=^|;|<\?php\s|<\?\s)(\h*\$(\w+)\s*=)(\s*(\'\'|""|\'.*?[^\\\\]\'|".*?[^\\\\]"|.*?)\s*;)/ims', $src, $variables );

		if ( ! empty( $constants[0] ) && ! empty( $constants[1] ) && ! empty( $constants[2] ) && ! empty( $constants[3] ) && ! empty( $constants[4] ) && ! empty( $constants[5] ) ) {
			foreach ( $constants[2] as $index => $name ) {
				$configs['constant'][ $name ] = array(
					'src'   => $constants[0][ $index ],
					'value' => $constants[4][ $index ],
					'parts' => array(
						$constants[1][ $index ],
						$constants[3][ $index ],
						$constants[5][ $index ],
					),
				);
			}
		}

		if ( ! empty( $variables[0] ) && ! empty( $variables[1] ) && ! empty( $variables[2] ) && ! empty( $variables[3] ) && ! empty( $variables[4] ) ) {
			// Remove duplicate(s), last definition wins.
			$variables[2] = array_reverse( array_unique( array_reverse( $variables[2], true ) ), true );
			foreach ( $variables[2] as $index => $name ) {
				$configs['variable'][ $name ] = array(
					'src'   => $variables[0][ $index ],
					'value' => $variables[4][ $index ],
					'parts' => array(
						$variables[1][ $index ],
						$variables[3][ $index ],
					),
				);
			}
		}

		$this->wp_configs = $configs;

		if ( $return_type == 'raw' ) {
			return $configs;
		} elseif ( $return_type == 'print_r' ) {
			return '<pre>' . print_r( $configs, true ) . '</pre>';
		}
	}

	/**
	 * Checks if a config exists in the wp-config.php file.
	 *
	 * @throws Exception If the wp-config.php file is empty.
	 * @throws Exception If the requested config type is invalid.
	 *
	 * @param string $type Config type (constant or variable).
	 * @param string $name Config name.
	 *
	 * @return bool
	 * @since 2.7.0
	 * @link https://plugins.svn.wordpress.org/debug-log-config-tool/tags/1.1/src/Classes/vendor/WPConfigTransformer.php
	 */
	public function sd_wpconfig_exists( $type, $name ) {
		$wp_config_src = file_get_contents( $this->sd_wpconfig_file_path() );

		if ( ! trim( $wp_config_src ) ) {
			throw new Exception( 'Config file is empty.' );
		}
		// Normalize the newline to prevent an issue coming from OSX.
		$this->wp_config_src = str_replace( array( "\n\r", "\r" ), "\n", $wp_config_src );

		$this->wp_configs = $this->sd_wpconfig_configs( 'raw' );

		if ( ! isset( $this->wp_configs[ $type ] ) ) {
			throw new Exception( "Config type '{$type}' does not exist." );
		}

		return isset( $this->wp_configs[ $type ][ $name ] );
	}

	/**
	 * Adds a config to the wp-config.php file.
	 *
	 * @throws Exception If the config value provided is not a string.
	 * @throws Exception If the config placement anchor could not be located.
	 *
	 * @param string $type    Config type (constant or variable).
	 * @param string $name    Config name.
	 * @param string $value   Config value.
	 * @param array  $options (optional) Array of special behavior options.
	 *
	 * @return bool
	 * @since 2.7.0
	 * @link https://plugins.svn.wordpress.org/debug-log-config-tool/tags/1.1/src/Classes/vendor/WPConfigTransformer.php
	 */
	public function sd_wpconfig_add( $type, $name, $value ) {
		if ( ! is_string( $value ) ) {
			throw new Exception( 'Config value must be a string.' );
		}

		if ( $this->sd_wpconfig_exists( $type, $name ) ) {
			return false;
		}

		$defaults = array(
			'raw'       => false, // Display value in raw format without quotes.
			'anchor'    => "/* That's all, stop editing! Happy publishing. */", // Config placement anchor string.
			'separator' => PHP_EOL, // Separator between config definition and anchor string.
			'placement' => 'before', // Config placement direction (insert before or after).
		);

		list( $raw, $anchor, $separator, $placement ) = array_values( $defaults );

		$raw       = (bool) $raw;
		$anchor    = (string) $anchor;
		$separator = (string) $separator;
		$placement = (string) $placement;

		if ( 'EOF' === $anchor ) {
			$contents = $this->wp_config_src . $this->sd_wpconfig_normalize( $type, $name, $this->sd_wpconfig_format_value( $value, $raw ) );
		} else {
			if ( false === strpos( $this->wp_config_src, $anchor ) ) {
				throw new Exception( 'Unable to locate placement anchor.' );
			}

			$new_src  = $this->sd_wpconfig_normalize( $type, $name, $this->sd_wpconfig_format_value( $value, $raw ) );
			$new_src  = ( 'after' === $placement ) ? $anchor . $separator . $new_src : $new_src . $separator . $anchor;
			$contents = str_replace( $anchor, $new_src, $this->wp_config_src );
		}

		return $this->sd_wpconfig_save( $contents );
	}

	/**
	 * Updates an existing config in the wp-config.php file.
	 *
	 * @throws Exception If the config value provided is not a string.
	 *
	 * @param string $type    Config type (constant or variable).
	 * @param string $name    Config name.
	 * @param string $value   Config value.
	 * @param array  $options (optional) Array of special behavior options.
	 *
	 * @return bool
	 * @since 2.7.0
	 * @link https://plugins.svn.wordpress.org/debug-log-config-tool/tags/1.1/src/Classes/vendor/WPConfigTransformer.php
	 */
	public function sd_wpconfig_update( $type, $name, $value ) {
		if ( ! is_string( $value ) ) {
			throw new Exception( 'Config value must be a string.' );
		}

		$defaults = array(
			'add'       => true, // Add the config if missing.
			'raw'       => false, // Display value in raw format without quotes.
			'normalize' => false, // Normalize config output using WP Coding Standards.
		);

		list( $add, $raw, $normalize ) = array_values( $defaults );

		$add       = (bool) $add;
		$raw       = (bool) $raw;
		$normalize = (bool) $normalize;

		if ( ! $this->sd_wpconfig_exists( $type, $name ) ) {
			return ( $add ) ? $this->sd_wpconfig_add( $type, $name, $value ) : false;
		}

		$old_src   = $this->wp_configs[ $type ][ $name ]['src'];
		$old_value = $this->wp_configs[ $type ][ $name ]['value'];
		$new_value = $this->sd_wpconfig_format_value( $value, $raw );

		if ( $normalize ) {
			$new_src = $this->sd_wpconfig_normalize( $type, $name, $new_value );
		} else {
			$new_parts    = $this->wp_configs[ $type ][ $name ]['parts'];
			$new_parts[1] = str_replace( $old_value, $new_value, $new_parts[1] ); // Only edit the value part.
			$new_src      = implode( '', $new_parts );
		}

		$contents = preg_replace(
			sprintf( '/(?<=^|;|<\?php\s|<\?\s)(\s*?)%s/m', preg_quote( trim( $old_src ), '/' ) ),
			'$1' . str_replace( '$', '\$', trim( $new_src ) ),
			$this->wp_config_src
		);

		return $this->sd_wpconfig_save( $contents );
	}

	/**
	 * Removes a config from the wp-config.php file.
	 *
	 * @param string $type Config type (constant or variable).
	 * @param string $name Config name.
	 *
	 * @return bool
	 * @since 2.7.0
	 * @link https://plugins.svn.wordpress.org/debug-log-config-tool/tags/1.1/src/Classes/vendor/WPConfigTransformer.php
	 */
	public function sd_wpconfig_remove( $type, $name ) {
		if ( ! $this->sd_wpconfig_exists( $type, $name ) ) {
			return false;
		}

		$wp_config_src = file_get_contents( $this->sd_wpconfig_file_path() );
		$this->wp_config_src = str_replace( array( "\n\r", "\r" ), "\n", $wp_config_src );
		$this->wp_configs = $this->sd_wpconfig_configs( 'raw' );

		$pattern  = sprintf( '/(?<=^|;|<\?php\s|<\?\s)%s\s*(\S|$)/m', preg_quote( $this->wp_configs[$type][$name]['src'], '/' ) );
		$contents = preg_replace( $pattern, '$1', $this->wp_config_src );

		return $this->sd_wpconfig_save( $contents );
	}

	/**
	 * Applies formatting to a config value.
	 *
	 * @throws Exception When a raw value is requested for an empty string.
	 *
	 * @param string $value Config value.
	 * @param bool   $raw   Display value in raw format without quotes.
	 *
	 * @return mixed
	 * @since 2.7.0
	 * @link https://plugins.svn.wordpress.org/debug-log-config-tool/tags/1.1/src/Classes/vendor/WPConfigTransformer.php
	 */
	public function sd_wpconfig_format_value( $value, $raw ) {
		if ( $raw && '' === trim( $value ) ) {
			throw new Exception( 'Raw value for empty string not supported.' );
		}

		return ( $raw ) ? $value : var_export( $value, true );
	}

	/**
	 * Normalizes the source output for a name/value pair.
	 *
	 * @throws Exception If the requested config type does not support normalization.
	 *
	 * @param string $type  Config type (constant or variable).
	 * @param string $name  Config name.
	 * @param mixed  $value Config value.
	 *
	 * @return string
	 * @since 2.7.0
	 * @link https://plugins.svn.wordpress.org/debug-log-config-tool/tags/1.1/src/Classes/vendor/WPConfigTransformer.php
	 */
	public function sd_wpconfig_normalize( $type, $name, $value ) {
		if ( 'constant' === $type ) {
			$placeholder = "define( '%s', %s );";
		} elseif ( 'variable' === $type ) {
			$placeholder = '$%s = %s;';
		} else {
			throw new Exception( "Unable to normalize config type '{$type}'." );
		}

		return sprintf( $placeholder, $name, $value );
	}

	/**
	 * Saves new contents to the wp-config.php file.
	 *
	 * @throws Exception If the config file content provided is empty.
	 * @throws Exception If there is a failure when saving the wp-config.php file.
	 *
	 * @param string $contents New config contents.
	 *
	 * @return bool
	 * @since 2.7.0
	 * @link https://plugins.svn.wordpress.org/debug-log-config-tool/tags/1.1/src/Classes/vendor/WPConfigTransformer.php
	 */
	public function sd_wpconfig_save( $contents ) {
		if ( ! trim( $contents ) ) {
			throw new Exception( 'Cannot save the config file with empty contents.' );
		}

		if ( $contents === $this->wp_config_src ) {
			return false;
		}

		$result = file_put_contents( $this->sd_wpconfig_file_path(), $contents, LOCK_EX );

		if ( false === $result ) {
			throw new Exception( 'Failed to update the config file.' );
		}

		return true;
	}

	/**
	 * Errors Log content
	 *
	 * @since 2.7.0
	 */
	public function sd_errors_log() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {
			
			$output = '<table id="errors-log" class="wp-list-table widefat striped">
						<thead>
							<tr>
								<th>Entries</th>
							</tr>
						</thead>
						<tbody>';

			if ( defined( 'WP_DEBUG_LOG' ) && ( ! is_string( WP_DEBUG_LOG ) ) ) {

				// Assemble the errors log file path, i.e. use System Dashboard's log file
		        $plain_domain = str_replace( array( ".", "-" ), "", $_SERVER['SERVER_NAME'] );
		        $errors_log_file_path = wp_upload_dir()['basedir'] . '/' . SYSTEM_DASHBOARD_PLUGIN_SLUG . '/logs/errors/' . $plain_domain . '_debug.log';

			} elseif ( defined( 'WP_DEBUG_LOG' ) && is_string( WP_DEBUG_LOG ) ) {

				$errors_log_file_path = WP_DEBUG_LOG;

			} else {}

	        // Read the erros log file, reverse the order of the entries, prune to the latest 5000 entries
	        $log = file_get_contents( $errors_log_file_path );

	        $log 	= str_replace( "[\\", "^\\", $log ); // certain error message contains the '[\' string, which will make the following split via explode() to split lines at places in the message it's not supposed to. So, we temporarily replace those with '^\'
	        $log = str_replace( "[internal function]", "^internal function^", $log );

	        // We are splitting the log file not using PHP_EOL to preserve the stack traces for PHP Fatal Errors among other things
	        $lines = explode("[", $log);
	        $prepended_lines = array();

	        foreach ( $lines as $line ) {
	        	if ( !empty($line) ) {
	        		$line 				= str_replace( "UTC]", "UTC]@@@", $line ); // add '@@@' as marker/separator after time stamp
	        		$line 				= str_replace( "Stack trace:", "<hr />Stack trace:", $line ); // add line break for stack trace section
					if ( strpos( $line, 'PHP Fatal' ) !== false ) {
		        		$line 			= str_replace( "#", "<hr />#", $line ); // add line break on PHP Fatal error's stack trace lines
		        	}
	        		$line 			= str_replace( "Argument <hr />#", "Argument #", $line ); // remove hr on certain error message
	        		$line 			= str_replace( "parameter <hr />#", "parameter #", $line ); // remove hr on certain error message
	        		$line 			= str_replace( "the <hr />#", "the #", $line ); // remove hr on certain error message
	        		$line 			= str_replace( "^\\", "[\\", $line ); // reverse the temporary replacement of '[\' with '^\'
	        		$line = str_replace( "^internal function^", "[internal function]", $line );
		        	$prepended_line 	= '[' . $line; // Put back the missing '[' after explode operation
		        	$prepended_lines[] 	= $prepended_line;
	        	}
	        }

	        $lines_newest_first 	= array_reverse( $prepended_lines );
	        $latest_lines 			= array_slice( $lines_newest_first, 0, 50000 );

	        // Will hold error details types
	        $errors_master_list = array();

	        // Will hold error details types
	        $errors_master_list = array();

			foreach( $latest_lines as $line ) {

				$line = explode("@@@ ", $line);

				$timestamp = str_replace( [ "[", "]" ], "", $line[0] );
				if ( array_key_exists('1', $line) ) {
					$error = $line[1];
				} else {
					$error = 'No error message specified...';
				}

				if ( strpos( $error, 'PHP Fatal' ) !==false ) {
					$error_type = 'PHP Fatal';
					$error_details = str_replace( "PHP Fatal: ", "", $error );
				} elseif ( strpos( $error, 'PHP Warning' ) !==false ) {
					$error_type = 'PHP Warning';
					$error_details = str_replace( "PHP Warning: ", "", $error );
				} elseif ( strpos( $error, 'PHP Notice' ) !==false ) {
					$error_type = 'PHP Notice';
					$error_details = str_replace( "PHP Notice: ", "", $error );
				} elseif ( strpos( $error, 'PHP Deprecated' ) !==false ) {
					$error_type = 'PHP Deprecated';
					$error_details = str_replace( "PHP Deprecated: ", "", $error );
				} elseif ( strpos( $error, 'PHP Parse' ) !== false ) {
					$error_type = 'PHP Parse';
					$error_details 	= str_replace( "PHP Parse error: ", "", $error );
				} elseif ( strpos( $error, 'WordPress database error' ) !==false ) {
					$error_type = 'WP DB error';
					$error_details = str_replace( "WordPress database error ", "", $error );
				} else {
					$error_type = 'Other';
					$error_details = $error;
				}

				// https://www.php.net/manual/en/function.array-search.php#120784
				if ( array_search( trim( $error_details ), array_column( $errors_master_list, 'details' ) ) === false ) {

					$errors_master_list[] = array(
						'type'			=> $error_type,
						'details'		=> trim( $error_details ),
						'occurrences'	=> array( $timestamp ),
					);

				} else {

					$error_position = array_search( trim( $error_details ), array_column( $errors_master_list, 'details' ) ); // integer

					array_push( $errors_master_list[$error_position]['occurrences'], $timestamp );

				}

			}

			foreach ( $errors_master_list as $error ) {

				$localized_timestamp = wp_date( 'j-M-Y - H:i:s', strtotime( $error['occurrences'][0] ) ); // last occurrence
				$occurrence_count = count( $error['occurrences'] );

				$output .= '<tr>
								<td><span class="hidden">' . esc_html( $localized_timestamp ) . '</span><strong>Last seen on</strong>: ' . esc_html( $localized_timestamp ) .' <span class="sd-faint">(' . esc_html( $occurrence_count ) . ' occurrences logged)</span><br />
								<strong>'. esc_html( $error['type'] ) .'</strong>: '. $error['details'] .'</td>
							</tr>';

			}

			$output .= '</tbody></table>';

			echo $output;

		}

	}

	/** 
	 * Email Delivery Log status
	 * 
	 * @since 2.8.0
	 */
	public function sd_email_delivery_log_status() {

		$value = get_option( 'system_dashboard_email_delivery_log' );

		$status = $value['status'];
		$date_time = $value['on'];

		return '<div id="email-delivery-log-status" class="log-entries-header">Logging was '. $status .' on '. $date_time .'</div>';

	}

	/**
	 * Email Delivery logger
	 *
	 * @since 2.8.0
	 */
	public function sd_email_delivery_logger( $email ) {

		global $wpdb;

        $email_delivery_log_table = $wpdb->prefix . 'sd_email_delivery_log';

        if ( is_array( $email['attachments'] && count( $email['attachments'] ) > 0 ) ) {
	        $attachments_exist = true;
        } else {
	        $attachments_exist = false;        	
        }

        if ( is_array( $email['to'] ) ) {
        	$email_to = implode( ", ", $email['to'] );
        } else {
        	$email_to = $email['to'];
        	$email_to_array = explode( ",", $email_to );
        	$email_to = implode( ", ", $email_to_array );
        }

        $data = array(
        	'to_email'		=> $email_to,
        	'subject'		=> $email['subject'],
        	'message'		=> $email['message'],
        	'headers'		=> $email['headers'],
        	'attachments'	=> $attachments_exist,
        	'sent_on'		=> current_time( 'mysql', $gmt = 0 ),
        	'sent_on_gmt'	=> current_time( 'mysql', $gmt = 1 ),
        );

        $format = array(
				'%s', // string
				'%s',
				'%s',
				'%s',
				'%d', // integer https://wordpress.stackexchange.com/a/145108
				'%s',
				'%s',
        );

        $result = $wpdb->insert( $email_delivery_log_table, $data, $format );

	}

	/**
	 * Email Delivery log entries
	 *
	 * @since 2.8.0
	 */
	public function sd_email_delivery_log() {

		if ( isset( $_REQUEST ) && current_user_can( 'manage_options' ) ) {

			$output = '<table id="email-delivery-log" class="wp-list-table widefat striped">
						<thead>
							<tr>
								<th>Entries</th>
							</tr>
						</thead>
						<tbody>';

			global $wpdb;

			$email_delivery_log_table = $wpdb->prefix . 'sd_email_delivery_log';

			$limit = 1000;

			$sql = $wpdb->prepare( "SELECT * FROM {$email_delivery_log_table} ORDER BY ID DESC LIMIT %d", array( $limit ) );

			$results = $wpdb->get_results( $sql, ARRAY_A );

			foreach( $results as $log ) {

				$output .= '<tr>
								<td><strong>Sent on:</strong> '. $log['sent_on'] . '<br />
								<strong>To:</strong> ' . $log['to_email'] . '<br />
								<strong>Subject:</strong> ' . $log['subject'] . 
								'<div class="ui accordion">
									<div class="title"><i class="dropdown icon"></i>View message</div>
									<div class="content">' . $log['message'] .'</div>
								</div></td>
							</tr>';

			}

			$output .= '</tbody></table>';

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
				array(
					'type'		=> 'plugin',
					'name'		=> 'WP Bulk Delete',
					'pointer'	=> 'wp-bulk-delete',
					'usenow'	=> '/wp-admin/admin.php?page=delete_all_posts',
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
			'object_cache' 	=> array(
				array(
					'type'		=> 'plugin',
					'name'		=> 'Redis Object Cache',
					'pointer'	=> 'redis-cache',
					'usenow'	=> '/wp-admin/options-general.php?page=redis-cache',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Powered Cache',
					'pointer'	=> 'powered-cache',
					'usenow'	=> '/wp-admin/admin.php?page=powered-cache',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Use Memcached',
					'pointer'	=> 'use-memcached',
					'usenow'	=> '/wp-admin/tools.php?page=use_memcached',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Object Cache 4 everyone',
					'pointer'	=> 'object-cache-4-everyone',
					'usenow'	=> 'url',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Docket Cache - Object Cache Accelerator',
					'pointer'	=> 'docket-cache',
					'usenow'	=> '',
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
					'name'		=> 'Rewrite Rules Inspector',
					'pointer'	=> 'rewrite-rules-inspector',
					'usenow'	=> 'url',
				),
				array(
					'type'		=> 'plugin',
					'name'		=> 'Combo WP Rewrite Slugs',
					'pointer'	=> 'combo-wp-rewrite-slugs',
					'usenow'	=> 'url',
				),
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
		$output .= $this->sd_html( 'accordion-head', __( 'View', 'system-dashboard' ) );

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
				array(
					'type'		=> 'link',
					'name'		=> 'Add MySQL Index to WordPress wp_options Table',
					'pointer'	=> 'https://guides.wp-bullet.com/add-mysql-index-wordpress-wp_options-table/',
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
			'object_cache' 	=> array(
				array(
					'type'		=> 'link',
					'name'		=> 'Code Reference: WP_Object_Cache',
					'pointer'	=> 'https://developer.wordpress.org/reference/classes/wp_object_cache/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'WordPress Object Caching: Redis, Memcached and native APIs',
					'pointer'	=> 'https://pressidium.com/blog/wordpress-object-caching-redis-memcached-and-native-apis/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Everything You Need To Know About WordPress Object Caching',
					'pointer'	=> 'https://wpastra.com/wordpress-object-caching/',
				),
				array(
					'type'		=> 'link',
					'name'		=> 'Using the WordPress Object Cache to Cache Query Results',
					'pointer'	=> 'https://pressable.com/knowledgebase/using-wordpress-object-cache-for-query-results/',
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
		$output .= $this->sd_html( 'accordion-head', __( 'View', 'system-dashboard' ) );

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
				'menu_title' 		=> __( 'System', 'system-dashboard' ),
				'menu_slug' 		=> 'system-dashboard',
				'menu_type'			=> 'submenu',
				'menu_parent'		=> 'index.php',
				'menu_position'		=> 1,
				// 'menu_icon'			=> 'dashicons-arrow-up-alt2',
				'framework_title' 	=> 'System Dashboard <small>by <a href="https://bowo.io/bowoio-sd" target="_blank">Bowo</a></small>',
				'framework_class' 	=> 'sd-options',
				'show_bar_menu' 	=> false,
				'show_search' 		=> false,
				'show_reset_all' 	=> false,
				'show_reset_section' => false,
				'show_form_warning' => false,
				'save_defaults'		=> true,
				'show_footer' 		=> false,
				'footer_credit'		=> '<a href="https://bowo.io/dotorg-sd" target="_blank">System Dashboard</a> is on <a href="https://bowo.io/github-sd" target="_blank">github</a>',
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
								'title'		=> __( 'Database', 'system-dashboard' ),
								'fields'	=> array(
									array(
										'type'		=> 'content',
										'title'		=> __( 'System & Uptime', 'system-dashboard' ),
										'content'	=> $this->sd_get_mysql_version() . ' / ' . $this->sd_db_uptime(),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Data & Index Size', 'system-dashboard' ),
										'content'	=> $this->sd_db_disk_usage( 'data' ) . ' / ' . $this->sd_db_disk_usage( 'index' ),
									),
									array(
										'id'		=> 'core_db_tables',
										'type'		=> 'accordion',
										'title'		=> __( 'Core', 'system-dashboard' ),
										'subtitle'	=> $this->sd_db_tables( 'count-core' ) . ' tables',
										'class'		=> 'core-db-tables',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Tables', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'core-db-tables' ), // AJAX loading via sd_db_tables()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'noncore_db_tables',
										'type'		=> 'accordion',
										'title'		=> __( 'Themes & Plugins', 'system-dashboard' ),
										'subtitle'	=> $this->sd_db_tables( 'count-noncore' ) . ' tables',
										'class'		=> 'noncore-db-tables',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Tables', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'noncore-db-tables' ), // AJAX loading via sd_db_tables()
													),													
												),
											),
										),
									),									array(
										'id'		=> 'db_key_specs',
										'type'		=> 'accordion',
										'title'		=> __( 'Key Info', 'system-dashboard' ),
										'class'		=> 'db-specs',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'db-specs' ), // AJAX loading via sd_db_specs()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'db_detail_specs',
										'type'		=> 'accordion',
										'title'		=> __( 'Detailed Specifications', 'system-dashboard' ),
										'class'		=> 'db-details',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'db-details' ), // AJAX loading via sd_db_details()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Tools', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'database' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'database' ),
									),

								),
							),

							array(
								'title' => __( 'Post Types & Taxonomies', 'system-dashboard' ),
								'fields' => array(
									array(
										'id'		=> 'post_types',
										'type'		=> 'accordion',
										'title'		=> __( 'Post Types Post Count', 'system-dashboard' ),
										'class'		=> 'post-types',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'post-types' ), // AJAX loading via sd_post_types()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'taxonomies',
										'type'		=> 'accordion',
										'title'		=> __( 'Taxonomies Term Count', 'system-dashboard' ),
										'class'		=> 'taxonomies',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'taxonomies' ), // AJAX loading via sd_taxonomies()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'pttax_old_slugs',
										'type'		=> 'accordion',
										'title'		=> __( 'Old Slugs', 'system-dashboard' ),
										'class'		=> 'old-slugs',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'old-slugs' ), // AJAX loading via sd_old_slugs()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Tools', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'posttypes_taxonomies' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'posttypes_taxonomies' ),
									),

								),
							),

							array(
								'title'		=> __( 'Media', 'system-dashboard' ),
								'fields'	=> array(

									array(
										'id'		=> 'media_count_by_mime',
										'type'		=> 'accordion',
										'title'		=> __( 'Media Count by Mime Type', 'system-dashboard' ),
										'class'		=> 'media-count',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'media-count' ), // AJAX loading via sd_media_count()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'media_allowed_mime_types',
										'type'		=> 'accordion',
										'title'		=> __( 'Allowed Mime Types', 'system-dashboard' ),
										'class'		=> 'mime-types',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'mime-types' ), // AJAX loading via sd_mime_types()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'image_sizes',
										'type'		=> 'accordion',
										'title'		=> __( 'Registered Image Sizes', 'system-dashboard' ),
										'class'		=> 'image-sizes',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														// 'content'	=> $this->sd_image_sizes(),
														'content'	=> $this->sd_html( 'ajax-receiver', 'image-sizes' ), // AJAX loading via sd_image_sizes()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'media_handling',
										'type'		=> 'accordion',
										'title'		=> __( 'Media Handling', 'system-dashboard' ),
										'class'		=> 'media-handling',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'media-handling' ), // AJAX loading via sd_media_handling()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Tools', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'media' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'media' ),
									),

								),
							),

							array(
								'title' => 'Directories',
								'fields' => array(
									array(
										'type'		=> 'content',
										'title'		=> __( 'Root path', 'system-dashboard' ),
										'content'	=> str_replace( "/wp-content", "", WP_CONTENT_DIR ),
									),
									array(
										'id'		=> 'directory_sizes',
										'type'		=> 'accordion',
										'title'		=> __( 'Directory Sizes', 'system-dashboard' ),
										'class'		=> 'directory-sizes',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'directory-sizes' ), // AJAX loading via sd_directory_sizes()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'filesystem_permissions',
										'type'		=> 'accordion',
										'title'		=> __( 'Filesystem Permissions', 'system-dashboard' ),
										'class'		=> 'filesystem-permissions',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'filesystem-permissions' ), // AJAX loading via sd_filesystem_permissions()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Tools', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'directories' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'directories' ),
									),
								),
							),

							array(
								'title' => __( 'Custom Fields', 'system-dashboard' ),
								'fields' => array(

									array(
										'id'		=> 'custom_fields',
										'type'		=> 'accordion',
										'title'		=> __( 'By Type', 'system-dashboard' ),
										'class'		=> 'custom-fields',
										'accordions'	=> array(

											array(
												'title'		=> __( 'View Public Fields', 'system-dashboard' ) . ' (' . $this->sd_custom_fields( 'public-count' ) . ')',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'public-custom-fields' ), // AJAX loading via sd_custom_fields()
													),													
												),
											),
											array(
												'title'		=> __( 'View Private Fields', 'system-dashboard' ) . ' (' . $this->sd_custom_fields( 'private-count' ) . ')',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'private-custom-fields' ), // AJAX loading via sd_custom_fields()
													),													
												),
											),

										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Tools', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'custom_fields' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'custom_fields' ),
									),

								),
							),

							array(
								'title' => __( 'Users', 'system-dashboard' ),
								'fields' => array(

									array(
										'id'		=> 'user_count_by_role',
										'type'		=> 'accordion',
										'title'		=> __( 'Users Count by Role', 'system-dashboard' ),
										'class'		=> 'user-count',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'user-count' ), // AJAX loading via sd_user_count()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'urc_tools',
										'type'		=> 'accordion',
										'title'		=> __( 'Roles & Capabilities', 'system-dashboard' ),
										'class'		=> 'roles-capabilities',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'roles-capabilities' ), // AJAX loading via sd_roles_capabilities()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Tools', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'users_roles_capabilities' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
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
								'title'		=> __( 'Options', 'system-dashboard' ),
								'fields'	=> array(
									array(
										'type'		=> 'content',
										'title'		=> __( 'Total', 'system-dashboard' ),
										'content'	=> $this->sd_options( 'total_count' ) . ' options',
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Autoloaded', 'system-dashboard' ),
										'content'	=> $this->sd_options( 'total_count_autoloaded' ) . ' options | Total size: ' . $this->sd_options( 'total_autoloaded_size' ),
									),
									array(
										'id'		=> 'wp_core_options',
										'type'		=> 'accordion',
										'title'		=> __( 'Core', 'system-dashboard' ),
										'subtitle'	=> $this->sd_options( 'wpcore_count' ) . ' options',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Options', 'system-dashboard' ),
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
										'title'		=> __( 'Themes & Plugins', 'system-dashboard' ),
										'subtitle'	=> $this->sd_options( 'noncore_count' ) . ' options',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Options', 'system-dashboard' ),
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
										'id'		=> 'wp_noncore_options',
										'type'		=> 'accordion',
										'title'		=> __( 'Largest Autoloaded', 'system-dashboard' ),
										'subtitle'	=> '10 options',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Options', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_options_largest_autoloads(),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Tools', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'options' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'options' ),
									),

								),
							),

							array(
								'title'		=> __( 'Transients', 'system-dashboard' ),
								'fields'	=> array(
									array(
										'type'		=> 'content',
										'title'		=> __( 'Total', 'system-dashboard' ),
										'content'	=> $this->sd_transients( 'total_count' ) . ' transients',
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Autoloaded', 'system-dashboard' ),
										'content'	=> $this->sd_transients( 'total_count_autoloaded' ) . ' transients | Total size: ' . $this->sd_transients( 'total_autoloaded_size' ),
									),
									array(
										'id'		=> 'transients_active',
										'type'		=> 'accordion',
										'title'		=> __( 'With Expiration', 'system-dashboard' ),
										'subtitle'	=> $this->sd_transients( 'count', 'active' ) . ' transients',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Transients', 'system-dashboard' ),
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
										'title'		=> __( 'Expired', 'system-dashboard' ),
										'subtitle'	=> $this->sd_transients( 'count', 'expired' ) . ' transients',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Transients', 'system-dashboard' ),
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
										'title'		=> __( 'Does Not Expire', 'system-dashboard' ),
										'subtitle'	=> $this->sd_transients( 'count', 'neverexpire' ) . ' transients',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Transients', 'system-dashboard' ),
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
										'title'		=> __( 'Tools', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'transients' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'transients' ),
									),

								),
							),

							array(
								'title'		=> __( 'Object Cache', 'system-dashboard' ),
								'fields'	=> array(
									array(
										'type'		=> 'content',
										'title'		=> __( 'Status', 'system-dashboard' ),
										'content'	=> $this->sd_object_cache( 'status' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Stats', 'system-dashboard' ),
										'content'	=> $this->sd_object_cache( 'stats' ),
									),
									array(
										'id'		=> 'object_cache_global_groups',
										'type'		=> 'accordion',
										'title'		=> __( 'Global Groups', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_object_cache( 'global_groups' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'object_cache_ignored_groups',
										'type'		=> 'accordion',
										'title'		=> __( 'Non-persistent Groups', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_object_cache( 'non_persistent_groups' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'object_cache_content',
										'type'		=> 'accordion',
										'title'		=> __( 'From $wp_object_cache', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Cache Content', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_object_cache( 'wp_object_cache_content' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'object_cache_content',
										'type'		=> 'accordion',
										'title'		=> __( 'From Memory', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Cache Content', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_object_cache( 'cache_content_from_memory' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'object_cache_diagnostics',
										'type'		=> 'accordion',
										'title'		=> __( 'Diagnostics', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_object_cache( 'diagnostics' ),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Tools', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'object_cache' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'object_cache' ),
									),

								),
							),
							array(
								'title'		=> __( 'Cron', 'system-dashboard' ),
								'fields'	=> array(
									array(
										'type'		=> 'content',
										'title'		=> __( 'Total', 'system-dashboard' ),
										'content'	=> $this->sd_cron( 'all', 'count' ) . ' cron events',
									),
									array(
										'id'		=> 'cron_events',
										'type'		=> 'accordion',
										'title'		=> __( 'Core', 'system-dashboard' ),
										'subtitle'		=> $this->sd_cron( 'wpcore', 'count' ) . ' events',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_cron( 'wpcore', 'events' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'cron_events',
										'type'		=> 'accordion',
										'title'		=> __( 'Themes & Plugins', 'system-dashboard' ),
										'subtitle'		=> $this->sd_cron( 'custom', 'count' ) . ' events',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_cron( 'custom', 'events' ),
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'cron_events',
										'type'		=> 'accordion',
										'title'		=> __( 'Schedules', 'system-dashboard' ),
										'subtitle'		=> $this->sd_cron( 'schedules', 'count' ) . ' intervals',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_cron( 'schedules', 'list' ),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'View', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'cron' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'cron' ),
									),

								),
							),


							array(
								'title'		=> __( 'Rewrite Rules', 'system-dashboard' ),
								'fields'	=> array(

									array(
										'type'		=> 'content',
										'title'		=> __( 'Total', 'system-dashboard' ),
										'content'	=> $this->sd_rewrite_rules_count() . ' rules',
									),
									array(
										'id'		=> 'rewrite_rules',
										'type'		=> 'accordion',
										'title'		=> __( 'List', 'system-dashboard' ),
										'subtitle'	=> __( 'URL Structure <br />&#10132; Query Parameters', 'system-dashboard' ),
										'class'		=> 'rewrite-rules',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'rewrite-rules' ), // AJAX loading via sd_rewrite_rules()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'View', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'rewrite_rules' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'rewrite_rules' ),
									),

								),
							),

							array(
								'title'		=> __( 'Shortcodes', 'system-dashboard' ),
								'fields'	=> array(

									array(
										'type'		=> 'content',
										'title'		=> __( 'Total', 'system-dashboard' ),
										'content'	=> $this->sd_shortcodes_count() . ' shortcodes',
									),
									array(
										'id'		=> 'shortcodes',
										'type'		=> 'accordion',
										'title'		=> __( 'List', 'system-dashboard' ),
										'class'		=> 'shortcodes',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'shortcodes' ), // AJAX loading via sd_shortcodes()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'View', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'shortcodes' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'shortcodes' ),
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
								'title'		=> __( 'Hooks', 'system-dashboard' ),
								'fields'	=> array(
									array(
										'id'		=> 'hooks_wpcore',
										'type'		=> 'accordion',
										'title'		=> __( 'Core', 'system-dashboard' ) . ' (v6.0)',
										'subtitle'	=>__( 'Links to the WordPress <a href="https://developer.wordpress.org/reference/" target="_blank">Code Reference</a> for each hook.', 'system-dashboard' ),
										'class'		=> 'wpcore-hooks',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Action Hooks', 'system-dashboard' ),
												'class'		=> 'core-action-hooks',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'core-action-hooks' ), // AJAX loading via sd_wpcore_hooks()
													),													
												),
											),
											array(
												'title'		=> __( 'View Filter Hooks', 'system-dashboard' ),
												'class'		=> 'core-filter-hooks',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'core-filter-hooks' ), // AJAX loading via sd_wpcore_hooks()
													),													
												),
											),
											// array(
											// 	'title'		=> __( 'Hooks on this page', 'system-dashboard' ),
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
										'title'		=> __( 'Current Theme', 'system-dashboard' ),
										'subtitle'	=> __( 'To preview links, ensure that <a href="/wp-admin/theme-editor.php" target="_blank">Theme File Editor</a> is not disabled.', 'system-dashboard' ),
										'class'		=> 'sd__hooks theme-hooks',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Hooks', 'system-dashboard' ),
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
										'title'		=> __( 'Active Plugins', 'system-dashboard' ),
										'subtitle'	=> __( 'To preview links, ensure that <a href="/wp-admin/plugin-editor.php" target="_blank">Plugin File Editor</a> is not disabled.', 'system-dashboard' ),
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
										'title'		=> __( 'View', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'hooks' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'hooks' ),
									),

								),
							),

							array(
								'title'		=> __( 'Classes', 'system-dashboard' ),
								'fields'	=> array(
									array(
										'id'		=> 'classes_core',
										'type'		=> 'accordion',
										'title'		=> __( 'Core', 'system-dashboard' ),
										'subtitle'		=> __( 'Links to the WordPress <a href="https://developer.wordpress.org/reference/" target="_blank">Code Reference</a> for each class.', 'system-dashboard' ),
										'class'		=> 'core-classes',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Classes and Methods', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'core-classes' ), // AJAX loading via sd_classes()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'classes_themes',
										'type'		=> 'accordion',
										'title'		=> __( 'Current Theme', 'system-dashboard' ),
										'subtitle'	=> __( 'To preview links, ensure that <a href="/wp-admin/theme-editor.php" target="_blank">Theme File Editor</a> is not disabled.', 'system-dashboard' ),
										'class'		=> 'theme-classes',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Classes and Methods', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'theme-classes' ), // AJAX loading via sd_classes()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'classes_plugins',
										'type'		=> 'accordion',
										'title'		=> __( 'Active Plugins', 'system-dashboard' ),
										'subtitle'	=> __( 'To preview links, ensure that <a href="/wp-admin/plugin-editor.php" target="_blank">Plugin File Editor</a> is not disabled.', 'system-dashboard' ),
										'class'		=> 'plugins-classes',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Classes and Methods', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'plugins-classes' ), // AJAX loading via sd_classes()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'View', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'classes' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'classes' ),
									),

								),
							),

							array(
								'title'		=> __( 'Functions', 'system-dashboard' ),
								'fields'	=> array(
									array(
										'id'		=> 'functions_core',
										'type'		=> 'accordion',
										'title'		=> __( 'Core', 'system-dashboard' ),
										'subtitle'		=> __( 'Links to the WordPress <a href="https://developer.wordpress.org/reference/" target="_blank">Code Reference</a> for each function.', 'system-dashboard' ),
										'class'		=> 'core-functions',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Functions', 'system-dashboard' )  . ' (' . $this->sd_functions( 'core-count' ) . ')',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'core-functions' ), // AJAX loading via sd_functions()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'functions_themes',
										'type'		=> 'accordion',
										'title'		=> __( 'Current Theme', 'system-dashboard' ),
										'subtitle'	=> __( 'To preview links, ensure that <a href="/wp-admin/theme-editor.php" target="_blank">Theme File Editor</a> is not disabled.', 'system-dashboard' ),
										'class'		=> 'theme-functions',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Functions', 'system-dashboard' )  . ' (' . $this->sd_functions( 'theme-count' ) . ')',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'theme-functions' ), // AJAX loading via sd_functions()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'functions_plugins',
										'type'		=> 'accordion',
										'title'		=> __( 'Active Plugins', 'system-dashboard' ),
										'subtitle'	=> __( 'To preview links, ensure that <a href="/wp-admin/plugin-editor.php" target="_blank">Plugin File Editor</a> is not disabled.', 'system-dashboard' ),
										'class'		=> 'plugins-functions',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Functions', 'system-dashboard' )  . ' (' . $this->sd_functions( 'plugins-count' ) . ')',
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_html( 'ajax-receiver', 'plugins-functions' ), // AJAX loading via sd_functions()
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'View', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'classes' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'classes' ),
									),

								),
							),

							array(
								'title'		=> __( 'Globals', 'system-dashboard' ),
								'fields'	=> array(

									array(
										'id'			=> 'version_globals',
										'type'			=> 'accordion',
										'title'			=> __( 'Version', 'system-dashboard' ),
										'accordions'  	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Common', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'On Themes & Plugins', 'system-dashboard' ),
										'accordions'  	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Various', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Admin', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Current User', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Main Query', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Multisite', 'system-dashboard' ),
										'accordions'	=> array(
										  array(
										    'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Locales & Localization', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'REST API', 'system-dashboard' ),
										'accordions'	=> array(
										  array(
										    'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Browser Detection', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Web Server Detection', 'system-dashboard' ),
										'accordions'  => array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Posts Loop', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Comments Loop', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'Front-End', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'From Themes & Plugins', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'			=> __( 'PHP Super Globals', 'system-dashboard' ),
										'accordions'	=> array(
											array(
												'title'   => __( 'View', 'system-dashboard' ),
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
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'globals' ),
									),

								),
							),

							array(
								'title'		=> __( 'Constants', 'system-dashboard' ),
								'fields'	=> array(
									array(
										'id'		=> 'defined_constants',
										'type'		=> 'accordion',
										'title'		=> __( 'Defined Constants', 'system-dashboard' ),
										'class'		=> 'constant-values',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
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
										'title'		=> __( 'Constants Documentation', 'system-dashboard' ),
										'class'		=> 'constant-docs',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
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
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'constants' ),
									),

								),
							),

							array(
								'title' => __( 'Viewer', 'system-dashboard' ),
								'fields' => array(

									array(
										'id'		=> 'viewer_wpconfig',
										'type'		=> 'accordion',
										'title'		=> 'wp-config.php',
										'subtitle'	=> __( 'WordPress main configuration file', 'system-dashboard' ),
										'class'		=> 'sd-viewer wpconfig',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_wpconfig_file_info() . $this->sd_html( 'ajax-receiver', 'wpconfig' ), // AJAX loading via sd_viewer()
													),													
												),
											),
										),
									),
									array(
										'id'		=> 'viewer_htaccess',
										'type'		=> 'accordion',
										'title'		=> '.htaccess',
										'subtitle'	=> __( 'Apache server configuration only for the directory the file is in', 'system-dashboard' ),
										'class'		=> 'htaccess',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
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
										'title'		=> __( 'WordPress <a href="/wp-json/wp/v2" target="_blank">REST API</a>', 'system-dashboard' ),
										'subtitle'	=> __( 'An interface for applications to interact with WordPress', 'system-dashboard' ),
										'class'		=> 'restapi_viewer',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
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
										'subtitle'	=> __( 'Tell search engine crawlers which URLs they can access on your site', 'system-dashboard' ),
										'class'		=> 'robotstxt',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
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
										'title'		=> __( 'Sitemap', 'system-dashboard' ),
										'subtitle'	=> __( 'Contains information for search engines to crawl your site more efficiently', 'system-dashboard' ),
										'content'	=> '<a href="/wp-sitemap.xml" target="_blank">' . __( 'Access now', 'system-dashboard' ) . ' &raquo;</a>',
									),
									array(
										'id'		=> 'viewer_urls_paths',
										'type'		=> 'accordion',
										'title'		=> __( 'URLs and Paths', 'system-dashboard' ),
										'subtitle'	=> __( 'From WP core functions and constants, as well as PHP $_SERVER superglobal', 'system-dashboard' ),
										'class'		=> 'urls-paths',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														'content'	=> $this->sd_urls_paths(),
													),													
												),
											),
										),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Recent Posts Feed', 'system-dashboard' ),
										'subtitle'	=> 'RSS 2.0',
										'class'		=> 'posts-feed',
										'content'	=> '<a href="/feed/" target="_blank">' . __( 'Access now', 'system-dashboard' ) . ' &raquo;</a>',
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Recent Comments Feed', 'system-dashboard' ),
										'subtitle'	=> 'RSS 2.0',
										'class'		=> 'comments-feed',
										'content'	=> '<a href="/comments/feed/" target="_blank">' . __( 'Access now', 'system-dashboard' ) . ' &raquo;</a>',
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'View', 'system-dashboard' ),
										'content'	=> $this->sd_tools( 'viewer' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'References', 'system-dashboard' ),
										'content'	=> $this->sd_references( 'viewer' ),
									),

								),
							), // End of Viewer module

							array(
								'title' => __( 'Logs', 'system-dashboard' ),
								'fields' => array(

									array(
										'id'		=> 'logs_page_access',
										'type'		=> 'accordion',
										'title'		=> '<input type="checkbox" id="page-access-log-checkbox" class="inset-3 page-access-log-checkbox"><label for="page-access-log-checkbox" class="green page-access-log-switcher"></label>' . __( 'Page Access', 'system-dashboard' ),
										'subtitle'	=> '',
										'class'		=> 'has-switcher page-access-log',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Log Entries', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														// 'content'	=> $this->sd_page_access_log_status() . $this->sd_page_access_log(),
														'content'	=> $this->sd_page_access_log_status() . $this->sd_html( 'ajax-receiver', 'page-access-log' ), // AJAX loading via sd_page_access_log()
													),													
												),
											),
										),
									),

									array(
										'id'		=> 'logs_errors',
										'type'		=> 'accordion',
										'title'		=> '<input type="checkbox" id="errors-log-checkbox" class="inset-3 errors-log-checkbox"><label for="errors-log-checkbox" class="green errors-log-switcher"></label>' . __( 'PHP Errors', 'system-dashboard' ),
										'subtitle'	=> '',
										'class'		=> 'has-switcher errors-log',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Log Entries', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														// 'content'	=> $this->sd_errors_log_status() . '<br />' . $this->sd_wpconfig_file_info() . '<br />' . $this->sd_debuglog_file_info() . '<br />' . $this->sd_errors_log(),
														'content'	=> $this->sd_errors_log_status() . $this->sd_html( 'ajax-receiver', 'errors-log' ) . $this->sd_debuglog_file_info(), // AJAX loading via sd_errors_log()
													),													
												),
											),
										),
									),

									array(
										'id'		=> 'email_delivery',
										'type'		=> 'accordion',
										'title'		=> '<input type="checkbox" id="email-delivery-log-checkbox" class="inset-3 email-delivery-log-checkbox"><label for="email-delivery-log-checkbox" class="green email-delivery-log-switcher"></label>' . __( 'Email Delivery', 'system-dashboard' ),
										'subtitle'	=> '',
										'class'		=> 'has-switcher email-delivery-log',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View Log Entries', 'system-dashboard' ),
												'fields'	=> array(
													array(
														'type'		=> 'content',
														// 'content'	=> $this->sd_email_delivery_log_status() . $this->sd_email_delivery_log(),
														'content'	=> $this->sd_email_delivery_log_status() . $this->sd_html( 'ajax-receiver', 'email-delivery-log' ), // AJAX loading via sd_email_delivery_log()
													),													
												),
											),
										),
									),

								),
							), // End of Logs module

						),
					),

					array(
						'id'		=> 'server',
						'type'		=> 'tabbed',
						'title' 	=> __( 'Server', 'system-dashboard' ),
						'class'		=> 'main-section',
						'subtitle'	=> $this->sd_server_overview(),
						'tabs'		=> array(

							array(
								'title' => __( 'Monitor', 'system-dashboard' ),
								'fields' => array(
									array(
										'type'		=> 'content',
										'title'		=> __( 'Uptime', 'system-dashboard' ),
										'content'	=> $this->sd_server_uptime(),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'CPU Load Average', 'system-dashboard' ),
										'subtitle'	=> '% of system total (raw)<br />at '. date( 'H:i:s', time() ),
										'content'	=> $this->sd_cpu_load_average(),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'RAM Usage', 'system-dashboard' ),
										'subtitle'	=> 'at '. date( 'H:i:s', time() ),
										'content'	=> $this->sd_ram_usage(),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Disk Usage', 'system-dashboard' ),
										'content'	=> $this->sd_disk_usage(),
									),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> __( 'Web Server', 'system-dashboard' ),
									// 	'content'	=> $_SERVER['SERVER_SOFTWARE'],
									// ),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> __( 'Web Server Interface', 'system-dashboard' ),
									// 	'content'	=> php_sapi_name(),
									// ),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> __( 'Database Engine', 'system-dashboard' ),
									// 	'content'	=> $this->sd_get_mysql_version(),
									// ),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> __( 'Timezone', 'system-dashboard' ),
									// 	'content'	=> date_default_timezone_get(),
									// ),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> __( 'Server Time', 'system-dashboard' ),
									// 	'content'	=> date( 'F j, Y - H:i', time() ),
									// ),
									// array(
									// 	'type'		=> 'content',
									// 	'title'		=> __( 'Server IP', 'system-dashboard' ),
									// 	'content'	=> $_SERVER['SERVER_ADDR'],
									// ),

								),
							),

							array(
								'title' => __( 'Hardware', 'system-dashboard' ),
								'fields' => array(

									array(
										'type'		=> 'content',
										'title'		=> __( 'CPU type', 'system-dashboard' ),
										'content'	=> $this->sd_cpu_type(),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'CPU / Cores', 'system-dashboard' ),
										'content'	=> $this->sd_cpus_cores_count(),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Total RAM', 'system-dashboard' ),
										'content'	=> $this->sd_total_ram_display(),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Total Disk Space', 'system-dashboard' ),
										'content'	=> $this->sd_total_disk_space( 'formatted' ),
									),

								),
							),

							array(
								'title' => 'PHP',
								'fields' => array(
									array(
										'type'		=> 'content',
										'title'		=> __( 'Version', 'system-dashboard' ),
										'content'	=> phpversion(),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'User', 'system-dashboard' ),
										'content'	=> ( function_exists('get_current_user') ? get_current_user() : 'Undetectable' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Max Execution Time', 'system-dashboard' ),
										'content'	=> ini_get( 'max_execution_time' ). ' seconds',
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Max Input Time', 'system-dashboard' ),
										'content'	=> ini_get( 'max_input_time' ). ' seconds',
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Max Input Vars', 'system-dashboard' ),
										'content'	=> ini_get( 'max_input_vars' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Memory Limit', 'system-dashboard' ),
										'content'	=> ini_get( 'memory_limit' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Post Max Size', 'system-dashboard' ),
										'content'	=> ini_get( 'post_max_size' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Upload Max Size', 'system-dashboard' ),
										'content'	=> ini_get( 'upload_max_filesize' ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Extensions Loaded', 'system-dashboard' ),
										'content'	=> implode(", ", get_loaded_extensions() ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Disabled Functions', 'system-dashboard' ),
										'content'	=> str_replace( ",", ", ", ini_get( 'disable_functions' ) ),
									),
									array(
										'type'		=> 'content',
										'title'		=> __( 'Error Reporting', 'system-dashboard' ),
										'subtitle'	=> 'Code: ' . error_reporting(),
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
										'title'		=> __( 'Detailed Specifications', 'system-dashboard' ),
										'content'	=> '',
									),
									array(
										'id'		=> 'phpinfo_details',
										'type'		=> 'accordion',
										'title'		=> '',
										'class'		=> 'phpinfo-details title-hidden',
										'accordions'	=> array(
											array(
												'title'		=> __( 'View', 'system-dashboard' ),
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
	 * Replace WP version number text in footer
	 * 
	 * @since 2.8.5
	 */
	public function footer_version_text() {
        return __( 'Also by Bowo &#8594; <a href="https://bowo.io/wpn-dlm" target="_blank">WordPress Newsboard</a>: The latest from 100+ sources', 'system-dashboard' );		
	}

	/**
	 * Add 'Dashboard' plugin action link.
	 *
	 * @since    1.0.0
	 */
	
	public function sd_add_plugin_action_links( $links ) {

		$settings_link = '<a href="index.php?page='.$this->plugin_name.'">' . __( 'View Dashboard', 'system-dashboard' ) . '</a>';

		array_unshift($links, $settings_link); 

		return $links; 

	}

	/**
	 * Add additional links in plugin meta row.
	 *
	 * @since    1.0.0
	 */

	/**
	 * To stop other plugins' admin notices overlaying in the Variable Inspector UI, remove them.
	 *
	 * @hooked admin_notices
	 *
	 * @since 2.8.4
	 */
	public function sd_suppress_admin_notices() {

		global $plugin_page;

		if ( 'system-dashboard' === $plugin_page ) {
			remove_all_actions( 'admin_notices' );
		}

	}	

	public function sd_add_plugin_meta_links( $plugin_meta, $plugin_file ) {

		if ( strpos( $plugin_file, 'system-dashboard.php' ) !== false ) {

			$new_links = array(
				'donate'	=> '<a href="https://paypal.me/qriouslad" target="_blank">' . __( 'Donate', 'system-dashboard' ) . '</a>',
			);

			$plugin_meta = array_merge( $plugin_meta, $new_links );

		}

		return $plugin_meta;

	}

	/**
	 * Remove CodeStar framework welcome / ads page
	 *
	 * @since 1.0.0
	 */
	public function sd_remove_codestar_submenu() {

		remove_submenu_page( 'tools.php', 'csf-welcome' );

	}

}
