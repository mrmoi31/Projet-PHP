<?php 

include 'APIPatient.php';

$http_method = $_SERVER['REQUEST_METHOD'];

	switch ($http_method) {
 		case 'GET':
			if (!isset($_GET['id'])) {
				$res = getAllUsager();
				if ($res != null) {
					deliver_response("200", "OK", $res);
				} else {
					deliver_response("400", "probleme de requete");
				}
			} else {
				$res = getUsagerById($_GET['id']);
				if ($res != null) {
					deliver_response("200", "OK", $res);
				} else {
					deliver_response("400", "probleme de requete");
				}
			}
 			
 		break;
	
		case 'POST':
 			$data = (array) json_decode(file_get_contents('php://input'), TRUE);

	        if (!isset($data["civilite"]) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['sexe']) || !isset($data['adresse']) || !isset($data['ville']) || !isset($data['code_postal']) || !isset($data['date_nais']) || !isset($data['lieu_nais']) || !isset($data['num_secu'])) {
	            deliver_response(400, "Données manquantes");
		    } else {
				$civilite = 	$data['civilite'];
				$nom = 			$data["nom"];
				$prenom = 		$data["prenom"];
				$sexe = 		$data["sexe"];
				$adresse = 		$data["adresse"];
				$ville = 		$data["ville"];
				$code_postal = 	$data["code_postal"];
				$dateN = 		$data["date_nais"];
				$lieuN = 		$data["lieu_nais"];
				$numSecu = 		$data["num_secu"];

		    	$res = ajoutUsager($civilite, $nom, $prenom, $sexe, $adresse, $ville, $code_postal, $dateN, $lieuN, $numSecu);
		    	if ($res = null) {
		    		deliver_response("200", "OK", $res);
		    	} else {
		    		deliver_response("400", "probleme de requete");
		    	}	
			}

 		break;		

		case 'DELETE' :
			$data = (array) json_decode(file_get_contents('php://input'), TRUE);
		
			if (!isset($_GET['id'])) {
				deliver_response(400, "Données manquantes");
			} else {
				$id = $_GET['id'];
				$res = supprimerUsager($id);
				if ($res === null) {
		   		 	deliver_response("200", "OK");
		   		} else {
		   		 	deliver_response("400", "probleme de requete");
		   		}
			}
		
		break;

		case "PATCH":

				patchUnPatient();
		
			break;

		case "PUT":
		
				putUnPatient();
		
			break;
 	}

?>