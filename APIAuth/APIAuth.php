<?php

include 'jwt_utils.php';
require 'ConnexionBdAuth.php';


// function connexionBdAuth() {

//     $server = "localhost";
//     $db = "projet-api-bd";
//     $login = "root";
//     $mdp = "";

//     //Connection base de donnée
//     try{'
//         $linkpdo = new PDO("mysql:host=$server; dbname=$db", $login, $mdp);
//     } 
//     //Verification connection
//     catch (Exception $e) {
//         die('Erreur: ' . $e->getMessage());

//         return $linkpdo;
//     }}

function demandeJeton($username, $password){


    $linkpdo = connexionBdAuth::getInstance();
    //if the users exist, create a JWT
        $query = "SELECT * FROM `user_auth_v1` WHERE `login` = :username";
        $stmt = $linkpdo->prepare($query); 
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result == true) {
            if ($username == $result['login'] && password_verify($password, $result['mdp'])) {
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
    } else {
        deliver_response(401, "Votre Login ou mot de passe est incorrect");
    }
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



$linkpdo = null;