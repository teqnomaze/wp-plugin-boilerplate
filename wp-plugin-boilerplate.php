<?php
/**
 * The main plugin file.
 *
 * @package Wpb
 *
 * @wordpress-plugin
 * Plugin Name:         WP Plugin Bolierplate
 * Plugin URI:          https://github.com/teqnomaze/wp-plugin-boilerplate
 * Description:         A template for kick-starting the development of a standards-compliant WordPress plugin.
 * Version:             1.0.0
 * Author:              Musthafa SM <musthafasm@gmail.com>
 * Author URI:          https://musthafasm.github.io
 * License:             MIT
 * License URI:         https://opensource.org/licenses/MIT
 * Text Domain:         wpb-text
 * Domain Path:         /languages
 * Requires PHP:        7.3
 * Requires at least:   5.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The main plugin class.
 *
 * @since 1.0.0
 */
final class Wp_Plugin_Boilerplate {

	/**
	 * Instance for the class.
	 *
	 * @var self|null $instance
	 */
	private static $instance = null;

	/**
	 * The plugin basename.
	 *
	 * @var string|null $basename
	 */
	private $basename = null;

	/**
	 * The plugin base url.
	 *
	 * @var string|null $baseurl
	 */
	private $baseurl = null;

	/**
	 * The plugin version.
	 *
	 * @var string|null $version
	 */
	private $version = null;

	/**
	 * If an instance exists, returns it. If not, creates one and retuns it.
	 *
	 * @return self
	 */
	public static function instance(): self {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * The autoloader based on namespace.
	 *
	 * @param string $class_name The class name.
	 * @return void
	 */
	public static function autoload( string $class_name ): void {

		if ( false === strpos( $class_name, 'Wpb' ) ) {
			return;
		}

		$file_path = explode( '\\', $class_name );
		$file_name = '';

		if ( isset( $file_path[ count( $file_path ) - 1 ] ) ) {

			$file_name = strtolower(
				$file_path[ count( $file_path ) - 1 ]
			);

			$file_name       = str_ireplace( '_', '-', $file_name );
			$file_name_parts = explode( '-', $file_name );
			$file_name_index = array_search( 'interface', $file_name_parts, true );

			if ( false !== $file_name_index ) {
				unset( $file_name_parts[ $file_name_index ] );
				$file_name = implode( '-', $file_name_parts );
				$file_name = "interface-{$file_name}.php";
			} else {
				$file_name = "class-$file_name.php";
			}
		}

		$fully_qualified_path = rtrim( dirname( __FILE__ ), '/\\' ) . '/includes/';
		$file_path_count      = count( $file_path );

		for ( $i = 1; $i < $file_path_count - 1; $i++ ) {
			$dir                   = strtolower( $file_path[ $i ] );
			$fully_qualified_path .= rtrim( $dir, '/\\' ) . '/includes/';
		}

		$fully_qualified_path .= $file_name;

		if ( stream_resolve_include_path( $fully_qualified_path ) ) {
			include_once $fully_qualified_path;
		}
	}

	/**
	 * Get the basename.
	 *
	 * @return string|null
	 */
	public function get_basename(): ?string {
		return $this->basename;
	}

	/**
	 * Get the base url.
	 *
	 * @return string|null
	 */
	public function get_baseurl(): ?string {
		return $this->baseurl;
	}

	/**
	 * Get the version.
	 *
	 * @return string|null
	 */
	public function get_version(): ?string {
		return $this->version;
	}

	/**
	 * Initialise the plugin features.
	 *
	 * @return self
	 */
	public function load_self(): self {

		// Load the autoloader.
		spl_autoload_register( array( $this, 'autoload' ) );

		// Set the private properties.
		$plugin_data = get_file_data(
			__FILE__,
			array(
				'name'    => 'Plugin Name',
				'version' => 'Version',
			)
		);

		$this->basename = plugin_basename( __FILE__ );
		$this->baseurl  = plugin_dir_url( __FILE__ );
		$this->version  = $plugin_data['version'];

		// Load textdomain for the plugin.
		load_plugin_textdomain( 'wpb-text', false, dirname( $this->get_basename() ) . '/languages' );

		// Enque scripts and style.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Initialise admin settings.
		( new \Wpb\Admin_Settings() )->init();

		return $this;
	}

	/**
	 * Enque admin scripts and style.
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts(): void {}

	/**
	 * Enque admin scripts and style.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {}

	/**
	 * Prresource initiate.
	 */
	private function __construct() {

		// Load the plugin when WordPress is ready.
		add_action( 'plugins_loaded', array( $this, 'load_self' ) );
	}

	/**
	 * Prresource cloning.
	 */
	private function __clone() {}
}

// Instantiate the plugin class.
Wp_Plugin_Boilerplate::instance();

