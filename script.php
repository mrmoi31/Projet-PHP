<?php
        $server = "localhost";
        $db = "projet-php";
        $login = "root";
        $mdp = "";

        //Connection base de donnée
        try{
            $linkpdo = new PDO("mysql: localhost=$server; dbname=$db", $login, $mdp);
        } 
        //Verification connection
        catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
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
        $sql = "SELECT * FROM patient WHERE nom = '$nom' AND prenom = '$prenom' AND adresse = '$adresse' AND code_postal = '$code_postal' AND ville = '$ville' AND dateN = '$dateN' AND lieuxN = '$lieuxN' AND numSecu = '$numSecu' ";
        $result = $linkpdo->query($sql);

        if ($result->rowCount() > 0 ){
            echo "Ce contact existe deja dans la BD.";
        }else{
            $insertSql = "INSERT INTO patient(nom, prenom, adresse, code_postal, ville, dateN, lieuxN, numSecu) VALUES('$nom', '$prenom', '$adresse', '$code_postal', '$ville', '$dateN', '$lieuxN', '$numSecu')";

            if ($linkpdo->exec($insertSql) !== false){
                echo "Patient enregistrer";
            }else{
                echo "Erreur lors de l'insertion du patient : " . print_r($linkpdo->errorInfo());
            }
        }            
        //header('Location: http://localhost/saisie.html');
?>
