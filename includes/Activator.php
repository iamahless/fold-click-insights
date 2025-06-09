<?php

namespace FCI;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FoldClick Insights Activator Class
 *
 * This class handles the activation of the FoldClick Insights plugin,
 * including the creation of the necessary database table.
 *
 * @package FoldClickInsights
 */
class Activator {
	/**
	 * Activate the plugin and create the necessary database table.
	 */
	public static function activate() {
		global $wpdb;

		$fci_table_name  = $wpdb->prefix . FCI_DATABASE_TABLE;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $fci_table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            screen_width smallint(5) NOT NULL,
            screen_height smallint(5) NOT NULL,
            links longtext NOT NULL,
			created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( $sql );
	}
}
