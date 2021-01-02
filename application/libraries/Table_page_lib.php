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
		$this->CI->load->library('form_validation','erd_lib','input');

	}

  public function fetch($table)
	{
		$table = urldecode($table);
		// $haystack = urldecode($haystack);

		$this->CI->load->database();

		// $posts = $this->CI->db->where($haystack, $needle)->get($table)->result_array();

		$erd_path = APPPATH.'erd/erd/erd.json';
		$erd = file_get_contents($erd_path);
		$erd = json_decode($erd, true);

		$cols_visible = $this->cols_visible($table, $erd, null);

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
				if ($key !== $table) {
					foreach ($value["cols"] as $key_2 => $value_2) {
						if ($key_2 == "id") {
							$parent_link_part_1 = '<a href="/record/t/'.$key.'/r/';
							$parent_link_part_2 = '" class="btn btn-sm btn-outline-primary">View</a>';
							$query = $query->select("CONCAT('$parent_link_part_1', "."`".$key."`".".id, '$parent_link_part_2') as `$key - $key_2`");
						} else {
							$query = $query->select("`".$key."`"."."."`".$key_2."`"." as `$key - $key_2`");
						}


					}
				}
			}
			$query = $query->from("`".$table."`");

			foreach ($cols_visible["cols_d"] as $key => $value) {
				// echo "xyz";
				if ($key !== $table) {
					$query = $query->join("`".$key."`", "`".$table."`".'.'."`".$value["linking_key"]."`".' = '."`".$key."`".'.id', 'left');
				}
			}
			// $query = $query->where("`".$table."`"."."."`".$haystack."` =", $needle);

			$posts = $query->get()->result_array();

		}

		$this->CI->db->_protect_identifiers=true;



		$data = array('responce' => 'success', 'posts' => $posts);
		return $data;

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

  public function fetch_for_record($table, $haystack, $needle, $child_of)
  {
		$table = urldecode($table);
		$haystack = urldecode($haystack);

		$this->CI->load->database();

		// $posts = $this->CI->db->where($haystack, $needle)->get($table)->result_array();

		$erd_path = APPPATH.'erd/erd/erd.json';
		$erd = file_get_contents($erd_path);
		$erd = json_decode($erd, true);

		$cols_visible = $this->cols_visible($table, $erd, $child_of);

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
				if ($key !== $table) {
					foreach ($value["cols"] as $key_2 => $value_2) {
						if ($key_2 == "id") {
							$parent_link_part_1 = '<a href="/record/t/'.$key.'/r/';
							$parent_link_part_2 = '" class="btn btn-sm btn-outline-primary">View</a>';
							$query = $query->select("CONCAT('$parent_link_part_1', "."`".$key."`".".id, '$parent_link_part_2') as `$key - $key_2`");
						} else {
							$query = $query->select("`".$key."`"."."."`".$key_2."`"." as `$key - $key_2`");
						}


					}
				}
			}
			$query = $query->from("`".$table."`");

			foreach ($cols_visible["cols_d"] as $key => $value) {
				// echo "xyz";
				if ($key !== $table) {
					$query = $query->join("`".$key."`", "`".$table."`".'.'."`".$value["linking_key"]."`".' = '."`".$key."`".'.id', 'left');
				}
			}
			$query = $query->where("`".$table."`"."."."`".$haystack."` =", $needle);

			$posts = $query->get()->result_array();

		}

		$this->CI->db->_protect_identifiers=true;



    $data = array('responce' => 'success', 'posts' => $posts);
    return $data;
  }

  public function fetch_join_where($table_1, $table_2, $haystack,$needle)
  {

		$this->CI->load->database();


		// $posts = $this->CI->db->select('*')->where($haystack, $needle)->from($table_1)->join($table_2, "$table_1.$table_2_key = $table_2.id")->get()->result_array();
		$table_2_singular = $this->erd_lib->grammar_singular($table_2);
		$table_2_singular = $table_2_singular."_id";
		// $table_1_singular = $this->erd_lib->grammar_singular($table_1);
		// $haystack = $table_1_singular.".".$haystack;


		$posts = $this->CI->db->select('*')->where($haystack, $needle)->from($table_2)->join($table_1, "$table_1.$table_2_singular = $table_2.id", "right")->get()->result_array();

		$data = array('responce' => 'success', 'posts' => $posts);
    return $data;

  }

  public function mergetest()
  {



		$this->CI->load->database();



		// $posts = $this->CI->db
		// ->select("`event_resource_links`.*")
    // ->select("DAY() AS wp_name")
		// ->from("event_resource_links")
		// ->join("resources", "event_resource_links.bedding_specialty_resource_id = resources.id", "right")
		// ->get()
		// ->result_array();


		$sql="Select 'aaa' as asd";
		// $sql="SELECT '' as table1_dummy, table1.*, '' as table2_dummy, table2.*, '' as table3_dummy, table3.* FROM table1 JOIN table2 ON table2.table1id = table1.id JOIN table3 ON table3.table1id = table1.id";
		$posts = $this->CI->db->query($sql)->result_array();

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

  public function cols_visible($table, $erd, $ignore_col_set)
  {
		// $erd_path = APPPATH.'erd/erd/erd.json';
		// $erd = file_get_contents($erd_path);
		// $erd = json_decode($erd, true);

		$parents = array();

		foreach ($erd as $key => $value) {
			if (isset($value["items"])) {
				if ($key !== $ignore_col_set) {
					foreach ($value["items"] as $key_2 => $value_2) {
						if ($key_2 == $table) {
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
		if (isset($erd[$ignore_col_set]["items"][$table])) {
			$linking_k_for_ignore = $erd[$ignore_col_set]["items"][$table];
			// header('Content-Type: application/json');
			// echo json_encode($erd, JSON_PRETTY_PRINT);
			// exit;
			unset($self[$linking_k_for_ignore]);
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

	public function makeSafeForCSS($string) {
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

			$tab_o["data_endpoint"] = "fetch_for_record/h/$haystack/n/$needle/child_of/null";
			$tab_o["type"] = "overview";
			$tab_o["rel_name"] = "overview";
			$tab_o["rel_name_id"] = $tab_o["rel_name"];
			$tab_o["table"] = $table;

		}
		elseif ($rec_part=="details") {

			$haystack = $foreign_k; //changes
			$needle = $record_id;

			$data_endpoint = "fetch_for_record/h/$haystack/n/$needle/child_of/$ignore_col_set";


			$tab_o["record_id"] = $record_id;
			$tab_o["data_endpoint"] = $data_endpoint;
			$tab_o["type"] = "sub_items"; // changes
			$tab_o["rel_name"] = $table." (as ".$foreign_k.")"; // changes
			$tab_o["rel_name_id"] = preg_replace('/\W+/','',strtolower(strip_tags($tab_o["rel_name"])));
			$tab_o["table"] = $table; // dynamic
			// $tab_o["foreign_key"] = $foreign_k;

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
			$cols_visible = $this->cols_visible($tab_o["table"], $erd, $ignore_col_set);
		}
		elseif ($rec_part=="table") {
			$cols_visible = $this->cols_visible($tab_o["table"], $erd, $ignore_col_set);
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
				) ;
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

				// zzzzz
				// $post = $this->CI->input->post();
				//
				// unset($ajax_data[0]);
				// $ajax_data = array();
				// foreach ($ajax_data as $key => $value) {
				// 	$ajax_data["`".urldecode($key)."`"] = "\"".$value."\"";
				// }
				// zzzz

	      // $data['name'] = $this->CI->input->post('edit_name');
	      // $data['event_children'] = $this->CI->input->post('edit_event_children');
				$rows = $this->table_rows($table);
				foreach ($rows as $key => $value) {
					if ($key !== "id") {
						$data["`".urldecode($key)."`"] = "\"".$this->CI->input->post('edit_'.$this->makeSafeForCSS($key))."\"";
					}
				}


				$this->CI->db->_protect_identifiers=false;
	      if ($this->CI->db->update($table, $data, array('id' => $data['id']))) {
	        $data = array('responce' => 'success', 'message' => 'Record update Successfully');
	        // $data = $this->CI->db->last_query();
	      } else {
	        $data = array('responce' => 'error', 'message' => 'Failed to update record');
	      }

				$this->CI->db->_protect_identifiers=true;
			  return $data;


	  //   }
	  //   return $data;
    // } else {
    // 	return "No direct script access allowed";
    // }
  }

}
