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

	        if (!isset($data['civilite']) || !isset($data['nom'] || !isset($data['prenom']))) {
	            deliver_response(400, "Données manquantes");
		    }else{

	        $civilite = isset($_POST["civilite"]) ? $_POST["civilite"] : '';
	        $nom = isset($_POST["nom"]) ? $_POST["nom"] : '';
	        $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : '';
	        $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : '';
	        $ville = isset($_POST["ville"]) ? $_POST["ville"] : '';
	        $code_postal = isset($_POST["codePostal"]) ? $_POST["codePostal"] : '';
	        $dateN = isset($_POST["dateNaissance"]) ? $_POST["dateNaissance"] : '';
	        $lieuxN = isset($_POST["lieuNaissance"]) ? $_POST["lieuNaissance"] : '';
	        $numSecu = isset($_POST["numSecu"]) ? $_POST["numSecu"] : '';
	        $id_medecin = isset($_POST["id_medecin"]) ? $_POST["id_medecin"] : '';


		    $res = ajoutPatient($civilite, $nom, $prenom, $adresse, $ville, $codePostal, $dateN, $lieuxN, $numSecu, $id_medecin);
		    if (!$res) {
		    	deliver_response("200", "OK", $res);
		    } else {
		    	deliver_response("400", "probleme de requete");
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