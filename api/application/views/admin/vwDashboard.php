<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title ">
                Dashboard
            </h3>
        </div>
        <div>
            <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
                <span class="m-subheader__daterange-label">
                    <span class="m-subheader__daterange-title">Today:</span>
                    <span class="m-subheader__daterange-date m--font-brand"><?= date("M d"); ?></span>
                </span>

            </span>
        </div>
    </div>
</div><div class="m-content" style="width:100%">
    <div class="m-portlet  m-portlet--unair">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::application -->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                <a href="<?php echo base_url('admin/application'); ?>">Applications</a>
                            </h4>
                            <br>

                            <span class="m-widget24__stats m--font-brand">
                                <?php echo $this->common->CountByTable('application'); ?> 
                            </span>
                            <div class="m--space-40"></div>

                        </div>
                    </div>
                    <!--end::application -->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::category-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                <a href="<?php echo base_url('admin/category'); ?>">Categories</a>
                            </h4>
                            <br>

                            <span class="m-widget24__stats m--font-info">
                                <?php echo $this->common->CountByTable('category'); ?>
                            </span>
                            <div class="m--space-40"></div>
                        </div>
                    </div>
                    <!--end::category-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Wallpaper -->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                <a href="<?php echo base_url('admin/wallpaper'); ?>">Wallpapers</a>
                            </h4>
                            <br>

                            <span class="m-widget24__stats m--font-danger">
                                <?php echo $this->common->CountByTable('wallpaper'); ?>
                            </span>
                            <div class="m--space-40"></div>
                        </div>
                    </div>
                    <!--end::wallpaper -->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Showcase Category-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                <!--<a href="<?php // echo base_url('admin/showcase_category'); ?>">Showcase Category</a>-->
                            </h4>
                            <br>

                            <span class="m-widget24__stats m--font-success">
                                <?php // echo $this->common->CountByTable('showcase_category'); ?>
                            </span>
                            <div class="m--space-40"></div>


                        </div>
                    </div>
                    <!--end::Showcase Category-->
                </div>

            </div>
        </div>
    </div>
   </div>