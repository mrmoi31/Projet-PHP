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
         echo "Medecin enregistrer";
     }else{
         echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
     }
 } }

 function ajoutConsultation(){
     include "connexionBd.php";
     //Recupérer les données
    $id_medecin = isset($_POST["id_medecin"]) ? $_POST["id_medecin"] : '';
    $dateRDV = isset($_POST["dateRDV"]) ? $_POST["dateRDV"] : '';
    $heureRDV = isset($_POST["heureRDV"]) ? $_POST["heureRDV"] : '';
    $id_patient = isset($_POST["id_patient"]) ? $_POST["id_patient"] : '';

    //Vérication de doublon
    $sql = "SELECT * FROM consultation WHERE id_medecin = '$id_medecin' AND dateRDV = '$dateRDV' AND heureRDV = '$heureRDV' AND id_patient = '$id_patient' ";
    $result = $linkpdo->query($sql);

    if ($result->rowCount() > 0 ){
     echo "Ce rdv existe deja dans la BD.";
    }else{
     $insertSql = "INSERT INTO consultation(id_medecin, dateRDV, heureRDV, id_patient) VALUES('$id_medecin', '$dateRDV', '$heureRDV', '$id_patient')";

        if ($linkpdo->exec($insertSql) !== false){
            echo "Consultation enregistrée";
        }else{
             echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
        }
    } 
     
 }

 function ajoutPatien(){
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
                     echo "Patient enregistrer";
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
            echo "Actualisé la page pour finir la suppresion";
        } else {
            echo "Erreur lors de la suppression du patient : " . print_r($stmt->errorInfo(), true);
        }
    }

    function supprimerMedecin($id_medecin) {
        include "connexionBd.php";
       
    
        $sql = "DELETE FROM medecin WHERE id_medecin = :id_medecin";
        $sql2 = "DELETE FROM patient WHERE id_medecin = :id_medecin";
        $stmt = $linkpdo->prepare($sql);
        $stmt2 = $linkpdo->prepare($sql2);
        $stmt->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
        $stmt2->bindParam(':id_medecin', $id_medecin, PDO::PARAM_INT);
    
        if ($stmt2->execute() && $stmt->execute()) {
            echo "Actualisé la page pour finir la suppresion";
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
                echo "Medecin enregistrer";
            }else{
                echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
            }
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
                         echo "Patient enregistrer";
                     }else{
                         echo "Erreur lors de la modification du patient : " . print_r($linkpdo->errorInfo());
                     }
                 }}
    
       
   ?>