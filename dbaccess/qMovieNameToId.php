<?php
	include 'DbAccess.php';
	
	$movieName = '';
	if (isset($_GET['movieName'])) {
		$movieName = $_GET['movieName'];
	}
	else die();
	
	$onlyMovies = false;
	if (isset($_GET['onlyMovies'])) {
		$onlyMovies = $_GET['onlyMovies'];
	}
	
	$limit = 0;
	if (isset($_GET['limit'])) {
		$limit = $_GET['limit'];
	}
	
	$query_string = "select m.title, m.movieid, m.year from movies m
					where m.title like '%" . str_replace(' ', '%', $movieName) . "%'";
					
	if ($onlyMovies) {
		$query_string .= "and m.title not like '%(TV)%'
						  and m.title not like '%(V)%'
					      and substr(m.title, 1, 1) != '\"'";
	}
				
	if ($limit > 0) $query_string .= ' limit ' . $limit;
	
	$dba = new DbAccess($query_string);
	$json = $dba->getDataAsJson();
	
	header('Content-type: application/json');
	echo json_encode($json);

?>