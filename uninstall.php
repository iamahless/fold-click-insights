<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

global $wpdb;
$fci_table_name = $wpdb->prefix . FCI_DATABASE_TABLE;
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.DirectDatabaseQuery.DirectQuery
$wpdb->query( 'DROP TABLE IF EXISTS `' . esc_sql( $fci_table_name ) . '`' );
