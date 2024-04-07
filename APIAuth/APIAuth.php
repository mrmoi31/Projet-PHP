<?php

include 'jwt_utils.php';

// Class for handling database connection
class connexionBdAuth{
    public static connexionBdAuth | null $_instance = null;
    private PDO $_pdo;

    // Constructor
    private function __construct(){
        try{
            $base_url = "mysql:host=%s;dbname=%s";
            $url = sprintf($base_url, "mysql-api-auth.alwaysdata.net", "api-auth_bd_user_auth_v1");
            $this->_pdo = new PDO($url, "root", ""); // Connect to the database
        }catch (PDOException $e){
            die('Erreur: ' . $e->getMessage()); // Display error message if connection fails
        }
    }

    // Getters
    public function getPDO(): PDO{
        return $this->_pdo;
    }

    // Singleton
    public static function getInstance (): ?PDO{
        if (is_null(self::$_instance)){
            self::$_instance = new connexionBdAuth(); // Create a new instance if it doesn't exist
        }
        return self::$_instance->getPDO();
    }
}

// Function to check the validity of a token
function checkToken($token){
    echo $token; // Output the token (for testing purposes)

    $url = "http://localhost";
    $option = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token),
        CURLOPT_CUSTOMREQUEST => 'GET'
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $option);
    $rep = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($rep, true);
    if($data['status_code'] == 200){
        return true; // Token is valid
    } else {
        return false; // Token is invalid
    }
}        

// Function to request a token
function demandeJeton($username, $password){
    $linkpdo = connexionBdAuth::getInstance(); // Get the database connection

    // Check if the user exists
    $query = "SELECT * FROM `user_auth_v1` WHERE `login` = :username";
    $stmt = $linkpdo->prepare($query); 
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (isset($result['login']) && isset($result['mdp'])){
        if ($username == $result['login'] && password_verify($password, $result['mdp'])) {        
            $headers = array(
                "alg" => "HS256",
                "typ" => "JWT"
            );
            $payload = array(
                "username" => $result['login'],
                "exp" => (time() + 3600) // Token expiration time (1 hour from now)
            );
            $secret = "g9V6bB8k";
            $jwt = generate_jwt($headers, $payload, $secret); // Generate a JWT
            return $jwt; // Return the generated token
        } else {
            deliver_response(401, "Votre Login  mot de passe est incorrect"); // Return an error response
        }
    }
}

// Function to deliver a response
function deliver_response($status_code, $status_message, $data=null){
    $json_response = json_encode($data);
    if($json_response===false)
    die('json encode ERROR : '.json_last_error_msg());

    http_response_code($status_code); // Set the HTTP response code
    header("Content-Type:application/json; charset=utf-8"); // Set the response content type

    $response['status_code'] = $status_code;
    $response['status_message'] = $status_message;
    $response['data'] = $data;

    $json_response = json_encode($response);
    if($json_response===false)
    die('json encode ERROR : '.json_last_error_msg());

    echo $json_response; // Output the response
}

$linkpdo = null; // Close the database connection
