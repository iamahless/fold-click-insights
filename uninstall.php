<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

global $wpdb;
$fci_table_name = $wpdb->prefix . 'fci_link_tracking';
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.SchemaChange,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.DirectDatabaseQuery.DirectQuery
$wpdb->query( 'DROP TABLE IF EXISTS `' . esc_sql( $fci_table_name ) . '`' );
