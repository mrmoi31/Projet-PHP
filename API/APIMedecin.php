<?php

require 'ConnexionBdGen.php';

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
        $linkpdo = connexionBdGen::getInstance();
   
        $stmt = $linkpdo->prepare("SELECT * FROM `medecin`;");
        $stmt->execute();
        $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
        $linkpdo = null;
        return $res;
    
    }

function getMedecinById($id)
{
    $linkpdo = connexionBdGen::getInstance();

    $stmt = $linkpdo->prepare("SELECT * FROM `medecin` where id_medecin = :id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
    $linkpdo = null;
    return $res;
}

function ajoutMedecin($civilite, $nom, $prenom){
    $linkpdo = connexionBdGen::getInstance();
        
        $stmt = $linkpdo->prepare("SELECT * FROM `medecin` WHERE civilite = :civilite AND nom = :nom AND prenom =   :prenom");
        $stmt->bindParam(':civilite', $civilite);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        
        $res = $stmt->execute();
    
    if ($res == true ) {
        if ($stmt->rowCount() > 0 ){
            
            $err = 1;
            return $err;

        }else{
            
               $stmt = "INSERT INTO medecin(civilite, nom, prenom) VALUES(:civilite, :nom, :prenom)";
               $stmt = $linkpdo->prepare($stmt);
               $stmt->bindParam(':civilite', $civilite);
               $stmt->bindParam(':nom', $nom);
               $stmt->bindParam(':prenom', $prenom);

            if ($stmt->execute() != false){
                return null;
            }else{
                $err = 2;
                return $err;
            }
        }
    }
}

function supprimerMedecin($id) {
    $linkpdo = connexionBdGen::getInstance();

    $sql = "DELETE FROM `medecin` WHERE id_medecin = :id_medecin";
    $sql2 = "DELETE FROM `consultation` WHERE id_medecin = :id_medecin";
    $stmt = $linkpdo->prepare($sql);
    $stmt2 = $linkpdo->prepare($sql2);
    $stmt->bindParam(':id_medecin', $id, PDO::PARAM_INT);
    $stmt2->bindParam(':id_medecin', $id, PDO::PARAM_INT);

    if ($stmt2->execute() && $stmt->execute()) {
        return null; 
    }
}

function putMedecin($id_medecin,$civilite, $nom, $prenom){

    $linkpdo = connexionBdGen::getInstance();
    //Recupérer les données
    $id_medecin = $_POST['id_medecin'];
    $civilite = $_POST["civilite"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];

    $updateSql = "UPDATE medecin SET civilite = '$civilite', nom = '$nom', prenom = '$prenom'";

    if ($linkpdo->exec($updateSql) !== false){
        return null;
    }
    }

    function patchMedecin($id_medecin, $dataPatch)
     {
        $dataInit = getMedecinById($_POST['id_medecin']);

        for ($i=0; $i < strlen($dataInit) ; $i++) { 
            if ($dataPatch[$i] != null) {
                $dataInit[$i] = $dataPatch[$i];
            }
        }

        $updateSql = "UPDATE medecin SET civilite = $dataInit['civilite'], nom = $dataInit['nom'], prenom = $data['prenom']";
        if ($linkpdo->exec($updateSql) !== false){
            return null;
        }
     }

?>