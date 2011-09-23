<?php

	include_once 'DbAccess.php';
		
	function getMovieDataById($movieId, $limit) {	
		$query_string = "select m.movieid, m.title, m.year, d.directorid, d.name as directorname
						 from movies m
						 left outer join movies2directors m2d on (m.movieid = m2d.movieid)
						 left outer join directors d on (m2d.directorid = d.directorid)
						 where m.movieid = " . $movieId;
						
		if ($limit > 0) $query_string .= ' limit ' . $limit;
		
		$dba = new DbAccess($query_string);
		$json = $dba->getDataAsJson();

		return $json;
	}
	
?>