<?php
/**
 * Plugin Name:     FoldClick Insights
 * Plugin URI:      PLUGIN SITE HERE
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

define( 'FCI_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
/**
 * Load the required dependencies for the plugin.
 */
function fci_load_dependencies() {
	require_once FCI_PLUGIN_PATH . 'includes/class-fci-activator.php';

	require_once FCI_PLUGIN_PATH . 'includes/class-fci-deactivator.php';
}

/**
 * Initiate the hooks for the plugin.
 */
function fci_initiate_hooks() {
	register_activation_hook( __FILE__, array( 'FCI_Activator', 'activate' ) );

	register_deactivation_hook( __FILE__, array( 'FCI_Deactivator', 'deactivate' ) );
}

fci_load_dependencies();
fci_initiate_hooks();
