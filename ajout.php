
<?php

    include "connexionBd.php";
        if (include "connexionBd.php" != true){
            echo "La connexion n'est pas effectuée";
        }


    function ajoutPatient(){

        //Recupérer les données
        $civilite = $_POST["civilite"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $adresse = $_POST["adresse"];
        $ville = $_POST["ville"];
        $code_postal = $_POST["code_postal"];
        $dateN = $_POST["dateN"];
        $lieuxN = $_POST["lieuxN"];
        $numSecu = $_POST["numSecu"];

        //Vérication de doublon
        $sql = "SELECT * FROM patient WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom' AND adresse = '$adresse' AND code_postal = '$code_postal' AND ville = '$ville' AND dateN = '$dateN' AND lieuxN = '$lieuxN' AND numSecu = '$numSecu' ";
        $result = $linkpdo->query($sql);

        if ($result->rowCount() > 0 ){
            echo "Ce patient existe deja dans la BD.";
        }else{
            $insertSql = "INSERT INTO patient(civilite, nom, prenom, adresse, code_postal, ville, dateN, lieuxN, numSecu) VALUES('$civilite', '$nom', '$prenom', '$adresse', '$code_postal', '$ville', '$dateN', '$lieuxN', '$numSecu')";

            if ($linkpdo->exec($insertSql) !== false){
                echo "Patient enregistrer";
            }else{
                echo "Erreur lors de l'insertion du patient : " . print_r($linkpdo->errorInfo());
            }
        } 


    }
    
    function ajoutMedecin(){
        //Recupérer les données
        $civilite = $_POST["civilite"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];

        //Vérication de doublon
        $sql = "SELECT * FROM medecins WHERE civilite = '$civilite' AND nom = '$nom' AND prenom = '$prenom'";
        $result = $linkpdo->query($sql);
    
        if ($result->rowCount() > 0 ){
            echo "Ce medecins existe deja dans la BD.";
        }else{
            $insertSql = "INSERT INTO patient(civilite, nom, prenom) VALUES('$civilite', '$nom', '$prenom')";
    
            if ($linkpdo->exec($insertSql) !== false){
                echo "Medecin enregistrer";
            }else{
                echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
            }
        } 

    }

    function ajoutConsultation(){

    }
?>
