<?php
/**
 * PhpUnit bootstrap file
 *
 * @package Wpb
 * @subpackage Unit_Test
 */

// Load the composer autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

// Call the bootstrap method of WP Mock.
\WP_Mock::bootstrap();

// Include plugin files.
require_once __DIR__ . '/../wp-plugin-boilerplate.php';
