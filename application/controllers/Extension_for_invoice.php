<?php
class Extension_for_invoice extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		// $this->load->helper(array('form', 'url'));
		// $this->load->library('form_validation');
		// // $this->load->model('trip');
		// // $this->load->library('../modules/trips/controllers/table_page_lib');
		// $this->load->library('table_page_lib');
		// $this->load->library('erd_lib');
		//
		//
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation']);
		// $this->load->helper(['url', 'language']);
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
	}

	public function auto_generate($id = NULL)
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}

		if (!$id OR !isset($_GET["redirect"]))
		{
			show_404();
		}

		$table = "invoice";
		$this->load->database();


		$this->db->_protect_identifiers=false;
		$query = $this->db;
		$query = $query->select("*");
		$query = $query->from($table);
		$query = $query->where($table.".id", $id);
		$query = $query->where("`auto generated status` =", "0");
		$query = $query->get();
		$posts = $query;

		// header('Content-Type: application/json');
		// echo json_encode(urldecode( $_GET["redirect"]), JSON_PRETTY_PRINT);
		// exit;
		if (count($query->result()) == 0) {
			$data = array('responce' => 'error');
			// header('Content-Type: application/json');
			// echo json_encode($data, JSON_PRETTY_PRINT);
			// exit;
			redirect(urldecode($_GET["redirect"]), 'refresh');
		}


		$query = $this->db;


		// id 	outstanding 	transaction id 	invoice id
		$query = $query->select("transaction.price - transaction.paid AS outstanding");
		$query = $query->select("transaction.id as 'transaction id'");
		$query = $query->select("invoice.id as 'invoice id'");
		$query = $query->from($table);
		$query = $query->join(
			"transaction",
			"$table.`organisation id` =  transaction.`counterparty id`",
			"left"
		);
		$query = $query->where($table.".id", $id);
		$query = $query->where("transaction.price >", "transaction.paid");
		$query = $query->where("transaction.`transaction type id` =", "1");
		$query = $query->get();
		// $posts = $query;

		if (count($query->result()) > 0) {
			// $result = (array) $query->row();
			$result = $query->result();

			// $result = $result["organisation id"];
			// echo $result;

			// header('Content-Type: application/json');
			// echo json_encode($result, JSON_PRETTY_PRINT);
			// exit;
		}


		// zzzzzzzzzzzzzz

		$data = array();
		foreach ($result as $key => $value) {
			$data[$key] = array();
			foreach ($value as $value_key => $value_value) {
				// code...
				$data[$key]["`$value_key`"] = $value_value;
			}
		}
		$query = $this->db;
		if ($query->insert_batch("`invoiced transaction`", $data)) {
		} else {
			$data = array('responce' => 'error');
		}


		$query = $this->db;
		if ($query->update("`$table`", array("`auto generated status`"=>"1"), array('id' => $id))) {
		} else {
			$data = array('responce' => 'error');
		}

		$data = array('responce' => 'success');
		// header('Content-Type: application/json');
		// echo json_encode($data, JSON_PRETTY_PRINT);
		// exit;
		redirect(urldecode($_GET["redirect"]), 'refresh');









	}



}
