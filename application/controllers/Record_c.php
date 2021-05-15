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
		$table = urldecode($table);
		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}

		// $data = $this->table_page_lib->record_abilities($table, $record_id);
		$data = $this->table_page_lib->postcalculated_table_for_record($table, $record_id);
		// header('Content-Type: application/json');
		// echo json_encode($data, JSON_PRETTY_PRINT);
		// exit;





		$permisssion_options = array(
			"owner" => array(
				"assumed" => 2,
				"options" => $this->table_page_lib->user_groups_for_dropdown()
			),
			// "assignbility" => array(
			// 	"assumed" => "",
			// 	"options" => array(
			// 		"Private",
			// 		// "Organisation",
			// 		"Public"
			// 	)
			// ),
			"editability" => array(
				"assumed" => "",
				"options" => array(
					array(
						"label"=>"Private",
						"value"=>"pr",
					),
					// array(
					// 	"label"="Organisation",
					// 	"value"="1",
					// ),
					array(
						"label"=>"Public",
						"value"=>"pu",
					),
				)
			),
			"visibility" => array(
				"assumed" => "",
				"options" => array(
					array(
						"label"=>"Private",
						"value"=>"pr",
					),
					// array(
					// 	"label"="Organisation",
					// 	"value"="1",
					// ),
					array(
						"label"=>"Public",
						"value"=>"pu",
					),
				)
			),
		);
		// echo $record;
		if ($data["table_exists"] == 1) {




			$this->load->view('table_header_v', array(
				"data"=>$data,
				"type"=>"g_record_core_abilities"
			));
			$this->load->view('table_block_v', array(
				"data"=>$data["g_core_abilities"],
				"permisssion_options"=>$permisssion_options,
				"type"=>"g_record_core_abilities"
			));


			if (!empty($data["g_parental_abilities"])) {
				$this->load->view('blank_v', array("data"=>'<div class="row"><div class="col-md-12 mt-5"><h2 class="text-center">items</h2><hr style="background-color: black; color: black; height: 1px;"></div></div>'));
			}
			foreach ($data["g_parental_abilities"] as $key => $value) {
				if (!empty($value)) {
					// code...
					$this->load->view('table_block_v', array(
						"data"=>$value,
						"permisssion_options"=>$permisssion_options,
						"type"=>"g_record_parental_abilities"
					));
				}
			}
			$this->load->view('table_footer_v', array("data"=>$data));

		} else {
			return "no such record";
		}


	}




}
