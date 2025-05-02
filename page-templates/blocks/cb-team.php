<?php
/**
 * Template for displaying all team members.
 * Excludes the leadership team.
 *
 * @package cb-arcus2025
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="team">
    <div class="container">
		<ul class="filters mb-2">
			<li class="filter-btn" data-filter="all">All Teams and Offices</li>
		</ul>
		<ul class="filters mb-2">
				<?php

				$excluded_team = get_term_by( 'slug', 'leadership', 'team' );

				$ttax = get_terms(
					array(
						'taxonomy'   => 'team',
						'hide_empty' => false,
						'exclude'    => array( $excluded_team->term_id ),
					)
				);

				if ( ! empty( $ttax ) && ! is_wp_error( $ttax ) ) {
    				foreach ( $ttax as $team ) {
        				echo '<li class="filter-btn" data-filter=".team-' . esc_attr( $team->slug ) . '">' . esc_html( $team->name ) . '</li>';
    				}
				}
				?>
			</ul>
			<ul class="filters mb-4">
				<?php
				$otax = get_terms(
					array(
						'taxonomy'   => 'office',
						'hide_empty' => false,
					)
				);

				if ( ! empty( $otax ) && ! is_wp_error( $otax ) ) {
					foreach ( $otax as $office ) {
						echo '<li class="filter-btn" data-filter=".office-' . esc_attr( $office->slug ) . '">' . esc_html( $office->name ) . '</li>';
					}
				}
				?>
			</ul>

		<?php
		$people = new WP_Query(
			array(
				'post_type'      => 'people',
				'posts_per_page' => -1,
				'tax_query'      => array(
					array(
						'taxonomy' => 'team',
						'field'    => 'term_id',
						'terms'    => $excluded_team ? $excluded_team->term_id : array(),
						'operator' => 'NOT IN', // Exclude posts with this term.
					),
				),
			)
		);
		?>
		<div class="row g-5 people-list">
    		<?php
    		while ( $people->have_posts() ) {
        		$people->the_post();

				$team_terms   = get_the_terms( get_the_ID(), 'team' );
				$office_terms = get_the_terms( get_the_ID(), 'office' );

				$team_classes = '';

				if ( ! empty( $team_terms ) && ! is_wp_error( $team_terms ) ) {
					foreach ( $team_terms as $team ) {
						$team_classes .= ' team-' . esc_attr( $team->slug );
					}
				}

		        $offices        = array();
        		$office_classes = '';

				if ( ! empty( $office_terms ) && ! is_wp_error( $office_terms ) ) {
            		foreach ( $office_terms as $office ) {
                		$office_classes .= ' office-' . esc_attr( $office->slug );
            		}
            		$offices = wp_list_pluck( $office_terms, 'name' );
        		}

        		$offices = ! empty( $offices ) ? '(' . implode( ', ', $offices ) . ')' : null;
        		?>
        	<div class="col-md-4 person<?= esc_attr( $team_classes . $office_classes ); ?>">
            	<?=
				has_post_thumbnail()
				? get_the_post_thumbnail(
					get_the_ID(),
					'large',
					array(
						'class' => 'person__image',
						'alt'   => get_the_title(),
					)
				)
                : '<img src="' . esc_url( get_stylesheet_directory_uri() . '/img/img-default.png' ) . '" class="person__image" alt="">';
	            ?>
				<div class="person__name"><?= esc_html( get_the_title() ); ?></div>
				<div class="person__role"><?= esc_html( trim( get_field( 'role', get_the_ID() ) . ' ' . $offices ) ); ?></div>
				<div class="person__bio"><?= wp_kses_post( get_the_content() ); ?></div>
			</div>
				<?php
    		}
    		wp_reset_postdata();
			?>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const filterButtons = document.querySelectorAll(".filter-btn");
    const people = document.querySelectorAll(".person");

    filterButtons.forEach(button => {
        button.addEventListener("click", function() {
            const filter = this.getAttribute("data-filter");

            filterButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            people.forEach(person => {
                if (filter === "all" || person.classList.contains(filter.substring(1))) {
                    person.style.display = "block";
                } else {
                    person.style.display = "none";
                }
            });
        });
    });

    document.querySelector('.filter-btn[data-filter="all"]').classList.add("active");
});
</script>