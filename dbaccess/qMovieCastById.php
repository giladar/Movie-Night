<?php

	include 'qMovieCastByIdCore.php';
	
	$movieId = '';
	if (isset($_GET['movieId'])) {
		$movieId = $_GET['movieId'];
	}
	else die();
	
	$limit = 0;
	if (isset($_GET['limit'])) {
		$limit = $_GET['limit'];
	}
	
	$json = getMovieCastById($movieId, $limit);
	
	header('Content-type: application/json');
	echo json_encode($json); 

?>