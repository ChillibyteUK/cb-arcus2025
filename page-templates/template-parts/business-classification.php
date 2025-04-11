<?php
/**
 * Template part for displaying the business classification pie charts.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

$chart = get_field( 'pie_chart' );

if ( ! empty( $chart ) ) :

    $disclaimer = get_field( 'position_disclaimer' );

    $fund  = array();
    $topix = array();

    foreach ( $chart as $row ) {
        array_push(
			$fund,
			array(
	            'name' => $row['industry'],
    	        'y'    => floatval( $row['fund_percentage'] ),
			)
		);
        array_push(
			$topix,
			array(
				'name' => $row['industry'],
				'y'    => floatval( $row['topix_percentage'] ),
			)
		);
    }
	?>
    <div class="row my-4">
        <div class="col-12 mb-2">
            <h3>Sector Classifications</h3>
        </div>
        <div class="col-12 col-lg-6">
            <h4 class="text-center mb-0">Fund %</h4>
            <div id="business-classification-fund"></div>
        </div>
        <div class="col-12 col-lg-6">
            <h4 class="text-center mb-0">TOPIX %</h4>
            <div id="business-classification-topix"></div>
        </div>

        <?php
		if ( ! empty( $disclaimer ) ) {
			?>
            <div class="col-12 fs-300">
                <?= wp_kses_post( $disclaimer ); ?>
            </div>
        	<?php
		}
		?>
    </div>

    <script>
        function createChart(id, data, color) {
            const colors = new Array(12).fill(1).map((c, i, a) => {
                return Highcharts.color(color)
                    .brighten(i / a.length * 0.8)
                    .get();
            });

            Highcharts.chart(id, {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    size: '100%',
                },
                title: null,
                credits: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '{point.percentage:.1f}%'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: false,
                        colors,
                        dataLabels: {
                            enabled: false,
                        },
                        shadow: false,
                        showInLegend: true
                    }
                },
                legend: {
                    align: 'right',
                    verticalAlign: 'middle',
                    layout: 'vertical',
                    symbolRadius: 2,
                    symbolWidth: 8,
                    symbolHeight: 8,
                    labelFormatter: function() {
                        return this.name + ': ' + this.y + '%';
                    }
                },
                series: [{
                    name: 'TOPIX % Business Clarification',
                    colorByPoint: true,
                    size: '80%',
                    innerSize: '70%',
                    data
                }],
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                align: 'center',
                                verticalAlign: 'bottom',
                                layout: 'vertical',
                            }
                        }
                    }],
                }
            });
        }
        createChart("business-classification-fund", <?= wp_json_encode( $fund ); ?>, "#535770");
        createChart('business-classification-topix', <?= wp_json_encode( $topix ); ?>, "#5f5e5e");
    </script>

<?php endif; ?>