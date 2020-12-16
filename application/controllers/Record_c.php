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


		$record = $this->table_page_lib->fetch_where($table, "id", $record_id)["posts"][0];

		$haystack = "id";
		$needle = $record_id;

		$data["rec_o"]["tab_o"]["data_endpoint"] = "fetch_where/h/$haystack/n/$needle";
		$data["rec_o"]["tab_o"]["type"] = "overview";
		$data["rec_o"]["tab_o"]["rel_name"] = "overview";
		$data["rec_o"]["tab_o"]["rel_name_id"] = $data["rec_o"]["tab_o"]["rel_name"];
		$data["rec_o"]["tab_o"]["table"] = $table;
		$dont_scan = "";


		$erd_path = APPPATH.'erd/erd/erd.json';
		$erd = file_get_contents($erd_path);
		$erd = json_decode($erd, true);

		$data["rec_o"]["tab_d"]["columns"]["editable"] = $erd[$table]["fields"];
		$data["rec_o"]["tab_d"]["columns"]["visible"] = array();


		$data["rec_o"]["tab_d"]["parents"] = array();
		foreach ($erd as $key => $value) {
			if (isset($value["items"])) {
				foreach ($value["items"] as $key_2 => $value_2) {
					if ($key_2 == $data["rec_o"]["tab_o"]["table"]) {
						// echo $key_2;
						$data["rec_o"]["tab_d"]["parents"][$key] = $value_2;
					}
				}
			}
		}
		// $data["rec_o"]["tab_d"]["parents"] = array_unique($data["rec_o"]["tab_d"]["parents"]);


		$data["rec_d"] = $this->relations($erd, $data["rec_o"]["tab_o"], $record, $dont_scan);

		// header('Content-Type: application/json');
		// echo json_encode($data, JSON_PRETTY_PRINT);
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

	}


	public function relations($erd, $parent_tab_o, $parent_record, $dont_scan)
	{
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		$result = array();
		// $columns = $erd[$parent_tab_o["table"]]["fields"];
		if (isset($erd[$parent_tab_o["table"]]["items"])) {
			$items = $erd[$parent_tab_o["table"]]["items"];
			foreach ($items as $key => $value) {
				if ($key !== $dont_scan) {


					$tab_o["rel_name"] = $key." (".$value." specialised)";
					$tab_o["rel_name_id"] = preg_replace('/\W+/','',strtolower(strip_tags($tab_o["rel_name"])));
					$tab_o["table"] = $key;
					$tab_o["foreign_key"] = $value;

					// var_dump($parent_tab_o);

					if (!empty($parent_record)) {

						$haystack = $value;
						$needle = $parent_record["id"];

						$data_endpoint = "fetch_where/h/$haystack/n/$needle";

					} else {
						$data_endpoint = "";
					}

					$tab_o["data_endpoint"] = $data_endpoint;

					$tab_o["type"] = "dedicated_items";






					$sub_columns = $erd[$key]["fields"];


					$result[$key] = array(
						"tab_o" => $tab_o,
						"tab_d" => array(
							"columns" => array(
								"editable" => $sub_columns,
								"visible" => array(),
							),
						)
					);



				} else {
					$result[$key] = array();
				}
			}
		}



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
