<?php  

function ajoutConsultation($id_medecin, $id_patient, $dateRDV, $heureRDV){
    include "connexionBd.php";
    //Recupérer les données
   //Vérication de doublon
   $sql = "SELECT * FROM consultation WHERE id_medecin = '$id_medecin' AND dateRDV = '$dateRDV' AND heureRDV = '$heureRDV' AND id_patient = '$id_patient'; ";
   $result = $linkpdo->query($sql);
   if ($result->rowCount() > 0 ){
    echo "Ce rdv existe deja dans la BD.";
   }else{
    $insertSql = "INSERT INTO consultation(id_medecin, dateRDV, heureRDV, id_patient) VALUES('$id_medecin', '$dateRDV', 'heureRDV', '$id_patient')";
       if ($linkpdo->exec($insertSql) !== false){
           echo "Consultation enregistrée";
       }else{
            echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
       }
   } 
    
}

function supprimerConsultation($id_consult) {
    include "connexionBd.php";

    $sql = "DELETE FROM consultation WHERE id_consultation = :id_consultation";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id_consultation', $id_consult, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Actualisez la page pour finir la suppression";
    } else {
        echo "Erreur lors de la suppression de la consultation : " . print_r($stmt->errorInfo(), true);
    }
}

function modifConsultation(){

    include "connexionBd.php";
    //Recupérer les données
    $id_medecin = isset($_POST["id_medecin"]) ? $_POST["id_medecin"] : '';
    $date = isset($_POST["date"]) ? $_POST["date"] : '';
    $heure = isset($_POST["heure"]) ? $_POST["heure"] : '';
    $id_patient = isset($_POST["id_patient"]) ? $_POST["id_patient"] : '';

    //Vérication de doublon
    $sql = "SELECT * FROM consultation WHERE medecin = '$medecin' AND dateRDV = '$dateRDV' AND heureRDV = '$heureRDV' AND patient = '$patient' ;";
    $result = $linkpdo->query($sql);
   
    if ($result->rowCount() > 0 ){
        echo "Cette consultation existe deja dans la BD.";
    }else{
        $updateSql = "UPDATE medecin SET civilite = '$civilite', nom = '$nom', prenom = '$prenom'";
   
        if ($linkpdo->exec($updateSql) !== false){
            echo "Consultation enregistrée";
        }else{
            echo "Erreur lors de l'insertion de la consultation : " . print_r($linkpdo->errorInfo());
        }
    } 

}
    
?>