<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class FCI_Enqueue_Scripts
 *
 * This class is responsible for enqueuing scripts and styles for the FoldClick Insights plugin.
 */
class FCI_Enqueue_Scripts {
	/**
	 * Constructor to initialize the class.
	 */
	public function load_scripts() {
		if ( is_front_page() ) {
			wp_enqueue_script(
				'fci-tracker',
				FCI_PLUGIN_URL . 'assets/js/tracker.js',
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
}
