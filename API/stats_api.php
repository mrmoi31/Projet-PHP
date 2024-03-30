<?php

include 'APIStats.php';

$http_method = $_SERVER['REQUEST_METHOD'];

// $cible = ???

switch ($http_method) {
	case 'GET':
			if ($cible == 'med') {
				$res = getStatMedecin();
				if ($res != null) {
			    	deliver_response("200", "OK", $res);
			    } else {
			    	deliver_response("400", "probleme de requete");
			    }
			} else if ($cible == 'usa') {
				$res = getStatUsager();
				if ($res != null) {
			    	deliver_response("200", "OK", $res);
			    } else {
			    	deliver_response("400", "probleme de requete");
			    }
			} else {
				deliver_response('400', "cible inconnue");
			}

		break;
	
	default:
		deliver_response('405', 'Bad Method');
		break;
}

?>