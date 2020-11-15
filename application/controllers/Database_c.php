<?php
class Database_c extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		// $this->load->model('trip');
		// $this->load->library('../modules/trips/controllers/table_page_lib');
		$this->load->library('table_page_lib');
	}

	public function database()
	{
		$data['tables'] = $this->table_page_lib->database_api();




		$data["rows"]["visible"] = array("name"=>array());
		$data["overview"]["table_id"] = "";
		$data["data_endpoint"] = "table_page/database_api";
		$data['title'] = "Database";
		$this->load->view('table_header_v', $data);
		$this->load->view('table_block_readonly_v', $data);
		$this->load->view('table_footer_v');

	}

	public function database_api()
	{
		$data = $this->table_page_lib->database_api();
		header('Content-Type: application/json');
		echo json_encode($data, JSON_PRETTY_PRINT);

	}

}
