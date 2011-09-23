<?php

	include_once 'DbCreds.php';

	class DbAccess {
		var $query;
		var $dbc;

		function getDataAsJson() { 
		
			$db = mysql_connect($this->dbc->getDbHost(), 
								$this->dbc->getDbUser(),
								$this->dbc->getDbPass())
			or die("Can't connect to database");

			mysql_select_db($this->dbc->getDatabase())
			or die("Can't select database");

			mysql_set_charset('utf8', $db); 
			
			$result = mysql_query($this->query);

			$fields_num = mysql_num_fields($result);

			$fields = array();
			for ($i = 0; $i < $fields_num; $i++) {
				$field = mysql_fetch_field($result);
				$fields[] = $field->name;
			}
			
			$json = array();
			while ($row = mysql_fetch_row($result)) {
				$record = array();
				for ($i = 0; $i < $fields_num; $i++) {
					$record[$fields[$i]] = $row[$i];
				}
				$json[] = $record;
			}
			mysql_free_result($result);
			mysql_close($db);
			return $json;
		}

		function __construct($query) {
			$this->query = $query;
			$this->dbc = new DbCreds();
		}
	}

?>