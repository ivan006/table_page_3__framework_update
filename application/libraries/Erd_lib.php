<?php
class Erd_lib
{
	private $CI;

	function __construct()
	{
		// $this->load->helper(array('form', 'url'));
		// $this->load->library('form_validation');

		$this->CI =& get_instance();
		$this->CI->load->database();
	}


	function erd_to_db()
	{

		$erd_two_path = $this->erd_path().'/erd.json';
		// include($erd_two_path);
		$erd_two = file_get_contents($erd_two_path);
		$erd_two = json_decode($erd_two, true);
		// $erd_two = json_encode($erd_two, JSON_PRETTY_PRINT);

		ob_start();
		foreach ($erd_two as $table_key => $table) {
			$table_fields = $table["fields"];
			echo "CREATE TABLE `".$table_key."` "."(\n";
			// echo "`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT ,\n";

			$nth_field = 0;
			foreach ($table_fields as $field_key => $field_value) {

				$nth_field = $nth_field+1;
				if ($nth_field > 1) {
					echo ",\n";
				}

				$fld = $field_value;
				echo "`";
				echo $field_key;
				echo "` ";
				if (isset($fld["Type"])) {
					echo $fld["Type"];
					echo " ";
				}
				if (isset($fld["Default"])) {
					echo $fld["Default"];
					echo " ";
				}
				if (isset($fld["Null"])) {
					if ($fld["Null"] == "NO") {
						echo "NOT NULL";
						echo " ";
					}
				}
				if (isset($fld["Comments"])) {
					echo $fld["Comments"];
					echo " ";
				}
				if (isset($fld["a_i"])) {
					echo $fld["a_i"];
					echo " ";
				}
				if (isset($fld["Virtuality"])) {
					echo $fld["Virtuality"];
					echo " ";
				}
				if (isset($fld["Extra"])) {
					echo $fld["Extra"];
					echo " ";
				}
				if (isset($fld["Key"])) {
					if ($fld["Key"] == "PRI") {
						echo "PRIMARY KEY";
						echo " ";
					}
				}

			}
			// echo ",\nPRIMARY KEY (`id`)";
			echo "\n) ENGINE = InnoDB;";
			echo "\n\n";
		}
		?>

		<?php
		$erd = ob_get_contents();

		ob_end_clean();

		return $erd;
	}

	function erd()
	{
		$one_path = $this->erd_path().'/erd.json';
		// include($one_path);
		$one = file_get_contents($one_path);
		$one = json_decode($one, true);

		// ksort($one);
		// foreach ($one as $key => $value) {
		// 	ksort($value["fields"]);
		// 	$one[$key]["fields"] = $value["fields"];
		// }
		$one = json_encode($one, JSON_PRETTY_PRINT);


		return $one;
	}

	function erd_path()
	{
		$one_path = APPPATH.'erd/active.json';
		$one = file_get_contents($one_path);
		$one = json_decode($one, true);
		$one = $one[0];

		// $one_path = APPPATH.'erd/active.json';
		$one_path = APPPATH."erd/$one";

		return $one_path;
	}

	function diff()
	{

		$db_to_erd = $this->db_to_erd();

		$erd = $this->erd();
		$erd_no_rels = json_decode($erd, true);
		foreach ($erd_no_rels as $key => $value) {
			unset($erd_no_rels[$key]["items"]);
		}
		$erd_no_rels = json_encode($erd_no_rels, JSON_PRETTY_PRINT);


		if ($db_to_erd == $erd_no_rels) {
			$identicle = "yes";
		} else {
			$identicle = "no";
			// code...
		}

		return $identicle;
	}

	function erd_two_old()
	{
		$one_path = $this->erd_path()."/one.json";
		// include($one_path);
		$one = file_get_contents($one_path);
		$one = json_decode($one, true);
		// $one_json = json_encode($one, JSON_PRETTY_PRINT);

		$relationships = $this->relationships($one);
		$relationships_json = json_encode($relationships, JSON_PRETTY_PRINT);

		// echo "<pre>";
		// echo $relationships_json;
		// exit;

		$tables = array();
		$nth_table = 0;
		foreach ($relationships as $table_key => $table_value) {

			// $tables[$table_key]["name"] = $table_key;
			// $tables[$table_key]["primary_key"] = "id";
			// $tables[$table_key][] = array(
			// 	"name" => "id",
			// 	"Type" => "bigint(20) unsigned",
			// 	"null" => "NOT NULL",
			// 	"a_i" => "AUTO_INCREMENT",
			// );

			$tables[$table_key] = array();

			foreach ($table_value["has_many"] as $rel_name) {
				// if ($rel_value !== "") {
				// 	$speciality = $rel_value."_specialty_";
				//
				//
				// } else {
				// 	$speciality = "";
				// }
				// $rel_key = $this->grammar_singular($rel_name);

				$rel = $this->relationship_helper($rel_name, $table_key);

				$tables[$table_key][$rel["rel_name_singular"]."_children"] = array(
				"Type" => "bigint(20) unsigned",
				);
			}
			foreach ($table_value["has_one"] as $rel_name) {
				// if ($rel_value !== "") {
				// 	$speciality = $rel_value."_specialty_";
				// } else {
				// 	$speciality = "";
				// }
				// $rel_key = $this->grammar_singular($rel_key);
				$rel = $this->relationship_helper($rel_name, $table_key);
				$tables[$table_key][$rel["rel_name_singular"]."_id"] = array(
				"Type" => "bigint(20) unsigned",
				);
			}

			foreach ($table_value["has_many_belong_many"] as $rel_name) {
				// if ($rel_value !== "") {
				// 	$speciality = $rel_value."_specialty_";
				// } else {
				// 	$speciality = "";
				// }
				// $rel_key = $this->grammar_singular($rel_key);
				$table_key_singular = $this->grammar_singular($table_key);
				$rel = $this->relationship_helper($rel_name, $table_key);

				// echo $rel["rel_name_singular"]."----".$rel["foreign_singular"]."<br>";
				$link_table = array(
					$table_key_singular,
					// $rel["rel_name_singular"]
					$rel["foreign_singular"]
				);
				sort($link_table);
				$link_table = implode("_",$link_table);
				// $link_table = $rel["specialty_prefix"].$link_table."_links";
				$link_table = $link_table."_links";

				$tables[$link_table][$rel["rel_name_singular"]."_id"] = array(
				"Type" => "bigint(20) unsigned",
				);


				$link_table = $this->grammar_singular($link_table);
				$tables[$table_key][$link_table."_children"] = array(
				"Type" => "bigint(20) unsigned",
				);
			}


			$tables[$table_key]["name"] = array(
				"Type" => "varchar(100)",
				"Null" => "NOT NULL",
			);

			$nth_table = $nth_table+1;
		}
		$tables_json = json_encode($tables, JSON_PRETTY_PRINT);


		return $tables_json;
	}

	function relationships($one)
	{

		$result = array();
		foreach ($one as $table_key => $table_value) {
			$result[$table_key]["has_many"] = $table_value;
			$result[$table_key]["has_one"] = array();
			$result[$table_key]["has_many_belong_many"] = array();
		}

		foreach ($result as $table_key => $table_value) {
			$has_manies_to_unset = array();
			foreach ($table_value["has_many"] as $rel_key => $rel_name) {

				$rel = $this->relationship_helper($rel_name, $table_key);


			}
			// var_dump($has_manies_to_unset);
			foreach ($has_manies_to_unset as $key => $value) {
				unset($result[$value[0]]["has_many"][$value[1]]);
				// echo "<br>result[".$value[0]."][\"has_many\"][".$value[1]."]";
			}
		}

		return $result;
	}

	function model_two()
	{
		// $one_path = $this->erd_path()."/one.json";
		// $one = file_get_contents($one_path);
		// $one = json_decode($one, true);
		$one = '{
			"events": [
				"resources"
			],
			"resources": [
				"bedding_specialty_events",
				"personal_specialty_events"
			],
			"organizations": [
				"buyer_specialty_events",
				"seller_specialty_events"
			]
		}
		';
		$one = json_decode($one, true);

		$relationships = $this->relationships($one);
		$relationships_json = json_encode($relationships, JSON_PRETTY_PRINT);


		ob_start();
		// foreach ($erd_two as $table_key => $table) {
		foreach ($relationships as $table_key => $table_value) {

			echo "class ".ucfirst($this->grammar_singular($table_key)) ." extends DataMapper {\n\n";
			echo "	public \$has_one = array(\n";
			if (isset($table_value["has_one"])) {
				foreach ($table_value["has_one"] as $relative_key => $relative_value) {
					echo "		\"";
					echo $this->grammar_singular($relative_value);
					echo "\",\n";

				}
			} else {
				echo "		// code...";
			}
			echo "	);\n\n";

			echo "	public \$has_many = array(\n";
			if (isset($table_value["has_many"])) {
				foreach ($table_value["has_many"] as $relative_key => $relative_value) {
					echo "		\"";
					echo $this->grammar_singular($relative_value);
					echo "\",\n";

				}
			} else {
				echo "		// code...";
			}
			echo "	);\n\n\n";
		}
		?>

		<?php
		$result = ob_get_contents();

		ob_end_clean();


		return $result;
	}

	function endsWith( $haystack, $needle ) {
		$length = strlen( $needle );
		if( !$length ) {
			return true;
		}
		return substr( $haystack, -$length ) === $needle;
	}

	function grammar_singular( $string ) {
		if ($this->endsWith( $string, "ies" )) {
			$string = substr($string, 0, -3)."y";
		} elseif ($this->endsWith( $string, "s" )) {
			$string = substr($string, 0, -1);
		}
		return $string;
	}

	function relationship_helper($rel_name, $local_table) {
		$rel_name_singular = $this->grammar_singular($rel_name);


		$rel = array(
			"rel_name_singular" => $rel_name_singular,
		);

		return $rel;
	}

	function grammar_plural( $string ) {
		if ($this->endsWith( $string, "y" )) {
			$string = substr($string, 0, -1)."ies";
		} else {
			$string = $string."s";
		}
		return $string;
	}

	function db_to_erd()
	{


		$tables = $this->tables_in_db();


		// ksort($tables);
		$erd = $this->erd();
		$erd = json_decode($erd, true);


		$tables_and_fields = array();
		foreach ($tables as $key => $value) {

			$query = array(
				"SHOW COLUMNS FROM `$key`",
			);
			$query = implode(" ", $query);
			$query_result = $this->CI->db->query($query)->result_array();

			$fields = $query_result;

			$fields_result = array();
			foreach ($fields as $fields_key => $fields_value) {
				$field_props = $fields_value;
				foreach ($field_props as $field_props_key => $field_props_value) {
					switch ($field_props_key) {
						case 'Null':
						if ($field_props_value == "YES") {
							unset($field_props[$field_props_key]);
						}
						case 'Key':
						if ($field_props_value == "") {
							unset($field_props[$field_props_key]);
						}
						case 'Default':
						if ($field_props_value == null) {
							unset($field_props[$field_props_key]);
						}
						case 'Extra':
						if ($field_props_value == "") {
							unset($field_props[$field_props_key]);
						}

						break;

						default:
						// code...
						break;
					}
				}
				$fields_result[$field_props["Field"]] = $field_props;
				unset($fields_result[$field_props["Field"]]["Field"]);

			}
			// ksort($fields_result);


			$tables_and_fields[$key]["fields"] = $fields_result;
			// echo $key."<br>";
			// print_r( $erd);
			if (isset($erd[$key]["items"])) {
				$tables_and_fields[$key]["items"] = $erd[$key]["items"];
			}


			// $query = array(
			// 	"SHOW TABLE STATUS LIKE '$key'",
			// );
			// $query = implode(" ", $query);
			// $query_result = $this->CI->db->query($query)->result_array();
			// $Auto_increment = $query_result[0]["Auto_increment"];
			//
			// $tables_and_fields[$key]["auto_increment"] = $Auto_increment;

		}

		$result = json_encode($tables_and_fields, JSON_PRETTY_PRINT);
		return $result;

	}

	function tables_in_db()
	{
		$query = array(
			"SHOW TABLES",
		);
		$query = implode(" ", $query);
		$query_result = $this->CI->db->query($query)->result_array();


		// $query_result = array_column($query_result, 'Field');

		$tables = array();
		foreach ($query_result as $key => $value) {
			$value = reset($value);
			$result[$value] = array();
		}
		return $result;

	}

}
