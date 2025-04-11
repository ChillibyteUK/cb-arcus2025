<?php
/**
 * Template Part: Top 10 Holdings
 *
 * This template part displays the top 10 holdings in a table format.
 * It reads data from a CSV file attached to the WordPress post.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

$positions_id = get_field( 'position_data' );

if ( empty( $positions_id ) ) {
    error_log( 'Positions file attachment ID is empty or unavailable.' );
    return;
}

$file_path = get_attached_file( $positions_id );

if ( ! file_exists( $file_path ) ) {
    error_log( 'Positions file does not exist at the specified path: ' . $file_path );
    return;
}

// Check file encoding for BOM and clean it if needed.
$contents = file_get_contents( $file_path );
$contents = preg_replace( '/^\xEF\xBB\xBF/', '', $contents ); // Remove UTF-8 BOM.
file_put_contents( $file_path, $contents ); // Overwrite clean file.

$fp = fopen( $file_path, 'r' );
if ( false === $fp ) {
    error_log( 'Failed to open positions file.' );
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

usort(
	$_rows,
	function ( $a, $b ) {
		$a = floatval( $a['% of NAV'] );
		$b = floatval( $b['% of NAV'] );
		if ( $a === $b ) {
			return 0;
		}
		return ( $a > $b ) ? -1 : 1;
	}
);
?>
<div class="pb-5">
    <h3>Top 10 Holdings</h3>
    <div class="performance-data-wrapper">
        <table class="table table-striped table-sm performance-data">
            <thead>
                <tr>
                    <td>&nbsp;</td>
                    <th scope="col">Name</th>
                    <th scope="col">Sector</th>
                    <th scope="col">% of NAV</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ( $i = 0; $i < 10; $i++ ) {
                    if ( ! isset( $_rows[ $i ] ) ) {
                        break; // Avoid errors if there are fewer than 10 rows.
                    }
                    ?>
                    <tr>
                        <td class="font-weight-bold"><?= esc_html( $i + 1 ); ?>&nbsp;</td>
                        <th scope="row"><?= esc_html( $_rows[ $i ]['Product Description'] ); ?>&nbsp;</th>
                        <td><?= esc_html( $_rows[ $i ]['BICS Industry name 1'] ); ?>&nbsp;</td>
                        <td><?= esc_html( number_format( $_rows[ $i ]['% of NAV'] * 100, 1 ) ); ?>%</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>