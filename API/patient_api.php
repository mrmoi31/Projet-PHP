<?php 

require_once 'APIPatient.php';

$http_method = $_SERVER['REQUEST_METHOD'];

	switch ($http_method) {
 		case 'GET':
			if (!isset($_GET['id'])) {
				$res = getAllUsager();
				if ($res === "vide") {
					deliver_response("400", "Aucun usager enregistré");
				} elseif ($res != null) {
					deliver_response("200", "OK", $res);
				} else {
					deliver_response("400", "Erreur SQL :", $res);
				}
			} else {
				$res = getUsagerById($_GET['id']);
				if ($res === "vide") {
					deliver_response("400", "Cet usager n'existe pas");
				} elseif ($res != null) {
					deliver_response("200", "OK", $res);
				} else {
					deliver_response("400", "Erreur SQL :", $res);
				}
			}
 			
 		break;
	
		case 'POST':
 			$data = (array) json_decode(file_get_contents('php://input'), TRUE);

	        if (!isset($data["civilite"]) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['sexe']) || !isset($data['adresse']) || !isset($data['ville']) || !isset($data['code_postal']) || !isset($data['date_nais']) || !isset($data['lieu_nais']) || !isset($data['num_secu'])) {
	            deliver_response(400, "Données manquantes");
		    } else {
				$civilite = $data['civilite'];
				$nom = $data["nom"];
				$prenom = $data["prenom"];
				$sexe = $data["sexe"];
				$adresse = $data["adresse"];
				$ville = $data["ville"];
				$code_postal = $data["code_postal"];
				$dateN = DateTime::createFromFormat('d/m/Y', $data["date_nais"]);
				$lieuN = $data["lieu_nais"];
				$numSecu = $data["num_secu"];
				$date_verif = $dateN->format('Y-m-d');

		    	$res = ajoutUsager($civilite, $nom, $prenom, $sexe, $adresse, $code_postal, $ville, $dateN, $lieuN, $numSecu, $date_verif);
		    	if ($res === "good") {
		    		deliver_response("200", "OK");
		    	} elseif ($res === "existant") {
		    		deliver_response("400", "Cet usager existe déjà");
		    	} else {
		    		deliver_response("400", "Erreur SQL :", $res);
		    	}
			}

 		break;		

		case 'DELETE' :
			$data = (array) json_decode(file_get_contents('php://input'), TRUE);
		
			if (!isset($_GET['id'])) {
				deliver_response("400", "Données manquantes");
			} else {
				$id = $_GET['id'];
				$res = supprimerUsager($id);
		    	if ($res === "good") {
		    		deliver_response("200", "OK", $res);
		    	} elseif ($res === "vide") {
		    		deliver_response("400", "Cet usager n'existe pas");
		    	} else {
		    		deliver_response("400", "Erreur SQL :", $res);
		    	}
			}
		
		break;

		case "PATCH":

				$dataPatch = (array) json_decode(file_get_contents('php://input'), TRUE);
				$id_usager = $_GET['id'];
				$res = modifUsager($id_usager, $dataPatch);

				if ($res === "good") {
					deliver_response("200", "OK", getUsagerById($_GET['id']));
				} elseif ($res === "vide") {
					deliver_response("400", "usager non trouvé");
				} else {
					deliver_response("400", "Erreur SQL : ", $res);
				}
		
			break;
 	}

?>