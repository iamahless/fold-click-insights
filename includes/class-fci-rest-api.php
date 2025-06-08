<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * FoldClick Insights REST API Class
 *
 * This class handles the REST API endpoints for the FoldClick Insights plugin.
 *
 * @package FoldClickInsights
 */
class FCI_Rest_Api {
	/**
	 * Register the REST API routes for the plugin.
	 *
	 * @return void
	 */
	public function add_api_routes() {
		register_rest_route(
			'foldclick-insights/v1',
			'track',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'track_visit' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Callback function to handle the tracking of visits.
	 *
	 * @param WP_REST_Request $request The REST request object.
	 * @return WP_REST_Response The response object.
	 */
	public function track_visit( WP_REST_Request $request ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'fci_link_tracking';

		$headers = $request->get_headers();
		$params  = $request->get_json_params();

		$nonce = $headers['x_wp_nonce'][0];

		if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			return new WP_REST_Response( 'Message not sent', 422 );
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
		$wpdb->insert(
			$table_name,
			array(
				'screen_width'  => intval( $params['screenWidth'] ),
				'screen_height' => intval( $params['screenHeight'] ),
				'links'         => wp_json_encode( $params['visibleLinks'] ),
				'created_at'    => current_time( 'mysql' ),
			)
		);

		return new WP_REST_Response( array( 'success' => true ), 200 );
	}
}
