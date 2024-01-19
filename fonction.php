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

function supprimer(){
    function supprimerMedecin($idMedecin) {
        global $linkpdo; // Utilisez la connexion à la base de données dans cette fonction
    
        // Vérifier si le médecin existe avant de le supprimer
        $verifSql = "SELECT * FROM medecin WHERE id_medecin = :idMedecin";
        $verifStmt = $linkpdo->prepare($verifSql);
        $verifStmt->bindParam(':idMedecin', $idMedecin, PDO::PARAM_INT);
        $verifStmt->execute();
    
        if ($verifStmt->rowCount() > 0) {
            // Le médecin existe, supprimer
            $deleteSql = "DELETE FROM medecin WHERE id_medecin = :idMedecin";
            $deleteStmt = $linkpdo->prepare($deleteSql);
            $deleteStmt->bindParam(':idMedecin', $idMedecin, PDO::PARAM_INT);
    
            if ($deleteStmt->execute()) {
                echo "Le médecin a été supprimé avec succès.";
            } else {
                echo "Erreur lors de la suppression du médecin : " . print_r($deleteStmt->errorInfo());
            }
        } else {
            echo "Le médecin avec l'ID $idMedecin n'existe pas.";
        }
    }
    


}

            

   ?>