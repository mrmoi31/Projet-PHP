<?php

function deliver_response($status_code, $status_message, $data=null){
    /// Paramétrage de l'entête HTTP
    http_response_code($status_code); //Utilise un message standardisé en fonction du code HTTP
    //header("HTTP/1.1 $status_code $status_message"); //Permet de
    //personnaliser le message associé au code HTTP
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

// Fonction pour récupérer les statistiques des médecins
    function getStatMedecin(){
        //$conn = connexionBD::getInstance();
        $base_url = "mysql:host=%s;dbname=%s";
        $url = sprintf($base_url, "localhost", "api_cabinet");
        $conn = new PDO($url, "root", "omgloltrol");
        
        $sql = "SELECT nom, prenom, sum(consultation.duree_consult)/60 as nb_heure
        FROM `consultation`, `medecin` 
        WHERE consultation.id_medecin = medecin.id_medecin 
        GROUP BY medecin.id_medecin";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        if ($res) {
            return $res;
        } else{
            $res = "vide";
            return $res;
        }
}

// Fonction pour récupérer les statistiques des usagers
    function getStatUsager(){
        //$conn = connexionBD::getInstance();
        $base_url = "mysql:host=%s;dbname=%s";
        $url = sprintf($base_url, "localhost", "api_cabinet");
        $conn = new PDO($url, "root", "omgloltrol");

        $sql = "SELECT civilite, CASE 
        WHEN TIMESTAMPDIFF(YEAR, date_nais, CURDATE()) < 25 THEN 'Moins de 25 ans'
        WHEN TIMESTAMPDIFF(YEAR, date_nais, CURDATE()) BETWEEN 25 AND 50 THEN 'Entre 25 et 50 ans'
        ELSE 'Plus de 50 ans' 
        END AS age_group, COUNT(*) AS count
        FROM usager
        GROUP BY civilite, age_group";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $linkpdo = null;
        if ($res) {
            return $res;
        } else{
            $res = "vide";
            return $res;
        }
}

?>