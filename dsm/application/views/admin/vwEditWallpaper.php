<div class="m-subheader ">
<div class="d-flex align-items-center">
  <div class="mr-auto">
    <h3 class="m-subheader__title"> <?php echo $page_title ?> </h3>
  </div>
 <a href="<?php echo base_url('admin/wallpaper') ?>" class="btn btn-success m-btn m-btn--icon">
            <span> <i class="fa fa-arrow-circle-o-left"></i><span></span>Back</span>
          </a></div>
</div>

<div class="col-sm-12">
<div class="m-portlet m-portlet--primary m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_2">
   <?php echo display_flash('error'); ?>
  <!--begin::Form-->
  <form class="m-form m-form--fit m-form--label-align-right" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data" name="wall_form" id="wall_form" novalidate="novalidate">
    <div class="m-portlet__body pb-2">
      <div class="box-header with-border">
        <div id="delete_allmsg_div"></div>
        <div class="FieldsMarked"> Fields Marked with (<span class="text-danger">*</span>) are Mandatory </div>
      </div>
      
      <div class="form-group m-form__group row">
     	<label class="col-form-label col-lg-3 col-sm-12" for="app_id">App Name<span class="text-danger">*</span> </label>
        <div class="col-lg-4 col-md-9 col-sm-12">
        	<input type="hidden" name="app_id" value="<?php echo $wall->app_id ?>">
      		<select  class="form-control input-lg m-input" name="app_id" id="app_id" disabled=""  onchange="appName(this);"required data-msg-required="Please select app.">
            	<option value="">Select Application</option>
                <?php
                            foreach ($appname as $key => $val) {
                                ?>
                                <option <?php echo ($wall->app_id == $val['app_id']) ? 'selected' : ''; ?>  value="<?php echo $val['app_id']; ?>"><?php echo $val['app_name']; ?></option>
                                <?php
                            }
                            ?>
            </select>
         </div>
     </div>
     
     <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12" for="media_type_id">Category Name</label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <select  class="form-control input-lg m-input"  name="category_id" id="category_id"   data-msg-required="Please select category.">
                            <?php
                            foreach ($category as $key => $val) {
                                ?>
                                <option <?php echo ($wall->category_id == $val['category_id']) ? 'selected' : ''; ?>  value="<?php echo $val['category_id']; ?>"><?php echo $val['category_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
      
     <div id="category">


     </div>  
    	<div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-3 col-sm-12" for="wall_name">Title <span class="text-danger">*</span> </label>
                    <div class="col-lg-4 col-md-9 col-sm-12">
                        <input type="text" class="form-control input-lg m-input" value="<?php echo get_input('wall_name', $wall->wall_name); ?>" name="wall_name" id="wall_name" required data-msg-required="Please enter title.">
                    </div>
                </div> 
     
     	<div id="wall_images">
        <?php 
			if($images){
			$i = 100;
			foreach($images as $image_val) {
			?>
            <div class="form-group m-form__group row" id="<?php echo $i; ?>">
            	<label class="col-form-label col-lg-3 col-sm-12" for="wall_image_<?php echo $i; ?>">Wallpaper</label>
                <div class="col-lg-9 col-md-12 col-sm-12">
                                        <div class="cropoutterwrap">
                                            <input type="hidden" name="photohidupdate[]" value="<?php echo $i;?>">
                                            <input type="hidden" name="update_id_<?php echo $i; ?>" value="<?php echo $image_val['id']; ?>">
                                            <input type="hidden" name="wall_image_old_<?php echo $i; ?>" value="<?php echo $image_val['wallpaper_image']; ?>">
                                            <input type="hidden" name="wall_img_old_<?php echo $i; ?>" value="<?php echo $image_val['wall_img_thumb']; ?>">
<!--                                            <input type="file" class="form-control  validImage"  name="wall_image_<?php echo $i; ?>" id="wall_image_<?php echo $i; ?>" data-caption="Image" data-image-path ="wallpaper/"  data-msg-required="Please upload wallpaper.">-->
                                        </div>

                                        <div class="w-25 mt-2">
                                            <img class="image-admin-display w-100" src="<?php echo base_url($image_val['wallpaper_image']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-10" style="margin-left:25%;margin-top: 10px;">
                                        <a class="btn btn-danger" style="color: white;"  data-delete-photo="<?php echo $image_val['id']; ?>" onclick="removephoto(this);"><i class="fa fa-fw fa-trash-o"></i></a>
                                    </div>
                                </div>
                                <?php
                                $i--;
                            }
				}
						?>
            <div class="form-group m-form__group row">
            	<label class="col-form-label col-lg-3 col-sm-12" for="wall_image">Wallpaper <?php echo SHOWCASE_IMAGE_SIZE; ?></label>
                <div class="col-lg-9 col-md-12 col-sm-12">
                                        <div class="cropoutterwrap">
                                            <input type="file" class="form-control  validImage"  name="wall_image[]" id="wall_image_1" multiple data-caption="Image" data-image-path ="wallpaper/"  data-msg-required="Please upload wallpaper.">
                                        </div>
                                    </div>
                                </div>            
<!--                	 <div class="wall_images"></div>
                    <div class="form-group m-form__group row ">
                        <label class="col-form-label col-lg-3 col-sm-12 " for=""></label>
                        <div class="col-sm-2">
                            <a class="btn btn-success" style="color: white;" onclick="addMorephoto(this);"><i class="fa fa-plus"></i> Add more</a>
                        </div>
                    </div>-->
                </div>
               
                       
             
     	</div>
      <div class="m-portlet__foot m-portlet__foot--fit py-2 border-0">
        <div class="m-form__actions m-form__actions py-0 ">
          <div class="row">
            <div class="col-lg-9 ml-lg-auto">
              <button type="submit" name="Submit" id="Submit" value="Save" class="btn btn-success"><i class="fa fa-save"></i>
                Save
              </button>
              <a  class="btn btn-secondary" href="<?php echo base_url('admin/wallpaper'); ?>"><i class="fa fa-times"></i> Cancel </a>
            </div>
          </div>
        </div>
      </div>
	 
  </form>
  <!--end::Form-->
</div>
</div>

<script type="text/javascript">

	function appName(thisval){
		var obj = $(thisval);
		var cat = $(thisval).val();
		$('#wall_images').show();
        $('.disabled_photo').attr('disabled', false);
        $('.textarea_disabled').attr('disabled', true);
		if (cat > 0 && cat != '') {
            $.ajax({
                url: base_url + "admin/wallpaper/getCategory",
                type: "post",
                data: {app_id: cat},
                dataType: 'html',
                success: function (res) {
                    $('#category').html(res);
                }
            });
        }
	}
	
	var intphotoBox = 1;
    var SHOWCASE_IMAGE_SIZE = "<?php echo SHOWCASE_IMAGE_SIZE; ?>";
    var SHOWCASE_IMAGE_SIZE_WIDTH = "<?php echo SHOWCASE_IMAGE_SIZE_WIDTH; ?>";
    var SHOWCASE_IMAGE_SIZE_HEIGHT = "<?php echo SHOWCASE_IMAGE_SIZE_HEIGHT; ?>";
    function addMorephoto() {
        intphotoBox++;
        var html_code = '<div class="form-group m-form__group row remove_div" id="' + intphotoBox + '">';
        html_code += '  <label class="col-form-label col-lg-3 col-sm-12" for="wall_image_' + intphotoBox + '"> Wallpaper <span class="text-danger">*</span></span>' + SHOWCASE_IMAGE_SIZE + '</label>';
        html_code += '<div class="col-lg-9 col-md-12 col-sm-12">';
        html_code += '<div class="cropoutterwrap"><input type="hidden" name="photohidinsert[]" value="'+intphotoBox+'">';
        html_code += '<input type="file" required class="form-control disabled_photo validImage"  name="wall_image_' + intphotoBox + '" id="wall_image_' + intphotoBox + '" data-caption="Image" data-image-path ="wallpaper/" required data-msg-required="Please upload wallpaper.">';
        html_code += '</div>';
        html_code += '</div>';
        html_code += '<div class="col-sm-10" style="margin-left:25%;margin-top: 10px;"><a class="btn btn-danger" style="color: white;" data-delete-photo="" onclick="removephoto(this);"><i class="fa fa-fw fa-trash-o"></i></a></div></div>';
        $(".wall_images").append(html_code);
    }
    function removephoto(thisval) {
        $(thisval).parent().parent().remove();
        var deleteId = $(thisval).attr('data-delete-photo');
        if (deleteId != '') {
            $.ajax({
                url: base_url + "admin/wallpaper/image_deleteajax",
                type: "post",
                data: {id: deleteId, action: 'photo'},
                dataType: 'html',
                success: function (res) {
                    console.warn(res);
                }
            });
        }
    }
			

</script>

