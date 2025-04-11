<?php
/**
 * Performance Chart Template
 *
 * This template generates a performance chart and table
 * for displaying financial data using Highcharts.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

$performance_chart_disclaimer = get_field( 'performance_chart_disclaimer' );
$performance_history_id       = get_field( 'performance_data' );

if ( empty( $performance_history_id ) ) {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( 'Performance history file attachment ID is empty or unavailable.' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
	}
	return;
}

$file_path = get_attached_file( $performance_history_id );

if ( ! file_exists( $file_path ) ) {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		error_log( 'Performance history file does not exist at the specified path: ' . $file_path ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
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
		error_log( 'Failed to open performance history file.' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
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


$filtered = array_filter(
	$_rows,
	function ( $row ) {
    	return '' !== $row['TOPIX TR Index'] && '0' !== $row['Rel Inst Index (Y) (3)'];
	}
);

$ajf_data   = array();
$topix_data = array();

foreach ( $filtered as $row ) {
  	$date = DateTime::createFromFormat( 'M-y', $row['Month'] )->format( 'Y-m-t' );

  	array_push( $ajf_data, array( $date, floatval( $row['Rel Inst Index (Y) (3)'] ) ) );
  	array_push( $topix_data, array( $date, floatval( $row['TOPIX TR Index'] ) ) );
}

// Sort the data arrays by date.
usort(
	$ajf_data,
	function ( $a, $b ) {
    	return strtotime( $a[0] ) <=> strtotime( $b[0] );
	}
);

usort(
	$topix_data,
	function ( $a, $b ) {
	    return strtotime( $a[0] ) <=> strtotime( $b[0] );
	}
);

/**
 * Converts a string to a float, removing any commas.
 *
 * @param string $num_string The input string to convert.
 * @return float The converted float value.
 */
function to_float( $num_string ) {
	return floatval( str_replace( ',', '', $num_string ) );
}

/**
 * Calculates the percentage change between two values.
 *
 * @param string $now  The current value as a string.
 * @param string $then The previous value as a string.
 * @return string The percentage change formatted as a number with one decimal place.
 */
function x_to_date( $now, $then ) {
    return number_format( ( to_float( $now ) / to_float( $then ) - 1 ) * 100, 1 );
}

/**
 * Converts a month-year string to a formatted month-year string.
 *
 * @param string $mon_string The input string in 'M-y' format.
 * @return string The formatted string in 'M y' format.
 */
function to_month_year( $mon_string ) {
	return DateTime::createFromFormat( 'M-y', $mon_string )->format( 'M y' );
}

/**
 * Finds the first row of a specific month from the given rows.
 *
 * @param array $rows  The array of rows containing date information.
 * @param int   $month The month to search for (1-12).
 * @return array|null  The first row of the specified month, or null if not found.
 */
function find_first_row_of_month( array $rows, int $month ) {
  	$found     = null;
  	$prev_year = DateTime::createFromFormat( 'M-y', $rows[0]['Month'] )->modify( '-1 year' )->format( 'y' );
  	foreach ( $rows as $row ) {
    	$row_month = DateTime::createFromFormat( 'M-y', $row['Month'] )->format( 'n' );
    	$row_year  = DateTime::createFromFormat( 'M-y', $row['Month'] )->format( 'y' );
		if ( ( $month ) === (int) $row_month ) {
      		if ( (int) $row_year === (int) $prev_year ) {
        		$found = $row;
        		break;
      		}
    	}
  	}

  	return $found;
}



?>
<div class="mb-5">
	<div id="performance-chart"></div>
</div>
<div class="mb-5">
	<div class="table-responsive">
		<table class="table table-striped table-sm performance-data">
			<thead>
				<tr>
					<th>Performance</th>
					<th class="text-end" scope="col"><?= esc_html( to_month_year( $_rows[0]['Month'] ) ); ?></th>
					<th class="text-end" scope="col">YTD</th>
					<th class="text-end" scope="col">1 Year</th>
					<th class="text-end" scope="col">3 Year</th>
					<th class="text-end" scope="col">5 Year</th>
					<th class="text-end" scope="col">Since Launch</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th scope="row">Arcus Japan Fund - A ACC Unhedged JPY</th>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['Rel Inst NAV (Y) (3)'], $_rows[1]['Rel Inst NAV (Y) (3)'] ) ); ?>%</td>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['Rel Inst NAV (Y) (3)'], find_first_row_of_month( $_rows, 12 )['Rel Inst NAV (Y) (3)'] ) ); ?>%</td>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['Rel Inst NAV (Y) (3)'], $_rows[12]['Rel Inst NAV (Y) (3)'] ) ); ?>%</td>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['Rel Inst NAV (Y) (3)'], $_rows[36]['Rel Inst NAV (Y) (3)'] ) ); ?>%</td>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['Rel Inst NAV (Y) (3)'], $_rows[60]['Rel Inst NAV (Y) (3)'] ) ); ?>%</td>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['Rel Inst NAV (Y) (3)'], '10000' ) ); ?>%</td>
				</tr>
				<tr>
					<th scope="row">TOPIX TR</th>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['TOPIX DV'], $_rows[1]['TOPIX DV'] ) ); ?>%</td>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['TOPIX DV'], find_first_row_of_month( $_rows, 12 )['TOPIX DV'] ) ); ?>%</td>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['TOPIX DV'], $_rows[12]['TOPIX DV'] ) ); ?>%</td>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['TOPIX DV'], $_rows[36]['TOPIX DV'] ) ); ?>%</td>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['TOPIX DV'], $_rows[60]['TOPIX DV'] ) ); ?>%</td>
					<td class="text-end"><?= esc_html( x_to_date( $_rows[0]['TOPIX DV'], '1800.47' ) ); ?>%</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
if ( have_rows( 'annualised_performance_data' ) ) {
	?>
<div class="mb-5">
	<div class="table-responsive">
		<table class="table table-striped table-sm performance-data">
			<thead>
				<tr>
					<th>Annualised Performance</th>
					<th class="text-end" scope="col">1 Year</th>
					<th class="text-end" scope="col">3 Year</th>
					<th class="text-end" scope="col">5 Year</th>
					<th class="text-end" scope="col">Since Launch</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ( have_rows( 'annualised_performance_data' ) ) {
					the_row();
					?>
				<tr>
					<th scope="row"><?= esc_html( get_sub_field( 'metric' ) ); ?></th>
					<td class="text-end"><?= esc_html( get_sub_field( '1_year' ) ); ?>%</td>
					<td class="text-end"><?= esc_html( get_sub_field( '3_year' ) ); ?>%</td>
					<td class="text-end"><?= esc_html( get_sub_field( '5_year' ) ); ?>%</td>
					<td class="text-end"><?= esc_html( get_sub_field( 'since_launch' ) ); ?>%</td>
				</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>
	<?php
}

if ( ! empty( $performance_chart_disclaimer ) ) {
	?>
	<div class="fs-300">
		<?= wp_kses_post( $performance_chart_disclaimer ); ?>
	</div>
	<?php
}

add_action(
	'wp_footer',
	function () use ( $ajf_data, $topix_data ) {
		?>
<script>
	const ajf = <?= wp_json_encode( $ajf_data ); ?>;
	const topix = <?= wp_json_encode( $topix_data ); ?>;

	// Convert date strings to Date objects
	ajf.forEach(function(point) {
    	const d = point[0].split('-');
    	point[0] = Date.UTC(d[0], d[1] - 1, d[2]);
  	});
  	topix.forEach(function(point) {
    	const d = point[0].split('-');
    	point[0] = Date.UTC(d[0], d[1] - 1, d[2]);
  	});

  	Highcharts.chart(
		'performance-chart',
		{
			chart: {
				type: 'line'
			},
			title: null,
			legend: {
				layout: 'vertical',
				align: 'left',
				verticalAlign: 'top',
				floating: true,
				x: 50,
				y: 5
			},
			credits: {
				enabled: false
			},
			xAxis: {
				type: 'datetime',
				dateTimeLabelFormats: {
					month: '%b %Y'
				}
			},
			yAxis: {
				title: {
					text: "Return",
					align: "middle",
					position3d: "flap",
				},
			},
			tooltip: {
				shared: true,
				xDateFormat: '%b %Y'
			},
			series: [
				{
					name: 'Arcus Japan Fund',
					color: "#1a2642",
					lineWidth: 2,
					data: ajf
				},
				{
					name: 'TOPIX TR',
					color: "#cb2928",
					lineWidth: 2,
					data: topix
				}
			]
		}
	);
</script>
		<?php
	},
	9999
);
