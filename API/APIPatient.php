<?php

//require_once 'connexionBdGen.php';
date_default_timezone_set('UTC');

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
    //$linkpdo = connexionBdGen::getInstance();
    $base_url = "mysql:host=%s;dbname=%s";
    $url = sprintf($base_url, "localhost", "api_cabinet");
    $linkpdo = new PDO($url, "root", "omgloltrol");

    $stmt = $linkpdo->prepare("SELECT * FROM `usager`;");
    $stmt->execute();
    $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
    $linkpdo = null;
    if ($res) {
        return $res;
    } else{
        $res = "vide";
        return $res;
    }
}

function getUsagerById($id) {
    //$linkpdo = connexionBdGen::getInstance();
    $base_url = "mysql:host=%s;dbname=%s";
    $url = sprintf($base_url, "localhost", "api_cabinet");
    $linkpdo = new PDO($url, "root", "omgloltrol");

    $stmt = $linkpdo->prepare("SELECT * FROM `usager` where id_usager = :id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = ($stmt->fetch(PDO::FETCH_ASSOC));
    $linkpdo = null;
    if ($res) {
        $usager  = array(
            'id' => $res['id_usager'],
            'nom' => $res['nom'],
            'prenom' => $res['prenom'],
            'civilite' => $res['civilite'],
            'sexe' => $res['sexe'],
            'adresse' => $res['adresse'],
            'code_postal' => $res['code_postal'],
            'ville' => $res['ville'],
            'date_nais' => $res['date_nais'],
            'lieu_nais' => $res['lieu_nais'],
            'num_secu' => $res['num_secu']
         );
        return $usager;
    }else {
        $res = "vide";
        return $res;
    }
}

function ajoutUsager($civilite, $nom, $prenom, $sexe, $adresse, $codePostal, $ville, $dateN, $lieuN, $numSecu,$date_verif) {
    //$linkpdo = connexionBdGen::getInstance();

    $base_url = "mysql:host=%s;dbname=%s";
    $url = sprintf($base_url, "localhost", "api_cabinet");
    $linkpdo = new PDO($url, "root", "omgloltrol");

    $sql = "SELECT * FROM usager WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom' and sexe = '$sexe' AND adresse = '$adresse' AND code_postal = '$codePostal' AND ville = '$ville' AND date_nais = '$date_verif' AND lieu_nais = '$lieuN' AND num_secu = '$numSecu'";
    $res = $linkpdo->query($sql);

    if ($res->rowCount() > 0 ){
        $status = "existant";
        return $status;
    }else{        
        $date_bd = $dateN->format('Y-m-d');
        $insertSql = "INSERT INTO usager(civilite, nom, prenom, sexe, adresse, code_postal, ville, date_nais, lieu_nais, num_secu) VALUES ('$civilite', '$nom', '$prenom', '$sexe', '$adresse', '$codePostal', '$ville', '$date_bd', '$lieuN', '$numSecu')";
        if ($linkpdo->exec($insertSql) == true){
            $status = "good";
            return $status;
        }else{
            $status = $linkpdo->errorInfo();
            return $status;
       }
    }
}
  
function supprimerUsager($id) {
    //$linkpdo = connexionBdGen::getInstance();
    $base_url = "mysql:host=%s;dbname=%s";
    $url = sprintf($base_url, "localhost", "api_cabinet");
    $linkpdo = new PDO($url, "root", "omgloltrol");

    $sql = getUsagerById($id);

    if ($sql === "vide") {
        $status = "vide";
        return $status;
    } else {
        $sql = "DELETE FROM `usager` WHERE id_usager = :id_usager";
        $stmt = $linkpdo->prepare($sql);
        $stmt->bindParam(':id_usager', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $status = "good";
            return $status;
        } else {
            $status = $linkpdo->errorInfo();
            return $status;
        }
    }
}

 function modifUsager($id_usager, $dataPatch) {
        //$linkpdo = connexionBdGen::getInstance();

        $base_url = "mysql:host=%s;dbname=%s";
        $url = sprintf($base_url, "localhost", "api_cabinet");
        $linkpdo = new PDO($url, "root", "omgloltrol");

        $ancienUsager = getUsagerById($_GET['id']);

        if ($ancienUsager === "vide") {
            $status = "vide";
            return $status;
        }

            if (isset($dataPatch['sexe'])) {
                $ancienUsager['sexe'] = $dataPatch['sexe'];
            }
            if (isset($dataPatch['nom'])) {
                $ancienUsager['nom'] = $dataPatch['nom'];
            }
            if (isset($dataPatch['prenom'])) {
                $ancienUsager['prenom'] = $dataPatch['prenom'];
            }
            if (isset($dataPatch['civilite'])) {
                $ancienUsager['civilite'] = $dataPatch['civilite'];
            }
            if (isset($dataPatch['adresse'])) {
                $ancienUsager['adresse'] = $dataPatch['adresse'];
            }
            if (isset($dataPatch['code_postal'])) {
                $ancienUsager['code_postal'] = $dataPatch['code_postal'];
            }
            if (isset($dataPatch['ville'])) {
                $ancienUsager['ville'] = $dataPatch['ville'];
            }
            if (isset($dataPatch['date_nais'])) {
                $ancienUsager['date_nais'] = $dataPatch['date_nais'];
            }
            if (isset($dataPatch['lieu_nais'])) {
                $ancienUsager['lieu_nais'] = $dataPatch['lieu_nais'];
            }
            if (isset($dataPatch['num_secu'])) {
                $ancienUsager['num_secu'] = $dataPatch['num_secu'];
            }

        $updateSql = "UPDATE `usager` SET civilite = :civilite, nom = :nom, prenom =:prenom, sexe = :sexe, adresse = :adresse, code_postal = :code_postal, ville = :ville, date_nais = :date_nais, lieu_nais = :lieu_nais, num_secu = :num_secu WHERE id_usager = :id";

        $stmt = $linkpdo->prepare($updateSql);
        $stmt->bindParam(":civilite", $ancienUsager['civilite'], PDO::PARAM_STR);
        $stmt->bindParam(":nom", $ancienUsager['nom'], PDO::PARAM_STR);
        $stmt->bindParam(":prenom", $ancienUsager['prenom'], PDO::PARAM_STR);
        $stmt->bindParam(":sexe", $ancienUsager['sexe'], PDO::PARAM_STR);
        $stmt->bindParam(":adresse", $ancienUsager['adresse'], PDO::PARAM_STR);
        $stmt->bindParam(":code_postal", $ancienUsager['code_postal'], PDO::PARAM_STR);
        $stmt->bindParam(":ville", $ancienUsager['ville'], PDO::PARAM_STR);
        $stmt->bindParam(":date_nais", $ancienUsager['date_nais'], PDO::PARAM_STR);
        $stmt->bindParam(":lieu_nais", $ancienUsager['lieu_nais'], PDO::PARAM_STR);
        $stmt->bindParam(":num_secu", $ancienUsager['num_secu'], PDO::PARAM_STR);
        $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $status = "good";
            return $status;
        } else {
            $status = $linkpdo->errorInfo();
            return $status;
        }
     }

?>