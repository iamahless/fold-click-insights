<?php
/**
 * Plugin Name:     FoldClick Insights
 * Plugin URI:      https://github.com/iamahless/fold-click-insights
 * Description:     A plugin to provide insights on fold clicks.
 * Author:          Alexander Garuba
 * Author URI:      https://github.com/iamahless
 * Text Domain:     fold-click-insights
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         fci
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FCI_DATABASE_TABLE', 'fci_link_tracking' );

/**
 * PSR-4 Autoloader.
 *
 * Dynamically loads classes as they are needed.
 *
 * @param string $class_name The fully-qualified class name.
 */
spl_autoload_register(
	function ( $class_name ) {
		$prefix   = 'FCI\\';
		$base_dir = __DIR__ . '/includes/';

		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class_name, $len ) !== 0 ) {
			return;
		}

		$relative_class = substr( $class_name, $len );
		$file           = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

/**
 * The main function to run the plugin.
 */
function fci_run_foldclick_insights() {
	register_activation_hook( __FILE__, array( 'FCI\Activator', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'FCI\Deactivator', 'deactivate' ) );

	$rest_api = new FCI\RestApi();
	$rest_api->register_routes();

	new FCI\AdminMenu();
	new FCI\Cron();

	add_action( 'wp_enqueue_scripts', 'fci_enqueue_scripts' );
}

/**
 * Enqueues the tracking script on the front page.
 */
function fci_enqueue_scripts() {
	if ( is_front_page() ) {
		wp_enqueue_script(
			'fci-tracker',
			plugin_dir_url( __FILE__ ) . 'assets/js/tracker.js',
			array(),
			'1.0.0',
			true
		);

		wp_localize_script(
			'fci-tracker',
			'fci_data',
			array(
				'rest_url' => esc_url_raw( rest_url( 'foldclick-insights/v1/track' ) ),
				'nonce'    => wp_create_nonce( 'wp_rest' ),
			)
		);
	}
}

fci_run_foldclick_insights();
