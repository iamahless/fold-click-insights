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
	 * This function deletes records older than 7 days from the 'foldclick_insights' table.
	 * It is scheduled to run daily.
	 *
	 * @return void
	 */
	public function delete_old_data() {
		global $wpdb;
		$table_name     = $wpdb->prefix . 'foldclick_insights';
		$seven_days_ago = date( 'Y-m-d H:i:s', strtotime( '-7 days' ) );

		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $table_name WHERE visit_time < %s",
				$seven_days_ago
			)
		);
	}
}
