 <?php 

 include 'APIAuth.php';

  $http_method = $_SERVER['REQUEST_METHOD'];
  	switch ($http_method) {
  		 case 'GET':
			$token = get_bearer_token();
			echo $token;
			

			if(!isset($token)|| !(is_jwt_valid($token, "g9V6bB8k"))){
				deliver_response(401, "Unauthorized");
				exit;
			}else{
				deliver_response(200, "OK");
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
 			// echo $res;
 		    if ($res) {
 		    	deliver_response("201", "OK", $res);
 		    } else {
 		    	deliver_response("400", "probleme de requete");
 		    }}
  			break;	
             default: 
             deliver_response(405, "Bad Method");

        }

 		
		

// ?>