<?php

function ajoutMedecin($data){
 include "connexionBd.php";
 //Recupérer les données

    $http_method = $_SERVER['REQUEST_METHOD'];
    if($http_method == "POST") {

        $data = (array) json_decode(file_get_contents('php://input'), TRUE);

        //if the users exist, create a JWT
        if (!isset($data['civilite']) || !isset($data['nom'] || !isset($data['prenom']))) {
            deliver_response(400, "Données manquantes");
        }
    }else{

    $civilite = $data['civilite'];
    $nom = $data['nom'];
    $prenom = $data['prenom'];

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
 }}}

function supprimerMedecin($data) {
    include "connexionBd.php";

    $http_method = $_SERVER['REQUEST_METHOD'];
    if($http_method == "POST") {

        $data = (array) json_decode(file_get_contents('php://input'), TRUE);

        //if the users exist, create a JWT
        if (!isset($data['civilite']) || !isset($data['nom'] || !isset($data['prenom']))) {
            deliver_response(400, "Données manquantes");
        }
    }else{

    $sql = "DELETE FROM medecin WHERE id_medecin = :id_medecin";
    $sql2 = "DELETE FROM usager WHERE id_medecin = :id_medecin";
    $stmt = $linkpdo->prepare($sql);
    $stmt2 = $linkpdo->prepare($sql2);
    $stmt->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
    $stmt2->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);

    if ($stmt2->execute() && $stmt->execute()) {
        echo "Actualisez la page pour finir la suppression";
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