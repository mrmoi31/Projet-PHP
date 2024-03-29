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

			
		case 'POST':
 			$data = (array) json_decode(file_get_contents('php://input'), TRUE);

	        if (!isset($data['civilite']) || !isset($data['nom']) || !isset($data['prenom']) || !isset($data['sexe']) || !isset($data['adresse']) || !isset($data['ville']) || !isset($data['code_postal']) || !isset($data['date_nais']) || !isset($data['lieu_nais']) || !isset($data['num_secu']) || !isset($data['id_medecin']) ) 
	        {
	            deliver_response(400, "Données manquantes");
		    }else{

	        $civilite = $_POST["civilite"];
	        $nom = $_POST["nom"];
	        $prenom = $_POST["prenom"];
	        $sexe = $_POST["sexe"];
	        $adresse = $_POST["adresse"];
	        $ville = $_POST["ville"];
	        $code_postal = $_POST["code_postal"];
	        $dateN = $_POST["date_nais"];
	        $lieuxN = $_POST["lieu_nais"];
	        $numSecu = $_POST["num_secu"];
	        $id_medecin = $_POST["id_medecin"];


		    $res = ajoutPatient($civilite, $nom, $prenom, $sexe, $adresse, $ville, $code_postal, $dateN, $lieuxN, $numSecu, $id_medecin);
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