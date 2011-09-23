<?php

	include 'DbAccess.php';
	
	$name = '';
	if (isset($_GET['name'])) {
		$name = $_GET['name'];
	}
	else die();
	
	$limit = 0;
	if (isset($_GET['limit'])) {
		$limit = $_GET['limit'];
	}
	
	$query_string = "select * from (select * from actors where parsedname like '%" . str_replace(' ', '%', $name) . "%') a order by totalvotes desc";
					
	if ($limit > 0) $query_string .= ' limit ' . $limit;
	
	$dba = new DbAccess($query_string);
	$json = $dba->getDataAsJson();
	
	header('Content-type: application/json');
	echo json_encode($json);

?>