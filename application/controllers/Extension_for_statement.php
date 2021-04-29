<?php
class Extension_for_statement extends CI_Controller
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

		$table = "statement";
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
		$query = $query->select("SUM(invoice.price - invoice.paid) AS total_outstanding");
		$query = $query->from($table);
		$query = $query->join(
			"invoice",
			"$table.`organisation id` =  invoice.`counterparty id`",
			"left"
		);
		$query = $query->where($table.".id", $id);
		$query = $query->where("invoice.price >", "invoice.paid");
		$query = $query->where("invoice.`invoice type id` =", "1");
		$query = $query->get();
		if (count($query->result()) > 0) {
			$total = $query->result_array();
			$total = $total[0]["total_outstanding"];
		} else {
			$total = 0;
		}

		$query = $this->db;
		$query = $query->select("invoice.price - invoice.paid AS outstanding");
		$query = $query->select("invoice.id as 'invoice id'");
		$query = $query->select("statement.id as 'statement id'");
		$query = $query->from($table);
		$query = $query->join(
			"invoice",
			"$table.`organisation id` =  invoice.`counterparty id`",
			"left"
		);
		$query = $query->where($table.".id", $id);
		$query = $query->where("invoice.price >", "invoice.paid");
		$query = $query->where("invoice.`invoice type id` =", "1");
		$query = $query->get();
		if (count($query->result()) > 0) {
			$result = $query->result();
		}


		$data = array();
		foreach ($result as $key => $value) {
			$data[$key] = array();
			foreach ($value as $value_key => $value_value) {
				$data[$key]["`$value_key`"] = $value_value;
			}
		}
		$query = $this->db;
		if ($query->insert_batch("`stated invoice`", $data)) {
		} else {
			$data = array('responce' => 'error');
		}


		$query = $this->db;
		if ($query->update("`$table`", array(
			"`auto generated status`"=>"1",
			"total"=>$total
		), array('id' => $id))) {

		} else {
			$data = array('responce' => 'error');
		}

		$data = array('responce' => 'success');
		// header('Content-Type: application/json');
		// echo json_encode($data, JSON_PRETTY_PRINT);
		// exit;
		redirect(urldecode($_GET["redirect"]), 'refresh');









	}

	public function report($id = NULL)
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

		$table = "statement";
		$this->load->database();


		$this->db->_protect_identifiers=false;

		if (1==1) {
			$query = $this->db;


			// id 	outstanding 	invoice id 	statement id
			// $query = $query->select("*");
			$query = $query->select("`$table`.`id` as 'statement id'");
			$query = $query->select("`organisation`.`name` as 'customer'");
			$query = $query->select("`$table`.`total` as 'total outstanding (ZAR)'");
			$query = $query->select("`$table`.`date` as 'stated date'");
			$query = $query->from($table);
			$query = $query->join(
				"`organisation`",
				"$table.`organisation id` =  `organisation`.`id`",
				"left"
			);
			$query = $query->where($table.".id", $id);
			$query = $query->get();
			// $posts = $query;

			if (count($query->result()) > 0) {
				// $result = (array) $query->row();
				$statement = $query->result_array();

				// $result = $result["organisation id"];
				// echo $result;

				// header('Content-Type: application/json');
				// echo json_encode($result, JSON_PRETTY_PRINT);
				// exit;
			} else {
				$responce_status = array('responce' => 'error');
				header('Content-Type: application/json');
				echo json_encode($responce_status, JSON_PRETTY_PRINT);
				exit;
			}
		}

		if (1==1) {
			$query = $this->db;
			$query = $query->select("invoice.date as 'invoice date'");
			$query = $query->select("services.`name` as 'service'");
			$query = $query->select("invoice.quantity as 'quantity'");
			$query = $query->select("`commodity unit`.`name` as 'unit'");
			$query = $query->select("invoice.price as 'price (ZAR)'");
			$query = $query->select("invoice.price - `stated invoice`.outstanding as 'paid (ZAR)'");
			$query = $query->select("`stated invoice`.outstanding AS 'outstanding (ZAR)'");

			$query = $query->from("`stated invoice`");
			$query = $query->join(
				"`invoice`",
				"invoice.`id` =  `stated invoice`.`invoice id`",
				"left"
			);
			$query = $query->join(
				"$table",
				"$table.`id` =  `stated invoice`.`statement id`",
				"left"
			);

			$query = $query->join(
				"`commodity type`",
				"`invoice`.`commodity type id` =  `commodity type`.`id`",
				"left"
			);
			$query = $query->join(
				"`commodity unit`",
				"`invoice`.`commodity unit id` =  `commodity unit`.`id`",
				"left"
			);
			$query = $query->join(
				"`organisation`",
				"`invoice`.`counterparty id` =  `organisation`.`id`",
				"left"
			);
			$query = $query->join(
				"`products`",
				"`invoice`.`products id` =  `products`.`id`",
				"left"
			);
			$query = $query->join(
				"`services`",
				"`invoice`.`services id` =  `services`.`id`",
				"left"
			);
			$query = $query->where($table.".id", $id);
			$query = $query->get();

			if (count($query->result()) > 0) {
				$stated_invoices = $query->result();
			} else {
				$stated_invoices = array();
			}
		}
		$statement_0 = $statement[0];

		// header('Content-Type: application/json');
		// echo json_encode($statement_0, JSON_PRETTY_PRINT);
		// exit;
		$data = array(
			"statement"=>$statement,
			"stated_invoices"=>$stated_invoices,
			"title"=>"statement ".$statement_0["stated date"]." for ".$statement_0["customer"]." (ref: ".$statement_0["statement id"].")",
			"back"=>urldecode($_GET["redirect"])
		);
		$this->load->view('extension_for_statement/report_v', array(
			"data"=>$data
		));
		return $data;

	}

	public function auto_email($id = NULL)
	{

		$table = "statement";
		if (1==1) {
			$query = $this->db;

			$query = $query->select("`organisation`.`email` as 'email'");
			$query = $query->from($table);
			$query = $query->join(
				"`organisation`",
				"$table.`organisation id` =  `organisation`.`id`",
				"left"
			);
			$query = $query->where($table.".id", $id);
			$query = $query->get();

			if (count($query->result()) > 0) {
				$customer_email = $query->result_array()[0]["email"];

			} else {
				$responce_status = array('responce' => 'error');
				header('Content-Type: application/json');
				echo json_encode($responce_status, JSON_PRETTY_PRINT);
				exit;
			}
		}

		$this->load->library(['email']);


		$email_config = $this->config->item('email_config', 'ion_auth');

		if ($this->config->item('use_ci_email', 'ion_auth') && isset($email_config) && is_array($email_config))
		{
			$this->email->initialize($email_config);
		}

		$message_data = $this->report($id);
		// $message = $this->load->view($this->config->item('email_templates', 'ion_auth') . $this->config->item('email_forgot_password', 'ion_auth'), $data, TRUE);

		$message = $this->load->view('extension_for_statement/report_v', array(
			"data"=>$message_data
		), TRUE);
		// $message = '';

		$this->email->clear();
		$this->email->set_newline("\r\n");
		$this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
		$this->email->to($customer_email);
		$this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $message_data["title"]);
		$this->email->message($message);

		if ($this->email->send())
		{
			// $this->set_message('forgot_password_successful');
			// echo 123333;
			// return TRUE;

		} else {
			$responce_status = array('responce' => 'error');
			header('Content-Type: application/json');
			echo json_encode($responce_status, JSON_PRETTY_PRINT);
			exit;
			// $data = array('responce' => 'error');
		}

		$query = $this->db;
		if ($query->update($table, array(
			"`auto sent status`"=>"1"
		), array('id' => $id))) {

		} else {
			// $data = array('responce' => 'error');
		}
		redirect(urldecode($_GET["redirect"]), 'refresh');

	}
}
