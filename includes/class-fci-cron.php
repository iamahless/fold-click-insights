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
