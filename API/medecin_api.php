<?php 

include 'APIMedecin.php';

 $http_method = $_SERVER['REQUEST_METHOD'];

 	switch ($http_method) {
 		case 'GET':

 			$res = getAllMedecins();
 			if (!$res) {
		    	deliver_response("200", "OK", $res);
		    } else {
		    	deliver_response("400", "probleme de requete");
		    }
 			
 			break;

 		case 'POST':
 			$data = (array) json_decode(file_get_contents('php://input'), TRUE);

	        if (!isset($data['civilite']) || !isset($data['nom'] || !isset($data['prenom']))) {
	            deliver_response(400, "Données manquantes");
		        }
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
 		
		case "DELETE" :

				$data = (array) json_decode(file_get_contents('php://input'), TRUE);

				if (!isset($data['id'])) {
					deliver_response(400, "Données manquantes");
				} else {

					$id = $data['id'];

					$res = supprimerMedecin($id);
					if (!$res) {
		   		 	deliver_response("200", "OK", $res);
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
 	}

?>