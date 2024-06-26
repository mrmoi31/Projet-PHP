<?php

//require_once "connexionBdGen.php";

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



function getAllMedecins()
    {
        //$linkpdo = connexionBdGen::getInstance();
        
        $base_url = "mysql:host=%s;dbname=%s";
        $url = sprintf($base_url, "mysql-medecin.alwaysdata.net", "medecin_projet_php");
        $linkpdo = new PDO($url, "medecin", "\$iutinfo");

        $stmt = $linkpdo->prepare("SELECT * FROM `medecin`;");
        $stmt->execute();
        $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
        if (!$res) {
            $res = "vide";
        }
        $linkpdo = null;
        return $res;
    
    }

function getMedecinById($id)
{
    //$linkpdo = connexionBdGen::getInstance();

    $base_url = "mysql:host=%s;dbname=%s";
    $url = sprintf($base_url, "mysql-medecin.alwaysdata.net", "medecin_projet_php");
    $linkpdo = new PDO($url, "medecin", "\$iutinfo");

    $stmt = $linkpdo->prepare("SELECT * FROM `medecin` where id_medecin = :id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $linkpdo = null;
    if ($res) {
        $medecin  = array(
            'id' => $res['id_medecin'],
            'nom' => $res['nom'],
            'prenom' => $res['prenom'],
            'civilite' => $res['civilite']
         );
        return $medecin;
    } elseif (!$res) {
        $res = "vide";
        return $res;
    } else {
        $res = $linkpdo->errorInfo();
        return $res;
    }
}


function ajoutMedecin($civilite, $nom, $prenom){
    //$linkpdo = connexionBdGen::getInstance();
    
        $base_url = "mysql:host=%s;dbname=%s";
        $url = sprintf($base_url, "mysql-medecin.alwaysdata.net", "medecin_projet_php");
        $linkpdo = new PDO($url, "medecin", "\$iutinfo");

        $stmt = $linkpdo->prepare("SELECT * FROM `medecin` WHERE civilite = :civilite AND nom = :nom AND prenom =   :prenom");
        $stmt->bindParam(':civilite', $civilite);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        
        $res = $stmt->execute();
    
    if ($res == true ) {
        if ($stmt->rowCount() > 0 ){
            $status = "existant";
            return $status;
        }else{
            
               $stmt = "INSERT INTO medecin(civilite, nom, prenom) VALUES(:civilite, :nom, :prenom)";
               $stmt = $linkpdo->prepare($stmt);
               $stmt->bindParam(':civilite', $civilite);
               $stmt->bindParam(':nom', $nom);
               $stmt->bindParam(':prenom', $prenom);

            if ($stmt->execute() != false){
                $status = "good";
                return $status;
            }else{
                $status = $linkpdo->errorInfo();
                return $status;
            }
        }
    }
}

function supprimerMedecin($id) {
    //$linkpdo = connexionBdGen::getInstance();

    $base_url = "mysql:host=%s;dbname=%s";
    $url = sprintf($base_url, "mysql-medecin.alwaysdata.net", "medecin_projet_php");
    $linkpdo = new PDO($url, "medecin", "\$iutinfo");

    $sql = getMedecinById($id);
    if ($sql === "vide") {
        $status = "vide";
        return $status;
    } else {

        $sql = "DELETE FROM `medecin` WHERE id_medecin = :id_medecin";
        $sql2 = "DELETE FROM `consultation` WHERE id_medecin = :id_medecin";
        $stmt = $linkpdo->prepare($sql);
        $stmt2 = $linkpdo->prepare($sql2);
        $stmt->bindParam(':id_medecin', $id, PDO::PARAM_INT);
        $stmt2->bindParam(':id_medecin', $id, PDO::PARAM_INT);
    
        if ($stmt2->execute() && $stmt->execute()) {
            $status = "good";
            return $status;
        } else {
            $status = $linkpdo->errorInfo();
            return $status;
        }
    }
}

    function patchMedecin($id_medecin, $dataPatch)
     {
        //$linkpdo = connexionBdGen::getInstance();

        $base_url = "mysql:host=%s;dbname=%s";
        $url = sprintf($base_url, "mysql-medecin.alwaysdata.net", "medecin_projet_php");
        $linkpdo = new PDO($url, "medecin", "\$iutinfo");

        $ancienMedecin = getMedecinById($_GET['id']);

        if ($ancienMedecin === "vide") {
            $status = "vide";
            return $status;
        }

            if (isset($dataPatch['nom'])) {
                $ancienMedecin['nom'] = $dataPatch['nom'];
            }
            if (isset($dataPatch['prenom'])) {
                $ancienMedecin['prenom'] = $dataPatch['prenom'];
            }
            if (isset($dataPatch['civilite'])) {
                $ancienMedecin['civilite'] = $dataPatch['civilite'];
            }

        $updateSql = "UPDATE `medecin` SET civilite = :civilite, nom = :nom, prenom =:prenom WHERE id_medecin=:id";

        $stmt = $linkpdo->prepare($updateSql);
        $stmt->bindParam(":civilite", $ancienMedecin['civilite'], PDO::PARAM_STR);
        $stmt->bindParam(":nom", $ancienMedecin['nom'], PDO::PARAM_STR);
        $stmt->bindParam(":prenom", $ancienMedecin['prenom'], PDO::PARAM_STR);
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