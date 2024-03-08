<?php

function ajoutPatient(){
include "connexionBd.php";
//Recupérer les données
        $civilite = isset($_POST["civilite"]) ? $_POST["civilite"] : '';
        $nom = isset($_POST["nom"]) ? $_POST["nom"] : '';
        $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : '';
        $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : '';
        $ville = isset($_POST["ville"]) ? $_POST["ville"] : '';
        $code_postal = isset($_POST["codePostal"]) ? $_POST["codePostal"] : '';
        $dateN = isset($_POST["dateNaissance"]) ? $_POST["dateNaissance"] : '';
        $lieuxN = isset($_POST["lieuNaissance"]) ? $_POST["lieuNaissance"] : '';
        $numSecu = isset($_POST["numSecu"]) ? $_POST["numSecu"] : '';
        $id_medecin = isset($_POST["id_medecin"]) ? $_POST["id_medecin"] : '';
        

         //Vérication de doublon
         $sql = "SELECT * FROM patient WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom' AND adresse = '$adresse' AND codePostal = '$code_postal' AND ville = '$ville' AND dateNaissance = '$dateN' AND lieuNaissance = '$lieuxN' AND numSecu = '$numSecu' ";
         $result = $linkpdo->query($sql);
 
         if ($result->rowCount() > 0 ){
             echo "Ce patient existe deja dans la BD.";
         }else{
             $insertSql = "INSERT INTO patient(civilite, nom, prenom, adresse, codePostal, ville, dateNaissance, lieuNaissance, numSecu, id_medecin) VALUES('$civilite', '$nom', '$prenom', '$adresse', '$code_postal', '$ville', '$dateN', '$lieuxN', '$numSecu', '$id_medecin')";
 
             if ($linkpdo->exec($insertSql) !== false){
                 echo "Patient enregistré";
             }else{
                 echo "Erreur lors de l'insertion du patient : " . print_r($linkpdo->errorInfo());
             }
         }}

function supprimerPatient($id_patient) {
    include "connexionBd.php";

    $sql = "DELETE FROM patient WHERE id_patient = :id_patient";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id_patient', $id_patient, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Actualisez la page pour finir la suppression";
    } else {
        echo "Erreur lors de la suppression du patient : " . print_r($stmt->errorInfo(), true);
    }
}

function modifPatient(){
    include "connexionBd.php";
    //Recupérer les données
    $civilite = isset($_POST["civilite"]) ? $_POST["civilite"] : '';
    $nom = isset($_POST["nom"]) ? $_POST["nom"] : '';
    $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : '';
    $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : '';
    $ville = isset($_POST["ville"]) ? $_POST["ville"] : '';
    $code_postal = isset($_POST["codePostal"]) ? $_POST["codePostal"] : '';
    $dateN = isset($_POST["dateNaissance"]) ? $_POST["dateNaissance"] : '';
    $lieuxN = isset($_POST["lieuNaissance"]) ? $_POST["lieuNaissance"] : '';
    $numSecu = isset($_POST["numSecu"]) ? $_POST["numSecu"] : '';
    $id_medecin = isset($_POST["id_medecin"]) ? $_POST["id_medecin"] : '';
            
    
    //Vérication de doublon
    $sql = "SELECT * FROM patient WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom' AND adresse = '$adresse' AND codePostal = '$code_postal' AND ville = '$ville' AND dateNaissance = '$dateN' AND lieuNaissance = '$lieuxN' AND numSecu = '$numSecu' ";
    $result = $linkpdo->query($sql);
     
    if ($result->rowCount() > 0 ){
        echo "Ce patient existe deja dans la BD.";
    }else{
    $updateSql = "UPDATE patient SET civilite = '$civilite', nom = '$nom', prenom = '$prenom', adresse = '$adresse', codePostal = '$code_postal', ville = '$ville', dateNaissance = '$dateN', lieuNaissance = '$lieuxN', numSecu = '$numSecu', id_medecin = '$id_medecin' ";
     
    if ($linkpdo->exec($updateSql) !== false){
        echo "Patient enregistré";
    }else{
        echo "Erreur lors de la modification du patient : " . print_r($linkpdo->errorInfo());
        }
    }
}

?>