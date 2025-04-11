<?php
/**
 * Template Part: Historical Performance
 *
 * This file processes and displays historical performance data for the Arcus Japan Fund.
 * It reads data from a CSV file, formats it, and outputs it in a table format.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

$performance_history_id            = get_field( 'performance_data' );
$historical_performance_disclaimer = get_field( 'historical_performance_disclaimer' );

if ( empty( $performance_history_id ) ) {
    error_log( 'Performance history file attachment ID is empty or unavailable.' );
    return;
}

$file_path = get_attached_file( $performance_history_id );

if ( ! file_exists( $file_path ) ) {
    error_log( 'Performance history file does not exist at the specified path: ' . $file_path );
    return;
}

// Check file encoding for BOM and clean it if needed.
$contents = file_get_contents( $file_path );
$contents = preg_replace( '/^\xEF\xBB\xBF/', '', $contents ); // Remove UTF-8 BOM.
file_put_contents( $file_path, $contents ); // Overwrite clean file.

$fp = fopen( $file_path, 'r' );
if ( false === $fp ) {
    error_log( 'Failed to open performance history file.' );
    return;
}

$headers = fgetcsv( $fp );
if ( false === $headers ) {
    error_log( 'Failed to read headers. Check CSV format.' );
    fclose( $fp );
    return;
}

$__rows = array();
$_years = array();

while ( ( $row = fgetcsv( $fp ) ) !== false ) {
    array_push( $__rows, array_combine( $headers, $row ) );
}

fclose( $fp );

$_rows = array_filter(
    $__rows,
    function ( $row ) {
        return '-' !== $row['Rel Inst Return (Y) (3)'] && '' !== $row['Rel Inst Return (Y) (3)'];
    }
);

$row_count = count( $_rows );
for ( $i = 0; $i < $row_count; $i++ ) {
    $date = DateTime::createFromFormat( 'M-y d', $_rows[ $i ]['Month'] . ' 1' );
    if ( ! $date ) {
        error_log( 'Invalid date format in row: ' . print_r( $_rows[ $i ], true ) );
        continue; // Skip rows with invalid dates.
    }

    $_rows[ $i ]['timestamp'] = floatval( $date->format( 'U' ) );
    $current_year = $date->format( 'Y' );
    $month = $date->format( 'n' );
    if ( ! isset( $_years[ $current_year ] ) ) {
        $_years[ $current_year ] = array();
    }
    $_years[ $current_year ][ $month ] = &$_rows[ $i ];
}

/**
 * Formats a numeric string into a formatted number with one decimal place.
 *
 * @param string $num_string The numeric string to format.
 * @return string The formatted number or an empty string if input is invalid.
 */
function format_num( $num_string ) {
    return ( ! $num_string || '-' === $num_string ) ? '' : number_format( floatval( $num_string ), 1 );
}

/**
 * Calculates the percentage change for a given year based on historical data.
 *
 * @param int    $current_year      The year for which the percentage is calculated.
 * @param array  $data              The historical performance data grouped by year.
 * @param string $field             The field name to calculate the percentage for.
 * @param float  $initial_start_val The initial value to use if no prior year data exists.
 * @return string The formatted percentage change for the year.
 */
function percentage_year( $current_year, $data, $field, $initial_start_val ) {
    if ( ! isset( $data[ $current_year ] ) || ! is_array( $data[ $current_year ] ) ) {
        error_log( "Missing or invalid data for year: $current_year" );
        return ''; // Return an empty string or a default value.
    }

    $end_of_period = null;
    $end_search    = $data[ $current_year ];
    ksort( $end_search );

    foreach ( array_reverse( $end_search ) as $d ) {
        if ( null !== $d ) {
            $end_of_period = $d;
            break;
        }
    }

    $start_of_period = isset( $data[ $current_year - 1 ] ) ? $data[ $current_year - 1 ]['12'] : null;

    return number_format( ( to_float( $end_of_period[ $field ] ) / to_float( $start_of_period[ $field ] ?? $initial_start_val ) - 1 ) * 100, 1 );
}
?>
<div class="py-5">
    <h3>Historical Performance Data<br>(Arcus Japan Fund - A ACC Unhedged JPY; values in %)</h3>
    <div class="performance-data-wrapper">
        <table class="table table-striped table-sm performance-data historical table-layout-fixed">
            <thead>
                <tr>
                    <td class="font-weight-bold">&nbsp;</td>
                    <?php
                    for ( $month = 1; $month <= 12; $month++ ) {
                        ?>
                        <th scope="col" class="text-end"><?= esc_html( date_format( date_create( "{$year}-{$month}-1" ), 'M' ) ); ?>&nbsp;</th>
                        <?php
                    }
                    ?>
                    <th scope="col" class="text-end">AJF</th>
                    <th scope="col" class="text-end">TOPIX<br />TR</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ( $_years as $current_year => $months ) {
                    ?>
                    <tr>
                        <th scope="row"><?= esc_html( $current_year ); ?>&nbsp;</th>
                        <?php
                        for ( $month = 1; $month <= 12; $month++ ) {
                            ?>
                        <td class="text-end"><?= esc_html( format_num( $months[ $month ]['Rel Inst Return (Y) (3)'] ?? null ) ); ?>&nbsp;</td>
                            <?php
                        }
                        ?>
                        <td class="text-end"><?= esc_html( percentage_year( $current_year, $_years, 'Rel Inst NAV (Y) (3)', 10000 ) ); ?>&nbsp;</td>
                        <td class="text-end"><?= esc_html( percentage_year( $current_year, $_years, 'TOPIX DV', 1800.47 ) ); ?>&nbsp;</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
if ( ! empty( $historical_performance_disclaimer ) ) {
    ?>
<div class="fs-300">
    <?= wp_kses_post( $historical_performance_disclaimer ); ?>
</div>
    <?php
}