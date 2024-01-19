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
        <label>Medecin :</label>
        <input type="text" name="medecin" id="medecin"><br>

        <label>Date RDV :</label>
        <input type="text" name="date" id="date"><br>

        <label>Heure RDV :</label>
        <input type="text" name="heure" id="heure"><br>

        <label>Patient :</label>
        <input type="text" name="patient" id="patient"><br>

        <button type="submit" name="send" value="send">Envoyer</button>
        <button type="reset" name="reset" value="reset">Reset</button>
        </form>
</body>

<?php include "fonction.php";
if (isset($_POST['send'])) {
    ajoutMedecin();
} ?>

   
</html>
