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



function getAllPatient(){

    $linkpdo = connexionBdGen::getInstance();
    $stmt = $linkpdo->prepare("SELECT * FROM `usager`;");
    $stmt->execute();
    $res = ($stmt->fetchAll());
    $linkpdo = null;
    return $res;

}

function getPatientById($id)
{
    $linkpdo = connexionBdGen::getInstance();

    $stmt = $linkpdo->prepare("SELECT * FROM `usager` where id_usager = :id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
    $linkpdo = null;
    return $res;
}

function ajoutPatient($civilite, $nom, $prenom, $sexe, $adresse, $ville, $codePostal, $dateN, $lieuN, $numSecu, $id_medecin){
    $linkpdo = connexionBdGen::getInstance();
        
        $stmt = $linkpdo->prepare("SELECT * FROM usager WHERE civilite = :civilite AND nom = :nom AND prenom = :prenom and sexe = :sexe AND adresse = :adresse AND code_postal = :codePostal AND ville = :ville AND date_nais = :dateNaissance AND lieu_nais = :lieuxNaissance AND num_secu = :numSecu and id_medecin = :id_medecin" );
        $stmt->bindParam(':civilite', $civilite, PDO::PARAM_STR);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':sexe', $sexe, PDO::PARAM_STR);
        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $stmt->bindParam(':codePostal', $codePostal, PDO::PARAM_STR);
        $stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
        $stmt->bindParam(':dateNaissance', $dateN, PDO::PARAM_STR);
        $stmt->bindParam(':lieuNaissance', $lieuxN, PDO::PARAM_STR);
        $stmt->bindParam(':numSecu', $numSecu, PDO::PARAM_STR);
        $stmt->bindParam(':id_medecin', $id_medecin, PDO::PARAM_STR);

        try {
            $res = $stmt->execute();
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    
    if ($res == true ) {
        if ($stmt->rowCount() > 0 ){
           echo "Ce patient existe deja dans la BD.\n";
        }else{
            
            $stmtInsert = "INSERT INTO usager(civilite, nom, prenom, sexe, adresse, codePostal, ville, dateNaissance, lieuxNaissance, numSecu, id_medecin) VALUES (:civilite, :nom, :prenom, :sexe, :adresse, :codePostal, :ville, :dateNaissance, :lieuxNaissance, :numSecu, :id_medecin)";
            $stmtInsert = $linkpdo->prepare($stmt);
            $stmtInsert->bindParam(':civilite', $civilite);
            $stmtInsert->bindParam(':nom', $nom);
            $stmtInsert->bindParam(':prenom', $prenom);
            $stmtInsert->bindParam(':sexe', $sexe);
            $stmtInsert->bindParam(':adresse', $adresse);
            $stmtInsert->bindParam(':codePostal', $codePostal);
            $stmtInsert->bindParam(':ville', $ville);
            $stmtInsert->bindParam(':dateNaissance', $dateN);
            $stmtInsert->bindParam(':lieuNaissance', $lieuxN);
            $stmtInsert->bindParam(':numSecu', $numSecu);
            $stmtInsert->bindParam(':id_medecin', $id_medecin);

            if ($stmtInsert->execute() == true){
                echo "Usager enregistré\n";
            }else{
                echo "Erreur lors de l'insertion de l'usager : " . print_r($linkpdo->errorInfo());
            }
        }
    }else{
        deliver_response(400, "Erreur SQL");    
    }
}

function supprimerPatient($id) {
    $linkpdo = connexionBdGen::getInstance();

    $sql = "DELETE FROM `usager` WHERE id_usager = :id_usager";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id_usager', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Medecin supprimé\n";
    } else {
        echo "Erreur lors de la suppression du medecin : " . print_r($stmt->errorInfo(), true);
    }
    }
function modifPatient(){
    $linkpdo = connexionBdGen::getInstance();
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