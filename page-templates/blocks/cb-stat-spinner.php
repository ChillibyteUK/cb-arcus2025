<?php
/**
 * Block template for CB Stat Spinner.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_block_region_applicable() ) {
    return;
}

if ( ! have_rows( 'stats' ) ) {
    return;
}

global $footnotes;

$background = get_field( 'background' );

$text = ( 'red-400' === $background || 'primary-400' === $background ) ? 'text--white' : 'text--dark';

$background = 'has-' . $background . '-background-color';

?>
<section class="stat_spinner">      
    <div class="container <?= esc_attr( trim( "$background $text" ) ); ?> p-5">
        <div class="stat_spinner__content pb-3">
            <?php
            $index = 0; // Counter to create unique IDs for each stat.
            while ( have_rows( 'stats' ) ) {
                the_row();
                $stat       = get_sub_field( 'stat' );
                $prefix     = get_sub_field( 'prefix' );
                $suffix     = get_sub_field( 'suffix' );
                $stat_title = get_sub_field( 'stat_title' );
                $footnote   = get_sub_field( 'footnote' );
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
                        <?php
                        if ( $footnote ) {
                            $stat_title .= '[FOOTNOTE]' . $footnote . '[/FOOTNOTE]';
                            $content     = $footnotes->extract_footnote( 'footnote', $stat_title );
                            echo '<span>' . wp_kses_post( $content['content'] ) . '</span>';
                        } else {
                            echo '<span>' . wp_kses_post( $stat_title ) . '</span>';
                        }
                        ?>
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