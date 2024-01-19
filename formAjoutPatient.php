
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="index.css">
        <title>Medecins - Cabinet Médical</title>
    </head>
    <?php 
        require "header.html";
      
 
    ?>
    <body>
        <form method="post">
        <label>Civilite :</label><br>
        <label>M :</label>
        <input type="radio" name="civilite" id="civilite" value="M">
        <label>Mme :</label>
        <input type="radio" name="civilite" id="civilite" value="Mme"><br>

        <label>Nom :</label>
        <input type="text" name="nom" id="nom"><br>

        <label>Prenom :</label>
        <input type="text" name="prenom" id="prenom"><br>

        <label>Adresse :</label>
        <input type="text" name="adresse" id="adresse"><br>

        <label>Ville :</label>
        <input type="text" name="ville" id="ville"><br>

        <label>Code Postal :</label>
        <input type="text" name="codepostal" id="codepostal"><br>

        <label>Date Naissance :</label>
        <input type="text" name="dateN" id="dateN"><br>

        <label>Lieux Naissance :</label>
        <input type="text" name="lieuxN" id="lieuxN"><br>

        <label>Numéro Sécu :</label>
        <input type="text" name="numSecu" id="numSecu"><br>

        <label> Medecin :</label>
        <input type="text" name="id_medecin" id="id_medecin"><br>

        

        <button type="submit" name="send" value="send">Envoyer</button>
        <button type="reset" name="reset" value="reset">Reset</button>
        </form>


</body>




</html>

<?php      
include "connexionBd.php";
//Recupérer les données
        $civilite = $_POST["civilite"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $adresse = $_POST["adresse"];
        $ville = $_POST["ville"];
        $code_postal = $_POST["codePostal"];
        $dateN = $_POST["dateNaissance"];
        $lieuxN = $_POST["lieuNaissance"];
        $numSecu = $_POST["numSecu"];
        $id_medecin = $_POST["id_medecin"];

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
         }


    

         
 
         


?>
