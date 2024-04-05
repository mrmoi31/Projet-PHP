<?php 

require_once 'APIMedecin.php';

 $http_method = $_SERVER['REQUEST_METHOD'];

 	switch ($http_method) {
 		case 'GET':

			if (!isset($_GET['id'])) {
				$res = getAllMedecins();
				if ($res != null) {
					deliver_response("200", "OK", $res);
				} elseif ($res === "vide") {
					deliver_response("400", "Aucun enregistré");
				} else {
					deliver_response("400", "Erreur SQL : ", $res);
				}
			}else{
				$res = getMedecinById($_GET['id']);
				if (isset($res['id'])) {
					deliver_response("200", "OK", $res);
				} elseif ($res === "vide") {
					deliver_response("400", "Ce medecin n'existe pas");
				} else {
					deliver_response("400", "Erreur SQL : ", $res);
				}
			}	
 			
 			break;

		case 'POST':
 			$data = (array) json_decode(file_get_contents('php://input'), TRUE);

	        if (!isset($data['civilite']) || !isset($data['nom']) || !isset($data['prenom'])) {
	            deliver_response('400', "Données manquantes");
		    }else{

		    $civilite = $data['civilite'];
		    $nom = $data['nom'];
		    $prenom = $data['prenom'];

		    $res = ajoutMedecin($civilite, $nom, $prenom);
		    	if ($res === "good") {
		    		deliver_response("200", "OK");
		    	} elseif ($res === "existant") {
		    	deliver_response("400", "Ce medecin existe déjà");
		    } else {
		    	deliver_response("400", "Erreur SQL :", $res);
			}
		}
 			break;

 		
		case 'DELETE' :

				$data = (array) json_decode(file_get_contents('php://input'), TRUE);

				if (!isset($_GET['id'])) {
					deliver_response(400, "Données manquantes");
				} else {

					$id = $_GET['id'];

					$res = supprimerMedecin($id);
		    		if ($res === "good") {
		    			deliver_response("200", "OK", $res);
		    		} elseif ($res === "vide") {
		    			deliver_response("400", "Ce medecin n'existe pas");
		    		} else {
		    			deliver_response("400", "Erreur SQL :", $res);
		    		}
				}
		
			break;

		case "PATCH":
		
				$dataPatch = (array) json_decode(file_get_contents('php://input'), TRUE);
				$id_medecin = $_GET['id'];
				$res = patchMedecin($id_medecin, $dataPatch);

				if ($res === "good") {
					deliver_response("200", "OK", getConsultById($_GET['id']));
				} elseif ($res === "vide") {
					deliver_response("400", "medecin non trouvée");
				} else {
					deliver_response("400", "Erreur SQL : ", $res);
				}
		
			break;
			
		default :
				deliver_response('405', "Bad Method");
			break;
 	}

?>