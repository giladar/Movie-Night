<?php

	include 'DbAccess.php';
	
	$limit = 0;
	if (isset($_GET['limit'])) {
		$limit = $_GET['limit'];
	}
	
	$id_string = "";
	$m2a_string = "";
	$join_string = "";

	$i = 0;
	foreach ($_GET as $param => $value) {
		if ($param != "limit") {
			$i++;
			$id_string .= "actor" . $i . ".actorid as id" . $i . ",";
			$m2a_string .= "(select * from movies2actors where actorid = " . $value . ") actor" . $i . ",";
			if ($i > 1) {
				$join_string .= "actor1.movieid = actor" . $i . ".movieid and ";
			}
		}
	}
	$id_string = substr($id_string, 0, strlen($id_string) - 1);
		
	$query_string  = "select m.year, m.movieid, " . $id_string . ", m.title from ";
	$query_string .= $m2a_string . "movies m where ";
	$query_string .= $join_string;
	$query_string .= "actor1.movieid = m.movieid ";
	$query_string .= "and substr(m.title, 1, 1) != '\"' and m.title not like '%(tv)%'";
	$query_string .= "and m.title not like '%(v)%' order by m.year asc";
	
	//echo $query_string;
					
	if ($limit > 0) $query_string .= ' limit ' . $limit;
	
	$dba = new DbAccess($query_string);
	$json = $dba->getDataAsJson();
	
	header('Content-type: application/json;');
	echo json_encode($json);

?>