<?php 

require_once 'APIConsultations.php';

 $http_method = $_SERVER['REQUEST_METHOD'];

 	switch ($http_method) {
 		case 'GET':

			if (!isset($_GET['id'])) {
				$res = getAllConsult();
				if ($res != null) {
					deliver_response("200", "OK", $res);
				} elseif ($res === "vide") {
					deliver_response("400", "Aucune consultation enregistrée");
				} else {
					deliver_response("400", "Erreur SQL :", $res);
				}
			}else{
				$res = getConsultById($_GET['id']);
				if ($res != null) {
					deliver_response("200", "OK", $res);
				} elseif ($res === "vide") {
					deliver_response("400", "Cette consultation n'existe pas");
				} else {
					deliver_response("400", "Erreur SQL :", $res);
				}
			}	
 			
 			break;

		case 'POST':
 			$data = (array) json_decode(file_get_contents('php://input'), TRUE);

	        if (!isset($data["id_medecin"]) || !isset($data["date_consult"])|| !isset($data["heure_consult"]) || !isset($data["id_usager"])|| !isset($data["duree_consult"])) {
	            deliver_response("400", "Données manquantes");
		    }else{

		    $id_medecin = $data['id_medecin'];
		    $dateRDV = $data['date_consult'];
		    $heureRDV = $data['heure_consult'];
		    $id_patient = $data['id_usager'];
			$dureeCons = $data['duree_consult'];

		    $res = ajoutConsultation($id_medecin, $id_patient ,$dateRDV, $heureRDV, $dureeCons);
		    if ($res === "good") {
		    	deliver_response("200", "OK");
		    } elseif ($res === "existant") {
		    	deliver_response("400", "Cette consultation existe déjà");
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

					$res = supprimerConsultation($id);
		    		if ($res === "good") {
		    			deliver_response("200", "OK", $res);
		    		} elseif ($res === "vide") {
		    			deliver_response("400", "Cette consultation n'existe pas");
		    		} else {
		    			deliver_response("400", "Erreur SQL :", $res);
		    		}
				}
		
			break;

		case "PATCH":

				$dataPatch = (array) json_decode(file_get_contents('php://input'), TRUE);
				$id_consult = $_GET['id'];
				$res = patchConsultation($id_consult, $dataPatch);

				if ($res === "good") {
					deliver_response("200", "OK", getConsultById($_GET['id']));
				} elseif ($res === "vide") {
					deliver_response("400", "consultation non trouvée");
				} else {
					deliver_response("400", "Erreur SQL : ", $res);
				}
		
			break;

		default : 
			deliver_response(405, "Bad Method");
	}
	
?>