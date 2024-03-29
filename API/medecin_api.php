<?php 

include 'APIMedecin.php';

 $http_method = $_SERVER['REQUEST_METHOD'];

 	switch ($http_method) {
 		case 'GET':

 			if (!isset($_GET['id'])) {
 				
 				$res = getAllMedecins();
	 			if ($res != null) {
			    	deliver_response("200", "OK", $res);
			    } else {
			    	deliver_response("400", "probleme de requete");
			    }

 			}else {
 				$res = getMedecinById($_GET['id']);
 				if ($res != null) {
		    		deliver_response("200", "OK", $res);
		    	} else {
		    		deliver_response("400", "probleme de requete");
		    	}
 			}
 			
 			break;

		case 'POST':
 			$data = (array) json_decode(file_get_contents('php://input'), TRUE);

	        if (!isset($data['civilite']) || !isset($data['nom']) || !isset($data['prenom'])) {
	            deliver_response(400, "Données manquantes");
		    }else{

		    $civilite = $data['civilite'];
		    $nom = $data['nom'];
		    $prenom = $data['prenom'];

		    $res = ajoutMedecin($civilite, $nom, $prenom);
		    	if ($res != null) {
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
			break;
 	}

?>