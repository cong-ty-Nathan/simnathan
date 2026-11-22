        <!-- footer -->
        <div class="footer">
            <div class="container">
                <div class="row ">
                    <!-- footer-logo -->
                    <?php
                    $footer_tab__logo = get_field("footer_logo", "option");
                    $footer_tab__email = get_field("footer_email", "option");
                    $footer_tab__phone = get_field("footer_phone", "option");
                    $footer_tab__location = get_field("footer_location", "option");

                    ?>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 ">
                        <div class="ft-img"><img src="<?= !empty($footer_tab__logo) ? $footer_tab__logo : get_template_directory_uri() . '/assets/images/ft_logo.png'; ?>" alt=""></div>
                    </div>
                    <!-- /.footer-logo -->
                    <!-- footer-links -->
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 ">
                        <div class="footer-widget ">
                            <h3 class="footer-title ">Liên kết nhanh</h3>
                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'quick-links',
                                    'container'      => false,
                                    'items_wrap'     => '<ul class="angle list-none">%3$s</ul>',
                                )
                            );
                            ?>
                        </div>
                    </div>
                    <!-- /.footer-links -->
                    <!-- footer-tours -->
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 ">
                        <div class="footer-widget ">
                            <h3 class="footer-title ">Cẩm nang du lịch</h3>
                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'tour-packages',
                                    'container'      => false,
                                    'items_wrap'     => '<ul class="angle list-none">%3$s</ul>',
                                )
                            );
                            ?>
                        </div>
                    </div>
                    <!-- /.footer-Tours -->
                    <!-- footer-post -->
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 ">
                        <div class="footer-widget">
                            <h3 class="footer-title">Thông tin liên hệ</h3>
                            <!-- <div class="ft-contact-info"> <span class="ft-contact-icon"><i class="fa fa-map-marker"></i></span> <span class="ft-contact-text"><?= !empty($footer_tab__location) ? esc_html($footer_tab__location) : '' ?></span></div> -->
                            <div class="ft-contact-info"> <span class="ft-contact-icon"><i class="fa fa-phone "></i></span> <span class="ft-contact-text"><?= !empty($footer_tab__phone) ? esc_html($footer_tab__phone) : '' ?></span></div>
                            <div class="ft-contact-info"> <span class="ft-contact-icon"><i class="fa fa-envelope "></i></span> <span class="ft-contact-text"><?= !empty($footer_tab__email) ? esc_html($footer_tab__email) : '' ?></span></div>

                        </div>
                    </div>
                    <!-- /.footer-post -->
                </div>
                <!-- tiny-footer -->
            </div>
            <div class="tiny-footer ">
                <div class="container ">
                    <div class="row ">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center ">
                            <?php $absolute_footer = get_field("absolute_footer"); ?>
                            <p><?= !empty($absolute_footer) ? $absolute_footer : '© 2026 Trọng Nhân Dev. All rights reserved.' ?></p>
                        </div>
                    </div>
                    <!-- /. tiny-footer -->
                </div>
            </div>
        </div>
        <!-- /.footer -->
        <div class="modal fade black-friday-modal" id="blackFridayModal" tabindex="-1" role="dialog" aria-labelledby="blackFridayModalTitle" aria-describedby="blackFridayModalDescription" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content black-friday-modal__content">
                    <button type="button" class="close black-friday-modal__close" data-dismiss="modal" aria-label="Đóng popup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <a class="black-friday-modal__offer" href="http://gigago.com/#esimnathan">
                        <span class="black-friday-modal__eyebrow">MÃ ƯU ĐÃI</span>
                        <h2 class="black-friday-modal__title" id="blackFridayModalTitle">BLACKFRIDAY15</h2>
                        <span class="black-friday-modal__discount">15% OFF ESIM</span>
                        <p class="black-friday-modal__description" id="blackFridayModalDescription">Sẵn sàng kết nối cho mọi hành trình cùng eSIM.</p>
                        <h3 class="black-friday-countdown__title">Black Friday sẽ kết thúc</h3>
                        <div class="black-friday-countdown" role="timer" aria-label="Thời gian còn lại đến hết ngày 30 tháng 11">
                            <div class="black-friday-countdown__item">
                                <span class="black-friday-countdown__value" data-countdown-days>00</span>
                                <span class="black-friday-countdown__label">ngày</span>
                            </div>
                            <div class="black-friday-countdown__item">
                                <span class="black-friday-countdown__value" data-countdown-hours>00</span>
                                <span class="black-friday-countdown__label">giờ</span>
                            </div>
                            <div class="black-friday-countdown__item">
                                <span class="black-friday-countdown__value" data-countdown-minutes>00</span>
                                <span class="black-friday-countdown__label">phút</span>
                            </div>
                            <div class="black-friday-countdown__item">
                                <span class="black-friday-countdown__value" data-countdown-seconds>00</span>
                                <span class="black-friday-countdown__label">giây</span>
                            </div>
                        </div>
                        <span class="black-friday-modal__button">MUA NGAY</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <div class="search-form">
                                <input type="text" name="s" class="form-control" placeholder="Find here">
                                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">close</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Modal -->
        <a href="javascript:" id="return-to-top"><i class="fa fa-angle-up"></i></a>
        <?php // All scripts are enqueued via functions.php using wp_enqueue_script() 
        ?>
        <?php wp_footer(); ?>
        </div>
        </body>


        </html>