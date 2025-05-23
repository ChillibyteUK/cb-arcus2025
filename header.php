<?php
/**
 * The header for the theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package cb-arcus2025
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( session_status() === PHP_SESSION_NONE ) {
    session_start();
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta
        charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, minimum-scale=1">
    <!-- link rel="preload"
        href="<?= esc_url( get_stylesheet_directory_uri() . '/fonts/bembo-regular.woff2' ); ?>"
        as="font" type="font/woff2" crossorigin="anonymous" -->

    <?php
    if ( ! is_user_logged_in() ) {
        if ( get_field( 'ga_property', 'options' ) ) {
            ?>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async
                src="<?= esc_url( 'https://www.googletagmanager.com/gtag/js?id=' . get_field( 'ga_property', 'options' ) ); ?>">
            </script>
            <script>
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());
                gtag('config',
                    '<?= esc_js( get_field( 'ga_property', 'options' ) ); ?>'
                );
            </script>
        	<?php
        }
        if ( get_field( 'gtm_property', 'options' ) ) {
            ?>
            <!-- Google Tag Manager -->
            <script>
                (function(w, d, s, l, i) {
                    w[l] = w[l] || [];
                    w[l].push({
                        'gtm.start': new Date().getTime(),
                        event: 'gtm.js'
                    });
                    var f = d.getElementsByTagName(s)[0],
                        j = d.createElement(s),
                        dl = l != 'dataLayer' ? '&l=' + l : '';
                    j.async = true;
                    j.src =
                        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                    f.parentNode.insertBefore(j, f);
                })(window, document, 'script', 'dataLayer',
                    '<?= esc_js( get_field( 'gtm_property', 'options' ) ); ?>'
                );
            </script>
            <!-- End Google Tag Manager -->
    		<?php
        }
    }
	if ( get_field( 'google_site_verification', 'options' ) ) {
		echo '<meta name="google-site-verification" content="' . esc_attr( get_field( 'google_site_verification', 'options' ) ) . '" />';
	}
	if ( get_field( 'bing_site_verification', 'options' ) ) {
		echo '<meta name="msvalidate.01" content="' . esc_attr( get_field( 'bing_site_verification', 'options' ) ) . '" />';
	}

	wp_head();
	?>

    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "---",
            "url": "---",
            "logo": "---",
            "description": "---",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "---",
                "addressLocality": "---",
                "addressRegion": "---",
                "postalCode": "---",
                "addressCountry": "GB"
            },
            "telephone": "+44 (0) ---",
            "email": "---"
        }
    </script>
</head>

<body <?php body_class( is_front_page() ? 'homepage' : '' ); ?>
    <?php understrap_body_attributes(); ?>>
    <?php
	do_action( 'wp_body_open' );
	if ( ! is_user_logged_in() ) {
    	if ( get_field( 'gtm_property', 'options' ) ) {
        	?>
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe
                    src="<?= esc_url( 'https://www.googletagmanager.com/ns.html?id=' . get_field( 'gtm_property', 'options' ) ); ?>"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
    		<?php
    	}
	}
	?>
    <div class="header">
        <div class="logo-container ps-2"><a href="/" class="logo" aria-label=""></a></div>
        <div class="nav-holder"></div>
        <div class="header-end"></div>
    </div>

    <?php
    if ( isset( $_SESSION['region'] ) ) {
        ?>
    <header class="wrapper-navbar">
        <div class="container px-0">
            <div class="navbar-logo"><a href="/" class="logo" aria-label=""></a></div>
            <div class="navbar-icon">
            <?php
			$icons = array(
				'default'  => 'icon--arcus.svg',
				'home'     => 'icon--home.svg',
				'insight'  => 'icon--insight.svg',
				'team'     => 'icon--team.svg',
				'about'    => 'icon--team.svg',
				'contact'  => 'icon--team.svg',
				'strategy' => 'icon--strategy.svg',
				'fund'     => 'icon--strategy.svg',
			);

            $current_page = '';
            if ( isset( $_SERVER['REQUEST_URI'] ) ) {
                $request_uri  = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
                $current_page = trim( wp_parse_url( sanitize_text_field( $request_uri ), PHP_URL_PATH ), '/' );
            }

			switch ( true ) {
                case '' === $current_page: // Home Page.
					$icon = $icons['home'];
					break;

				case str_starts_with( $current_page, 'insights' ): // Insights page and sub-pages.
					$icon = $icons['insight'];
					break;

				case str_starts_with( $current_page, 'media' ): // Insights page and sub-pages.
					$icon = $icons['insight'];
					break;

                case str_starts_with( $current_page, 'fund' ): // Fund page and sub-pages.
					$icon = $icons['fund'];
					break;

                case 'team' === $current_page: // Team Page.
					$icon = $icons['team'];
					break;

				case 'about-us' === $current_page: // About Page.
					$icon = $icons['about'];
					break;

				case 'contact' === $current_page: // Contact Page.
					$icon = $icons['contact'];
					break;

				case 'strategy' === $current_page: // Strategy Page.
					$icon = $icons['strategy'];
					break;

				default: // Default Icon.
					$icon = $icons['default'];
					break;
			}

			// Output the icon.

			echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/img/' . $icon ) . '">';
			?>
            </div>
            <nav class="navbar navbar-expand-lg py-0">
                <div class="container nav-top align-items-center">
                    
                    <div class="button-container d-lg-none">
                        <button class="navbar-toggler mt-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="navbar">
                        <?php
            			wp_nav_menu(
							array(
								'theme_location'  => 'primary_nav',
								'container_class' => 'w-100',
								'menu_class'      => 'navbar-nav justify-content-around gap-4 w-100',
								'fallback_cb'     => '',
								'depth'           => 3,
								'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
                            )
						);
						?>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var navbar = document.querySelector(".wrapper-navbar");
            var initialOffset = navbar.offsetTop;

            window.addEventListener("scroll", function () {
                if (window.scrollY >= initialOffset) {
                    navbar.classList.add("fixed");
                } else {
                    navbar.classList.remove("fixed");
                }
            });
        });
    </script>
    	<?php
	}