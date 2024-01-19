<?php

include "connexionBd.php";

function ajoutTest(){
    
  
    //Recupérer les données
    $civilite = $_POST["civilite"];
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];

    //Vérication de doublon
    $sql = "SELECT * FROM medecin WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom'";
    $result = $linkpdo->query($sql);

   

    if ($result->rowCount() > 0 ){
        echo "Ce medecin existe deja dans la BD.";
    }else{
        $insertSql = "INSERT INTO medecin(civilite, nom, prenom) VALUES('$index+1','$civilite', '$nom', '$prenom')";
        $index = "SELECT count(id_medecin)";
        if ($linkpdo->exec($insertSql) !== false){
            echo "Medecin enregistrer";
        }else{
            echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
        }
    } 


     
      

      
       

  
   

   
    
}
?>

