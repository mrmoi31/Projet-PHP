<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="index.css">
        <title>Medecins - Cabinet Médical</title>
    </head>
    <?php 
        require "header.html";
        include "connexionBd.php";
    ?>
    <body>
        <form method="post">
        <label>Civilite :</label>
        <input type="text" name="civ" id="civ"><br>

        <label>Nom :</label>
        <input type="text" name="nom" id="nom"><br>

        <label>Prenom :</label>
        <input type="text" name="prenom" id="prenom"><br>

        <button type="submit" name="send" value="send">Envoyer</button>
        <button type="reset" name="reset" value="reset">Reset</button>
        </form>

       


</body>
    <?php
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
         $insertSql = "INSERT INTO medecin(civilite, nom, prenom) VALUES('$civilite', '$nom', '$prenom')";
 
         if ($linkpdo->exec($insertSql) !== false){
             echo "Medecin enregistrer";
         }else{
             echo "Erreur lors de l'insertion du medecin : " . print_r($linkpdo->errorInfo());
         }
     } 

 
      
       

       
        ?>
</html>
