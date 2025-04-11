<?php
/**
 * Template part for displaying the Share Class table.
 *
 * @package cb-arcus2025
 */

$share_class = get_field( 'share_class_table' );

if ( ! empty( $share_class ) ) {
    $disclaimer = get_field( 'share_class_disclaimer' );
	?>
<div class="container bg--white p-5">
	<h2>Share Class</h2>
	<div class="performance-data-wrapper pb-5">
		<table class="table table-striped table-sm performance-data share-class-table">
			<thead>
				<tr>
					<th scope="col">Share Class</th>
					<th scope="col">Currency</th>
					<th scope="col">Type</th>
					<th scope="col">Hedging</th>
					<th scope="col">ISIN Code</th>
					<th scope="col">Minimum initial investment</th>
					<th scope="col">Current Management&nbsp;fee&nbsp;%</th>
					<th scope="col">Performance fee&nbsp;%</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( $share_class as $row ) {
					?>
					<tr <?= ! empty( $row['minimum_initial_investment_fee_%'] ) ? ' class="split"' : ''; ?>>
						<td><?= esc_html( $row['share_class'] ); ?>&nbsp;</td>
						<td><?= esc_html( $row['currency'] ); ?>&nbsp;</td>
						<td><?= esc_html( $row['type'] ); ?>&nbsp;</td>
						<td><?= esc_html( $row['hedging'] ); ?>&nbsp;</td>
						<td><?= esc_html( $row['isin_code'] ); ?>&nbsp;</td>
						<td><?= esc_html( $row['minimum_initial_investment_fee_%'] ); ?>&nbsp;</td>
						<td><?= esc_html( $row['current_management'] ); ?>&nbsp;</td>
						<td><?= esc_html( $row['performance_fee_%'] ); ?>&nbsp;</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<?php
	if ( ! empty( $disclaimer ) ) {
		?>
	<div class="fs-300">
		<?= wp_kses_post( $disclaimer ); ?>
	</div>
		<?php
	}
	?>
</div>
	<?php
}