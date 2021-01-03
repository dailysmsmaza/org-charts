<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_model extends MY_Model
{
	public $table = 'manage_backup'; // you MUST mention the table name
	public $primary_key = 'id'; // you MUST mention the primary key
	
	public function __construct()
	{
		$this->return_as = 'object';
     $this->before_delete[] = 'remove_code_backup';
    parent::__construct();
  }

  function get_datatables($sql_details)
	{
		$this->load->library('datatables_ssp');

		$delete_all = array(
			'customfilter' => 'id',
			'db' => 'id',
			'formatter' => function($row) {
				return get_delete_all($row);
			}
		);
		$backup_name =	array(
			'customfilter' => 'backup_name',
			'db' => 'backup_name',
		);
    $backup_path= array(
        'customfilter' => 'backup_path',
        'db' => 'backup_path',
        'formatter' => function( $backup_path, $row ) {
						return get_backup($backup_path);
					}
        );
		$backup_date = array(
			'customfilter' => 'backup_date',
			'db' => 'backup_date',
			'formatter' => function($backup_date, $row ){
				$formate_date=array("date_format"=>$row['backup_date']);
				return get_format_date($formate_date); 
			}
		);
    $delete  = array(
			'customfilter' => 'id',
			'db' => 'id',
			'formatter' => function($id) {
				return get_delete($id);
			}
		);
    function get_backup($backup_path)
			{
				return "
        <div class='TextCenter btn-resume'><a download href=../".$backup_path.">Download</a></div>";
			}

			$data_table = array_values(compact('delete_all','backup_name','backup_path','backup_date','delete')) ;

		
		$columns = array();

		foreach ($data_table as $data_key => $value) {
			$value['dt']=$data_key;
			$columns[] = $value; 
		}

		return json_encode(
			Datatables_ssp::simple($_GET, $sql_details, $this->table, $this->primary_key, $columns,$myjoin='',$where='')
		);
		
	}
  public function remove_code_backup($data)
	{
		$result = $this->where('id',$data)->get_all();
		foreach ($result as $key => $value) 
		{
			if(file_exists('./'.$value->backup_path))
			{
				unlink('./'.$value->backup_path);
			}
		}
	}


}


/* End of file Backup_model.php */