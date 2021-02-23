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

		$data = $this->table_page_lib->record_abilities($table, $record_id);


		$owner_group_options = array(
			"assumed" => "yes",
			"options" => array(
				array(
					"id" => "1",
					"name" => "1",
					"indent" => ""
				)
			)
		);

		// echo $record;
		if ($data["table_exists"] == 1) {




			$this->load->view('table_header_v', array("data"=>$data));
			$this->load->view('table_block_v', array("data"=>$data["g_core_abilities"], "owner_group_options"=>$owner_group_options));


			if (!empty($data["g_parental_abilities"])) {
				$this->load->view('blank_v', array("data"=>'<div class="row"><div class="col-md-12 mt-5"><h2 class="text-center">items</h2><hr style="background-color: black; color: black; height: 1px;"></div></div>'));
			}
			foreach ($data["g_parental_abilities"] as $key => $value) {
				if (!empty($value)) {
					// code...
					$this->load->view('table_block_v', array("data"=>$value,"owner_group_options"=>$owner_group_options));
				}
			}
			$this->load->view('table_footer_v', array("data"=>$data));

		} else {
			return "no such record";
		}


	}




}
