<?php
        $html = include "medecins.php";

        $doc = new DOMDocument();
        $doc->loadHTML($html);
        
        $table = $doc->getElementsByTagName('table')->item(0);
        $rows = $table->getElementsByTagName('tr');

        foreach ($rows as $row) {
            // Vérifie si la ligne a la classe spécifique 'ligne-speciale'
            if ($row->getAttribute('class') === 'selected') {
                $cells = $row->getElementsByTagName('td');
                $rowData = [];

                foreach ($cells as $cell) {
                    $rowData[] = $cell->nodeValue;
                }

                // Affiche les données de la ligne spéciale
                print_r($rowData);
            }
        }
       
        /*
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
        //header('Location: http://localhost/saisie.html');*/
?>
