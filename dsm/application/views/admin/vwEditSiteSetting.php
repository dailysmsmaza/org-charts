<div class="m-subheader ">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title"><?php echo $page_title; ?></h3>
    </div>
  </div>
</div>
<?php if(empty($setting)): ?>
  <?php $this->load->view('admin/partials/_admin_not_found'); ?>
<?php return FALSE; endif;  ?>
<div class="col-sm-12">
  <div class="m-portlet m-portlet--primary m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_2">
    <!--begin::Form-->
    <form class="m-form m-form--fit m-form--label-align-right" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data" name="site_form" id="user_form" novalidate="novalidate">
      <div class="m-portlet__body pb-2">
        
        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12" for="site_name">
            Site Name  <span class="text-danger">*</span>
          </label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <input type="text" class="form-control input-lg m-input" value="<?php echo get_input('site_name',$setting->site_project_name); ?>" name="site_name" id="site_name" placeholder="Enter your site name" required data-msg-required="Please enter site name.">
          </div>
        </div>
        
        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12" for="site_email"> Site Email <span class="text-danger">*</span> </label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <input type="email" class="form-control input-lg m-input" id="site_email" name="site_email" placeholder="Enter your site email" value="<?php echo get_input('site_email',$setting->site_email) ?>" required data-msg-required="Please enter site email.">
          </div>
        </div>
        
        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12" for="site_url"> Site Url <span class="text-danger">*</span> </label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <input type="url" class="form-control input-lg m-input" id="site_url" name="site_url" placeholder="Enter your site url" value="<?php echo get_input('site_url',$setting->site_url) ?>" required data-msg-required="Please enter site url.">
          </div>
        </div>
          <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12" for="website_admin_logo_caption"> Website Admin Logo Caption </label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <input type="text" class="form-control input-lg m-input" id="website_admin_logo_caption" name="website_admin_logo_caption" placeholder="Enter caption" value="<?php echo get_input('website_admin_logo_caption',$setting->website_admin_logo_caption) ?>"  data-msg-required="Please enter website frontend logo caption.">
          </div>
        </div>
           <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12" for="website_admin_logo"> Website Admin Logo 
		  <?php echo ADMIN_LOGO_SIZE; ?></label> 
          <div class="col-lg-8 col-md-9 col-sm-12">
            <div class="cropoutterwrap">
            <input type="file"  class="form-control validImage" name="website_admin_logo" id="website_admin_logo" data-image-crop="1" data-image-height="<?php echo ADMIN_LOGO_SIZE_HEIGHT; ?>" data-image-width="<?php echo  ADMIN_LOGO_SIZE_WIDTH; ?>" data-caption="Image" data-image-path ="site-setting/adminlogo/" >
            </div>
            <?php if($setting->website_admin_logo != ""): ?>
              <div class="w-50 mt-2">
                <img class="image-admin-display w-50" src="<?php echo base_url($setting->website_admin_logo); ?>">
              </div>
            <?php endif; ?>
          </div>
        </div>
          <!--admin side close-->
        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12" for="mobile_number"> Mobile Number <span class="text-danger">*</span></label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <input type="text" class="form-control validPhoneNumber input-lg m-input" id="mobile_number" maxlength="20" name="mobile_number" placeholder="Enter your mobile number" value="<?php echo get_input('mobile_number',$setting->site_phone_number) ?>" required data-msg-required="Please enter mobile number.">
          </div>
        </div>

        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12" for="tel_phone_number"> Tel Phone Number  <span class="text-danger">*</span> </label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <input type="text" class="form-control validPhoneNumber input-lg m-input" maxlength="20" id="tel_phone_number" name="tel_phone_number" placeholder="Enter tel phone number" value="<?php echo get_input('tel_phone_number',$setting->site_telphone_number) ?>" required data-msg-required="Please enter tel phone number.">
          </div>
        </div>

        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12" for="fax_number"> Fax Number <span class="text-danger">*</span></label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <input type="text" class="form-control validPhoneNumber input-lg m-input" maxlength="20" id="fax_number" name="fax_number" placeholder="Enter your fax number" value="<?php echo get_input('fax_number',$setting->site_telphone_number) ?>" required data-msg-required="Please enter fax number.">
          </div>
        </div>

        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12" for="fax_number"> Address <span class="text-danger">*</span></label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <textarea name="address" id="address" class="form-control input-lg m-input" rows="3" required data-msg-required="Please enter address."><?php echo $setting->site_address; ?></textarea>
          </div>
        </div>
        
        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12" for="site_copy_right"> Copy Right <span class="text-danger">*</span></label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <input type="text" class="form-control input-lg m-input" required data-msg-required="Please enter copy right." id="site_copy_right" name="site_copy_right" placeholder="Enter your copy right" value="<?php echo get_input('site_copy_right',$setting->site_copy_right) ?>" >
          </div>
        </div>

        <hr class="my-2">
        <div class="m-portlet__foot m-portlet__foot--fit py-2 border-0">
          <div class="m-form__actions m-form__actions py-0 ">
            <div class="row">
              <div class="col-lg-9 ml-lg-auto">
                <button type="submit" name="Submit" id="Submit" value="Save" class="btn btn-success"><i class="fa fa-save"></i>
                  Save
                </button>
                <a  class="btn btn-secondary" href="<?php echo current_url(); ?>"> Cancel </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </form>
    <!--end::Form-->
  </div>
</div>
