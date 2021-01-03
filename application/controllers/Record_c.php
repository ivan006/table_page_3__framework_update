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
		$table = urldecode($table);
		$tab_o_singular = $this->erd_lib->grammar_singular($table);


		$data = array();
		$data["title"] = $tab_o_singular." ".$record_id;


		$record = $this->table_page_lib->fetch_for_record($table, "id", $record_id,"")["posts"][0];


		// echo $record;
		if (!empty($record)) {
			$erd_path = APPPATH.'erd/erd/erd.json';
			$erd = file_get_contents($erd_path);
			$erd = json_decode($erd, true);


			$dont_scan = "";

			$rec_o = $this->table_page_lib->table_o_and_d("overview", $erd, $table, null, $record["id"], "", $dont_scan);


			$rec_d = array();
			if (isset($erd[$rec_o["tab_o"]["table"]]["items"])) {
				$items = $erd[$rec_o["tab_o"]["table"]]["items"];
				foreach ($items as $key => $value) {
					if ($key !== $dont_scan) {


						$rec_d[$key] = $this->table_page_lib->table_o_and_d("details", $erd, $key, $value, $record["id"], $table, $dont_scan);

					} else {
						$rec_d[$key] = array();
					}
				}
			}

			// $data["rec_o"]["tab_o"] = $rec_o["tab_o"];
			// $data["rec_o"]["tab_d"] = $rec_o_tab_d;
			$data["rec_o"] = $rec_o;
			$data["rec_d"] = $rec_d;

			$data["owner_group_options"] = array(
				"assumed" => "yes",
				"options" => array(
					array(
						"id" => "1",
						"name" => "1",
						"indent" => ""
					)
				)
			);




			$this->load->view('table_header_v', array("data"=>$data));
			$this->load->view('table_block_v', array("data"=>$data["rec_o"], "owner_group_options"=>$data["owner_group_options"]));


			if (!empty($data["rec_d"])) {
				$this->load->view('blank_v', array("data"=>'<div class="row"><div class="col-md-12 mt-5"><h2 class="text-center">items</h2><hr style="background-color: black; color: black; height: 1px;"></div></div>'));
			}
			foreach ($data["rec_d"] as $key => $value) {
				if (!empty($value)) {
					// code...
					$this->load->view('table_block_v', array("data"=>$value,"owner_group_options"=>$data["owner_group_options"]));
				}
			}
			$this->load->view('table_footer_v', array("data"=>$data));

		} else {
			return "no such record";
		}


	}




}
