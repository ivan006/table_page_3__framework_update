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

  public function insert($table)
  {

		$this->CI->load->database();

    // if ($this->CI->input->is_ajax_request()) {


      // $this->form_validation->set_rules('name', 'Name', 'required');
      // $this->form_validation->set_rules('event_children', 'Event_children');

      // if ($this->form_validation->run() == FALSE) {
      //   $data = array('responce' => 'error', 'message' => validation_errors());
      // } else {
        $ajax_data = $this->CI->input->post();
        if ($this->CI->db->insert($table, $ajax_data)) {
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

  public function fetch($table)
  {

		$this->CI->load->database();


    // if ($this->CI->input->is_ajax_request()) {
    // // if ($posts = $this->CI->db->get($table)->result()) {
    // // 	$data = array('responce' => 'success', 'posts' => $posts);
    // // }else{
    // // 	$data = array('responce' => 'error', 'message' => 'Failed to fetch data');
    // // }
    $posts = $this->CI->db->get($table)->result();
    $data = array('responce' => 'success', 'posts' => $posts);
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

  public function update($table)
  {

		$this->CI->load->database();

    // if ($this->CI->input->is_ajax_request()) {
	  //   $this->form_validation->set_rules('edit_name', 'Name', 'required');
	  //   $this->form_validation->set_rules('edit_event_children', 'Event_children');
	  //   if ($this->form_validation->run() == FALSE) {
	  //     $data = array('responce' => 'error', 'message' => validation_errors());
	  //   } else {

	      $data['id'] = $this->CI->input->post('edit_record_id');


	      // $data['name'] = $this->CI->input->post('edit_name');
	      // $data['event_children'] = $this->CI->input->post('edit_event_children');
				$rows = $this->table_rows($table);
				foreach ($rows as $key => $value) {
					if ($key !== "id") {
						$data[$key] = $this->CI->input->post('edit_'.$key);
					}
				}

	      if ($this->CI->db->update($table, $data, array('id' => $data['id']))) {
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

  public function fetch_for_record($table, $haystack, $needle)
  {

		$this->CI->load->database();

		$posts = $this->CI->db->where($haystack, $needle)->get($table)->result_array();
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



		// $posts = $this->db
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

}
