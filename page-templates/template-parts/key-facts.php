<?php

defined( 'ABSPATH' ) || exit;

global $footnotes; // Use the global $footnotes object.

if ( ! class_exists( 'Footnotes' ) ) {
	error_log( 'Footnotes class not found. Ensure it is included before this template.' );
	return;
}

$key_facts = get_field( 'key_facts' );
$managerial_positions = get_field( 'managerial_positions' );
$facts = get_field( 'facts' );
?>
<div id="key-facts">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <?php
				if ( ! empty( $managerial_positions ) ) {
                    foreach ( $managerial_positions as $position ) {
	                	?>
                        <p>
                            <span class="fs-500"><?= esc_html( $position['position'] ); ?>: <?= esc_html( $position['name'] ); ?></span>
                            <?php
                            if ( ! empty( $position['disclaimer'] ) ) {
                                $footnote = $footnotes->add_footnote( 'footnote', $position['disclaimer'] );
                                echo wp_kses_post( $footnotes->link_to_footnote( $footnote ) );
                            }
                            ?>
                            <?php
							if ( ! empty( $position['rating'] ) ) {
								?>
                                <br>
								<img class="citywire-rating" src="<?= esc_url( get_stylesheet_directory_uri() . '/img/citywire-' . $position['rating'] . '.jpg' ); ?>" alt="Citywire Rating <?= esc_attr( $position['rating'] ); ?>" />
                            	<?php
							}
							?>
                        </p>
                	<?php
					}
                }
				?>
            </div>
            <div class="col-12 col-lg-6">
                <dl class="fs-500">
                    <?php
					foreach ( $facts as $fact ) {
						?>
                        <dt>
                            <?= esc_html( $fact['title'] ); ?>
                            <?php
                            if ( $fact['disclaimer'] ) {
                                $footnote = $footnotes->add_footnote( 'footnote', $fact['disclaimer'] );
                                echo wp_kses_post( $footnotes->link_to_footnote( $footnote ) );
                            }
                            ?>
                        </dt>
                        <dd><?= $fact['description']; ?></dd>
                    	<?php
					}
					?>
                </dl>
            </div>
        </div>
    </div>
</div>