<?php

include 'jwt_utils.php';

class connexionBdAuth{
    public static connexionBdAuth | null $_instance = null;
    private PDO $_pdo;

    //Constructeur
    private function __construct(){
        try{
            $base_url = "mysql:host=%s;dbname=%s";
            $url = sprintf($base_url, "localhost", "api_auth");
            $this->_pdo = new PDO($url, "root", "");
        }catch (PDOException $e){
            die('Erreur: ' . $e->getMessage());

        }
    }

    //Getters
    public function getPDO(): PDO{
        return $this->_pdo;
    }

    //Singleton
    public static function getInstance (): ?PDO{
        if (is_null(self::$_instance)){
            self::$_instance = new connexionBdAuth();
        }
        return self::$_instance->getPDO();
    }
}



function demandeJeton($username, $password){


    $linkpdo = connexionBdAuth::getInstance();
    //if the users exist, create a JWT
    $query = "SELECT * FROM `user_auth_v1` WHERE `login` = :username";
    $stmt = $linkpdo->prepare($query); 
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($result);
        if (isset($result['login'])&& isset($result['mdp'])){
   
            if ($username == $result['login'] && password_verify($password, $result['mdp'])) {        
                $headers = array(
                    "alg" => "HS256",
                    "typ" => "JWT"
                );
                $payload = array(
                    "username" => $result['login'],
                    // "role" => $result['role'],
                    "exp" => (time() + 3600)
                );
                $secret = "g9V6bB8k";
                $jwt = generate_jwt($headers, $payload, $secret);
                // echo $jwt;
                return $jwt;    
            } else {
                deliver_response(401, "Votre Login  mot de passe est incorrect");
            }
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