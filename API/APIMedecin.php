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
           echo "Ce medecin existe deja dans la BD.\n";
        }else{
            
               $stmt = "INSERT INTO medecin(civilite, nom, prenom) VALUES(:civilite, :nom, :prenom)";
               $stmt = $linkpdo->prepare($stmt);
               $stmt->bindParam(':civilite', $civilite);
               $stmt->bindParam(':nom', $nom);
               $stmt->bindParam(':prenom', $prenom);

            if ($stmt->execute() != false){
                echo "Medecin enregistré\n";
            }else{
                echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
            }
        }
    }else{
        deliver_response(400, "Erreur SQL");    
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
        echo "Medecin supprimé\n";
    } else {
        echo "Erreur lors de la suppression du medecin : " . print_r($stmt->errorInfo(), true);
    }
    }

function modifMedecin(){

    $linkpdo = connexionBdGen::getInstance();
    //Recupérer les données
    $civilite = isset($_POST["civilite"]) ? $_POST["civilite"] : '';
       $nom = isset($_POST["nom"]) ? $_POST["nom"] : '';
       $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : '';
   
    //Vérication de doublon
    $sql = "SELECT * FROM medecin WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom'";
    $result = $linkpdo->query($sql);
   
    if ($result->rowCount() > 0 ){
        echo "Ce medecin existe deja dans la BD.";
    }else{
        $updateSql = "UPDATE medecin SET civilite = '$civilite', nom = '$nom', prenom = '$prenom'";
   
        if ($linkpdo->exec($updateSql) !== false){
            echo "Medecin enregistré";
        }else{
            echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
        }
    } 

    }

?>