<?php 

include 'APIAuth.php';

 $http_method = $_SERVER['REQUEST_METHOD'];

 	switch ($http_method) {
 		case 'GET':

 			$res = getAllMedec();
 			if ($res != null) {
		    	deliver_response("200", "OK", $res);
		    } else {
		    	deliver_response("400", "probleme de requete");
		    }
 			
 			break;

		case 'POST':
 			$data = (array) json_decode(file_get_contents('php://input'), TRUE);

	        if (!isset($data['login']) || !isset($data['mdp'])) {
	            deliver_response(400, "Données manquantes");
		    }else{

		    $username = $data['login'];
		    $password = $data['mdp'];
		    

		    $res = demandeJeton($username, $password);
		    if (!$res) {
		    	deliver_response("200", "OK", $res);
		    } else {
		    	deliver_response("400", "probleme de requete");
		    }}

 			break;	

            default: 
            deliver_response(405, "Bad Method");

        }

 		
		

?>