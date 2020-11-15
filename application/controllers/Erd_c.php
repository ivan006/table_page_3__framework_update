
<?php
class Erd_c extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->library('erd_lib');
	}

	function index()
	{
		// echo "<pre>";
		$data["erd"] = $this->erd_lib->erd();
		$data["erd_to_db"] = $this->erd_lib->erd_to_db();
		$data["model_two"] = $this->erd_lib->model_two();
		$data["db_to_erd"] = $this->erd_lib->db_to_erd();
		$data["diff"] = $this->erd_lib->diff();


		// header('Content-Type: application/json');
		// echo json_encode($class);
		// exit;

		$this->load->view('erd_v', $data);
	}

}
