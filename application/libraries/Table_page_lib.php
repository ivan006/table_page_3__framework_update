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


		// if ($this->CI->input->is_ajax_request()) {
		$edit_id = $this->CI->input->post('edit_id');

		// edit me start 1
		// $this->CI->db->select("*");
		// $this->CI->db->from($table);
		// $this->CI->db->where("id", $edit_id);
		// $query = $this->CI->db->get();

		// edit me start 2

		if (1==1) {
			$erd_two_path = APPPATH.'erd/active/erd.json';
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

			$QueryA = $QueryA."FROM `_activity_log` as `_activity_log`
			RIGHT JOIN (SELECT * FROM $table WHERE `id` = '$edit_id')
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
	public function fetch($table, $page_type, $where)
	{
		$table = urldecode($table);

		$this->CI->load->database();

		// $posts = $this->CI->db->where($where["haystack"], $where["needle"])->get($table)->result_array();

		$erd_path = APPPATH.'erd/active/erd.json';
		$erd = file_get_contents($erd_path);
		$erd = json_decode($erd, true);

		if ($page_type == "record") {
			$where["haystack_type"] = urldecode($where["haystack_type"]);
			if ($where["haystack_type"] == "foreign_key") {
				$foreign_key = $where["haystack"];
			} else {
				$foreign_key = null;
			}
			$cols_visible = $this->cols_visible(
				$table,
				$erd,
				$foreign_key
			);
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
						$sql="WITH RECURSIVE q AS
						(
							SELECT  id,`$linking_key`, CONCAT('0-', id) as path
							FROM    $key
							WHERE   `$linking_key` = 0
							UNION ALL
							SELECT  m.id,m.`$linking_key`, CONCAT(q.path, '-', m.id) as path
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
					$where["haystack"] = urldecode($where["haystack"]);
					$query = $query->where("`".$table."`"."."."`".$where["haystack"]."` =", $where["needle"]);
				}
				elseif ($page_type == "table") {
				}
				$sql = $query->_compile_select();

				// SELECT CONCAT('View') as `id`, `objects`.`id`, `objects`.`name`, CONCAT('View') as `objects - id`, `joining_table_objects`.`name` as `objects - name`, `joining_table_objects`.`object id` as `objects - object id`, `joining_table_objects_lineage`.path as `objects - lineage` FROM `objects` LEFT JOIN `objects` as `joining_table_objects` ON `objects`.`object id` = `joining_table_objects`.id LEFT JOIN (WITH RECURSIVE q AS ( SELECT id,`object id`, CONCAT('0-', id) as path FROM objects WHERE `object id` = 0 UNION ALL SELECT m.id,m.`object id`, CONCAT(q.path, '-', m.id) as path FROM objects m JOIN q ON m.`object id` = q.id ) SELECT * FROM q ) as `joining_table_objects_lineage` ON `objects`.`object id` = `joining_table_objects_lineage`.id
			}


			if ("new"=="new1") {
				// code...




				$parent_link_part_1 = '<a href="/record/t/'.$table.'/r/';
				$parent_link_part_2 = '" class="btn btn-sm btn-outline-primary">View</a>';

				$sql = "";
				$sql = $sql."";
				$sql = $sql."SELECT ";
				$sql = $sql."CONCAT('$parent_link_part_1', `$table`.id, '$parent_link_part_2') as `id`";

				foreach ($cols_visible["cols_o"] as $key => $value) {
					if ($key !== "id") {
						// code...
					}
					$sql = $sql.", `$table`.`$key`";
				}
				foreach ($cols_visible["cols_d"] as $key => $value) {
					// if ($key !== $table) {
					foreach ($value["cols"] as $key_2 => $value_2) {
						if ($key_2 == "id") {
							$parent_link_part_1 = '<a href="/record/t/'.$key.'/r/';
							$parent_link_part_2 = '" class="btn btn-sm btn-outline-primary">View</a>';


							$sql = $sql.", CONCAT('$parent_link_part_1', `joining_table_$key`.id, '$parent_link_part_2') as `$key - $key_2`";
						} else {
							$sql = $sql.", `joining_table_$key`.`$key_2` as `$key - $key_2`";
						}


					}
					if (isset($value["is_self_joined"])) {
						// $g_select["visible"] = array_merge(
						// 	$g_select["visible"],
						// 	array("$key - lineage" => "1")
						// );
						$sql = $sql.", `joining_table_".$key."_lineage`.path as `$key - lineage`";
					}
					// }
				}
				$sql = $sql." FROM `$table`";

				foreach ($cols_visible["cols_d"] as $key => $value) {
					// echo "xyz";
					// if ($key !== $table) {

					$sql = $sql." LEFT JOIN `$key` as `joining_table_$key` ON `$table`.`".$value["linking_key"]."` = `joining_table_$key`.id ";
					// }

					if (isset($value["is_self_joined"])) {
						$linking_key = $value["linking_key"];
						$sql2="WITH RECURSIVE q AS
						(
							SELECT  id,`$linking_key`, CONCAT('0-', id) as path
							FROM    $key
							WHERE   `$linking_key` = 0
							UNION ALL
							SELECT  m.id,m.`$linking_key`, CONCAT(q.path, '-', m.id) as path
							FROM    $key m
							JOIN    q
							ON      m.`$linking_key` = q.id
							)
							SELECT  *
							FROM    q
							";

							$sql = $sql."LEFT JOIN ($sql2) as `joining_table_".$key."_lineage` ON `$table`.`$linking_key` = `joining_table_".$key."_lineage`.id";
						}
					}

					if ($page_type == "record") {
						$where["haystack"] = urldecode($where["haystack"]);
						$sql = $sql." WHERE   `$table`.`".$where["haystack"]."` = ".$where["needle"]."";

					}
					elseif ($page_type == "table") {
					}

					// SELECT CONCAT('View') as `id`, SELECT `objects`.`id`, SELECT `objects`.`name`, SELECT CONCAT('View') as `objects - id`, SELECT `joining_table_objects`.`name` as `objects - name`, SELECT `joining_table_objects`.`object id` as `objects - object id`, SELECT `joining_table_objects_lineage`.path as `objects - lineage`, FROM `objects`LEFT JOIN `objects` as `joining_table_objects` ON `objects`.``object id`` = `joining_table_objects`.idLEFT JOIN (WITH RECURSIVE q AS ( SELECT id,`object id`, CONCAT('0-', id) as path FROM objects WHERE `object id` = 0 UNION ALL SELECT m.id,m.`object id`, CONCAT(q.path, '-', m.id) as path FROM objects m JOIN q ON m.`object id` = q.id ) SELECT * FROM q ) as `joining_table_objects_lineage` ON `objects`.`object id` = `joining_table_objects_lineage`.id
			}



			// echo json_encode($sql, JSON_PRETTY_PRINT);
			// echo "<textarea>";
			// echo $query;

			// header('Content-Type: application/json');
			// echo $sql;
			// exit;
			$query = $this->CI->db->query($query);
			// blue.bluegemify.co.za


			// SELECT CONCAT('<a href=\"/record/t/objects/r/', `objects`.id, '\" class=\"btn btn-sm btn-outline-primary\">View</a>') as `id`, `objects`.`id`, `objects`.`name`, CONCAT('<a href=\"/record/t/objects/r/', `joining_table_objects`.id, '\" class=\"btn btn-sm btn-outline-primary\">View</a>') as `objects - id`, `joining_table_objects`.`name` as `objects - name`, `joining_table_objects`.`object id` as `objects - object id`, `joining_table_objects_lineage`.path as `objects - lineage`
			// FROM `objects`
			// LEFT JOIN `objects` as `joining_table_objects` ON `objects`.`object id` = `joining_table_objects`.id
			// LEFT JOIN (WITH RECURSIVE q AS
			// 					(
			// 						SELECT  id,`object id`, CONCAT('0-', id) as path
			// 						FROM    objects
			// 						WHERE   `object id` = 0
			// 						UNION ALL
			// 						SELECT  m.id,m.`object id`, CONCAT(q.path, '-', m.id) as path
			// 						FROM    objects m
			// 						JOIN    q
			// 						ON      m.`object id` = q.id
			// 					)
			// 					SELECT  *
			// 					FROM    q
			// 					) as `joining_table_objects_lineage` ON `objects`.`object id` = `joining_table_objects_lineage`.id



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
			$posts = $query;
			// $posts = $posts->get();
			$posts = $posts->result_array();
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
		$erd_path = APPPATH.'erd/active/erd.json';
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
		// $erd_path = APPPATH.'erd/active/erd.json';
		// $erd = file_get_contents($erd_path);
		// $erd = json_decode($erd, true);

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
			// 		// $rel[$key]["g_from"] = $key;
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

	public function abilities_cache_ability($rec_part, $erd, $table, $foreign_k, $ignore_col_set, $dont_scan)
	{
		// if (!$this->ion_auth->logged_in())
		// {
		// 	// redirect them to the login page
		// 	redirect('auth/login', 'refresh');
		// }
		if ($rec_part=="overview") {

			// $g_identity["type"] = "overview";
			$g_identity["g_ability_name"] = $table;
			$g_identity["g_ability_html_id"] = preg_replace('/\W+/','',strtolower(strip_tags($g_identity["g_ability_name"])));
			$g_identity["g_from"] = $table;
			$g_identity["g_where_haystack_type"] = "primary_key";

			$haystack = "id";
			// $needle = $record_id;


			$g_identity["g_where_haystack"] = $haystack;

			$g_identity["g_where_haystack_type"] = "foreign_key";
			// $g_identity["g_where_needle"] = $needle;

			$g_identity["data_endpoint"] = "fetch_for_record/h_type/primary_key/h/$haystack/n/";

		}
		elseif ($rec_part=="details") {

			$haystack = $foreign_k; //changes
			// $needle = $record_id;



			// $g_identity["type"] = "sub_items"; // changes
			$g_identity["g_ability_name"] = $table." (as ".$foreign_k.")"; // changes
			$g_identity["g_ability_html_id"] = preg_replace('/\W+/','',strtolower(strip_tags($g_identity["g_ability_name"])));
			$g_identity["g_from"] = $table; // dynamic
			$g_identity["g_where_haystack"] = $foreign_k;

			$g_identity["g_where_haystack_type"] = "foreign_key";
			// $g_identity["g_where_needle"] = $record_id;

			$data_endpoint = "fetch_for_record/h_type/foreign_key/h/$haystack/n/";
			$g_identity["data_endpoint"] = $data_endpoint;

			// var_dump($parent_g_identity);
		}
		elseif ($rec_part=="table") {

			$data_endpoint = "fetch";


			// $g_identity["type"] = "table"; // changes
			$g_identity["g_ability_name"] = $table; // changes
			$g_identity["g_ability_html_id"] = preg_replace('/\W+/','',strtolower(strip_tags($g_identity["g_ability_name"])));
			$g_identity["g_from"] = $table; // dynamic
			// $g_identity["g_where_haystack"] = $foreign_k;
			// $g_identity["g_where_needle"] = $record_id;
			$g_identity["data_endpoint"] = $data_endpoint;

			// var_dump($parent_g_identity);
		}





		$editable = $erd[$table]["fields"];
		foreach ($editable as $key => $value) {
			$g_select["editable"][$key]["col_deets"] = $value;
			if ($key == $foreign_k) {
				$g_select["editable"][$key]["assumable"] = "";
			}
		}


		if ($rec_part=="overview") {
			$cols_visible = $this->cols_visible($g_identity["g_from"], $erd, "");
		}
		elseif ($rec_part=="details") {
			$cols_visible = $this->cols_visible($g_identity["g_from"], $erd, $foreign_k);
			// $cols_visible = $this->cols_visible($g_identity["g_from"], $erd, "");
		}
		elseif ($rec_part=="table") {
			$cols_visible = $this->cols_visible($g_identity["g_from"], $erd, "");
		}

		// header('Content-Type: application/json');
		// echo json_encode($cols_visible, JSON_PRETTY_PRINT);
		// exit;


		$g_select["visible"] = array();

		$g_select["visible"] = $cols_visible["cols_o"];

		$cols_wth_props = array();
		foreach ($cols_visible["cols_d"] as $key => $value) {
			foreach ($value["cols"] as $key_2 => $value_2) {
				$cols_wth_props["$key - $key_2"] = $value_2;
			}
			$g_select["visible"] = array_merge(
				$g_select["visible"],
				$cols_wth_props
			);

			// $ignore_col_set
			if (isset($g_select["editable"][$value["linking_key"]])) {
				// code...
				$cols_visible_lookup_helper = $this->cols_visible($key, $erd, "");
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
						// $cols_visible_lookup = array_merge(
						// 	$cols_visible_lookup,
						// 	array("$key_lookup - lineage" => "")
						// );
					}

				}

				$g_select["editable"][$value["linking_key"]]["rels"] = array(
					"table"=>$key,
					// "rows"=>$value["cols"]
					"rows"=>$cols_visible_lookup
				);
				if (isset($value["is_self_joined"])) {
					$g_select["visible"] = array("$key - lineage" => "") + $g_select["visible"];
					// $g_select["visible"] = array_merge(
					// 	$g_select["visible"],
					// 	array("$key - lineage" => "")
					// );
				}
			}
			// // $editable = $erd[$table]["fields"];
			// foreach ($editable as $key => $value) {
			// 	$g_select["editable"][$key]["col_deets"] = $value;
			// }
		}








		$result["g_identity"] = $g_identity;
		$result["g_select"] = $g_select;



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

		unset($post["variables"][0]);
		$ajax_data = array();
		foreach ($post["variables"] as $key => $value) {

			$ajax_data["`".urldecode($key)."`"] = "\"".$value."\"";
		}

		// $thing = json_encode($ajax_data, JSON_PRETTY_PRINT);
		// echo $thing;
		// exit;

		$this->CI->db->_protect_identifiers=false;

		$query_result = $this->CI->db->insert("`".$table."`", $ajax_data);
		$this->CI->db->_protect_identifiers=true;

		if ($query_result) {

			if (1==1) {

				$table_and_id = array(
					"table" => $table,
					"id" => 10000
				);



				$this->CI->input->post('edit_permissions_owner');
				$this->CI->input->post('edit_permissions_owner');

				$permissions = array(
					// "owner" => 1,
					// "editability" => 2,
					// "visibility" => 3
					"owner" => $post["permissions"]["edit_permissions_owner"],
					"editability" => $post["permissions"]["edit_permissions_editability"],
					"visibility" => $post["permissions"]["edit_permissions_visibility"]
				);
				$this->log_activity($table_and_id, $permissions);
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
				$ajax_data["`".urldecode($key)."`"] = "\"".$post["variables"]['edit_'.$this->makeSafeForCSS($key)]."\"";

			}
		}


		$this->CI->db->_protect_identifiers=false;

		$query_result = $this->CI->db->update($table, $ajax_data, array('id' => $ajax_data['id']));

		$this->CI->db->_protect_identifiers=true;

		if ($query_result) {

			if (1==1) {

				$table_and_id = array(
					"table" => $table,
					"id" => $ajax_data['id']
				);



				$this->CI->input->post('edit_permissions_owner');
				$this->CI->input->post('edit_permissions_owner');

				$permissions = array(
					// "owner" => 1,
					// "editability" => 2,
					// "visibility" => 3
					"owner" => $post["permissions"]["edit_permissions_owner"],
					"editability" => $post["permissions"]["edit_permissions_editability"],
					"visibility" => $post["permissions"]["edit_permissions_visibility"]
				);
				$this->log_activity($table_and_id, $permissions);
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

	public function log_activity($table_and_id, $permissions)
	{

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
			"owner" => $permissions["owner"],
			"editability" => $permissions["editability"],
			"visibility" => $permissions["visibility"]
		);

		// header('Content-Type: application/json');
		// echo json_encode($activity_log, JSON_PRETTY_PRINT);
		// exit;


		$query_result = $this->CI->db->replace('_activity_log', $activity_log);


	}

	public function owner_group_options()
	{

		$this->CI->load->database();


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




	public function abilities_cache($table)
	{
		$table = urldecode($table);
		$g_identity_singular = $this->CI->erd_lib->grammar_singular($table);

		$data = array();
		$data["table_name"] = $table;
		$data["table_name_singular"] = $g_identity_singular;
		// $data["record_id"] = $record_id;
		// $data["title"] = $g_identity_singular." ".$record_id;


		// $record = $this->fetch($table, "record", array(
		// 	"haystack"=>"id",
		// 	"needle"=>$record_id,
		// 	"haystack_type"=>"primary_key"
		// ))["posts"][0];


		$tables_in_db = $this->CI->erd_lib->tables_in_db();
		// header('Content-Type: application/json');
		// echo json_encode($tables, JSON_PRETTY_PRINT);
		// exit;

		if (isset($tables_in_db[$table])) {
			$data["table_exists"] = 1;
		} else {

			$data["table_exists"] = 0;
		}
		// if (!empty($record)) {
		// 	$data["record_exits"] = 1;
		//
		// } else {
		// 	$data["record_exits"] = 0;
		//
		// }


		$erd_path = APPPATH.'erd/active/erd.json';
		$erd = file_get_contents($erd_path);
		$erd = json_decode($erd, true);


		$dont_scan = "";

		$g_core_abilities = $this->abilities_cache_ability("overview", $erd, $table, null, "", $dont_scan);

		// header('Content-Type: application/json');
		// echo json_encode($tables, JSON_PRETTY_PRINT);
		// exit;


		$g_parental_abilities = array();
		if (isset($erd[$g_core_abilities["g_identity"]["g_from"]]["items"])) {
			$items = $erd[$g_core_abilities["g_identity"]["g_from"]]["items"];
			foreach ($items as $key => $value) {
				if ($key !== $dont_scan) {


					$g_parental_abilities[$key] = $this->abilities_cache_ability("details", $erd, $key, $value, $table, $dont_scan);

				} else {
					$g_parental_abilities[$key] = array();
				}
			}
		}

		// $data["g_core_abilities"]["g_identity"] = $g_core_abilities["g_identity"];
		// $data["g_core_abilities"]["g_select"] = $g_core_abilities_g_select;
		$data["g_core_abilities"] = $g_core_abilities;
		$data["g_parental_abilities"] = $g_parental_abilities;




		return $data;


	}

	public function record_abilities_2($table, $record_id)
	{
		if (file_exists("application/erd/active/crud_cache/$table.txt")) {
			$data = file_get_contents("application/erd/active/crud_cache/$table.txt");
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

				$g_where_haystack = $iteration_result["g_identity"]["g_where_haystack"];

				$iteration_result["g_select"]["editable"][$g_where_haystack]["assumable"] = $record_id;


				$data["g_parental_abilities"][$key] = $iteration_result;
			}

			return $data;
		} else {
			return array();
			// code...
		}


	}



	public function table_abilities_2($table)
	{
		if (file_exists("application/erd/active/crud_cache/$table.txt")) {
			$data = file_get_contents("application/erd/active/crud_cache/$table.txt");
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
