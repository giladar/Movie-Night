<?php
	include 'DbAccess.php';
	
	$actorId = '';
	if (isset($_GET['actorId'])) {
		$actorId = $_GET['actorId'];
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
	
	$query_string = "select m.movieid, a.actorid, m.title ,a.name,
					replace(replace(m2a.as_character, '[',''), ']','') as as_character,
					m.year  from movies2actors m2a, movies m, actors a
					where a.actorid = m2a.actorid
					and m.movieid = m2a.movieid
					and a.actorid = " . $actorId;
					
	if ($onlyMovies) {
		$query_string .= " and m.title not like '%(TV)%'
						  and m.title not like '%(V)%'
					      and substr(m.title, 1, 1) != '\"'";
	}
				
	if ($limit > 0) $query_string .= ' limit ' . $limit;
	
	$dba = new DbAccess($query_string);
	$json = $dba->getDataAsJson();
	
	header('Content-type: application/json');
	echo json_encode($json);

?>