<?php
/**
 * Compliance Modal
 *
 * This file contains the code for displaying a compliance modal
 * to users based on their region and professional status.
 *
 * @package cb-arcus2025
 */

// Hook to start session.
add_action(
    'init',
    function () {
        if ( ! session_id() ) {
            session_start();
        }
    }
);

add_action(
    'wp_footer',
    function () {
        if ( defined('WP_ENV') && WP_ENV === 'development' ) {
            echo '<div class="container-xl"><hr><div class="fw-bold mb-2">DEBUG INFO</div>';
            echo '<pre>SESSION: ' . print_r($_SESSION, true) . '</pre>'; // phpcs:ignore
            echo '<button id="clear-session-button" class="btn btn-secondary">Clear Session & Reload</button>';
            echo '</div>';
        }
    }
);

/**
 * Enqueues the script to clear the session and reload the page.
 * This function also localizes the AJAX URL for the script.
 */
function enqueue_clear_session_script() {
    wp_enqueue_script(
        'clear-session-script',
        get_stylesheet_directory_uri() . '/js/clear-session.js',
        array( 'child-understrap-scripts' ),
        '1.0',
        true
    );

    // Localize AJAX URL.
    wp_localize_script(
        'clear-session-script',
        'ajax_object',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'enqueue_clear_session_script' );


/**
 * Enqueues the modal scripts and styles.
 * This function ensures that the compliance modal script is only loaded
 * if the region session is not set.
 */
function enqueue_compliance_modal_scripts() {

    // Only enqueue if region session is not set.
    if ( ! isset( $_SESSION['region'] ) ) {
        // Enqueue custom modal JavaScript.
        wp_enqueue_script(
            'compliance-modal',
            get_stylesheet_directory_uri() . '/js/compliance-modal.js',
            array( 'child-understrap-scripts' ),
            '1.0',
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'enqueue_compliance_modal_scripts' );

/**
 * Retrieves regions and their associated disclaimers dynamically.
 *
 * This function fetches all terms from the 'region' taxonomy and retrieves
 * the associated countries and disclaimers using Advanced Custom Fields (ACF).
 *
 * @return array An array of regions with their slugs, names, countries, and disclaimers.
 */
function get_compliance_regions() {
    $regions = get_terms(
        array(
            'taxonomy'   => 'region',
            'hide_empty' => false,
        )
    );

    $region_data = array();

    foreach ( $regions as $region ) {
        $countries  = get_field( 'countries', 'region_' . $region->term_id );
        $disclaimer = get_field( 'disclaimer', 'region_' . $region->term_id );

        $region_data[] = array(
            'slug'       => $region->slug,
            'name'       => $region->name,
            'countries'  => $countries ? explode( "\n", $countries ) : array(),
            'disclaimer' => $disclaimer ? $disclaimer : '',
        );
    }

    return $region_data;
}

/**
 * AJAX handler to fetch the disclaimer for a region term.
 *
 * This function retrieves the disclaimer associated with a specific region
 * based on the provided region slug.
 */
function fetch_region_disclaimer() {
    // Check if the region slug is provided.
    if ( ! isset( $_POST['region_slug'] ) || empty( $_POST['region_slug'] ) ) {
        wp_send_json_error( array( 'message' => 'Region slug not provided.' ) );
        return;
    }

    $region_slug = sanitize_text_field( $_POST['region_slug'] );

    // Get the term by slug.
    $term = get_term_by( 'slug', $region_slug, 'region' );
    if ( ! $term ) {
        wp_send_json_error( array( 'message' => 'Region not found.' ) );
        return;
    }

    // Get the 'disclaimer' ACF field for the term.
    $disclaimer = get_field( 'disclaimer', 'region_' . $term->term_id );
    if ( ! $disclaimer ) {
        wp_send_json_error( array( 'message' => 'Disclaimer not found for this region.' ) );
        return;
    }

    // Return the disclaimer text.
    wp_send_json_success( array( 'disclaimer' => wp_kses_post( $disclaimer ) ) );
}
add_action( 'wp_ajax_fetch_region_disclaimer', 'fetch_region_disclaimer' );
add_action( 'wp_ajax_nopriv_fetch_region_disclaimer', 'fetch_region_disclaimer' );


/**
 * Outputs the compliance modal HTML.
 *
 * This function displays a modal for compliance confirmation,
 * allowing users to select their region and view the associated disclaimer.
 */
function display_compliance_modal() {
    if ( isset( $_SESSION['region'] ) ) {
        return;
    }

    $regions = get_compliance_regions();
    ?>
    <style>
        #disclaimerText {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 10px;
            padding-bottom: 2rem;
        }
        .compliance-backdrop {
            background-image: url(<?= esc_url( get_stylesheet_directory_uri() . '/img/modal-bg.svg' ); ?>);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: bottom left;
            opacity: 1 !important;
        }
    </style>
    <!-- US-specific compliance modal -->
    <div class="modal fade" id="usComplianceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/arcus-logo.svg' ); ?>" width=141 height=34>
                </div>
                <div class="modal-body">
                    <h2 class="h3">Important Notice for US Visitors</h2>
                    <p>This site is not accessible to visitors from the USA. Please contact us directly for more information.</p>
                </div>
                <div class="modal-footer">
                    <a href="mailto:<?= esc_attr( antispambot( 'info@arcusinvest.com' ) ); ?>" class="button" id="usContactButton">Contact</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="complianceModal" tabindex="-1" aria-labelledby="complianceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/arcus-logo.svg' ); ?>" width=141 height=34>
                </div>
                <div class="modal-body">
                    <div id="step1">
                        <p>Please select your investor type:</p>
                        <div class="d-flex gap-3 mt-3">
                            <button id="btnProfessional" class="btn btn-primary">Professional</button>
                            <button id="btnRetail" class="btn btn-outline-secondary">Non-Professional</button>
                        </div>
                        <!-- <div class="form-check">
                            <label for="investorCheckbox" class="form-check-label">I am a professional or institutional investor</label>
                            <input type="checkbox" class="form-check-input" id="investorCheckbox">
                        </div> -->
                    </div>
                    <div id="step2" class="d-none">
                        <label for="regionSelect" class="form-label">Select your country</label>
                        <select id="regionSelect" class="form-select">
                            <option value="">-- Select a country --</option>
                            <?php
                            $regions = get_terms(
                                array(
                                    'taxonomy'   => 'region',
                                    'hide_empty' => false,
                                )
                            );
                            foreach ( $regions as $region ) {
                                // Fetch the 'countries' ACF field for the current term.
                                $countries = get_field( 'countries', 'region_' . $region->term_id );

                                // If 'countries' field exists, loop through its values.
                                if ( $countries ) {
                                    $countries_array = explode( "\n", $countries ); // Split lines into an array.
                                    foreach ( $countries_array as $country ) {
                                        echo '<option data-region="' . esc_attr( $region->slug ) . '">' . esc_html( trim( $country ) ) . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div id="step3" class="d-none">
                        <div id="disclaimerText">
                            <p>Select a country to view the disclaimer.</p>
                        </div>
                        <button id="acceptButton" class="button mt-3" disabled>Accept</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const complianceModal = document.getElementById('complianceModal');
    const usComplianceModal = document.getElementById('usComplianceModal');

    if (complianceModal) {
        complianceModal.addEventListener('show.bs.modal', function () {
            setTimeout(() => {
                document.querySelector('.modal-backdrop').classList.add('compliance-backdrop');
            }, 10);
        });

        complianceModal.addEventListener('hidden.bs.modal', function () {
            document.querySelector('.modal-backdrop')?.classList.remove('compliance-backdrop');
        });
    }

    if (usComplianceModal) {
		usComplianceModal.addEventListener('show.bs.modal', function () {
			setTimeout(() => {
				document.querySelector('.modal-backdrop')?.classList.add('compliance-backdrop');
			}, 10);
		});

		usComplianceModal.addEventListener('hidden.bs.modal', function () {
			document.querySelector('.modal-backdrop')?.classList.remove('compliance-backdrop');
		});
	}
});
</script>
    <?php
}
add_action( 'wp_footer', 'display_compliance_modal' );

/**
 * AJAX handler to set the region session variable.
 *
 * This function validates the provided region slug and sets it
 * in the session for the current user.
 */
function set_region_session() {
    // Ensure the session is started.
    if ( ! session_id() ) {
        session_start();
    }

    // Validate the region slug.
    if ( ! isset( $_POST['region_slug'] ) || empty( $_POST['region_slug'] ) ) {
        wp_send_json_error( array( 'message' => 'Region slug not provided.' ) );
        return;
    }

    $region_slug = sanitize_text_field( $_POST['region_slug'] );

    // Set the region in the session.
    $_SESSION['region'] = $region_slug;

    wp_send_json_success( array( 'message' => 'Session variable set.' ) );
}
add_action( 'wp_ajax_set_region_session', 'set_region_session' );
add_action( 'wp_ajax_nopriv_set_region_session', 'set_region_session' );
