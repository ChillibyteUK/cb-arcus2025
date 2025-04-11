<?php
/**
 * Template Part: Size Distribution of Equity Positions
 *
 * This template part generates a table displaying the size distribution
 * of equity positions based on market capitalization and percentage of NAV.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

$positions_id = get_field( 'position_data' );

if ( empty( $positions_id ) ) {
    error_log( 'Position data file attachment ID is empty or unavailable.' );
    return;
}

$file_path = get_attached_file( $positions_id );

if ( ! file_exists( $file_path ) ) {
    error_log( 'Position data file does not exist at the specified path: ' . $file_path );
    return;
}

// Check file encoding for BOM and clean it if needed.
$contents = file_get_contents( $file_path );
$contents = preg_replace( '/^\xEF\xBB\xBF/', '', $contents ); // Remove UTF-8 BOM.
file_put_contents( $file_path, $contents ); // Overwrite clean file.

$fp = fopen( $file_path, 'r' );
if ( false === $fp ) {
    error_log( 'Failed to open position data file.' );
    return;
}

$headers = fgetcsv( $fp );
if ( false === $headers ) {
    error_log( 'Failed to read headers. Check CSV format.' );
    fclose( $fp );
    return;
}

$_rows = array();

while ( ( $row = fgetcsv( $fp ) ) !== false ) {
    if ( count( $row ) !== count( $headers ) ) {
        error_log( 'Header/row column mismatch: ' . print_r( $row, true ) );
        continue;
    }
    $_rows[] = array_combine( $headers, $row );
}

fclose( $fp );

$over10 = array_filter(
	$_rows,
	function ( $row ) {
		return '> 10' === $row['Market Cap band'];
	}
);

$between5and10 = array_filter(
	$_rows,
	function ( $row ) {
	    return '5 ─ 10' === $row['Market Cap band'];
	}
);

$between1and5 = array_filter(
	$_rows,
	function ( $row ) {
    	return '1 ─ 5' === $row['Market Cap band'];
	}
);

$under1 = array_filter(
	$_rows,
	function ( $row ) {
    	return '< 1' === $row['Market Cap band'];
	}
);

/**
 * Reduce function to calculate the sum of '% of NAV' values.
 *
 * @param float $carry The accumulated value.
 * @param array $item  The current row of data.
 * @return float The updated accumulated value.
 */
function nav_reduce( $carry, $item ) {
    $carry += $item['% of NAV'];
    return $carry;
}

/**
 * Calculate the percentage of NAV for a given array of data.
 *
 * @param array $nav_array The array containing NAV data.
 * @return string The formatted percentage of NAV.
 */
function percent_of_nav( $nav_array ) {
    return number_format( array_reduce( $nav_array, 'nav_reduce' ) * 100, 1 ) . '%';
}

?>
<h3>Size distribution of equity positions</h3>
<div class="performance-data-wrapper">
	<table class="table table-striped table-sm performance-data">
		<thead>
			<tr>
				<th scope="col">Market Capitalisation (USD Billion)</th>
				<th scope="col">Number of holdings</th>
				<th scope="col">% of NAV</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th scope="row">> 10</th>
				<td><?= esc_html( count( $over10 ) ); ?>&nbsp;</td>
				<td><?= esc_html( percent_of_nav( $over10 ) ); ?>&nbsp;</td>
			</tr>
			<tr>
				<th scope="row">5 - 10</th>
				<td><?= esc_html( count( $between5and10 ) ); ?>&nbsp;</td>
				<td><?= esc_html( percent_of_nav( $between5and10 ) ); ?>&nbsp;</td>
			</tr>
			<tr>
				<th scope="row">1 - 5</th>
				<td><?= esc_html( count( $between1and5 ) ); ?>&nbsp;</td>
				<td><?= esc_html( percent_of_nav( $between1and5 ) ); ?>&nbsp;</td>
			</tr>
			<tr>
				<th scope="row">
					< 1</th>
				<td><?= esc_html( count( $under1 ) ); ?>&nbsp;</td>
				<td><?= esc_html( percent_of_nav( $under1 ) ); ?>&nbsp;</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th scope="row">TOTAL</th>
				<td><?= esc_html( count( $_rows ) ); ?>&nbsp;</td>
				<td><?= esc_html( percent_of_nav( $_rows ) ); ?>&nbsp;</td>
			</tr>
		</tfoot>
	</table>
</div>