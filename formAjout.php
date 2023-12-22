<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="index.css">
        <title>Medecins - Cabinet Médical</title>
    </head>
    <?php 
        require "header.html";
        require "test.php";
        $civilite = $_POST["civilite"];
    ?>
    <body>
       
        

        <form action="testTheo.php" method="post">
        <label>Civilite :</label>
        <input type="text" name="civ" id="civ"><br>

        <label>Nom :</label>
        <input type="text" name="nom" id="nom"><br>

        <label>Prenom :</label>
        <input type="text" name="prenom" id="prenom"><br>

        <button type="submit" name="send" value="send" action="ajoutTest()">Envoyer</button>
        <button type="reset" name="reset" value="reset">Reset</button>
        </form>







    </body>
</html>
