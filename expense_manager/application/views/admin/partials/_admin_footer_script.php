<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<script>
  $(document).ready(function() {
      var bulkdelete_exist = $('#bulkDelete').val(); // = "Index"
      if(bulkdelete_exist=="on"){
        var column_sort=false;
      }else {
        var column_sort=true;
      }
      if($('#gridTable').length){
        $.post(base_url+'admin/dashboard/is_login',{},function (data, textStatus, jqXHR) {
          if(data.success === true){
            dataTable = $('#gridTable').on( 'order.dt',  function () { 
              $("#bulkDelete").prop('checked',false);
      		  $('.gridTable-delete-all').addClass('disabled');
      		  $('#gridTable input[name="delete_all[]"]').prop('checked',$(this).prop('checked'));
            });
            $('#gridTable').dataTable({
                <?php  if (empty($soringCol)) { $soringCol=''; } ?>
                <?  if (empty($manage_view_path)) { $manage_view_path=''; } ?>
                <?=$soringCol;?>
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                "bStateSave": true,
                "ajax": "<?=$manage_view_path;?>",
                "aoColumnDefs": [
                  { 
                    "bSortable": column_sort,
                    "aTargets": [0]
                  }
                ] ,
                "aLengthMenu": [
                  [10, 25, 50, 100, -1],
                  ["10", "25", "50", "100", "All" ]
                ],
                "language": {
                    "processing": "<div></div><div></div><div></div><div></div><div></div>"
                },
                "initComplete": function( settings, json ) {
                  if(json.data.length==0)
                  {
                    $("#Submit").hide();
                  }
                }
            });
          }else{
            window.location.href = $("#current_url").val();
          }
        });
      }
  });
</script>