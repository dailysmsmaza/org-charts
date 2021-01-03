<div class="m-subheader ">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title"><?php echo $page_title; ?></h3>
    </div>
  </div>
</div>

<div class="col-sm-12">
  <div class="m-portlet m-portlet--primary m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_2">
    <!--begin::Form-->
    <form class="m-form m-form--fit m-form--label-align-right" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data" name="user_form" id="user_form" novalidate="novalidate">
      <div class="m-portlet__body pb-2">
        
        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12 text-capitalize" for="email"> Email <span class="text-danger">*</span></label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <input type="email" class="form-control input-lg m-input" id="email" name="email" required data-msg-required="Please enter email." value="<?php echo get_input('email',$this->session->userdata('email')); ?>">
          </div>
        </div>

        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12 text-capitalize" for="first_name">
            Name<span class="text-danger">*</span>
          </label>
          <div class="col-lg-4 col-md-9 col-sm-12">
            <input type="text" class="form-control input-lg m-input" value="<?php echo get_input('user_name',$this->session->userdata('first_name')); ?>" name="first_name" id="first_name" placeholder="Enter your name" required data-msg-required="Please enter name.">
            </div>
        </div>
        
        
        <div class="form-group m-form__group row">
          <label class="col-form-label col-lg-3 col-sm-12 text-capitalize" for="user_image"> Profile Picture<?php echo PROFILE_SIZE; ?></label> 
          <div class="col-lg-8 col-md-9 col-sm-12">
            <div class="cropoutterwrap">
            <input type="file"  class="form-control validImage" name="user_image" id="user_image" data-image-crop="1" data-image-height="<?php echo PROFILE_SIZE_HEIGHT; ?>" data-image-width="<?php echo PROFILE_SIZE_WIDTH; ?>" data-caption="Image" data-image-path ="profile/" >
            </div>
            <?php if($this->session->userdata('user_image') != ""): ?>
              <div class="w-50 mt-4">
                <img class="image-admin-display w-25" src="<?php echo base_url($this->session->userdata('user_image')); ?>">
              </div>
            <?php endif; ?>
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
                <a  class="btn btn-secondary" href="<?php echo current_url(); ?>"> <i class="fa fa-times"></i> Cancel </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </form>
    <!--end::Form-->
  </div>
</div>
