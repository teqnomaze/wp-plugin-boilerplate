<?php
/**
 * The unit test class file.
 *
 * @package Wp_Plugin_Boilerplate
 */

namespace Wpb\Tests;

use \Wpb\Wp_Plugin_Boilerplate;

/**
 * Test class for the core plugin class.
 */
class Test_Wp_Plugin_Boilerplate extends \WP_Mock\Tools\TestCase {

	/**
	 * Setup all parent.
	 *
	 * @return void
	 */
	public function setUp() {
		\WP_Mock::setUp();
	}

	/**
	 * Teardown all parent.
	 *
	 * @return void
	 */
	public function tearDown() {
		\WP_Mock::tearDown();
	}

	/**
	 * Test instance method.
	 *
	 * @return void
	 */
	public function test_instance() {
		$this->assertInstanceOf( Wp_Plugin_Boilerplate::class, Wp_Plugin_Boilerplate::instance() );
	}

	/**
	 * Test load_self method.
	 *
	 * @return void
	 */
	public function test_load_self() {

		$instance = Wp_Plugin_Boilerplate::instance();

		\WP_Mock::passthruFunction( 'load_plugin_textdomain' )->once();

		\WP_Mock::userFunction( 'plugin_basename' )
			->once()
			->with( \WP_Mock\Functions::type( 'string' ) )
			->andReturn( 'basename' );

		\WP_Mock::userFunction( 'plugin_dir_url' )
			->once()
			->with( \WP_Mock\Functions::type( 'string' ) )
			->andReturn( 'baseurl' );

		\WP_Mock::userFunction( 'get_file_data' )
			->once()
			->with(
				\WP_Mock\Functions::type( 'string' ),
				array(
					'name'    => 'Plugin Name',
					'version' => 'Version',
				)
			)
			->andReturn(
				array(
					'name'    => 'Plugin Name',
					'version' => '1.0.0',
				)
			);

		$this->assertInstanceOf( Wp_Plugin_Boilerplate::class, $instance->load_self() );
		$this->assertEquals( 'basename', $instance->get_basename() );
		$this->assertEquals( 'baseurl', $instance->get_baseurl() );
		$this->assertEquals( '1.0.0', $instance->get_version() );
	}
}
