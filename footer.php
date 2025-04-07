<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;
?>
<div id="footer-top"></div>
<footer class="footer py-5">
    <div class="container-xl">
        <img src="<?=get_stylesheet_directory_uri()?>/img/arcus-logo--wo.svg" alt="Arcus Invest" class="footer__logo">
        <div class="row pb-5">
            <div class="col-lg-3">
                <?= wp_nav_menu(array('theme_location' => 'footer_menu1', 'container_class' => 'footer__menu')) ?>
            </div>
            <div class="col-lg-9">
                <div class="footer__addresses--label">
                    Offices
                </div>
                <div class="row footer__addresses">
                    <div class="col-md-4 footer__office mb-4">
                        <?php
                        if ( $uk = get_field('uk_address', 'option') ) {
                        ?>
                            <div class="footer__title"><?= $uk['office_name'] ?></div>
                            <div class="footer__address"><?= $uk['office_address'] ?></div>
                            <div class="footer__phone"><?= $uk['office_phone'] ?></div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-4 footer__office mb-4">
                        <?php
                        if ( $jp = get_field('jp_address', 'option') ) {
                        ?>
                            <div class="footer__title"><?= $jp['office_name'] ?></div>
                            <div class="footer__address"><?= $jp['office_address'] ?></div>
                            <div class="footer__phone"><?= $jp['office_phone'] ?></div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-4 footer__office mb-4">
                        <?php
                        if ( $my = get_field('my_address', 'option') ) {
                        ?>
                            <div class="footer__title"><?= $my['office_name'] ?></div>
                            <div class="footer__address"><?= $my['office_address'] ?></div>
                            <div class="footer__phone"><?= $my['office_phone'] ?></div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="colophon d-flex justify-content-between align-items-center flex-wrap">
            <div>
                &copy; <?= date('Y') ?> Arcus Investment Limited. Authorised and regulated by the <a href="https://www.fca.org.uk/" target="_blank">Financial Conduct Authority</a> in the United Kingdom.
            </div>
            <div>
                <a href="https://www.chillibyte.co.uk/" rel="nofollow noopener" target="_blank" class="cb"
                title="Digital Marketing by Chillibyte"></a>
            </div>
        </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>