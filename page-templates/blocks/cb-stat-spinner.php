<?php
/**
 * Block template for CB Stat Spinner.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

if ( ! have_rows( 'stats' ) ) {
    return;
}

$background = get_field( 'background' );

$text = ( 'red-400' === $background || 'primary-400' === $background ) ? 'text--white' : 'text--dark';

$background = 'has-' . $background . '-background-color';

?>
<section class="stat_spinner">      
    <div class="container <?= esc_attr( trim( "$background $text" ) ); ?> p-5">
        <div class="stat_spinner__content">
            <?php
            $index = 0; // Counter to create unique IDs for each stat.
            while ( have_rows( 'stats' ) ) {
                the_row();
                $stat       = get_sub_field( 'stat' );
                $prefix     = get_sub_field( 'prefix' );
                $suffix     = get_sub_field( 'suffix' );
                $stat_title = get_sub_field( 'stat_title' );
                ?>
                <div class="stat_spinner__item">
                    <div class="stat_spinner__stat">
                        <?php if ( $prefix ) : ?>
                            <span class="prefix"><?= esc_html( $prefix ); ?></span>
                        <?php endif; ?>
                        <span class="number" id="stat-<?= esc_attr( $index ); ?>" data-target="<?= esc_attr( $stat ); ?>">0</span>
                        <?php if ( $suffix ) : ?>
                            <span class="suffix"><?= esc_html( $suffix ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="stat_spinner__text">
                        <span><?= esc_html( $stat_title ); ?></span>
                    </div>
                </div>
                <?php
                ++$index;
            }
            ?>
        </div>
    </div>
</section>
<script type="module">
    import { CountUp } from 'https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.6.2/countUp.min.js';

    document.addEventListener('DOMContentLoaded', function () {
        const numbers = document.querySelectorAll('.number');

        numbers.forEach((number) => {
            const targetValue = parseFloat(number.getAttribute('data-target'));
            const decimalPlaces = (targetValue.toString().split('.')[1] || '').length;
            const countUp = new CountUp(number.id, targetValue, {
                duration: 2,
                useEasing: true,
                decimalPlaces: decimalPlaces,
                enableScrollSpy: true
            });

            if (!countUp.error) {
                countUp.start();
            } else {
                console.error(countUp.error);
            }
        });
    });
</script>