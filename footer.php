<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;
?>
<div id="footer-top"></div>
<footer class="footer py-5">
    <div class="container-xl">
        <div class="row pb-4">
            <div class="col-md-3">
                <?= wp_nav_menu(array('theme_location' => 'footer_menu1', 'container_class' => 'footer__menu')) ?>
            </div>
            <div class="col-md-9">
                <div class="footer__addresses">
                    <div class="footer__addresses--label">
                        Offices
                    </div>
                    <div class="footer__office">
                        <?php
                        if ($uk = get_field('uk_address', 'option')) {
                        ?>
                            <div class="footer__title"><?= $uk['office_name'] ?></div>
                            <div class="footer__address"><?= $uk['office_address'] ?></div>
                            <div class="footer__phone"><?= $uk['office_phone'] ?></div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="footer__office">
                        <?php
                        if ($jp = get_field('jp_address', 'option')) {
                        ?>
                            <div class="footer__title"><?= $jp['office_name'] ?></div>
                            <div class="footer__address"><?= $jp['office_address'] ?></div>
                            <div class="footer__phone"><?= $jp['office_phone'] ?></div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="footer__office">
                        <?php
                        if ($my = get_field('my_address', 'option')) {
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
                CB
            </div>
        </div>
</footer>
<div class="spacer" style="height:100vh"></div>
<?php wp_footer(); ?>
</body>

</html>