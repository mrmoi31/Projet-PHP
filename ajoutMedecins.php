<?php

   

        //Vérication de doublon
        $sql = "SELECT * FROM medecins WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom'";
        $result = $linkpdo->query($sql);

        if ($result->rowCount() > 0 ){
            echo "Ce medecins existe deja dans la BD.";
        }else{
            $insertSql = "INSERT INTO patient(civilite, nom, prenom) VALUES('$civilite', '$nom', '$prenom')";

            if ($linkpdo->exec($insertSql) !== false){
                echo "Patient enregistrer";
            }else{
                echo "Erreur lors de l'insertion du patient : " . print_r($linkpdo->errorInfo());
            }
        }            
        //header('Location: http://localhost/saisie.html');
?>
