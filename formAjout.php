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

        <button type="submit" name="send" value="send">Envoyer</button>
        <button type="reset" name="reset" value="reset">Reset</button>
        </form>

  


</body>

<?php include "testTheo.php";
if (isset($_POST['send'])) {
    ajoutMedecin();
} ?>

   
</html>
