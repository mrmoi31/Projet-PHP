<?php 

include 'APIConsultations.php';

 $http_method = $_SERVER['REQUEST_METHOD'];

 	switch ($http_method) {
 		case 'GET':

 			$res = getAllMedecins();
 			if ($res != null) {
		    	deliver_response("200", "OK", $res);
		    } else {
		    	deliver_response("400", "probleme de requete");
		    }
 			
 			break;

		case 'POST':
 			$data = (array) json_decode(file_get_contents('php://input'), TRUE);

	        if (!isset($data["id_medecin"]) || !isset($data["date_consult"])|| !isset($data["heure_consult"]) || !isset($data["id_usager"])|| !isset($data["duree_consult"])) {
	            deliver_response(400, "Données manquantes");
		    }else{

		    $id_medecin = $data['id_medecin'];
		    $dateRDV = $data['date_consult'];
		    $heureRDV = $data['heure_consult'];
		    $id_patient = $data['id_usager'];
			$dureeCons = $data['duree_consult'];

		    $res = ajoutConsultation($id_medecin, $id_patient ,$dateRDV, $heureRDV, $dureeCons);
		    if (!$res) {
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

					$res = supprimerMedecin($id);
					if ($res === null) {
		   		 		deliver_response("200", "OK");
		   			} else {
		   		 		deliver_response("400", "probleme de requete");
		   		 	}
				}
		
			break;

		case "PATCH":

				patchUnePhrase();
		
			break;

		case "PUT":
		
				putUnePhrase();
		
			break;

		default : 
			deliver_response(405, "Bad Method");
	}
	
?>