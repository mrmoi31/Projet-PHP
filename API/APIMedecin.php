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

function getAllMedecins()
{
    $linkpdo = connexionBdGen();
    $stmt = $linkpdo->prepare("SELECT * FROM `medecin`;");
    $stmt->execute();
    $json_response = json_encode($stmt->fetchAll());
    $linkpdo = null;
    return $json_response;
}

function ajoutMedecin($civilite, $nom, $prenom){
 include "connexionBd.php";
 //Recupérer les données

 //Vérication de doublon
 $sql = "SELECT * FROM medecin WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom'";
 $result = $linkpdo->query($sql);

 if ($result->rowCount() > 0 ){
     echo "Ce medecin existe deja dans la BD.";
 }else{
     $insertSql = "INSERT INTO medecin(civilite, nom, prenom) VALUES('$civilite', '$nom', '$prenom')";

     if ($linkpdo->exec($insertSql) !== false){
         echo "Medecin enregistré";
     }else{
         echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
     }
 }}

function supprimerMedecin($id) {
    include "connexionBd.php";

    $sql = "DELETE FROM medecin WHERE id_medecin = :id_medecin";
    $sql2 = "DELETE FROM usager WHERE id_medecin = :id_medecin";
    $stmt = $linkpdo->prepare($sql);
    $stmt2 = $linkpdo->prepare($sql2);
    $stmt->bindParam(':id_medecin', $id, PDO::PARAM_INT);
    $stmt2->bindParam(':id_medecin', $id, PDO::PARAM_INT);

    if ($stmt2->execute() && $stmt->execute()) {
        echo "Medecin supprimé";
    } else {
        echo "Erreur lors de la suppression du medecin : " . print_r($stmt->errorInfo(), true);
    }
}

function modifMedecin(){

    include "connexionBd.php";
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