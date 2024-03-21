<?php 

include 'APIPatient.php';

 $http_method = $_SERVER['REQUEST_METHOD'];

 	switch ($http_method) {
 		case 'GET':

 			$res = getAllPatient();
 			if ($res != null) {
		    	deliver_response("200", "OK", $res);
		    } else {
		    	deliver_response("400", "probleme de requete");
		    }
 			
 			break;

			/*
			case 'POST':
 			$data = (array) json_decode(file_get_contents('php://input'), TRUE);

	        if (!isset($data['civilite']) || !isset($data['nom'] || !isset($data['prenom']))) {
	            deliver_response(400, "Données manquantes");
		    }else{

		    $civilite = $data['civilite'];
		    $nom = $data['nom'];
		    $prenom = $data['prenom'];

		    $res = ajoutMedecin($civilite, $nom, $prenom);
		    if (!$res) {
		    	deliver_response("200", "OK", $res);
		    } else {
		    	deliver_response("400", "probleme de requete");
		    }

 			break;
 			*/
			

 		
		case 'DELETE' :

				$data = (array) json_decode(file_get_contents('php://input'), TRUE);

				if (!isset($_GET['id'])) {
					deliver_response(400, "Données manquantes");
				} else {

					$id = $_GET['id'];

					$res = supprimerPatient($id);
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