<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="index.css">
        <title>Medecins - Cabinet Médical</title>
    </head>
    <?php require "header.html"; ?>
    <body>
        <form method="post">
        <label for="pet-select">Medecin :</label>

        <label>Medecin :</label>
        <input type="text" name="id_medecin" id="id_medecin" value="Entrez l'id du medecin"><br>

        <label>Date RDV :</label>
        <input type="date" name="date" id="date"><br>

        <label>Heure RDV :</label>
        <input type="number" name="heure" id="heure"><br>

        <label>Patient :</label>
        <input type="text" name="id_patient" id="id_patient" value="Entrez l'id du patient"><br>

        <button type="submit" name="send" value="send">Envoyer</button>
        <button type="reset" name="reset" value="reset">Reset</button>
        </form>
</body>

<?php include "fonction.php";
if (isset($_POST['send'])) {
    ajoutConsultation();
} ?>
   
</html>
