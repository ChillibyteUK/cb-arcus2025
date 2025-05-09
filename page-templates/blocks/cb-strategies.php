<?php
/**
 * Block Name: CB Strategies
 *
 * This is the template that displays the CB Strategies block.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_block_region_applicable() ) {
    return;
}

if ( have_rows( 'strategies' ) ) {
	?>
<section class="strategies">
	<div class="container has-primary-400-background-color text--white p-4">
		<?php
		if ( get_field( 'title' ) ) {
			?>
			<h2 class="mb-5"><?= esc_html( get_field( 'title' ) ); ?></h2>
			<?php
		}
		?>
		<div class="accordion" id="cbStrategiesAccordion">
			<?php
			$index = 0;
			while ( have_rows( 'strategies' ) ) {
				the_row();
				$strategy_name  = get_sub_field( 'strategy_name' );
				$description    = get_sub_field( 'description' );
				$contacts       = get_sub_field( 'contacts' );
				$fund_link      = get_sub_field( 'fund_link' );
				$factsheet_link = get_sub_field( 'request_email' );
				++$index;
				?>
				<div class="accordion-item">
					<h3 class="accordion-header" id="heading<?= esc_attr( $index ); ?>">
						<button
							class="accordion-button <?= esc_attr( $index > 1 ? 'collapsed' : '' ); ?>"
							type="button"
							data-bs-toggle="collapse"
							data-bs-target="#collapse<?= esc_attr( $index ); ?>"
							aria-expanded="<?= esc_attr( 1 === $index ? 'true' : 'false' ); ?>"
							aria-controls="collapse<?= esc_attr( $index ); ?>">
							<?= esc_html( $strategy_name ); ?>
						</button>
					</h3>
					<div 
						id="collapse<?= esc_attr( $index ); ?>" 
						class="accordion-collapse collapse <?= esc_attr( 1 === $index ? 'show' : '' ); ?>"
						aria-labelledby="heading<?= esc_attr( $index ); ?>"
						data-bs-parent="#cbStrategiesAccordion">
						<div class="accordion-body">
							<?php
							if ( $contacts ) {
								?>
								<div class="strategies-contact">
									<?php
									foreach ( $contacts as $contact ) {
										?>
									<div class="strategies-contact__card">
										<div class="fw-bold"><?= esc_html( $contact['contact_role'] ); ?></div>
										<div><?= esc_html( $contact['contact_name'] ); ?></div>
										<?php
										if ( ! empty( $contact['rating'] ) ) {
											?>
										<img class="citywire-rating" src="<?= esc_url( get_stylesheet_directory_uri() . '/img/citywire-' . $contact['rating'] . '.jpg' ); ?>" alt="Citywire Rating <?= esc_attr( $contact['rating'] ); ?>" />
											<?php
										}
										?>
									</div>
										<?php
									}
									?>
								</div>
								<?php
							}
							?>
							<div><?= wp_kses_post( $description ); ?></div>
							<?php
							if ( $fund_link ) {
								?>
								<p><a href="<?= esc_url( $fund_link['url'] ); ?>" class="button">View Performance</a></p>
								<?php
							} elseif ( $factsheet_link ) {
								?>
								<p><a href="<?= esc_url( 'mailto:' . antispambot( $factsheet_link ) ); ?>" class="button">Request Factsheet</a></p>
								<?php
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
	<?php
}