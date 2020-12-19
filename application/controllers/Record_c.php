<?php
class Record_c extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		// $this->load->model('trip');
		// $this->load->library('../modules/trips/controllers/table_page_lib');
		$this->load->library('table_page_lib');
		$this->load->library('erd_lib');


		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		$this->load->helper(['url', 'language']);
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
	}

	public function index($table, $record_id)
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$tab_o_singular = $this->erd_lib->grammar_singular($table);


		$data = array();
		$data["title"] = $tab_o_singular." ".$record_id;


		$record = $this->table_page_lib->fetch_for_record($table, "id", $record_id)["posts"][0];


		// echo $record;
		if (!empty($record)) {
			$erd_path = APPPATH.'erd/erd/erd.json';
			$erd = file_get_contents($erd_path);
			$erd = json_decode($erd, true);


			$dont_scan = "";

			$rec_o = $this->table_o_and_d("overview", $erd, $table, null, $record["id"], $dont_scan);


			$rec_d = array();
			if (isset($erd[$rec_o["tab_o"]["table"]]["items"])) {
				$items = $erd[$rec_o["tab_o"]["table"]]["items"];
				foreach ($items as $key => $value) {
					if ($key !== $dont_scan) {


						$rec_d[$key] = $this->table_o_and_d("details", $erd, $key, $value, $record["id"], $dont_scan);

					} else {
						$rec_d[$key] = array();
					}
				}
			}

			// $data["rec_o"]["tab_o"] = $rec_o["tab_o"];
			// $data["rec_o"]["tab_d"] = $rec_o_tab_d;
			$data["rec_o"] = $rec_o;
			$data["rec_d"] = $rec_d;

			// header('Content-Type: application/json');
			// echo json_encode($record_inherited_cols, JSON_PRETTY_PRINT);
			// exit;





			$this->load->view('table_header_v', array("data"=>$data));
			$this->load->view('table_block_v', array("data"=>$data["rec_o"]));

			foreach ($data["rec_d"] as $key => $value) {
				if (!empty($value)) {
					// code...
					$this->load->view('table_block_v', array("data"=>$value));
				}
			}
			$this->load->view('table_footer_v', array("data"=>$data));

		} else {
			return "no such record";
		}


	}


	public function table_o_and_d($rec_part, $erd, $table, $foreign_k, $record_id, $dont_scan)
	{
		// if (!$this->ion_auth->logged_in())
		// {
		// 	// redirect them to the login page
		// 	redirect('auth/login', 'refresh');
		// }
		if ($rec_part=="overview") {

			$haystack = "id";
			$needle = $record_id;

			$tab_o["data_endpoint"] = "fetch_for_record/h/$haystack/n/$needle";
			$tab_o["type"] = "overview";
			$tab_o["rel_name"] = "overview";
			$tab_o["rel_name_id"] = $tab_o["rel_name"];
			$tab_o["table"] = $table;

		} elseif ($rec_part=="details") {

			$haystack = $foreign_k; //changes
			$needle = $record_id;

			$data_endpoint = "fetch_for_record/h/$haystack/n/$needle";


			$tab_o["data_endpoint"] = $data_endpoint;
			$tab_o["type"] = "dedicated_items"; // changes
			$tab_o["rel_name"] = $table." (".$foreign_k." specialised)"; // changes
			$tab_o["rel_name_id"] = preg_replace('/\W+/','',strtolower(strip_tags($tab_o["rel_name"])));
			$tab_o["table"] = $table; // dynamic
			// $tab_o["foreign_key"] = $foreign_k;

			// var_dump($parent_tab_o);
		}






		if ($rec_part=="overview") {

			$tab_d["cols"]["editable"] = $erd[$table]["fields"];

			$tab_d["cols"]["visible"] = array();

			$record_inherited_cols = $this->table_page_lib->record_inherited_cols($tab_o["table"], $erd);


			$tab_d["cols"]["visible"] = $record_inherited_cols["self"];

			foreach ($record_inherited_cols["rel"] as $key => $value) {
				foreach ($value["inherited_cols"] as $key_2 => $value_2) {
					$cols_wth_props[$key_2] = $value_2["col_props"];
				}
				$tab_d["cols"]["visible"] = array_merge(
					$tab_d["cols"]["visible"],
					$cols_wth_props
				);
			}
		} elseif ($rec_part=="details") {

			$tab_d["cols"]["editable"] = $erd[$table]["fields"];

			$tab_d["cols"]["visible"] = array();

			$record_inherited_cols = $this->table_page_lib->record_inherited_cols($tab_o["table"], $erd);


			$tab_d["cols"]["visible"] = $record_inherited_cols["self"];

			foreach ($record_inherited_cols["rel"] as $key => $value) {
				foreach ($value["inherited_cols"] as $key_2 => $value_2) {
					$cols_wth_props[$key_2] = $value_2["col_props"];
				}
				$tab_d["cols"]["visible"] = array_merge(
					$tab_d["cols"]["visible"],
					$cols_wth_props
				);
			}
		}



		$result["tab_o"] = $tab_o;
		$result["tab_d"] = $tab_d;


		return $result;

	}



	public function mergetest()
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$result = $this->table_page_lib->mergetest();
		header('Content-Type: application/json');
		echo json_encode($result, JSON_PRETTY_PRINT);
	}


}
