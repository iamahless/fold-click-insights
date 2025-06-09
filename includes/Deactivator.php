<?php

namespace FCI;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FoldClick Insights Deactivator Class
 *
 * This class handles the deactivation of the FoldClick Insights plugin,
 * including clearing scheduled hooks.
 *
 * @package FoldClickInsights
 */
class Deactivator {
	/**
	 * Deactivate the plugin and clear scheduled hooks.
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook( 'fci_daily_cleanup' );
	}
}
