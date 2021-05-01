<?php
class Extension_for_bh_services extends CI_Controller
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

	public function report()
	{


		$table = "bh services";
		$this->load->database();


		$this->db->_protect_identifiers=false;

		if (1==1) {
			$query = $this->db;
			$query = $query->select("*");
			$query = $query->from("`$table`");
			$query = $query->get();
			if (count($query->result()) > 0) {
				$services = $query->result_array();
			} else {
				$responce_status = array('responce' => 'error');
				header('Content-Type: application/json');
				echo json_encode($responce_status, JSON_PRETTY_PRINT);
				exit;
			}
		}

		if (1==1) {
			$query = $this->db;


			// id 	outstanding 	invoice id 	statement id
			// $query = $query->select("*");
			$query = $query->select("`$table`.`id` as 'id'");
			$query = $query->select("`$table`.`name` as 'name'");
			$query = $query->select("`bh transactions`.`services id` as 'services id'");
			$query = $query->select("`bh transactions`.`package id` as 'package id'");
			$query = $query->select("`bh transactions`.`quantity (days)` as 'quantity (days)'");
			$query = $query->select("`bh transactions`.`date` as 'date'");
			$query = $query->select('DATE_ADD(`bh transactions`.`date`, INTERVAL `bh transactions`.`quantity (days)` DAY) as "end_date"');
			$query = $query->select("`bh transactions`.`price` as 'price'");
			$query = $query->from("`$table`");
			$query = $query->join(
				"`bh transactions`",
				"`$table`.`id` =  `bh transactions`.`services id`",
				"left"
			);
			// $query = $query->where($table.".id", $id);
			$query = $query->get();
			// $posts = $query;

			if (count($query->result()) > 0) {
				// $result = (array) $query->row();
				$transacitons = $query->result_array();

				// $result = $result["organisation id"];
				// echo $result;

				// header('Content-Type: application/json');
				// echo json_encode($data, JSON_PRETTY_PRINT);
				// exit;
			} else {
				$responce_status = array('responce' => 'error');
				header('Content-Type: application/json');
				echo json_encode($responce_status, JSON_PRETTY_PRINT);
				exit;
			}
		}


		header('Content-Type: application/json');
		echo json_encode($transacitons, JSON_PRETTY_PRINT);
		exit;
		$data = array();
		foreach ($services as $key => $value) {
			// code...
			$data[$key] = array(
				"name" => $value["name"],
				"months" => array(

					$this->month_details("first day of this month"),
					$this->month_details("first day of +1 month"),
					$this->month_details("first day of +2 month")
				)
			);
		}

		// header('Content-Type: application/json');
		// echo json_encode($data, JSON_PRETTY_PRINT);
		// exit;
		$this->load->view('extension_for_services/report_v', array(
			"data"=>$data
		));



	}

	function get_all_days_for_given_month($year, $month){
		$list=array();
		for($d=1; $d<=31; $d++)
		{
			$time=mktime(12, 0, 0, $month, $d, $year);
			if (date('m', $time)==$month)
			$list[date('Y-m-d', $time)]=date('d (D)', $time);
		}
		return $list;
	}

	function month_details($date_query) {
		$month = date('m',strtotime($date_query));
		$year = date('y',strtotime($date_query));
		$data["title"] = date('F',strtotime($date_query));
		$data["dates"] = $this->get_all_days_for_given_month($year, $month);
		return $data;
	}
}
