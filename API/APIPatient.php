<?php

require 'ConnexionBdGen.php';

function deliver_response($status_code, $status_message, $data=null) {
    // Paramétrage de l'entête HTTP
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

function getAllUsager() {
    $linkpdo = connexionBdGen::getInstance();
    $stmt = $linkpdo->prepare("SELECT * FROM `usager`;");
    $stmt->execute();
    $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
    $linkpdo = null;
    return $res;
}

function getUsagerById($id) {
    $linkpdo = connexionBdGen::getInstance();
    $stmt = $linkpdo->prepare("SELECT * FROM `usager` where id_usager = :id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
    $linkpdo = null;
    return $res;
}


function ajoutUsager($civilite, $nom, $prenom, $sexe, $adresse, $codePostal, $ville, $dateN, $lieuN, $numSecu,$date_verif) {
    $linkpdo = connexionBdGen::getInstance();
    $sql = "SELECT * FROM usager WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom' and sexe = '$sexe' AND adresse = '$adresse' AND code_postal = '$codePostal' AND ville = '$ville' AND date_nais = '$date_verif' AND lieu_nais = '$lieuN' AND num_secu = '$numSecu'";
    $res = $linkpdo->query($sql);
    if ($res->rowCount() > 0 ) {
        echo "Ce patient existe deja dans la BD.";
    } else {
        
        $date_bd = $dateN->format('Y-m-d');
        $insertSql = "INSERT INTO usager(civilite, nom, prenom, sexe, adresse, code_postal, ville, date_nais, lieu_nais, num_secu) VALUES ('$civilite', '$nom', '$prenom', '$sexe', '$adresse', '$codePostal', '$ville', '$date_bd', '$lieuN', '$numSecu')";
        if ($linkpdo->exec($insertSql) == true){
            echo "Usager enregistré\n";
        } else {
            echo "Erreur lors de l'insertion de l'usager : " . print_r($linkpdo->errorInfo());
        }
    }
}
  
function supprimerUsager($id) {
    $linkpdo = connexionBdGen::getInstance();
    $sql = "DELETE FROM `usager` WHERE id_usager = :id_usager";
    $stmt = $linkpdo->prepare($sql);
    $stmt->bindParam(':id_usager', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "Patient supprimé\n";
    } else {
        echo "Erreur lors de la suppression du Patient : " . print_r($stmt->errorInfo(), true);
    }
}
//Faire Modif Usager
// function modifUsager() {
//     $linkpdo = connexionBdGen::getInstance();
//     $civilite = isset($_POST["civilite"]) ? $_POST["civilite"] : '';
//     $nom = isset($_POST["nom"]) ? $_POST["nom"] : '';
//     $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : '';
//     $adresse = isset($_POST["adresse"]) ? $_POST["adresse"] : '';
//     $ville = isset($_POST["ville"]) ? $_POST["ville"] : '';
//     $code_postal = isset($_POST["codePostal"]) ? $_POST["codePostal"] : '';
//     $dateN = isset($_POST["dateNaissance"]) ? $_POST["dateNaissance"] : '';
//     $lieuxN = isset($_POST["lieuNaissance"]) ? $_POST["lieuNaissance"] : '';
//     $numSecu = isset($_POST["numSecu"]) ? $_POST["numSecu"] : '';
//     $id_medecin = isset($_POST["id_medecin"]) ? $_POST["id_medecin"] : '';
//     $sql = "SELECT * FROM patient WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom' AND adresse = '$adresse' AND codePostal = '$code_postal' AND ville = '$ville' AND dateNaissance = '$dateN' AND lieuNaissance = '$lieuxN' AND numSecu = '$numSecu' ";
//     $result = $linkpdo->query($sql);
//      if ($result->rowCount() > 0 ){
//         echo "Ce patient existe deja dans la BD.";
//     } else {
//         $updateSql = "UPDATE patient SET civilite = '$civilite', nom = '$nom', prenom = '$prenom', adresse = '$adresse', codePostal = '$code_postal', ville = '$ville', dateNaissance = '$dateN', lieuNaissance = '$lieuxN', numSecu = '$numSecu', id_medecin = '$id_medecin' ";
//         if ($linkpdo->exec($updateSql) !== false){
//             echo "Patient enregistré";
//         } else {
//             echo "Erreur lors de la modification du patient : " . print_r($linkpdo->errorInfo());
//         }
//     }
// }

?>