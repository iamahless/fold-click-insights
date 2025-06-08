<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FoldClick Insights Admin Menu Class
 *
 * This class handles the admin menu for the FoldClick Insights plugin.
 *
 * @package FoldClickInsights
 */
class FCI_Admin_Menu {
	/**
	 * Add the admin page to the WordPress admin menu.
	 *
	 * @return void
	 */
	public function add_admin_page() {
		add_menu_page(
			'FoldClick Insights',
			'FoldClick Insights',
			'manage_options',
			'fci',
			array( $this, 'render_admin_page' ),
			'dashicons-chart-line',
			20
		);
	}

	/**
	 * Render the admin page content.
	 *
	 * This function retrieves the data from the database and displays it in a table format.
	 *
	 * @return void
	 */
	public function render_admin_page() {
		$cache_key = 'fci_homepage_visits_data';
		$results   = wp_cache_get( $cache_key, 'fci' );

		if ( false === $results ) {
			global $wpdb;
			$fci_table_name = $wpdb->prefix . FCI_DATABASE_TABLE;

            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$results = $wpdb->get_results( "SELECT * FROM $fci_table_name ORDER BY created_at DESC" );

			wp_cache_set( $cache_key, $results, 'fci', HOUR_IN_SECONDS );
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'FoldClick Insights - Homepage Visits (Last 7 Days)', 'fci' ); ?></h1>
			<table class="widefat fixed" cellspacing="0">
				<thead>
					<tr>
						<th id="columnname" class="manage-column column-columnname" scope="col"><?php esc_html_e( 'Visit Time', 'fci' ); ?></th>
						<th id="columnname" class="manage-column column-columnname" scope="col"><?php esc_html_e( 'Screen Size', 'fci' ); ?></th>
						<th id="columnname" class="manage-column column-columnname" scope="col"><?php esc_html_e( 'Visible Hyperlinks', 'fci' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( ! empty( $results ) ) : ?>
						<?php foreach ( $results as $row ) : ?>
							<tr>
								<td><?php echo esc_html( $row->created_at ); ?></td>
								<td><?php echo esc_html( $row->screen_width . 'x' . $row->screen_height ); ?></td>
								<td>
									<ul>
										<?php
										$links = json_decode( $row->links );
										if ( is_array( $links ) ) {
											foreach ( $links as $link ) {
												echo '<li>' . esc_url( $link ) . '</li>';
											}
										}
										?>
									</ul>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="3"><?php esc_htmlesc_html_e( 'No data to display.', 'fci' ); ?></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<?php
	}
}