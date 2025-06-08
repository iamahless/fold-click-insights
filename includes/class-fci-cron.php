<?php

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
class FCI_Cron {
	/**
	 * Deletes old data from the database.
	 *
	 * This function deletes records older than 7 days from the 'fci_link_tracking' table.
	 * It is scheduled to run daily.
	 *
	 * @return void
	 */
	public function delete_old_data() {
		global $wpdb;
		$table_name     = $wpdb->prefix . 'fci_link_tracking';
		$seven_days_ago = gmdate( 'Y-m-d H:i:s', strtotime( '-7 days' ) );

        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $table_name WHERE created_at < %s",
				$seven_days_ago
			)
		);
	}
}
