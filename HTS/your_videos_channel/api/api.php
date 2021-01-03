<?php

require_once("Rest.inc.php");

	class API extends REST {

		public $data = "";
		const demo_version = false;

		private $db 	= NULL;
		private $mysqli = NULL;
		public function __construct() {
			// Init parent contructor
			parent::__construct();
			// Initiate Database connection
			$this->dbConnect();	
		}

		/*
		 *  Connect to Database
		*/
		private function dbConnect() {
			require_once ("../includes/config.php");
			$this->mysqli = new mysqli($host, $user, $pass, $database);
			$this->mysqli->query('SET CHARACTER SET utf8');
		}

		/*
		 * Dynmically call the method based on the query string
		 */
		public function processApi() {
			$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('processApi - method not exist',404); // If the method not exist with in this class "Page not found".
		}

		/* Api Checker */
		private function checkConnection() {
			if (mysqli_ping($this->mysqli)) {
				//echo "Responses : Congratulations, database successfully connected.";
                $respon = array(
                    'status' => 'ok', 'database' => 'connected'
                );
                $this->response($this->json($respon), 200);
			} else {
                $respon = array(
                    'status' => 'failed', 'database' => 'not connected'
                );
                $this->response($this->json($respon), 404);
			}
		}

		private function get_total_views() {

			include "../includes/config.php";

					$jsonObj = array();	

					$query = "SELECT * FROM tbl_gallery WHERE id='".$_GET['id']."'";
					$sql = mysqli_query($connect, $query) or die(mysqli_error());

					while ($data = mysqli_fetch_assoc($sql)) {
						 
						$row['id'] = $data['id'];
						$row['video_title'] = $data['video_title'];
			 			$row['total_views'] = $data['total_views'];
			 
						array_push($jsonObj, $row);
					
					}

					$view_qry = mysqli_query($connect, "UPDATE tbl_gallery SET total_views = total_views + 1 WHERE id = '".$_GET['id']."'");
			 

					$set['result'] = $jsonObj;
					
					header( 'Content-Type: application/json; charset=utf-8' );
				    echo $val= str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
					die();	

		}

		
		private function get_posts() {
			
			include "../includes/config.php";
		    $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		    $setting_result = mysqli_query($connect, $setting_qry);
		    $settings_row   = mysqli_fetch_assoc($setting_result);
		    $api_key    = $settings_row['api_key']; 

			if (isset($_GET['api_key'])) {

				$access_key_received = $_GET['api_key'];
				
				if ($access_key_received == $api_key) {

					if($this->get_request_method() != "GET") $this->response('',406);
					$limit = isset($this->_request['count']) ? ((int)$this->_request['count']) : 10;
					$page = isset($this->_request['page']) ? ((int)$this->_request['page']) : 1;
					
					$offset = ($page * $limit) - $limit;
					$count_total = $this->get_count_result("SELECT COUNT(DISTINCT n.id) FROM tbl_gallery n");
					
					$query = "SELECT distinct 
								n.id AS 'vid',
								n.cat_id,
								n.video_title, 
								n.video_url, 
								n.video_id,
								n.video_thumbnail,
								n.video_duration,
								n.video_description,
								n.video_type,
								n.size,
								n.total_views,
								n.date_time,
								
								c.category_name
								
							FROM 
								tbl_gallery n, 
								tbl_category c 
								
							WHERE 
								n.cat_id = c.cid ORDER BY n.id DESC LIMIT $limit OFFSET $offset";
							  
					$post = $this->get_list_result($query);
					$count = count($post);
					$respon = array(
						'status' => 'ok', 'count' => $count, 'count_total' => $count_total, 'pages' => $page, 'posts' => $post
					);
					$this->response($this->json($respon), 200);

				} else {
					die ('Oops, API Key is Incorrect!');
				}
			} else {
				die ('Forbidden, API Key is Required!');
			}

		}
		
		private function get_category_index() {

			include "../includes/config.php";
		    $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		    $setting_result = mysqli_query($connect, $setting_qry);
		    $settings_row   = mysqli_fetch_assoc($setting_result);
		    $api_key    = $settings_row['api_key']; 

			if (isset($_GET['api_key'])) {

				$access_key_received = $_GET['api_key'];
				
				if ($access_key_received == $api_key) {

					if($this->get_request_method() != "GET") $this->response('',406);
					$count_total = $this->get_count_result("SELECT COUNT(DISTINCT cid) FROM tbl_category");

					//$query = "SELECT distinct cid, category_name, category_image FROM tbl_category ORDER BY cid DESC";
					$query = "SELECT DISTINCT c.cid, c.category_name, c.category_image, COUNT(DISTINCT r.id) as video_count
					  FROM tbl_category c LEFT JOIN tbl_gallery r ON c.cid = r.cat_id GROUP BY c.cid ORDER BY c.cid DESC";

					$news = $this->get_list_result($query);
					$count = count($news);
					$respon = array(
						'status' => 'ok', 'count' => $count, 'categories' => $news
					);
					$this->response($this->json($respon), 200);

				} else {
						die ('Oops, API Key is Incorrect!');
				}
			} else {
				die ('Forbidden, API Key is Required!');
			}
		}

		private function get_category_posts() {

			include "../includes/config.php";
		    $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		    $setting_result = mysqli_query($connect, $setting_qry);
		    $settings_row   = mysqli_fetch_assoc($setting_result);
		    $api_key    = $settings_row['api_key']; 

			if (isset($_GET['api_key'])) {

				$access_key_received = $_GET['api_key'];
				
				if ($access_key_received == $api_key) {

					$id = $_GET['id'];

					if($this->get_request_method() != "GET") $this->response('',406);
					$limit = isset($this->_request['count']) ? ((int)$this->_request['count']) : 10;
					$page = isset($this->_request['page']) ? ((int)$this->_request['page']) : 1;
					
					$offset = ($page * $limit) - $limit;
					$count_total = $this->get_count_result("SELECT COUNT(DISTINCT id) FROM tbl_gallery WHERE cat_id = '$id'");
					
					$query = "SELECT distinct 
								cid,
								category_name,
								category_image
								
							FROM
								tbl_category 

							WHERE 
								cid = '$id'

							ORDER BY cid DESC";

					$query2 = "SELECT distinct 
								n.id AS 'vid',
								n.cat_id,
								n.video_title, 
								n.video_url, 
								n.video_id,
								n.video_thumbnail,
								n.video_duration,
								n.video_description,
								n.video_type,
								n.size,
								n.total_views,
								n.date_time,
								
								c.category_name
								
							FROM 
								tbl_gallery n, 
								tbl_category c 
								
							WHERE 
								n.cat_id = c.cid AND c.cid = '$id' ORDER BY n.id DESC LIMIT $limit OFFSET $offset";
							  
					$category = $this->get_category_result($query);
					$post = $this->get_list_result($query2);
					$count = count($post);
					$respon = array(
						'status' => 'ok', 'count' => $count, 'count_total' => $count_total, 'pages' => $page, 'category' => $category, 'posts' => $post
					);
					$this->response($this->json($respon), 200);

				} else {
						die ('Oops, API Key is Incorrect!');
				}
			} else {
				die ('Forbidden, API Key is Required!');
			}

		}

		private function get_search_results() {

			include "../includes/config.php";
		    $setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		    $setting_result = mysqli_query($connect, $setting_qry);
		    $settings_row   = mysqli_fetch_assoc($setting_result);
		    $api_key    = $settings_row['api_key']; 

			if (isset($_GET['api_key'])) {

				$access_key_received = $_GET['api_key'];
				
				if ($access_key_received == $api_key) {

					$search = $_GET['search'];

					if($this->get_request_method() != "GET") $this->response('',406);
					$limit = isset($this->_request['count']) ? ((int)$this->_request['count']) : 10;
					$page = isset($this->_request['page']) ? ((int)$this->_request['page']) : 1;
					
					$offset = ($page * $limit) - $limit;
					$count_total = $this->get_count_result("SELECT COUNT(DISTINCT n.id) FROM tbl_gallery n, tbl_category c WHERE n.cat_id = c.cid AND (n.video_title LIKE '%$search%' OR n.video_description LIKE '%$search%')");

					$query = "SELECT distinct 
								n.id AS 'vid',
								n.cat_id,
								n.video_title, 
								n.video_url, 
								n.video_id,
								n.video_thumbnail,
								n.video_duration,
								n.video_description,
								n.video_type,
								n.size,
								n.total_views,
								n.date_time,
								
								c.category_name
								
							FROM 
								tbl_gallery n, 
								tbl_category c 
								
							WHERE n.cat_id = c.cid AND (n.video_title LIKE '%$search%' OR n.video_description LIKE '%$search%') 

							LIMIT $limit OFFSET $offset";
							  
					$post = $this->get_list_result($query);
					$count = count($post);
					$respon = array(
						'status' => 'ok', 'count' => $count, 'count_total' => $count_total, 'pages' => $page, 'posts' => $post
					);
					$this->response($this->json($respon), 200);

				} else {
						die ('Oops, API Key is Incorrect!');
				}
			} else {
				die ('Forbidden, API Key is Required!');
			}

		}

		private function get_privacy_policy() {

			include "../includes/config.php";

			$setting_qry    = "SELECT * FROM tbl_settings where id = '1'";
		    $setting_result = mysqli_query($connect, $setting_qry);
		    $settings_row   = mysqli_fetch_assoc($setting_result);
		    $api_key    = $settings_row['api_key']; 

			if (isset($_GET['api_key'])) {

				$access_key_received = $_GET['api_key'];
				
				if ($access_key_received == $api_key) {

					$sql = "SELECT * FROM tbl_settings WHERE id = 1";
					$result = mysqli_query($connect, $sql);

					header( 'Content-Type: application/json; charset=utf-8' );
					print json_encode(mysqli_fetch_assoc($result));

			} else {
					die ('Oops, API Key is Incorrect!');
				}
			} else {
				die ('Forbidden, API Key is Required!');
			}

		}



		 /*
		 * ======================================================================================================
		 * =============================== API utilities # DO NOT EDIT ==========================================
		 */

		private function get_list($query) {
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				$result = array();
				while($row = $r->fetch_assoc()) {
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}
		
		private function get_list_result($query) {
			$result = array();
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				while($row = $r->fetch_assoc()) {
					$result[] = $row;
				}
			}
			return $result;
		}

		private function get_category_result($query) {
			$result = array();
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				while($row = $r->fetch_assoc()) {
					$result = $row;
				}
			}
			return $result;
		}

		private function get_one($query) {
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				$result = $r->fetch_assoc();
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}
		
		private function get_count($query) {
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				$result = $r->fetch_row();
				$this->response($result[0], 200); 
			}
			$this->response('',204);	// If no records "No Content" status
		}
		
		private function get_count_result($query) {
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
			if($r->num_rows > 0) {
				$result = $r->fetch_row();
				return $result[0];
			}
			return 0;
		}
		
		private function post_one($obj, $column_names, $table_name) {
			$keys 		= array_keys($obj);
			$columns 	= '';
			$values 	= '';
			foreach($column_names as $desired_key) { // Check the recipe received. If blank insert blank into the array.
			  if(!in_array($desired_key, $keys)) {
			   	$$desired_key = '';
				} else {
					$$desired_key = $obj[$desired_key];
				}
				$columns 	= $columns.$desired_key.',';
				$values 	= $values."'".$this->real_escape($$desired_key)."',";
			}
			$query = "INSERT INTO ".$table_name."(".trim($columns,',').") VALUES(".trim($values,',').")";
			//echo "QUERY : ".$query;
			if(!empty($obj)) {
				//$r = $this->mysqli->query($query) or trigger_error($this->mysqli->error.__LINE__);
				if ($this->mysqli->query($query)) {
					$status = "success";
			    $msg 		= $table_name." created successfully";
				} else {
					$status = "failed";
			    $msg 		= $this->mysqli->error.__LINE__;
				}
				$resp = array('status' => $status, "msg" => $msg, "data" => $obj);
				$this->response($this->json($resp),200);
			} else {
				$this->response('',204);	//"No Content" status
			}
		}

		private function post_update($id, $obj, $column_names, $table_name) {
			$keys = array_keys($obj[$table_name]);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the recipe received. If key does not exist, insert blank into the array.
			  if(!in_array($desired_key, $keys)) {
			   	$$desired_key = '';
				} else {
					$$desired_key = $obj[$table_name][$desired_key];
				}
				$columns = $columns.$desired_key."='".$this->real_escape($$desired_key)."',";
			}

			$query = "UPDATE ".$table_name." SET ".trim($columns,',')." WHERE id=$id";
			if(!empty($obj)) {
				// $r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if ($this->mysqli->query($query)) {
					$status = "success";
					$msg 	= $table_name." update successfully";
				} else {
					$status = "failed";
					$msg 	= $this->mysqli->error.__LINE__;
				}
				$resp = array('status' => $status, "msg" => $msg, "data" => $obj);
				$this->response($this->json($resp),200);
			} else {
				$this->response('',204);	// "No Content" status
			}
		}

		private function delete_one($id, $table_name) {
			if($id > 0) {
				$query="DELETE FROM ".$table_name." WHERE id = $id";
				if ($this->mysqli->query($query)) {
					$status = "success";
			    $msg 		= "One record " .$table_name." successfully deleted";
				} else {
					$status = "failed";
			    $msg 		= $this->mysqli->error.__LINE__;
				}
				$resp = array('status' => $status, "msg" => $msg);
				$this->response($this->json($resp),200);
			} else {
				$this->response('',204);	// If no records "No Content" status
			}
		}
		
		private function responseInvalidParam() {
			$resp = array("status" => 'Failed', "msg" => 'Invalid Parameter' );
			$this->response($this->json($resp), 200);
		}

		/* ==================================== End of API utilities ==========================================
		 * ====================================================================================================
		 */

		/* Encode array into JSON */
		private function json($data) {
			if(is_array($data)) {
				return json_encode($data, JSON_NUMERIC_CHECK);
			}
		}

		/* String mysqli_real_escape_string */
		private function real_escape($s) {
			return mysqli_real_escape_string($this->mysqli, $s);
		}
	}

	// Initiiate Library

	$api = new API;
	$api->processApi();
?>
