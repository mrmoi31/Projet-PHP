<?php

//require_once 'connexionBdGen.php';

function deliver_response($status_code, $status_message, $data=null) {
    // Paramétrage de l'entête HTTP
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

function getAllUsager() {
    $linkpdo = connexionBdGen::getInstance();
    $stmt = $linkpdo->prepare("SELECT * FROM `usager`;");
    $stmt->execute();
    $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
    $linkpdo = null;
    return $res;
}

function getUsagerById($id) {
    $linkpdo = connexionBdGen::getInstance();
    $stmt = $linkpdo->prepare("SELECT * FROM `usager` where id_usager = :id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
    $linkpdo = null;
    return $res;
}
date_default_timezone_set('UTC');

function ajoutUsager($civilite, $nom, $prenom, $sexe, $adresse, $codePostal, $ville, $dateN, $lieuN, $numSecu,$date_verif) {
    //$linkpdo = connexionBdGen::getInstance();

    $base_url = "mysql:host=%s;dbname=%s";
    $url = sprintf($base_url, "localhost", "api_cabinet");
    $linkpdo = new PDO($url, "root", "omgloltrol");

    $sql = "SELECT * FROM usager WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom' and sexe = '$sexe' AND adresse = '$adresse' AND code_postal = '$codePostal' AND ville = '$ville' AND date_nais = '$date_verif' AND lieu_nais = '$lieuN' AND num_secu = '$numSecu'";
    $res = $linkpdo->query($sql);
    if ($res->rowCount() > 0 ) {
        echo "Ce patient existe deja dans la BD.";
    } else {
        
        $date_bd = $dateN->format('Y-m-d');
        $insertSql = "INSERT INTO usager(civilite, nom, prenom, sexe, adresse, code_postal, ville, date_nais, lieu_nais, num_secu) VALUES ('$civilite', '$nom', '$prenom', '$sexe', '$adresse', '$codePostal', '$ville', '$date_bd', '$lieuN', '$numSecu')";
        if ($linkpdo->exec($insertSql) == true){
            echo "Usager enregistré\n";
        } else {
            echo "Erreur lors de l'insertion de l'usager : " . print_r($linkpdo->errorInfo());
        }
    }
}
  
function supprimerUsager($id) {
    $linkpdo = connexionBdGen::getInstance();
    $sql = "DELETE FROM `usager` WHERE id_usager = :id_usager";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id_usager', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "Patient supprimé\n";
    } else {
        echo "Erreur lors de la suppression du Patient : " . print_r($stmt->errorInfo(), true);
    }
}

 function modifUsager($id_usager, $dataPatch) {
             //$linkpdo = connexionBdGen::getInstance();

        $base_url = "mysql:host=%s;dbname=%s";
        $url = sprintf($base_url, "localhost", "api_cabinet");
        $linkpdo = new PDO($url, "root", "omgloltrol");

        $ancienUsager = getUsagerById($_GET['id']);

            if (isset($dataPatch['ville'])) {
                $ancienUsager['ville'] = $dataPatch['ville'];
            }
            //if (isset($dataPatch['prenom'])) {
            //    $ancienUsager['prenom'] = $dataPatch['prenom'];
            //}
            //if (isset($dataPatch['civilite'])) {
            //    $ancienUsager['civilite'] = $dataPatch['civilite'];
            //}

            //deliver_response("400", "feur", $ancienMedecin);

            echo $ancienUsager['ville'];

        $updateSql = "UPDATE `usager` SET ville = :ville WHERE id_usager = :id";

        $stmt = $linkpdo->prepare($updateSql);
        //$stmt->bindParam(":civilite", $ancienMedecin['civilite'], PDO::PARAM_STR);
        //$stmt->bindParam(":nom", $ancienMedecin['nom'], PDO::PARAM_STR);
        $stmt->bindParam(":ville", $ancienUsager['ville'], PDO::PARAM_STR);
        $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);

        if ($linkpdo->exec($updateSql) != false){
            return null;
        }
    }

?>