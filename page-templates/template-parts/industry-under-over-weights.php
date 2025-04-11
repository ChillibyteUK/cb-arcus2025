<?php
/**
 * Template Part: Industry Under and Over Weights
 *
 * This template processes and displays the top 5 industry overweights and underweights
 * based on relative exposure data from a CSV file.
 *
 * @package cb-arcus2025
 */

$weighting_data_id = get_field( 'weighting_data' );

if ( empty( $weighting_data_id ) ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'Weighting data file attachment ID is empty or unavailable.' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
    }
    return;
}

$file_path = get_attached_file( $weighting_data_id );

if ( ! file_exists( $file_path ) ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'Weighting data file does not exist at the specified path: ' . $file_path ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
    }
    return;
}

// Check file encoding for BOM and clean it if needed.
$contents = file_get_contents( $file_path );
$contents = preg_replace( '/^\xEF\xBB\xBF/', '', $contents ); // Remove UTF-8 BOM.
file_put_contents( $file_path, $contents ); // Overwrite clean file.

$fp = fopen( $file_path, 'r' );
if ( false === $fp ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'Failed to open weighting data file.' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
    }
    return;
}

$headers = fgetcsv( $fp );
if ( false === $headers ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( 'Failed to read headers. Check CSV format.' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
    }
    fclose( $fp );
    return;
}

$_rows = array();

while ( ( $row = fgetcsv( $fp ) ) !== false ) {
    if ( count( $row ) !== count( $headers ) ) {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            error_log( 'Header/row column mismatch: ' . print_r( $row, true ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions
        }
        continue;
    }
    $_rows[] = array_combine( $headers, $row );
}

fclose( $fp );

usort(
	$_rows,
	function ( $a, $b ) {
        return $b['Difference %'] === $a['Difference %']
            ? $a['Industry Group'] <=> $b['Industry Group']
            : floatval( $b['Difference %'] ) <=> floatval( $a['Difference %'] );
	}
);
?>
<div class="row g-5 pb-5">
    <div class="col-12 col-lg-6">
        <div class="performance-data-wrapper">
            <table class="table table-striped table-sm performance-data">
                <thead>
                    <tr>
                        <td class="fw-bold">Top 5 Industry Overweights</td>
                        <th class="text-end" scope="col">Relative Exposure</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					foreach ( array_slice( $_rows, 0, 5 ) as $row ) {
						?>
                        <tr>
                            <th scope="row"><?= esc_html( $row['Industry Group'] ); ?>%</th>
                            <td class="text-end"><?= esc_html( round( $row['Difference %'], 1 ) ); ?>%</td>
                        </tr>
                    	<?php
					}
					?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="performance-data-wrapper">
            <table class="table table-striped table-sm performance-data">
                <thead>
                    <tr>
                        <td class="fw-bold">Top 5 Industry Underweights</td>
                        <th class="text-end" scope="col">Relative Exposure</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					foreach ( array_reverse( array_slice( $_rows, -5 ) ) as $row ) {
						?>
                        <tr>
                            <th scope="row"><?= esc_html( $row['Industry Group'] ); ?></th>
                            <td class="text-end"><?= esc_html( round( $row['Difference %'], 1 ) ); ?>%</td>
                        </tr>
                    	<?php
					}
					?>
                </tbody>
            </table>
        </div>
    </div>
</div>