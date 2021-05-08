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

				// header('Content-Type: application/json');
				// echo json_encode($statement, JSON_PRETTY_PRINT);
				// exit;
			} else {
				$responce_status = array('responce' => 'error');
				header('Content-Type: application/json');
				echo json_encode($responce_status, JSON_PRETTY_PRINT);
				exit;
			}
		}
		if (!empty($_POST)) {
			// code...
			if ($_POST["services"]) {
				// code...
				foreach ($_POST["services"] as $key => $value) {

					if ($value["quantity"] != "" & $value["quantity"] > 0 &  $value["date"] != "") {
						if ($this->number_of_double_bookings($key, $value) > 0) {
							// code...
							$_POST["services"][$key]["validation"] = "no";
						} else {
							// code...
							$_POST["services"][$key]["validation"] = "yes";
						}

					}
				}
			}
		}


		$this->load->view('extendable_partials/bootstap4_header_v', array(
			"title"=>"Services - Form"
		));
		$this->load->view('extension_for_bh_packages/form_v', array(
			"data"=>$statement
		));
		$this->load->view('extendable_partials/bootstap4_footer_v', array());

	}

	function number_of_double_bookings($key, $value){
		if (1==1) {
			$new_check_in = $value["date"];
			$new_check_out_encoded=date_create($new_check_in);
			date_add($new_check_out_encoded,date_interval_create_from_date_string($value["quantity"]." days"));
			$new_check_out = date_format($new_check_out_encoded,"Y-m-d");

			$existing_start_date = "`date`";
			// $existing_start_date = "`date`";
			$existing_end_date = "DATE_ADD(`bh transactions`.`date`, INTERVAL `bh transactions`.`quantity (days)` DAY)";

			$query = $this->db;
			// $query = $query->select("*");
			$query = $query->select("$existing_start_date");
			$query = $query->select("$existing_end_date");
			$query = $query->from("`bh transactions`");
			$query = $query->where("`services id` =", $key);
			$query = $query->group_start();
			$query = $query->where("$existing_start_date <=", "'$new_check_in'")->where("'$new_check_in' <", "$existing_end_date");
			// can checkin on checkout but cant checkin on checkin
			// 2 ins or 2 outs cant have edge case but an in-out can have edge case
			$query = $query->group_end();
			$query = $query->or_group_start();
			$query = $query->where("$existing_start_date <", "'$new_check_out'")->where("'$new_check_out' <=", "$existing_end_date");
			$query = $query->group_end();

			// $query = $query->where("'$new_check_in' BETWEEN $existing_start_date AND $existing_end_date");
			// $query = $query->or_where("'$new_check_out' BETWEEN $existing_start_date AND $existing_end_date");

			$query = $query->or_group_start();
			$query = $query->where("$existing_start_date >=", "'$new_check_in'")->where("'$new_check_out' >=", "$existing_end_date");
			$query = $query->group_end();
			$query = $query->get();

			// SELECT *
			// FROM `bh transactions`
			// WHERE
			// `services id` = '1'
			// AND
			// ( `date` <= checkin AND checkin <= end_date) OR
			// (`date` <= checkout AND checkout <= end_date) OR
			// (checkin >= `date` AND end_date <= checkout)
			// 2021\-05\-15
			// 2021\-05\-13

			// $query = $query->_compile_select();
			// echo $query;
			// exit;

			$number_of_double_bookings = count($query->result());
			return $number_of_double_bookings;
			// if (count($query->result()) > 0) {
			// 	// $statement = $query->result_array();
			// 	// $responce_status = array('responce' => "error 1? $number_of_double_bookings");
			// 	// header('Content-Type: application/json');
			// 	// echo json_encode($responce_status, JSON_PRETTY_PRINT);
			// 	// exit;
			//
			// } else {
			// 	// $responce_status = array('responce' => "error 0? $number_of_double_bookings");
			// 	// header('Content-Type: application/json');
			// 	// echo json_encode($responce_status, JSON_PRETTY_PRINT);
			// 	// exit;
			// }
		}
	}
}
