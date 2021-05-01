<?php
class Extension_for_bh_packages extends CI_Controller
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

	public function form()
	{


		$table = "bh services";
		$this->load->database();


		$this->db->_protect_identifiers=false;

		if (1==1) {
			$query = $this->db;


			// id 	outstanding 	invoice id 	statement id
			$query = $query->select("*");
			// $query = $query->select("`$table`.`id` as 'statement id'");
			// $query = $query->select("`organisation`.`name` as 'customer'");
			// $query = $query->select("`$table`.`total` as 'total outstanding (ZAR)'");
			// $query = $query->select("`$table`.`date` as 'stated date'");
			$query = $query->from("`$table`");
			// $query = $query->join(
			// 	"`organisation`",
			// 	"$table.`organisation id` =  `organisation`.`id`",
			// 	"left"
			// );
			// $query = $query->where($table.".id", $id);
			$query = $query->get();
			// $posts = $query;

			if (count($query->result()) > 0) {
				// $result = (array) $query->row();
				$statement = $query->result_array();

				// $result = $result["organisation id"];
				// echo $result;

				header('Content-Type: application/json');
				echo json_encode($statement, JSON_PRETTY_PRINT);
				exit;
			} else {
				$responce_status = array('responce' => 'error');
				header('Content-Type: application/json');
				echo json_encode($responce_status, JSON_PRETTY_PRINT);
				exit;
			}
		}

		// if (1==1) {
		// 	$query = $this->db;
		// 	$query = $query->select("invoice.date as 'invoice date'");
		// 	$query = $query->select("services.`name` as 'service'");
		// 	$query = $query->select("invoice.quantity as 'quantity'");
		// 	$query = $query->select("`commodity unit`.`name` as 'unit'");
		// 	$query = $query->select("invoice.price as 'price (ZAR)'");
		// 	$query = $query->select("invoice.price - `stated invoice`.outstanding as 'paid (ZAR)'");
		// 	$query = $query->select("`stated invoice`.outstanding AS 'outstanding (ZAR)'");
		//
		// 	$query = $query->from("`stated invoice`");
		// 	$query = $query->join(
		// 	"`invoice`",
		// 	"invoice.`id` =  `stated invoice`.`invoice id`",
		// 	"left"
		// 	);
		// 	$query = $query->join(
		// 	"$table",
		// 	"$table.`id` =  `stated invoice`.`statement id`",
		// 	"left"
		// 	);
		//
		// 	$query = $query->join(
		// 	"`commodity type`",
		// 	"`invoice`.`commodity type id` =  `commodity type`.`id`",
		// 	"left"
		// 	);
		// 	$query = $query->join(
		// 	"`commodity unit`",
		// 	"`invoice`.`commodity unit id` =  `commodity unit`.`id`",
		// 	"left"
		// 	);
		// 	$query = $query->join(
		// 	"`organisation`",
		// 	"`invoice`.`counterparty id` =  `organisation`.`id`",
		// 	"left"
		// 	);
		// 	$query = $query->join(
		// 	"`products`",
		// 	"`invoice`.`products id` =  `products`.`id`",
		// 	"left"
		// 	);
		// 	$query = $query->join(
		// 	"`services`",
		// 	"`invoice`.`services id` =  `services`.`id`",
		// 	"left"
		// 	);
		// 	$query = $query->where($table.".id", $id);
		// 	$query = $query->get();
		//
		// 	if (count($query->result()) > 0) {
		// 		$stated_invoices = $query->result();
		// 	} else {
		// 		$stated_invoices = array();
		// 	}
		// }
		// $statement_0 = $statement[0];
		//
		// // header('Content-Type: application/json');
		// // echo json_encode($statement_0, JSON_PRETTY_PRINT);
		// // exit;
		// $data = array(
		// "statement"=>$statement,
		// "stated_invoices"=>$stated_invoices,
		// "title"=>"statement ".$statement_0["stated date"]." for ".$statement_0["customer"]." (ref: ".$statement_0["statement id"].")",
		// "back"=>urldecode($_GET["redirect"])
		// );
		// $this->load->view('extension_for_statement/report_v', array(
		// "data"=>$data
		// ));
		// return $data;

	}
}
