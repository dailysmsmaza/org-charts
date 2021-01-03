<section>
    <footer>
        <section class="fooder-top">
            <section class="container">
                <section class="fooder-top-contect">
                    <aside class="box box2">
                        <h2>LINKS</h2>
                        <ul class="footer-link">
                            <li><a href="<?php echo base_url('home'); ?>">Home</a></li>
                            <li><a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
                            <li><a href="<?php echo base_url('services'); ?>">Services</a></li>
                            <li><a href="<?php echo base_url('showcase'); ?>">Showcase</a></li>
                            <li><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
                        </ul>
                    </aside>
                    <aside class="box box4">
                        <h2>FIND ME ON</h2>
                        <ul class="footer-social">
                            <?php
                            $datas = social_media();
                            if ($datas):
                                foreach ($datas as $key => $data_val):
                                    ?>  <li class="<?php echo $data_val['social_icon_class']; ?>"><a  target="_blank" href="<?php echo $data_val['social_media_link']; ?>"></a></li>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </aside>
                    <aside class="box box3">
                        <h2>CONTACT</h2>
                        <ul class="footer-link">
                            <li><a href="mailto:<?php echo $websetting->site_email; ?>"><?php echo $websetting->site_email; ?></a></li>
                            <li><a href="tel:<?php echo $websetting->site_phone_number; ?>"><?php echo $websetting->site_phone_number; ?></a></li>
                        </ul>
                    </aside>
                </section>
            </section>
        </section>
        <section class="fooder-bottom">
            <section class="container">
                <aside class="fooder-top-right">
                    <p class="left"><?php echo $websetting->site_copy_right; ?></p>
                    <p class="right">Web Designers <a href="https://www.infoquestit.com/" target="_blank">Infoquest</a></p>
                </aside>
            </section>
        </section>

        <?php
        $code_google_analytics = google_analytics();
        echo $code_google_analytics->google_analytics_code;
        ?>
        <!--pop open-->
<!--        <section class="modal fade product-popup" id="productid" role="dialog">
            <section class="vertical-alignment-helper">
                <section class="modal-dialog vertical-align-center"> 

                     Modal content
                    <section class="modal-content">
                        <section class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </section>
                        <section class="modal-body">
                            <section class="product-name">
                                <ul>
                                    <li><img  src="<?php // echo HTTP_ASSETS_PATH_CLIENT;  ?>images/gallery.jpg" alt="" ></li>
                                    <li><img  src="<?php // echo HTTP_ASSETS_PATH_CLIENT;  ?>images/gallery.jpg" alt="" ></li>
                                    <li><img  src="<?php // echo HTTP_ASSETS_PATH_CLIENT;  ?>images/gallery.jpg" alt="" ></li>
                                    <li><img  src="<?php // echo HTTP_ASSETS_PATH_CLIENT;  ?>images/gallery.jpg" alt="" ></li>
                                    <li><img  src="<?php // echo HTTP_ASSETS_PATH_CLIENT;  ?>images/gallery.jpg" alt="" ></li>
                                    <li><img  src="<?php // echo HTTP_ASSETS_PATH_CLIENT;  ?>images/gallery.jpg" alt="" ></li>
                                    <li><img  src="<?php // echo HTTP_ASSETS_PATH_CLIENT;  ?>images/gallery.jpg" alt="" ></li>
                                </ul>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>-->
    </footer>
</body>
</html>
