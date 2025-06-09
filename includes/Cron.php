<?php

namespace FCI;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * FoldClick Insights Cron Class
 *
 * This class handles the scheduled tasks for the FoldClick Insights plugin.
 *
 * @package FoldClickInsights
 */
class Cron {
	/**
	 * Constructor to initialize the cron job.
	 *
	 * This constructor sets up a daily scheduled event to clean up old data
	 * from the database.
	 */
	public function __construct() {
		add_action( 'fci_daily_cleanup', array( $this, 'delete_old_data' ) );

		if ( ! wp_next_scheduled( 'fci_daily_cleanup' ) ) {
			wp_schedule_event( time(), 'daily', 'fci_daily_cleanup' );
		}
	}

	/**
	 * Deletes old data from the database.
	 *
	 * This function deletes records older than 7 days from the FCI_DATABASE_TABLE.
	 * It is scheduled to run daily.
	 *
	 * @return void
	 */
	public function delete_old_data() {
		global $wpdb;
		$fci_table_name = $wpdb->prefix . FCI_DATABASE_TABLE;
		$seven_days_ago = gmdate( 'Y-m-d H:i:s', strtotime( '-7 days' ) );

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.DirectDatabaseQuery.DirectQuery
		$wpdb->query(
			$wpdb->prepare(
				'DELETE FROM `' . esc_sql( $fci_table_name ) . '` WHERE created_at < %s',
				$seven_days_ago
			)
		);
	}
}
