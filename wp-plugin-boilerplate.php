<?php
/**
 * The main plugin file.
 *
 * @package Wp_Plugin_Boilerplate
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

namespace Wpb;

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
		load_plugin_textdomain( 'wpb-text', false, dirname( $this->basename ) . '/languages' );

		// Enque scripts and style.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'enqueue_scripts', array( $this, 'enqueue_scripts' ) );

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
