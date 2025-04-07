<?php
/**
 * Template part for displaying a two-column people block.
 *
 * @package cb-arcus2025
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="two_col_people">
    <div class="container">
        <div class="row g-5">
            <?php
			$people = get_field( 'people' );
			if ( ! empty( $people ) && is_array( $people ) ) {
	            foreach ( get_field( 'people' ) as $p ) {
    	            $office_terms = get_the_terms( $p, 'office' );

        	        if ( ! empty( $office_terms ) && ! is_wp_error( $office_terms ) ) {
            	        $offices = wp_list_pluck( $office_terms, 'name' );
                	}
                	$offices = ! empty( $offices ) ? '(' . implode( ', ', $offices ) . ')' : null;
                	?>
            <div class="col-md-6 colperson">
                	<?= get_the_post_thumbnail( $p, 'large', array( 'class' => 'colperson__image' ) ); ?>
                <div class="colperson__name"><?= esc_html( get_the_title( $p ) ); ?></div>
                <div class="colperson__role"><?= esc_html( trim( get_field( 'role', $p ) . ' ' . $offices ) ); ?></div>
                <div class="colperson__bio"><?= wp_kses_post( get_the_content( null, false, $p ) ); ?></div>
            </div>
                	<?php
				}
            }
            ?>
        </div>
    </div>
</section>