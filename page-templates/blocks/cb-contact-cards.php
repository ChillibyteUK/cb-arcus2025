<?php
/**
 * Template for displaying contact cards.
 *
 * @package cb-arcus2025
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="contact_cards">
    <div class="container-xl bg-white p-5">
        <div class="row justify-content-center">
            <?php
            while ( have_rows( 'cards' ) ) {
                the_row();
                ?>
            <div class="col-md-6">
                <div class="contact_cards__card">
                    <?=
					wp_get_attachment_image(
						get_sub_field( 'image' ),
						'medium',
						false,
						array(
							'class' => 'contact_cards__image',
							'alt'   => get_sub_field( 'name' ),
						)
					);
					?>
                    <div class="contact_cards__inner">
                        <div class="contact_cards__name"><?= esc_html( get_sub_field( 'name' ) ); ?></div>
                        <div class="contact_cards__role"><?= esc_html( get_sub_field( 'role' ) ); ?></div>
                        <div class="contact_cards__email">E: <a href="mailto:<?= esc_attr( antispambot( get_sub_field( 'email' ) ) ); ?>"><?= esc_html( get_sub_field( 'email' ) ); ?></a></div>
						<a href="mailto:<?= esc_attr( antispambot( get_sub_field( 'email' ) ) ); ?>" class="button">Contact</a>
                    </div>
                </div>
            </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>