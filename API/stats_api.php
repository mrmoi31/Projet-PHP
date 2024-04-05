<?php

require_once 'APIStats.php';

$http_method = $_SERVER['REQUEST_METHOD'];

$cible = $_GET['cible'];

switch ($http_method) {
	case 'GET':
			if ($cible == 'med') {
				$res = getStatMedecin();
				if ($res === "vide") {
					deliver_response("400", "Aucune statistique enregistrée");
				} elseif ($res != null) {
					deliver_response("200", "OK", $res);
				} else {
					deliver_response("400", "Erreur SQL :", $res);
				}
			} else if ($cible == 'usa') {
				$res = getStatUsager();
				if ($res === "vide") {
					deliver_response("400", "Aucune statistique enregistrée");
				} elseif ($res != null) {
					deliver_response("200", "OK", $res);
				} else {
					deliver_response("400", "Erreur SQL :", $res);
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