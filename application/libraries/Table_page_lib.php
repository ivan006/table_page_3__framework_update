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
		$this->CI->load->library(
			'form_validation',
			'erd_lib',
			'input',
			'ion_auth',
			'session'
		);


	}

	// public function fetch_without_inheritance($table)
	// {
	//
	// 	$table = urldecode($table);
	// 	$this->CI->load->database();
	//
	//
	// 	// if ($this->CI->input->is_ajax_request()) {
	// 	// // if ($posts = $this->CI->db->get($table)->result()) {
	// 	// // 	$data = array('responce' => 'success', 'posts' => $posts);
	// 	// // }else{
	// 	// // 	$data = array('responce' => 'error', 'message' => 'Failed to fetch data');
	// 	// // }
	// 	// echo $table;
	//
	//
	// 	$this->CI->db->_protect_identifiers=false;
	// 	$posts = $this->CI->db->get("`".$table."`")->result();
	// 	$data = array('responce' => 'success', 'posts' => $posts);
	// 	$this->CI->db->_protect_identifiers=true;
	// 	return $data;
	//
	// 	// } else {
	// 	// 	return "No direct script access allowed";
	// 	// }
	//
	//
	//
	// }

	public function edit($table)
	{

		$this->CI->load->database();

		$table = urldecode($table);

		// if ($this->CI->input->is_ajax_request()) {
		$edit_id = $this->CI->input->post('edit_id');

		// edit me start 1
		// $this->CI->db->select("*");
		// $this->CI->db->from($table);
		// $this->CI->db->where("id", $edit_id);
		// $query = $this->CI->db->get();

		// edit me start 2

		if (1==1) {
			$erd_two_path = $this->CI->erd_lib->erd_path().'/erd.json';
			$erd_two = file_get_contents($erd_two_path);
			$erd_two = json_decode($erd_two, true);

			$fields = $erd_two[$table]["fields"];

			$this->CI->db->_protect_identifiers=false;


			$QueryA = "";
			$QueryA = $QueryA."SELECT
			`record_table_and_id`,
			`timestamp`,
			`owner`,
			`editability`,
			`visibility`,";

			$iteration = 0;
			foreach ($fields as $field_key => $field_value) {
				if ($iteration > 0) {
					$QueryA = $QueryA.",";
				}
				$QueryA = $QueryA." `$table`.`$field_key`";
				$iteration = $iteration+1;
			}

			$QueryA = $QueryA." FROM `_activity_log` as `_activity_log`
			RIGHT JOIN (SELECT * FROM `$table` WHERE `id` = '$edit_id')
			AS `$table` ON `_activity_log`.`record_table_and_id` = CONCAT('$table', '/', `$table`.id)";

			$query = $this->CI->db->query($QueryA);

			$this->CI->db->_protect_identifiers=true;
		}

		// edit me end
		$post = null;
		if (count($query->result()) > 0) {
			$variables = (array) $query->row();
			// unset();
			// var_dump($variables);
			unset($variables["record_table_and_id"]);
			unset($variables["owner"]);
			unset($variables["editability"]);
			unset($variables["visibility"]);
			unset($variables["timestamp"]);
			$post["variables"] = $variables;
			$post["permissions"] = array(
				"permissions_owner" => $query->row()->owner,
				"permissions_editability" => $query->row()->editability,
				"permissions_visibility" => $query->row()->visibility,
			);
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

		// $this->CI->load->database();
		//
		//
		// $row_query = array(
		// "SHOW COLUMNS FROM `$table`",
		// );
		// $row_query = implode(" ", $row_query);
		// $rows = $this->CI->db->query($row_query)->result_array();
		// $rows = array_column($rows, 'Field');

		if (!file_exists($this->CI->erd_lib->erd_path()."/crud_cache/$table.txt")) {
			return array();
		}
		$data = file_get_contents($this->CI->erd_lib->erd_path()."/crud_cache/$table.txt");
		$data = json_decode($data, true);

		$result = array();
		foreach ($data["g_core_abilities"]["g_select"]["editable"] as $key => $value) {
			$result[$key] = array();
		}
		// header('Content-Type: application/json');
		// echo json_encode($result, JSON_PRETTY_PRINT);
		// exit;



		return $result;
	}

	// public function fetch_for_record($table, $haystack, $needle, $child_of)
	public function fetch($table, $page_type, $where, $groups)
	{
		$table = urldecode($table);

		$this->CI->load->database();

		// $posts = $this->CI->db->where($where["haystack"], $where["needle"])->get($table)->result_array();

		$erd_path = $this->CI->erd_lib->erd_path().'/erd.json';
		$erd = file_get_contents($erd_path);
		$erd = json_decode($erd, true);

		if ($page_type == "record") {
			$where["haystack_type"] = urldecode($where["haystack_type"]);
			if ($where["haystack_type"] == "foreign_key") {
				$foreign_key = $where["haystack"];
			} else {
				$foreign_key = null;
			}
			$cols_visible = $this->precalculated_columns(
				$table,
				$erd,
				$foreign_key
			);
			// $cols_visible = $this->precalculated_columns($table, $erd, "");
		}
		elseif ($page_type == "table") {
			$cols_visible = $this->precalculated_columns($table, $erd, null);
		}

		// header('Content-Type: application/json');
		// echo json_encode($cols_visible, JSON_PRETTY_PRINT);
		// exit;






		$this->CI->db->_protect_identifiers=false;
		$query = $this->CI->db;


		if ("old"=="old") {
			// code...
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
				if (isset($value["is_self_joined"])) {
					// $g_select["visible"] = array_merge(
					// 	$g_select["visible"],
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

				if (isset($value["is_self_joined"])) {
					$linking_key = $value["linking_key"];
					$sql="WITH RECURSIVE q AS (
					SELECT  id,`$linking_key`, CONCAT('0-', id) as path
					FROM    $key
					WHERE   `$linking_key` = 0
					UNION ALL
					SELECT  m.id,m.`$linking_key`, CONCAT(q.path, '-', m.id) as path
					FROM    $key m
					JOIN    q
					ON      m.`$linking_key` = q.id)
					SELECT  *
					FROM    q";
					$query = $query->join("(".$sql.") as `joining_table_".$key."_lineage`", "`".$table."`".'.'."`$linking_key`".' = '."`joining_table_".$key."_lineage`".'.id', 'left');
				}
			}
			$query = $query->join("`_activity_log`", "`_activity_log`.`record_table_and_id` = CONCAT('$table', '/', `$table`.id)", 'left');

			// echo json_encode($groups);
			// exit;
			$query = $query->group_start();
			// $query = $query->or_where("`_activity_log`.`owner` =", "0");

			$query = $query->where("`_activity_log`.`editability` =", "'pu'");
			$query = $query->or_where("`_activity_log`.`visibility` =", "'pu'");
			$query = $query->or_where("`_activity_log`.`editability` IS", "NULL");
			$query = $query->or_where("`_activity_log`.`visibility` IS", "NULL");
			$query = $query->or_where("`_activity_log`.`owner` =", "2");
			if (!empty($groups)) {
				// code...
				$query = $query->or_where_in("`_activity_log`.`owner`", $groups);
			}
			$query = $query->group_end();
			// $query = $query->or_where_in("`_activity_log`.`editability`", array("'Public'", "''"));
			// $query = $query->or_where_in("`_activity_log`.`visibility`", array("'Public'", "''"));

			if ($page_type == "record") {
				$where["haystack"] = urldecode($where["haystack"]);

				// echo "`".$table."`"."."."`".$where["haystack"]."` =". '"'.$where["needle"].'"';
				// exit;
				$query = $query->where("`".$table."`"."."."`".$where["haystack"]."` =", '"'.$where["needle"].'"');
			}
			elseif ($page_type == "table") {
			}



			// $sql = $query->_compile_select();
			// echo $sql;
			// exit;
			$query = $query->get();

		}



		$posts = $query;
		$posts = $posts->result_array();

		// print_r($this->CI->db->last_query());
		// exit;


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
	// 	$table_2_singular = $this->CI->erd_lib->grammar_singular($table_2);
	// 	$table_2_singular = $table_2_singular."_id";
	// 	// $table_1_singular = $this->CI->erd_lib->grammar_singular($table_1);
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
		$erd_path = $this->CI->erd_lib->erd_path().'/erd.json';
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

	public function precalculated_columns($table, $erd, $foreign_key)
	{
		$parents = array();

		foreach ($erd as $key => $value) {
			if (isset($value["items"])) {
				foreach ($value["items"] as $key_2 => $value_2) {
					if ($key_2 == $table) {

						if ($value_2 !== $foreign_key) { // dont inherit values for current parent
							// echo $key_2;
							$parents[$key]["cols"] = $value["fields"];
							$parents[$key]["linking_key"] = $value_2;
							if (isset($value["items"][$key])) {
								$parents[$key]["is_self_joined"] = 1;
							}
						}
					}
				}
			}
		}

		$self = $erd[$table]["fields"];

		foreach ($parents as $key => $value) {
			foreach ($erd[$key]["items"] as $key_2 => $value_2) {
				unset($self[$value_2]);
			}
		}

		if (isset($self[$foreign_key])) {
			unset($self[$foreign_key]);
		}

		$cols_visible = array(
			"cols_o" => $self,
			"cols_d" => $parents
		);

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

	public function precalculated_relatives($rec_part, $erd, $table, $foreign_k)
	{


		if ($rec_part=="overview") {

			$g_identity["g_ability_name"] = $table;
			$g_identity["g_ability_html_id"] = preg_replace('/\W+/','',strtolower(strip_tags($g_identity["g_ability_name"])));
			$g_identity["g_from"] = $table;

			$haystack = "id";
			$g_identity["g_where_haystack"] = $haystack;
			// $g_identity["g_where_haystack_type"] = "primary_key";
			$g_identity["g_where_haystack_type"] = "foreign_key";

			$data_endpoint = "fetch_for_record/h_type/primary_key/h/$haystack/n/";
			$g_identity["data_endpoint"] = $data_endpoint;

		}
		elseif ($rec_part=="details") {

			$g_identity["g_ability_name"] = $table." (as ".$foreign_k.")"; // changes
			$g_identity["g_ability_html_id"] = preg_replace('/\W+/','',strtolower(strip_tags($g_identity["g_ability_name"])));
			$g_identity["g_from"] = $table; // dynamic

			$haystack = $foreign_k; //changes
			$g_identity["g_where_haystack"] = $foreign_k;
			$g_identity["g_where_haystack_type"] = "foreign_key";

			$data_endpoint = "fetch_for_record/h_type/foreign_key/h/$haystack/n/";
			$g_identity["data_endpoint"] = $data_endpoint;
		}
		elseif ($rec_part=="table") {

			$g_identity["g_ability_name"] = $table; // changes
			$g_identity["g_ability_html_id"] = preg_replace('/\W+/','',strtolower(strip_tags($g_identity["g_ability_name"])));
			$g_identity["g_from"] = $table; // dynamic

			$data_endpoint = "fetch";
			$g_identity["data_endpoint"] = $data_endpoint;
		}

		$editable = $erd[$table]["fields"];
		foreach ($editable as $key => $value) {
			$g_select["editable"][$key]["col_deets"] = $value;
			if ($key == $foreign_k) {
				$g_select["editable"][$key]["assumable"] = "";
			}
		}




		$result["g_identity"] = $g_identity;
		if ($rec_part=="overview") {
			$cols_visible = $this->precalculated_columns($g_identity["g_from"], $erd, "");}
		elseif ($rec_part=="details") {
			$cols_visible = $this->precalculated_columns($g_identity["g_from"], $erd, $foreign_k);
		}

		if ($rec_part=="overview") {
		// if (1==1) {

			$g_select["visible"] = array();

			$g_select["visible"] = $cols_visible["cols_o"];

			$cols_wth_props = array();

			foreach ($cols_visible["cols_d"] as $key => $value) {

				// header('Content-Type: application/json');
				// echo json_encode($value, JSON_PRETTY_PRINT);
				// exit;
				foreach ($value["cols"] as $key_2 => $value_2) {
					if (isset($value_2["important_field"])) {
						// code...
						$cols_wth_props["$key - $key_2"] = $value_2;
					}
				}
				$g_select["visible"] = array_merge(
					$g_select["visible"],
					$cols_wth_props
				);

				if (isset($g_select["editable"][$value["linking_key"]])) {
					if (isset($value["is_self_joined"])) {
						$g_select["visible"] = array("$key - lineage" => "") + $g_select["visible"];
					}
				}
			}

			foreach ($cols_visible["cols_d"] as $key => $value) {
				if (isset($g_select["editable"][$value["linking_key"]])) {
					// code...
					$cols_visible_lookup_helper = $this->precalculated_columns($key, $erd, "");
					$cols_visible_lookup = $cols_visible_lookup_helper["cols_o"];
					$cols_visible_lookup_part_2 = array();
					foreach ($cols_visible_lookup_helper["cols_d"] as $key_lookup => $value_lookup) {
						foreach ($value_lookup["cols"] as $key_lookup_2 => $value_lookup_2) {
							$cols_visible_lookup_part_2["$key_lookup - $key_lookup_2"] = $value_lookup_2;
						}
						$cols_visible_lookup = array_merge(
							$cols_visible_lookup,
							$cols_visible_lookup_part_2
						);

						if (isset($value_lookup["is_self_joined"])) {
							$cols_visible_lookup = array("$key_lookup - lineage" => "") + $cols_visible_lookup;
						}

					}

					$g_select["editable"][$value["linking_key"]]["rels"] = array(
						"table"=>$key,
						"rows"=>$cols_visible_lookup
					);
				}
			}
			$result["g_select"] = $g_select;

		}

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


		// unset($post["variables"][0]);
		if ("old" == "old2") {
			$ajax_data = array();
			foreach ($post["variables"] as $key => $value) {

				$ajax_data["`".urldecode($key)."`"] = '"'.$value.'"';
			}
			// zzzzzzzzzzzzzz

		} else {
			// code...
			$ajax_data = array();
			$rows = $this->table_rows($table);
			foreach ($rows as $key => $value) {
				if ($key !== "id") {
					// $ajax_data["`".urldecode($key)."`"] = "\"".$this->CI->input->post('edit_'.$this->makeSafeForCSS($key))."\"";
					$ajax_data["`".urldecode($key)."`"] = '"'.$post["variables"][$this->makeSafeForCSS($key)].'"';

				}
			}
		}
		// header('Content-Type: application/json');
		// echo json_encode($ajax_data, JSON_PRETTY_PRINT);
		// exit;





		$this->CI->db->_protect_identifiers=false;

		$query_result = $this->CI->db->insert("`$table`", $ajax_data);
		$this->CI->db->_protect_identifiers=true;

		if ($query_result) {

			if (1==1) {

				$insert_id = $this->CI->db->insert_id();
				// $insert_id = 10000;
				$table_and_id = array(
					"table" => $table,
					"id" => $insert_id
				);



				$this->CI->input->post('edit_permissions_owner');
				$this->CI->input->post('edit_permissions_owner');

				$permissions = array();
				$permissions["owner"] = $post["permissions"]["edit_permissions_owner"];
				if ($post["permissions"]["edit_permissions_editability"] == "") {
					$permissions["editability"] = "pr";
				} else {
					$permissions["editability"] = $post["permissions"]["edit_permissions_editability"];
				}
				if ($post["permissions"]["edit_permissions_visibility"] == "") {
					$permissions["visibility"] = "pr";
				} else {
					$permissions["visibility"] = $post["permissions"]["edit_permissions_visibility"];
				}


				$this->log_activity($table_and_id, $permissions, "insert");
			}

			$data = array('responce' => 'success', 'message' => 'Record added Successfully');
		} else {
			$data = array('responce' => 'error', 'message' => 'Failed to add record');
		}
		// }

		return $data;
		// } else {
		// 	return "No direct script access allowed";
		// }
	}

	public function delete($table)
	{

		$this->CI->load->database();

		$this->CI->db->_protect_identifiers=false;
		// if ($this->CI->input->is_ajax_request()) {
		$del_id = $this->CI->input->post('del_id');

		if ($this->CI->db->delete("`$table`", array('id' => $del_id))) {
			if (1==1) {


				$table_and_id = array(
					"table" => $table,
					"id" => $del_id
				);



				$this->CI->input->post('edit_permissions_owner');
				$this->CI->input->post('edit_permissions_owner');



				$permissions = array();
				// $permissions["owner"] = $post["permissions"]["edit_permissions_owner"];
				// if ($post["permissions"]["edit_permissions_editability"] == "") {
				// 	$permissions["editability"] = "pr";
				// } else {
				// 	$permissions["editability"] = $post["permissions"]["edit_permissions_editability"];
				// }
				// if ($post["permissions"]["edit_permissions_visibility"] == "") {
				// 	$permissions["visibility"] = "pr";
				// } else {
				// 	$permissions["visibility"] = $post["permissions"]["edit_permissions_visibility"];
				// }

				$this->log_activity($table_and_id, $permissions, "delete");
			}


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
		// header('Content-Type: application/json');
		// echo json_encode($post = $this->CI->input->post(), JSON_PRETTY_PRINT);
		// exit;

		$table = urldecode($table);
		$this->CI->load->database();

		// if ($this->CI->input->is_ajax_request()) {
		//   $this->form_validation->set_rules('edit_name', 'Name', 'required');
		//   $this->form_validation->set_rules('edit_event_children', 'Event_children');
		//   if ($this->form_validation->run() == FALSE) {
		//     $ajax_data = array('responce' => 'error', 'message' => validation_errors());
		//   } else {


		$post = $this->CI->input->post();

		$ajax_data['id'] = $post["variables"]["edit_record_id"];

		$rows = $this->table_rows($table);
		foreach ($rows as $key => $value) {
			if ($key !== "id") {
				// $ajax_data["`".urldecode($key)."`"] = "\"".$this->CI->input->post('edit_'.$this->makeSafeForCSS($key))."\"";
				$ajax_data["`".urldecode($key)."`"] = '"'.$post["variables"]['edit_'.$this->makeSafeForCSS($key)].'"';

			}
		}

		// zzzzzzzzzzzzzz
		// header('Content-Type: application/json');
		// echo json_encode($ajax_data, JSON_PRETTY_PRINT);
		// exit;
		$this->CI->db->_protect_identifiers=false;

		$query_result = $this->CI->db->update("`$table`", $ajax_data, array('id' => $ajax_data['id']));

		$this->CI->db->_protect_identifiers=true;

		if ($query_result) {

			if (1==1) {

				$table_and_id = array(
					"table" => $table,
					"id" => $ajax_data['id']
				);



				$this->CI->input->post('edit_permissions_owner');
				$this->CI->input->post('edit_permissions_owner');


				$permissions = array();
				$permissions["owner"] = $post["permissions"]["edit_permissions_owner"];
				if ($post["permissions"]["edit_permissions_editability"] == "") {
					$permissions["editability"] = "pr";
				} else {
					$permissions["editability"] = $post["permissions"]["edit_permissions_editability"];
				}
				if ($post["permissions"]["edit_permissions_visibility"] == "") {
					$permissions["visibility"] = "pr";
				} else {
					$permissions["visibility"] = $post["permissions"]["edit_permissions_visibility"];
				}

				$this->log_activity($table_and_id, $permissions, "update");
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

	public function log_activity($table_and_id, $permissions, $last_activity_type)
	{

		$this->CI->db->_protect_identifiers=false;
		// $table = "_groups";
		// $haystack = "user_id";
		// $needle = $this->CI->ion_auth->get_user_id();
		// $user_group_links = $this->fetch_where($table, $haystack, $needle)["posts"];
		// $user_group = $user_group_links[0]["group_id"];

		$activity_log = array(
			"record_table_and_id" => $table_and_id["table"]."/".$table_and_id["id"],
			// "record_table" => $table_and_id["table"],
			// "record_id" => $table_and_id["id"],
			// "actvity_type" => "",
			"timestamp" => date("Y-m-d H:i:s"),
			"last_activity_type" => $last_activity_type,
			// "owner" => $permissions["owner"],
			// "editability" => $permissions["editability"],
			// "visibility" => $permissions["visibility"]
		);


		if (!empty($permissions)) {
			// code...
			$activity_log["owner"] = $permissions["owner"];
			$activity_log["editability"] = $permissions["editability"];
			$activity_log["visibility"] = $permissions["visibility"];

		}

		if ($table_and_id["table"] == "groups") {
			$activity_log["owner"] = $table_and_id["id"];
		}

		// header('Content-Type: application/json');
		// echo json_encode($activity_log, JSON_PRETTY_PRINT);
		// exit;


		// $query_result = $this->CI->db->replace('_activity_log', $activity_log);

		$activity_log_2 = array();
		foreach ($activity_log as $key => $value) {
			if ($key !== "id") {
				$activity_log_2["`".$key."`"] = '"'.$value.'"';

			}
		}

		// echo json_encode($permissions, JSON_PRETTY_PRINT);
		// exit;
		$_activity_log = $this->CI->db->select('*')->where('`record_table_and_id`', '"'.$table_and_id["table"]."/".$table_and_id["id"].'"')->from('_activity_log')->get()->result_array();
		if (empty($_activity_log)) {
			$query_result = $this->CI->db->insert(
				'_activity_log',
				$activity_log_2,
			);

		} else {
			$query_result = $this->CI->db->update(
				'_activity_log',
				$activity_log_2,
				array('`record_table_and_id`' => '"'.$table_and_id["table"]."/".$table_and_id["id"].'"')
			);
		}

		$this->CI->db->_protect_identifiers=true;
	}

	public function user_groups()
	{


		$this->CI->load->database();


		// $this->db->from('table')
		// ->join('SELECT id from table2 where something=%s) as T2'),'table.id=T2.id', 'LEFT',NULL)
		// ->get()->row();
		//
		// $result = $query_run->get('user_messages');
		// //echo $this->db->last_query();
		// return $result->row();

		$sql="WITH RECURSIVE q AS
		(
			SELECT  id,name,description,group_id,CONCAT(id) as path
			FROM    groups
			WHERE   group_id = 0
			UNION ALL
			SELECT  m.id,m.name,m.description,m.group_id,CONCAT(q.path,'-',m.id) as path
			FROM    groups m
			JOIN    q
			ON      m.group_id = q.id
			)
			SELECT  *
			FROM    q
		";

		$query_result = $this->CI->db->query($sql)->result_array();

		// chaneg to $config['tables']['users_groups'] ?
		$table = "users_groups";
		$haystack = "user_id";
		$needle = $this->CI->ion_auth->get_user_id();
		$user_group_links = $this->fetch_where($table, $haystack, $needle)["posts"];

		$user_group_ids = array_column($user_group_links, "group_id");

		$result = array();
		foreach ($query_result as $key => $value) {
			$matches = array_intersect($user_group_ids,explode("-",$value["path"]));
			if (!empty($matches)) {
				$result[$key] = $value;
			}
		}
		return $result;

	}

	public function user_groups_for_dropdown()
	{


		$user_groups = $this->user_groups();

		$keys = array_column($user_groups, 'path');
		$user_groups=array_combine($keys,$user_groups);
		ksort($user_groups);
		// header('Content-Type: application/json');
		// echo json_encode($query_result, JSON_PRETTY_PRINT);
		// exit;



		$result = array();
		foreach ($user_groups as $key => $value) {
			$result[$value["id"]] = array(
				"id"=>$value["id"],
				"name"=>$value["name"],
				"indent"=>str_repeat("-", count(explode("-",$value["path"]))-1),
				"path"=>$key,
			);
		}

		// header('Content-Type: application/json');
		// echo json_encode($result, JSON_PRETTY_PRINT);
		// exit;




		return $result;

	}





	public function precalculated_table($table)
	{
		$table = urldecode($table);
		$g_identity_singular = $this->CI->erd_lib->grammar_singular($table);

		$data = array();
		$data["table_name"] = $table;
		$data["table_name_singular"] = $g_identity_singular;

		$tables_in_db = $this->CI->erd_lib->tables_in_db();

		if (isset($tables_in_db[$table])) {
			$data["table_exists"] = 1;
		} else {

			$data["table_exists"] = 0;
		}

		$erd_path = $this->CI->erd_lib->erd_path().'/erd.json';
		$erd = file_get_contents($erd_path);
		$erd = json_decode($erd, true);

		if (isset($erd[$table]["record_links"])) {
			$data["record_links"] = $erd[$table]["record_links"];
		}
		if (isset($erd[$table]["table_links"])) {
			$data["table_links"] = $erd[$table]["table_links"];
		}

		$g_core_abilities = $this->precalculated_relatives("overview", $erd, $table, null, "");

		$g_parental_abilities = array();
		if (isset($erd[$table]["items"])) {
			$items = $erd[$table]["items"];
			foreach ($items as $key => $value) {
				$g_parental_abilities[$key] = $this->precalculated_relatives("details", $erd, $key, $value, $table);

			}
		}

		$data["g_core_abilities"] = $g_core_abilities;
		$data["g_parental_abilities"] = $g_parental_abilities;

		return $data;
	}

	public function postcalculated_table_for_record($table, $record_id)
	{

		if (file_exists($this->CI->erd_lib->erd_path()."/crud_cache/$table.txt")) {
			$data = file_get_contents($this->CI->erd_lib->erd_path()."/crud_cache/$table.txt");
			$data = json_decode($data, true);
			$data["record_id"] = $record_id;
			$data["title"] = $data["table_name_singular"]." ".$record_id;
			$data["g_core_abilities"]["g_identity"]["g_where_needle"] = $record_id;
			$new_endpoint = $data["g_core_abilities"]["g_identity"]["data_endpoint"].$record_id;
			$data["g_core_abilities"]["g_identity"]["data_endpoint"] = $new_endpoint;
			$data["g_core_abilities"]["g_identity"]["g_ability_name"] = "overview";
			$data["g_core_abilities"]["g_identity"]["g_ability_html_id"] = "overview";

			foreach ($data["g_parental_abilities"] as $key => $value) {
				$iteration_result = $data["g_parental_abilities"][$key];

				$iteration_result["g_identity"]["g_where_needle"] = $record_id;

				$new_endpoint = $iteration_result["g_identity"]["data_endpoint"].$record_id;
				$iteration_result["g_identity"]["data_endpoint"] = $new_endpoint;

				$relation = file_get_contents($this->CI->erd_lib->erd_path()."/crud_cache/$key.txt");
				$relation = json_decode($relation, true);
				$relation = $relation["g_core_abilities"]["g_select"];

				$g_where_haystack = $value["g_identity"]["g_where_haystack"];
				unset($relation["editable"][$g_where_haystack]["rels"]);
				// foreach ($relation["editable"] as $relation_key => $relation_value) {
				// 	unset($relation["editable"])
				// }


				// $table_name = $data["table_name"];
				$self_editable_cols = $data["g_core_abilities"]["g_select"]["editable"];
				foreach ($self_editable_cols as $self_editable_col_key => $self_editable_col_value) {
					if (isset($relation["visible"]["$table - $self_editable_col_key"])) {

						unset($relation["visible"]["$table - $self_editable_col_key"]);
					}
				}
				// header('Content-Type: application/json');
				// echo json_encode($data["g_core_abilities"]["g_select"], JSON_PRETTY_PRINT);
				// exit;
				$iteration_result["g_select"] = $relation;

				$g_where_haystack = $iteration_result["g_identity"]["g_where_haystack"];

				$iteration_result["g_select"]["editable"][$g_where_haystack]["assumable"] = $record_id;
				$iteration_result["g_select"]["editable"][$g_where_haystack]["assumable"] = $record_id;


				$data["g_parental_abilities"][$key] = $iteration_result;
			}

			return $data;
		} else {
			return array();
			// code...
		}


	}



	public function postcalculated_table_for_table($table)
	{
		if (file_exists($this->CI->erd_lib->erd_path()."/crud_cache/$table.txt")) {
			$data = file_get_contents($this->CI->erd_lib->erd_path()."/crud_cache/$table.txt");
			$data = json_decode($data, true);
			$data["title"] = $data["table_name"];
			$data["g_core_abilities"]["g_identity"]["data_endpoint"] = "fetch";

			unset($data["g_parental_abilities"]);

			return $data;
		} else {
			return array();
			// code...
		}


	}





}
