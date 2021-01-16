<?php
class Table_page_lib
{
	private $CI;

	function __construct()
	{
		// parent::__construct();

		// $this->load->helper(array('form', 'url'));
		// $this->load->library('form_validation');
		// $this->load->library('erd_lib');

		$this->CI =& get_instance();
		//
		$this->CI->load->helper(array('form', 'url'));
		$this->CI->load->library('form_validation','erd_lib','input', 'ion_auth', 'session');


	}

	public function fetch_without_inheritance($table)
	{

		$table = urldecode($table);
		$this->CI->load->database();


		// if ($this->CI->input->is_ajax_request()) {
		// // if ($posts = $this->CI->db->get($table)->result()) {
		// // 	$data = array('responce' => 'success', 'posts' => $posts);
		// // }else{
		// // 	$data = array('responce' => 'error', 'message' => 'Failed to fetch data');
		// // }
		// echo $table;


		$this->CI->db->_protect_identifiers=false;
		$posts = $this->CI->db->get("`".$table."`")->result();
		$data = array('responce' => 'success', 'posts' => $posts);
		$this->CI->db->_protect_identifiers=true;
		return $data;

		// } else {
		// 	return "No direct script access allowed";
		// }



	}

	public function edit($table)
	{

		$this->CI->load->database();


		// if ($this->CI->input->is_ajax_request()) {
		$edit_id = $this->CI->input->post('edit_id');

		$this->CI->db->select("*");
		$this->CI->db->from($table);
		$this->CI->db->where("id", $edit_id);
		$query = $this->CI->db->get();
		$post = null;
		if (count($query->result()) > 0) {
			$post = $query->row();
		}
		if ($post) {
			$data = array('responce' => 'success', 'post' => $post);
		} else {
			$data = array('responce' => 'error', 'message' => 'failed to fetch record');
		}
		return $data;
		// } else {
		// 	return "No direct script access allowed";
		// }
	}

	public function table_rows($table)
	{

		$this->CI->load->database();


		$row_query = array(
		"SHOW COLUMNS FROM $table",
		);
		$row_query = implode(" ", $row_query);
		$rows = $this->CI->db->query($row_query)->result_array();
		$rows = array_column($rows, 'Field');

		$result = array();
		foreach ($rows as $key => $value) {
			$result[$value] = array();
		}

		return $result;
	}

	// public function fetch_for_record($table, $haystack, $needle, $child_of)
	public function fetch($table, $page_type, $context)
	{
		$table = urldecode($table);

		$this->CI->load->database();

		// $posts = $this->CI->db->where($context["haystack"], $context["needle"])->get($table)->result_array();

		$erd_path = APPPATH.'erd/erd/erd.json';
		$erd = file_get_contents($erd_path);
		$erd = json_decode($erd, true);

		if ($page_type == "record") {
			$context["foreign_key"] = urldecode($context["foreign_key"]);
			$cols_visible = $this->cols_visible($table, $erd, $context["foreign_key"]);
			// $cols_visible = $this->cols_visible($table, $erd, "");
		}
		elseif ($page_type == "table") {
			$cols_visible = $this->cols_visible($table, $erd, null);
		}

		// header('Content-Type: application/json');
		// echo json_encode($cols_visible, JSON_PRETTY_PRINT);
		// exit;


		if (1==1) {


			$this->CI->db->_protect_identifiers=false;
			$query = $this->CI->db;

			$parent_link_part_1 = '<a href="/record/t/'.$table.'/r/';
			$parent_link_part_2 = '" class="btn btn-sm btn-outline-primary">View</a>';
			$query = $query->select("CONCAT('$parent_link_part_1', "."`".$table."`".".id, '$parent_link_part_2') as `id`");

			foreach ($cols_visible["cols_o"] as $key => $value) {
				if ($key !== "id") {
					// code...
				}
				$query = $query->select("`".$table."`".'.'."`".$key."`");
			}
			foreach ($cols_visible["cols_d"] as $key => $value) {
				// if ($key !== $table) {
					foreach ($value["cols"] as $key_2 => $value_2) {
						if ($key_2 == "id") {
							$parent_link_part_1 = '<a href="/record/t/'.$key.'/r/';
							$parent_link_part_2 = '" class="btn btn-sm btn-outline-primary">View</a>';
							$query = $query->select("CONCAT('$parent_link_part_1', "."`joining_table_".$key."`".".id".", '$parent_link_part_2') as `$key - $key_2`");
						} else {
							$query = $query->select("`joining_table_".$key."`"."."."`".$key_2."`"." as `$key - $key_2`");
						}


					}
					if ($table == $key) {
						// $tab_d["cols"]["visible"] = array_merge(
						// 	$tab_d["cols"]["visible"],
						// 	array("$key - lineage" => "1")
						// );
						$query = $query->select("`joining_table_".$key."_lineage`.path"." as `$key - lineage`");
					}
				// }
			}
			$query = $query->from("`".$table."`");

			foreach ($cols_visible["cols_d"] as $key => $value) {
				// echo "xyz";
				// if ($key !== $table) {
					$query = $query->join("`".$key."` as `joining_table_".$key."`", "`".$table."`".'.'."`".$value["linking_key"]."`".' = '."`joining_table_".$key."`".'.id', 'left');
				// }

				if ($table == $key) {
					$linking_key = $value["linking_key"];
					$sql="WITH RECURSIVE q AS
					(
						SELECT  id,`$linking_key`,CONCAT(id) as path
						FROM    $key
						WHERE   `$linking_key` = 0
						UNION ALL
						SELECT  m.id,m.`$linking_key`,CONCAT(q.path,'-',m.id) as path
						FROM    $key m
						JOIN    q
						ON      m.`$linking_key` = q.id
					)
					SELECT  *
					FROM    q
					";
					$query = $query->join("(".$sql.") as `joining_table_".$key."_lineage`", "`".$table."`".'.'."`$linking_key`".' = '."`joining_table_".$key."_lineage`".'.id', 'left');
				}
			}

			if ($page_type == "record") {
				$context["haystack"] = urldecode($context["haystack"]);
				$query = $query->where("`".$table."`"."."."`".$context["haystack"]."` =", $context["needle"]);
			}
			elseif ($page_type == "table") {
			}
			// $sql="WITH RECURSIVE q AS
			// (
			// 	SELECT  id,`object id`,CONCAT(id) as path
			// 	FROM    objects
			// 	WHERE   `object id` = 0
			// 	UNION ALL
			// 	SELECT  m.id,m.`object id`,CONCAT(q.path,'-',m.id) as path
			// 	FROM    objects m
			// 	JOIN    q
			// 	ON      m.`object id` = q.id
			// )
			// SELECT  *
			// FROM    q
			// ";
			// $posts = $this->CI->db->query($sql)->result_array();
			$posts = $query->get()->result_array();
			// print_r($this->CI->db->last_query());
			// exit;

		}

		$this->CI->db->_protect_identifiers=true;




		// header('Content-Type: application/json');
		// echo $this->CI->db->last_query();
		// exit;

		$data = array('responce' => 'success', 'posts' => $posts);
		return $data;
	}

	// public function fetch_join_where($table_1, $table_2, $haystack,$needle)
	// {
	//
	// 	$this->CI->load->database();
	//
	//
	// 	// $posts = $this->CI->db->select('*')->where($haystack, $needle)->from($table_1)->join($table_2, "$table_1.$table_2_key = $table_2.id")->get()->result_array();
	// 	$table_2_singular = $this->erd_lib->grammar_singular($table_2);
	// 	$table_2_singular = $table_2_singular."_id";
	// 	// $table_1_singular = $this->erd_lib->grammar_singular($table_1);
	// 	// $haystack = $table_1_singular.".".$haystack;
	//
	//
	// 	$posts = $this->CI->db->select('*')->where($haystack, $needle)->from($table_2)->join($table_1, "$table_1.$table_2_singular = $table_2.id", "right")->get()->result_array();
	//
	// 	$data = array('responce' => 'success', 'posts' => $posts);
	// 	return $data;
	//
	// }

	public function fetch_where($table, $haystack, $needle)
	{

		$this->CI->load->database();


		$posts = $this->CI->db->select('*')->where($haystack, $needle)->from($table)->get()->result_array();

		$data = array('responce' => 'success', 'posts' => $posts);
		return $data;

	}

	public function database_api()
	{
		$erd_path = APPPATH.'erd/erd/erd.json';
		$rows = file_get_contents($erd_path);
		$rows = json_decode($rows, true);


		// $this->CI->load->database();
		//
		// $row_query = array(
		//   "SHOW TABLES",
		// );
		// $row_query = implode(" ", $row_query);
		// $rows = $this->CI->db->query($row_query)->result_array();
		// $rows = array_column($rows, 'Tables_in_'.$this->CI->db->database);
		// foreach ($rows as $key => $value) {
		// 	$rows_formatted[]["name"] = $value;
		// }
		foreach ($rows as $key => $value) {
			$rows_formatted[]["name"] = $key;
		}


		$data = array('responce' => 'success', 'posts' => $rows_formatted);
		return $data;
	}

	public function cols_visible($table, $erd, $foreign_key)
	{
		// $erd_path = APPPATH.'erd/erd/erd.json';
		// $erd = file_get_contents($erd_path);
		// $erd = json_decode($erd, true);

		$parents = array();

		foreach ($erd as $key => $value) {
			if (isset($value["items"])) {
				foreach ($value["items"] as $key_2 => $value_2) {
					if ($key_2 == $table) {
						if ($value_2 !== $foreign_key) {
							// echo $key_2;
							$parents[$key]["cols"] = $value["fields"];
							$parents[$key]["linking_key"] = $value_2;
						}
					}
				}
			}
		}



		// header('Content-Type: application/json');
		// echo json_encode($parents, JSON_PRETTY_PRINT);
		// exit;

		if (1==1) {
			// code...
			// $table_fields = $erd[$table]["fields"];
			// $rel = array();
			//
			// foreach ($parents as $key => $value) {
			// 	if (isset($table_fields[$key])) {
			// 		// echo "string";
			// 		// $col_deets = $table_fields[$key];
			//
			// 		foreach ($value["fields"] as $key_2 => $value_2) {
			// 			$rel[$key][$key_2] = $value_2;
			// 		}
			// 		// $rel[$key]["table"] = $key;
			// 	}
			// }
		}




		$self = $erd[$table]["fields"];


		foreach ($parents as $key => $value) {

			foreach ($erd[$key]["items"] as $key_2 => $value_2) {
				// echo "string";
				unset($self[$value_2]);
			}
			// header('Content-Type: application/json');
			// echo json_encode( $erd[$key]["items"], JSON_PRETTY_PRINT);
			// exit;

			// foreach ($value["inherited_cols"] as $key_2 => $value_2) {
			// 	$cols_wth_props[$key_2] = $value_2["col_props"];
			// }
			// $self = array_merge(
			// 	$self,
			// 	$cols_wth_props
			// );
		}
		// if (isset($erd[$ignore_col_set]["items"][$table])) {
		// 	$linking_k_for_ignore = $erd[$ignore_col_set]["items"][$table];
		// 	// header('Content-Type: application/json');
		// 	// echo json_encode($erd, JSON_PRETTY_PRINT);
		// 	// exit;
		// 	unset($self[$value_2]);
		// }
		if (isset($self[$foreign_key])) {
			unset($self[$foreign_key]);
		}

		// $cols_visible = array_merge(
		// 	array($table=>$self),
		// 	$parents
		// );
		$cols_visible = array(
		"cols_o" => $self,
		"cols_d" => $parents
		);

		// $parents = array_unique($parents);
		return $cols_visible;



	}

	public function makeSafeForCSS($string)
	{
		//Lower case everything
		$string = strtolower($string);
		//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
		//Convert whitespaces and underscore to dash
		// $string = preg_replace("/[\s_]/", "-", $string);
		$string = preg_replace("/[\s_]/", "_", $string);
		return $string;
	}

	public function table_o_and_d($rec_part, $erd, $table, $foreign_k, $record_id, $ignore_col_set, $dont_scan)
	{
		// if (!$this->ion_auth->logged_in())
		// {
		// 	// redirect them to the login page
		// 	redirect('auth/login', 'refresh');
		// }
		if ($rec_part=="overview") {

			$haystack = "id";
			$needle = $record_id;

			$tab_o["data_endpoint"] = "fetch_for_record/h/$haystack/n/$needle/foreign_key/null";
			$tab_o["type"] = "overview";
			$tab_o["rel_name"] = "overview";
			$tab_o["rel_name_id"] = $tab_o["rel_name"];
			$tab_o["table"] = $table;

		}
		elseif ($rec_part=="details") {

			$haystack = $foreign_k; //changes
			$needle = $record_id;

			$data_endpoint = "fetch_for_record/h/$haystack/n/$needle/foreign_key/$foreign_k";


			$tab_o["record_id"] = $record_id;
			$tab_o["data_endpoint"] = $data_endpoint;
			$tab_o["type"] = "sub_items"; // changes
			$tab_o["rel_name"] = $table." (as ".$foreign_k.")"; // changes
			$tab_o["rel_name_id"] = preg_replace('/\W+/','',strtolower(strip_tags($tab_o["rel_name"])));
			$tab_o["table"] = $table; // dynamic
			$tab_o["foreign_key"] = $foreign_k;

			// var_dump($parent_tab_o);
		}
		elseif ($rec_part=="table") {

			$data_endpoint = "fetch";


			// $tab_o["record_id"] = $record_id;
			$tab_o["data_endpoint"] = $data_endpoint;
			$tab_o["type"] = "table"; // changes
			$tab_o["rel_name"] = $table; // changes
			$tab_o["rel_name_id"] = preg_replace('/\W+/','',strtolower(strip_tags($tab_o["rel_name"])));
			$tab_o["table"] = $table; // dynamic
			// $tab_o["foreign_key"] = $foreign_k;

			// var_dump($parent_tab_o);
		}





		$editable = $erd[$table]["fields"];
		foreach ($editable as $key => $value) {
			$tab_d["cols"]["editable"][$key]["col_deets"] = $value;
			if ($key == $foreign_k) {
				$tab_d["cols"]["editable"][$key]["assumable"] = $record_id;
			}
		}


		if ($rec_part=="overview") {
			$cols_visible = $this->cols_visible($tab_o["table"], $erd, "");
		}
		elseif ($rec_part=="details") {
			$cols_visible = $this->cols_visible($tab_o["table"], $erd, $foreign_k);
			// $cols_visible = $this->cols_visible($tab_o["table"], $erd, "");
		}
		elseif ($rec_part=="table") {
			$cols_visible = $this->cols_visible($tab_o["table"], $erd, "");
		}

		// header('Content-Type: application/json');
		// echo json_encode($cols_visible, JSON_PRETTY_PRINT);
		// exit;


		$tab_d["cols"]["visible"] = array();

		$tab_d["cols"]["visible"] = $cols_visible["cols_o"];

		$cols_wth_props = array();
		foreach ($cols_visible["cols_d"] as $key => $value) {
			foreach ($value["cols"] as $key_2 => $value_2) {
				$cols_wth_props["$key - $key_2"] = $value_2;
			}
			$tab_d["cols"]["visible"] = array_merge(
				$tab_d["cols"]["visible"],
				$cols_wth_props
			);

			// $ignore_col_set
			if (isset($tab_d["cols"]["editable"][$value["linking_key"]])) {
				// code...
				$tab_d["cols"]["editable"][$value["linking_key"]]["rels"] = array(
					"table"=>$key,
					"rows"=>$value["cols"]
				);
				if ($table == $key) {
					$tab_d["cols"]["visible"] = array_merge(
						$tab_d["cols"]["visible"],
						array("$key - lineage" => "1")
					);
				}
			}
			// // $editable = $erd[$table]["fields"];
			// foreach ($editable as $key => $value) {
			// 	$tab_d["cols"]["editable"][$key]["col_deets"] = $value;
			// }
		}








		$result["tab_o"] = $tab_o;
		$result["tab_d"] = $tab_d;



		return $result;

	}

	public function insert($table)
	{

		$table = urldecode($table);

		$this->CI->load->database();

		// if ($this->CI->input->is_ajax_request()) {


		// $this->form_validation->set_rules('name', 'Name', 'required');
		// $this->form_validation->set_rules('event_children', 'Event_children');

		// if ($this->form_validation->run() == FALSE) {
		//   $data = array('responce' => 'error', 'message' => validation_errors());
		// } else {

		$post = $this->CI->input->post();

		unset($post[0]);
		$ajax_data = array();
		foreach ($post as $key => $value) {
			$ajax_data["`".urldecode($key)."`"] = "\"".$value."\"";
		}

		// $thing = json_encode($ajax_data, JSON_PRETTY_PRINT);
		// echo $thing;
		// exit;

		$this->CI->db->_protect_identifiers=false;
		if ($this->CI->db->insert("`".$table."`", $ajax_data)) {
			$data = array('responce' => 'success', 'message' => 'Record added Successfully');
		} else {
			$data = array('responce' => 'error', 'message' => 'Failed to add record');
		}
		$this->CI->db->_protect_identifiers=true;
		// }

		return $data;
		// } else {
		// 	return "No direct script access allowed";
		// }
	}

	public function delete($table)
	{

		$this->CI->load->database();

		// if ($this->CI->input->is_ajax_request()) {
		$del_id = $this->CI->input->post('del_id');

		if ($this->CI->db->delete($table, array('id' => $del_id))) {
			$data = array('responce' => 'success');
		} else {
			$data = array('responce' => 'error');
		}
		return $data;
		// } else {
		// 	return "No direct script access allowed";
		// }
	}

	public function update($table)
	{

		$table = urldecode($table);
		$this->CI->load->database();

		// if ($this->CI->input->is_ajax_request()) {
		//   $this->form_validation->set_rules('edit_name', 'Name', 'required');
		//   $this->form_validation->set_rules('edit_event_children', 'Event_children');
		//   if ($this->form_validation->run() == FALSE) {
		//     $data = array('responce' => 'error', 'message' => validation_errors());
		//   } else {

		$data['id'] = $this->CI->input->post('edit_record_id');

		$rows = $this->table_rows($table);
		foreach ($rows as $key => $value) {
			if ($key !== "id") {
				$data["`".urldecode($key)."`"] = "\"".$this->CI->input->post('edit_'.$this->makeSafeForCSS($key))."\"";
			}
		}


		$this->CI->db->_protect_identifiers=false;

		$query_result = $this->CI->db->update($table, $data, array('id' => $data['id']));

		$this->CI->db->_protect_identifiers=true;

		if ($query_result) {
			if (1==1) {

				$table_and_id = array(
					"table" => $table,
					"id" => $data['id']
				);
				$this->log_activity($table_and_id);
			}
			$data = array('responce' => 'success', 'message' => 'Record update Successfully');
			// $data = $this->CI->db->last_query();



		} else {
			$data = array('responce' => 'error', 'message' => 'Failed to update record');
		}
		return $data;


		//   }
		//   return $data;
		// } else {
		// 	return "No direct script access allowed";
		// }
	}

	public function log_activity($table_and_id)
	{

		// $query_result = $this->CI->db->last_row();// To get last record form the table
		// $row = $query_result->result()->id; // To print id of last record

		// if( $this->db->affected_rows() === FALSE ){die($this->db->last_query());}
		// $row = $this->CI->db->last_query()->id;
		// $row = $this->CI->db->affected_rows();
		// $row = $this->db->insert_id;


		$table = "_users_groups";
		$haystack = "user_id";
		$needle = $this->CI->ion_auth->get_user_id();
		$user_group_links = $this->fetch_where($table, $haystack, $needle)["posts"];
		$user_group = $user_group_links[0]["group_id"];

		$activity_log = array(
			"record_table_and_id" => $table_and_id["table"]."/".$table_and_id["id"],
			// "record_table" => $table_and_id["table"],
			// "record_id" => $table_and_id["id"],
			// "actvity_type" => "",
			"timestamp" => date("Y-m-d H:i:s"),
			"user_group" => $user_group
		);

		// header('Content-Type: application/json');
		// echo json_encode($activity_log, JSON_PRETTY_PRINT);
		// exit;


		$query_result = $this->CI->db->replace('_activity_log', $activity_log);

		// if ($query_result) {
		// 	$data = array('responce' => 'success', 'message' => 'Record update Successfully');
		// } else {
		// 	$data = array('responce' => 'error', 'message' => 'Failed to update record');
		// }
		// return $data;
	}

	public function owner_group_options()
	{

		$this->CI->load->database();


		$sql="WITH RECURSIVE q AS
		(
			SELECT  id,name,description,group_id,CONCAT(id) as path
			FROM    _groups
			WHERE   group_id = 0
			UNION ALL
			SELECT  m.id,m.name,m.description,m.group_id,CONCAT(q.path,'-',m.id) as path
			FROM    _groups m
			JOIN    q
			ON      m.group_id = q.id
		)
		SELECT  *
		FROM    q
		";


		$query_result = $this->CI->db->query($sql)->result_array();



		$table = "_users_groups";
		$haystack = "user_id";
		$needle = $this->CI->ion_auth->get_user_id();
		$user_group_links = $this->fetch_where($table, $haystack, $needle)["posts"];
		$user_group_ids = array_column($user_group_links, "group_id");


		$keys = array_column($query_result, 'path');
		$query_result=array_combine($keys,$query_result);
		ksort($query_result);




		$result = array();
		foreach ($query_result as $key => $item) {
			if (!empty(array_intersect($user_group_ids,explode("-",$key)))) {
				$result[$item["id"]] = array(
					"id"=>$item["id"],
					"name"=>$item["name"],
					"indent"=>str_repeat("-", count(explode("-",$key))-1),
					"path"=>$key,
				);
			}
		}



		// header('Content-Type: application/json');
		// echo json_encode($result, JSON_PRETTY_PRINT);
		// exit;

		return $result;

	}

	public function BookingsPerSupplierPerMonth($GET,$TourOperator)
	{
		// this is for product analysis


		$months[0] = $GET["MonthA"];
		$months[1] = $this->AddADay($GET["MonthB"]);
		$SmartServiceType = $this->FilterSmart($GET["ServiceType"],"All service types");
		$SmartTourOperator = $this->FilterSmartTourOperatorAgentOrSupplier($TourOperator);
		// $SmartServiceStatus = $this->FilterSmart($GET["ServiceStatus"],"All statuses");
		$SmartServiceStatus = $this->FilterSmartServiceStatus($GET["ServiceStatus"]);
		$SmartBookingStatus = $this->FilterSmartBookingStatus("Confirmed");


		$this->db->_protect_identifiers=false;

		$QueryAA = $this->db
		->select('DATE_FORMAT(pick_up_date, "%Y-%m") as date')
		->select('SUM(total_sell) AS Revenue')
		->select('SUM(total_cost) AS Cost')
		->select('SUM(total_sell)-SUM(total_cost) AS Profit')
		->select('COUNT(DISTINCT wbi.booking_id) as BookingCount')
		->select('supplier_id')
		->select('COUNT(DISTINCT wbi.id) as ServicelineCount')
		// ->select('wbi.status as wbi_status')
		->from('what_bookings_itineraries AS wbi')
		->join('`what_bookings_itineraries_costing` itcost', 'itcost.itinerary_id = wbi.id', 'inner')
		->join('`what_bookings` wb', 'wb.id = wbi.booking_id', 'inner')
		->where('pick_up_date BETWEEN "'.$months[0].' "AND "'.$months[1].'"')
		// ->where('service_type', 'car-rental')
		// $months
		->where('service_type '.$SmartServiceType['operator'], $SmartServiceType['term'])
		// ->where('wbi.status '.$SmartServiceStatus['operator'], $SmartServiceStatus['term'])
		->where_in("wbi.status",$SmartServiceStatus)
		->where_in("wb.booking_status",$SmartBookingStatus)
		->group_by('supplier_id')
		->_compile_select();
		$this->db->_reset_select();

		$QueryABA = $this->db
		->select('adults')
		->select('children')
		->select('infants')
		->select('supplier_id')
		->from('what_bookings_itineraries AS wbi')
		->join('`what_bookings_pax_config` wbcp', 'wbcp.booking_id = wbi.booking_id', 'inner')
		->join('`what_bookings` wb', 'wb.id = wbi.booking_id', 'inner')
		// ->where('DATE_FORMAT(pick_up_date, "%M %Y") =', $month)
		->where('pick_up_date BETWEEN "'.$months[0].' "AND "'.$months[1].'"')
		// ->where('service_type', 'car-rental')
		->where('service_type '.$SmartServiceType['operator'], $SmartServiceType['term'])
		// ->where('wbi.status '.$SmartServiceStatus['operator'], $SmartServiceStatus['term'])
		->where_in("wbi.status",$SmartServiceStatus)
		->where_in("wb.booking_status",$SmartBookingStatus)
		->group_by('wbi.booking_id')
		->group_by('supplier_id')
		->_compile_select();
		$this->db->_reset_select();



		$QueryAB = $this->db
		->select('SUM(adults) as adults')
		->select('SUM(children) as children')
		->select('SUM(infants) as infants')
		->select('supplier_id')
		->from('('.$QueryABA.') AS ABA')
		->group_by('supplier_id')
		->_compile_select();

		$this->db->_reset_select();



		$QueryA = $this->db
		->select('ititcost.date')
		->select('FORMAT(Revenue, 2) AS Revenue', false)
		->select('FORMAT(Cost, 2) AS Cost', false)
		->select('FORMAT(Profit, 2) AS MainValue', false)
		->select('BookingCount')
		->select('tp_code AS MainKey')
		->select('org_name')
		->select('ServicelineCount')
		->select('adults')
		->select('children')
		->select('infants')
		->select('ititcost.supplier_id')
		// ->select('ititcost.wbi_status')
		->from('('.$QueryAA.') AS ititcost')
		->join('('.$QueryAB.') AS SupplierMonthPax', 'SupplierMonthPax.supplier_id = ititcost.supplier_id', 'left')
		->join('`who_orgs_tp_crm_links` org', 'ititcost.supplier_id = org.org_id', 'inner')
		->join('`who_orgs` orgs_2', 'org.org_id = orgs_2.id', 'inner')
		->where('SUBSTRING(tp_code, 1,1) '.$SmartTourOperator['operator'].' '.$SmartTourOperator['term'])
		->order_by('tp_code', 'ASC')
		->_compile_select();
		$this->db->_reset_select();

		$this->db->_protect_identifiers=true;

		$result = $this->db->query($QueryA)->result_array();
		// $result = $QueryA;

		return $result;

	}



}
