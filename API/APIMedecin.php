<?php

function ajoutMedecin(){
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
     $insertSql = "INSERT INTO medecin(civilite, nom, prenom) VALUES('$civilite', '$nom', '$prenom')";

     if ($linkpdo->exec($insertSql) !== false){
         echo "Medecin enregistré";
     }else{
         echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
     }
 } }

function supprimerMedecin($id_medecin) {
    include "connexionBd.php";

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