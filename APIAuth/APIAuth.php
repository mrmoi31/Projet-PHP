<?php

include 'jwt_utils.php';

include 'connexionBd.php';

$http_method = $_SERVER['REQUEST_METHOD'];
    if($http_method == "POST") {
        //get posted data
        $data = (array) json_decode(file_get_contents('php://input'), TRUE);

        //if the users exist, create a JWT
        if (!isset($data['username']) || !isset($data['password'])) {
            deliver_response(400, "Votre Login ou mot de passe est incorrect");
        } else {
            $username = $data['username'];
            $password = $data['password'];
            $query = "SELECT * FROM user WHERE username = :username";
            $stmt = $linkdpo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $result = $stmt->fetch();
            if ($username == $result['username'] && password_verify($password, $result['password'])) {
                $headers = array(
                    "alg" => "HS256",
                    "typ" => "JWT"
                );

                $payload = array(
                    "username" => $username,
                    "role" => $result['role'],
                    "exp" => (time() + 60));

                $secret = "g9V6bB8k";

                $jwt = generate_jwt($headers, $payload, $secret);
                deliver_response(200, "OK", $jwt);
            } else {
                deliver_response(401, "Votre Login ou mot de passe est incorrect");
            }
        }else {
            deliver_response(405, "Bad Method");
        }

    function deliver_response($status_code, $status_message, $data=null){
        // var_dump($data);
        $json_response = json_encode($data);
        if($json_response===false)
        die('json encode ERROR : '.json_last_error_msg());
        /// Paramétrage de l'entête HTTP
        http_response_code($status_code); //Utilise un message standardisé en fonction du code HTTP
        //header("HTTP/1.1 $status_code $status_message"); //Permet de personnaliser le message associé au code HTTP
        header("Content-Type:application/json; charset=utf-8");//Indique au client le format de la réponse
        $response['status_code'] = $status_code;
        $response['status_message'] = $status_message;
        $response['data'] = $data;
        /// Mapping de la réponse au format JSON
        $json_response = json_encode($response);
        if($json_response===false)
        die('json encode ERROR : '.json_last_error_msg());
        /// Affichage de la réponse (Retourné au client)
        echo $json_response;

  
       
    }

    

}

$linkdpo = null;