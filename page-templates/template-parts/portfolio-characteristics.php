<?php
/**
 * Portfolio Characteristics Template Part
 *
 * This file is used to display the portfolio characteristics in a table format.
 * It retrieves data using the `get_field` function and displays it dynamically.
 *
 * @package  cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

global $footnotes; // Use the global $footnotes object.

if ( ! class_exists( 'Footnotes' ) ) {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( 'Footnotes class not found. Ensure it is included before this template.' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	}
	return;
}

$characteristics = get_field( 'portfolio_characteristics' );
?>
<h3>Porfolio Characteristics</h3>
<div class="table-responsive">
	<table class="table table-striped table-sm performance-data">
		<thead>
			<tr>
				<td class="fw-bold">Characteristics</td>
				<td>&nbsp;</td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ( $characteristics as $characteristic ) {
				?>
				<tr>
					<th scope="row">
						<?= esc_html( $characteristic['title'] ); ?>
						<?php
						if ( ! empty( $characteristic['disclaimer'] ) ) {
							$footnote = $footnotes->add_footnote( 'footnote', $characteristic['disclaimer'] );
							echo wp_kses_post( $footnotes->link_to_footnote( $footnote ) );
						}
						?>
					</th>
					<td class="text-end"><?= esc_html( $characteristic['value'] ); ?>&nbsp;</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>