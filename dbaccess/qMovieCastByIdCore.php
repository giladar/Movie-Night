<?php

	include_once 'DbAccess.php';
	
	function appearanceCompare($x, $y) {
		return $x['appearance'] - $y['appearance'];
	}
	
	function getMovieCastById($movieId, $limit) {	
		$query_string = "select m2a.movieid, m2a.actorid,
						replace(replace(m2a.as_character, '[',''), ']','') as as_character,
						m.title, m.year, a.name, a.parsedname
						from movies2actors m2a, movies m, actors a
						where m2a.movieid = m.movieid
						and m2a.actorid = a.actorid
						and m2a.movieid = " . $movieId;
						
		if ($limit > 0) $query_string .= ' limit ' . $limit;
		
		$dba = new DbAccess($query_string);
		$json = $dba->getDataAsJson();
		
		foreach ($json as $index => $value) {
			$num = count($json) + 1;
			if (preg_match("/.*?<(\d+)>/", $value['as_character'], $matches)) {
				$num = $matches[1];			
				$json[$index]['as_character'] = trim(str_replace('<' . $num . '>','',$json[$index]['as_character']));		
			}
			$json[$index]['appearance'] = $num;
		}
		usort($json,'appearanceCompare');
		return $json;
	}
	
?>