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
			$query = $query->select("DATE_ADD(`bh transactions`.`date`, INTERVAL `bh transactions`.`quantity (days)`-1 DAY) as 'end_date'");
			$query = $query->select("`bh transactions`.`price` as 'price'");
			$query = $query->from("`$table`");
			$query = $query->join(
				"`bh transactions`",
				"`$table`.`id` =  `bh transactions`.`services id`",
				"left"
			);
			$query = $query->where("DATE_ADD(`bh transactions`.`date`, INTERVAL `bh transactions`.`quantity (days)`-1 DAY) >=", "'".date('Y-m-d',strtotime("first day of this month"))."'");
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


		// header('Content-Type: application/json');
		// echo json_encode($transacitons, JSON_PRETTY_PRINT);
		// exit;
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

		$services_unavailable = array();
		foreach ($services as $key => $value) {
			$services_unavailable[$value["name"]] = array();
			foreach ($transacitons as $key_1 => $value_1) {
				if ($value_1["name"] == $value["name"]) {
					$services_unavailable[$value["name"]] = array_merge(
						$services_unavailable[$value["name"]],
						array_flip($this->createDateRangeArray($value_1["date"], $value_1["end_date"]))
					);
					// $services_unavailable[$value["name"]][] = 	;
				}
			}
		}


		// header('Content-Type: application/json');
		// echo json_encode($data, JSON_PRETTY_PRINT);
		// exit;
		$result = $data;
		foreach ($data as $key => $value) {
			foreach ($value["months"] as $key_1 => $value_1) {
				// header('Content-Type: application/json');
				// echo json_encode($value_1, JSON_PRETTY_PRINT);
				// exit;
				foreach ($value_1["dates"] as $key_2 => $value_2) {
					if (isset($services_unavailable[$value["name"]][$key_2])) {
						$result[$key]["months"][$key_1]["dates"][$key_2] = "unavail";
					}
				}
			}
		}
		// header('Content-Type: application/json');
		// echo json_encode($result, JSON_PRETTY_PRINT);
		// exit;
		
		$this->load->view('extendable_partials/bootstap4_header_v', array(
			"title"=>"Services - Report"
		));
		$this->load->view('extension_for_bh_services/report_v', array(
			"data"=>$result
		));
		$this->load->view('extendable_partials/bootstap4_footer_v', array());



	}

	function get_all_days_for_given_month($year, $month){
		$list=array();
		for($d=1; $d<=31; $d++)
		{
			$time=mktime(12, 0, 0, $month, $d, $year);
			if (date('m', $time)==$month)
			$list[date('Y-m-d', $time)]= "avail";
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

	function createDateRangeArray($strDateFrom,$strDateTo)
	{
		// takes two dates formatted as YYYY-MM-DD and creates an
		// inclusive array of the dates between the from and to dates.

		// could test validity of dates here but I'm already doing
		// that in the main script

		$aryRange = [];

		$iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
		$iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

		if ($iDateTo >= $iDateFrom) {
			array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
			while ($iDateFrom<$iDateTo) {
				$iDateFrom += 86400; // add 24 hours
				array_push($aryRange, date('Y-m-d', $iDateFrom));
			}
		}
		return $aryRange;
	}
}
