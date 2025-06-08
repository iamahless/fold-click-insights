<?php
/**
 * PHPUnit bootstrap file.
 *
 * @package Fold_Click_Insights
 */

$fci_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $fci_tests_dir ) {
	$fci_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

// Forward custom PHPUnit Polyfills configuration to PHPUnit bootstrap file.
$fci_phpunit_polyfills_path = getenv( 'FCI_TESTS_PHPUNIT_POLYFILLS_PATH' );
if ( false !== $fci_phpunit_polyfills_path ) {
	define( 'FCI_TESTS_PHPUNIT_POLYFILLS_PATH', $fci_phpunit_polyfills_path );
}

if ( ! file_exists( "{$fci_tests_dir}/includes/functions.php" ) ) {
	echo "Could not find {$fci_tests_dir}/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once "{$fci_tests_dir}/includes/functions.php";

/**
 * Manually load the plugin being tested.
 */
function fci_manually_load_plugin() {
	require dirname( __DIR__ ) . '/fold-click-insights.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require "{$fci_tests_dir}/includes/bootstrap.php";
