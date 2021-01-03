<div class="m-subheader ">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title"> <?php echo $page_title ?> </h3>
    </div>
    <a class="btn btn-success m-btn m-btn--icon code_backup text-capitalize" > <span> <i class="fa fa-plus-circle"></i><span></span>Code Backup</span> </a></div>
</div>
<div class="col-sm-12">
<div class="m-portlet m-portlet--primary m-portlet--head-solid-bg m-portlet--head-sm" data-portlet="true" id="m_portlet_tools_2">
<div class="m-portlet__body">
  <div class="m_datatable m-datatable m-datatable--default m-datatable--loaded">
    <table id="gridTable" class="table table-striped m-table ">
      <thead>
        <tr class="p-0 ">
          <th width="8%" data-orderable="false" class="text-secondary py-3" > <label class="m-checkbox m-checkbox--single p-0 m-checkbox--all m-checkbox--solid m-checkbox--brand">
              <input type="checkbox" id="bulkDelete">
              <span class="mt-2"></span> </label>
            <a data-method="bulk_delete" role="button" aria-disabled="true" class="btn disabled btn-danger gridTable-delete pull-right gridTable-delete-all btn-sm m-btn m-btn--icon  m-btn--icon-only m-btn--custom m-btn--pill"> <i class="fa fa-3x fa-trash"></i> </a> </th>
          <th width="55%" class="py-3">File Name</th>
          <th width="10%" class="py-3">Download</th>
          <th width="15%" class="py-3">Backup Date</th>
          <th class="text-center py-3" width="10%" data-orderable="false">Delete</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
</div>
</div>
