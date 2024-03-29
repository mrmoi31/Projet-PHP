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

function ajoutConsultation($id_medecin, $id_patient, $dateRDV, $heureRDV, $dureeCons){
    $linkpdo = connexionBdGen::getInstance();
    //Recupérer les données
   //Vérication de doublon
   $sql = "SELECT * FROM consultation WHERE id_medecin = '$id_medecin' AND date_consult = '$dateRDV' AND heure_consult = '$heureRDV' AND id_usager = '$id_patient' AND duree_consult = '$dureeCons'; ";
   $result = $linkpdo->query($sql);
   if ($result->rowCount() > 0 ){
    echo "Ce rdv existe deja dans la BD.";
   }else{
    $insertSql = "INSERT INTO consultation(id_medecin, date_consult, heure_consult, id_usager, duree_consult) VALUES('$id_medecin', '$dateRDV', '$heureRDV', '$id_patient', '$dureeCons')";
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