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
		$this->load->database();
		$this->db->_protect_identifiers=false;

		if (1==1) {

			$query = $this->db;
			$query = $query->select("*");
			$query = $query->from("`bh services`");
			$query = $query->get();

			if (count($query->result()) > 0) {
				$services = $query->result_array();
			} else {

				$services = array();
				// $responce_status = array('responce' => 'error');
				// header('Content-Type: application/json');
				// echo json_encode($responce_status, JSON_PRETTY_PRINT);
				// exit;
			}
		}

		$submit_success = false;
		if (!empty($_POST)) {
			$invalid = false;
			if ($_POST["services"]) {
				foreach ($_POST["services"] as $key => $value) {
					// if ($key == 2) {
					// 	$expose = $this->double_bookings($key, $value);
					// 	header('Content-Type: application/json');
					// 	// echo json_encode($expose, JSON_PRETTY_PRINT);
					// 	echo $expose;
					// 	exit;
					// }
					if ($value["quantity"] != "" & $value["quantity"] > 0 &  $value["date"] != "") {
						if (count($this->double_bookings($key, $value)) > 0) {
							$_POST["services"][$key]["validation"] = "no";
							$invalid = true;
						} else {
							$_POST["services"][$key]["validation"] = "yes";
						}
					}

				}
			}

			if ($invalid == false) {

				$data = array(
					"customer name" => $_POST["name"],
					"email" => $_POST["email"],
					"date" => $_POST["date"],
				);
				$data_formated = array();
				foreach ($data as $key_1 => $value_1) {
					$data_formated["`$key_1`"] = "'$value_1'";
				}

				$this->db->insert('`bh packages`', $data_formated);
				$insert_id = $this->db->insert_id();

				if ($_POST["services"]) {
					foreach ($_POST["services"] as $key => $value) {

						$data = array(
							"services id" => $key,
							"package id" => $insert_id,
							"quantity (days)" => $value["quantity"],
							"date" => $value["date"],
						);
						$data_formated = array();
						foreach ($data as $key_1 => $value_1) {
							$data_formated["`$key_1`"] = "'$value_1'";
						}

						$this->db->insert('`bh transactions`', $data_formated);

					}
				}
				$submit_success = true;

			}

		}

		// header("Access-Control-Allow-Origin: https://briland.co.za");
		// header('Access-Control-Allow-Origin: *');
		$this->load->view('extendable_partials/bootstap4_header_v', array(
			"title"=>"Services - Form"
		));
		$this->load->view('extension_for_bh_packages/form_v', array(
			"data"=>array("services"=>$services, "submit_success"=>$submit_success)
		));
		$this->load->view('extendable_partials/bootstap4_footer_v', array());

	}

	function double_bookings($key, $value){
		$new_check_in = $value["date"];
		$new_check_out_encoded=date_create($new_check_in);
		date_add($new_check_out_encoded,date_interval_create_from_date_string($value["quantity"]." days"));
		$new_check_out = date_format($new_check_out_encoded,"Y-m-d");

		$existing_start_date = "`date`";
		$existing_end_date = "DATE_ADD(`bh transactions`.`date`, INTERVAL `bh transactions`.`quantity (days)` DAY)";

		$query = $this->db;
		$query = $query->select("*");
		$query = $query->from("`bh transactions`");
		$query = $query->where("`services id` =", "'$key'");
		$query = $query->group_start();
		$query = $query->group_start()->where("$existing_start_date <=", "'$new_check_in'")->where("'$new_check_in' <", "$existing_end_date")->group_end();
		// can checkin on checkout but cant checkin on checkin
		// 2 ins or 2 outs cant have edge case but an in-out can have edge case
		$query = $query->or_group_start()->where("$existing_start_date <", "'$new_check_out'")->where("'$new_check_out' <=", "$existing_end_date")->group_end();
		$query = $query->or_group_start()->where("$existing_start_date >=", "'$new_check_in'")->where("'$new_check_out' >=", "$existing_end_date")->group_end();
		$query = $query->group_end();

		// if ($key == 2) {
		// 	$query_compiled = $query->_compile_select();
		// 	$result = $query_compiled;
		// 	return $result;
		// }
		$query = $query->get();
		$this->db->flush_cache();


		$double_bookings = count($query->result());
		$result = $double_bookings;

		if (count($query->result()) > 0) {
			$result = $query->result_array();
		} else {
			$result = array();
		}
		return $result;
	}
}
