<!--begin::Base Scripts -->
<?php if($this->router->fetch_method() === "create" || $this->router->fetch_method() === "edit" ): ?>
    <script src="http://yui.yahooapis.com/3.17.2/build/yui/yui-min.js"></script>
  <?php if($is_CKEditor): ?>   
    <script src="//cdn.ckeditor.com/4.7.3/full/ckeditor.js"></script>
  <?php endif; ?>   
<?php endif; ?>

<?php
  $js = array('vendors.bundle.js','scripts.bundle.js');
  $datatable = array('jquery.dataTables.min.js','dataTables.bootstrap4.min.js','sweetalert.min.js');  // data table js
  $crop = array('img-crop.js','crop.js'); // imag croping js
  $form_validation=array('additional-methods.min.js');
  echo get_js($js,'admin_js');
  if($this->router->fetch_method() === "create" || $this->router->fetch_method() === "edit" )
  {
    echo get_js($crop,'admin_custom_js');
    echo get_js($form_validation,'admin_custom_js');
  }
  if($this->router->fetch_method()==="index")
  {
    echo get_js($datatable,'admin_custom_js');
  }
  
  echo get_js('custom.js','admin_custom_js');

  $controller_name=$this->router->fetch_class();

  if($controller_name=='news')
  {
  	echo get_js('bootstrap-datetimepicker.js','admin_custom_js');
  }


?>

<?
if($is_GRID)
{
?>
	<?php $this->load->view('admin/partials/_admin_footer_script'); ?>
<?
}
?>
<?php if($is_CKEditor): ?>
  <script>
    ckeditor = $('.description');
    $.each(ckeditor,function(i,e) {
      var el_id = $(e).attr('id');
      CKEDITOR.replace(el_id,{ filebrowserUploadUrl : '<?=base_url()?>upload'});
      CKEDITOR.config.allowedContent = true;
    })
  </script>
<?php endif; ?>
<? if($this->router->fetch_class() === "backup_db" ) {?>
<script>
  
  $(function (){
    $(document).on('click','.db_backup',function(){
        StartLoading()
        $.ajax({
          type: "POST",
          url: "<?=base_url()?>admin/backup_db/backup_database",
          success: function(res) {
          if(res.success === true)
          {
            get_flash(res.message,res.type);  
          }
            StopLoading();
            $("#gridTable").dataTable().fnDraw();
          },
          error: function() {
            StopLoading();
          },
        });
    })
  });
</script>
<? }?>

<? if($this->router->fetch_class() === "backup" ) {?>
<script>
  
  $(function (){
    $(document).on('click','.code_backup',function(){
      StartLoading()
      $.ajax({
        type: "POST",
        url: "<?=base_url()?>backup_demo/test_backup",
        success: function(res) {
          if(res.success === true)
          {
            get_flash(res.message,res.type);  
          }
          StopLoading();
          $("#gridTable").dataTable().fnDraw();
        },
        error: function() {
          StopLoading();
        },
      });
  })
  });
</script>
<? }?> 
<!--end::Base Scripts -->