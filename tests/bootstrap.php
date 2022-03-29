<?php
/**
 * PhpUnit bootstrap file
 *
 * @package Wp_Plugin_Boilerplate
 * @subpackage Unit_Test
 */

// Load the autoload file.
require_once __DIR__ . '/../vendor/autoload.php';

// Call the bootstrap method of WP Mock.
\WP_Mock::bootstrap();

// Include plugin files.
require_once __DIR__ . '/../wp-plugin-boilerplate.php';
