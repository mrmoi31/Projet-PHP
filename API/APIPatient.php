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

function connexionBdGen() {

        $server = "localhost";
        $db = "projet-apii";
        $login = "root";
        $mdp = "";
    
        //Connection base de donnée
        try{
            $linkpdo = new PDO("mysql:host=$server; dbname=$db", $login, $mdp);
        } 
        //Verification connection
        catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
        return $linkpdo;}

function getAllPatient(){

    $linkpdo = connexionBdGen();
    $stmt = $linkpdo->prepare("SELECT * FROM `usager`;");
    $stmt->execute();
    $res = ($stmt->fetchAll());
    $linkpdo = null;
    return $res;

}

function getPatientById($id)
{
    $linkpdo = connexionBdGen();

    $stmt = $linkpdo->prepare("SELECT * FROM `usager` where id_usager = :id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
    $linkpdo = null;
    return $res;
}

function ajoutPatient(){
        //include "connexionBd.php";
        //Recupérer les données
        
        $linkpdo = connexionBdGen();

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
         }
     }

     function ajoutMedecin($civilite, $nom, $prenom, $adresse, $ville, $codePostal, $dateN, $lieuN, $numSecu, $id_medecin){
        //include "connexionBd.php";
     
        $linkpdo = connexionBdGen();
        
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

function supprimerPatient($id) {
    //include "connexionBd.php";

    $linkpdo = connexionBdGen();

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